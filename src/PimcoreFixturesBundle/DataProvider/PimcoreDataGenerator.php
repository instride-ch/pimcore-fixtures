<?php

declare(strict_types=1);

/**
 * instride AG.
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that is distributed with this source code.
 *
 * @copyright 2024 instride AG (https://instride.ch)
 */

namespace Instride\Bundle\PimcoreFixturesBundle\DataProvider;

use Faker\Factory;
use Instride\Bundle\PimcoreFixturesBundle\Helper\DataObjectHelper;
use Instride\Bundle\PimcoreFixturesBundle\Loader\FixtureConfigLoader;
use Instride\Bundle\PimcoreFixturesBundle\Purger\FixturePurger;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\Tool\UUID;
use Pimcore\Tool;

class PimcoreDataGenerator implements DataGeneratorInterface
{
    private FixtureConfigLoader $configService;

    public function __construct(FixtureConfigLoader $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Creates a number of objects of a given class with random values.
     * By providing static values, you can override the random values.
     *
     * @param string $class
     * @param int $amount
     * @param array $static_values
     * @return array
     */
    public function generate(string $class, int $amount, array $static_values = []): array
    {
        $objects = [];
        $locales = Tool::getValidLanguages();

        for ($i = 0; $i < $amount; $i++) {
            $object = $this->createObject($class);
            $attributes = $this->configService->getConfig(\basename($class));

            $this->populateObjectAttributes($object, $locales, $attributes);

            if (!empty($static_values)) {
                foreach ($static_values as $attribute => $value) {
                    $this->setValue($object, $attribute, $value);
                }
            }

            $this->setDefaultObjectAttributes($object);
            $objects[] = $object->save();
        }

        return $objects;
    }

    private function setDefaultObjectAttributes(Concrete $object): void
    {
        $object->setPublished(true);
        DataObjectHelper::setParent($object);

        // Object needs a key to be saved and get an ID
        $object->setKey('_temp-key');
        $uuid = UUID::create($object->save());
        $object->setKey($uuid->getUuid())->save();
    }


    private function setValue(Concrete $object, string $attribute, $value, string $locale = ''): void
    {
        $methodName = 'set' . ucfirst($attribute);

        if (!method_exists($object, $methodName)) {
            throw new \InvalidArgumentException("Method $methodName does not exist in class " . $object->getClassName());
        }

        $locale ? $object->$methodName($value, $locale) : $object->$methodName($value);
    }

    /**
     * @param string $className
     * @return Concrete
     */
    private function createObject(string $className): Concrete
    {
        $classFullName = '\\Pimcore\\Model\\DataObject\\' . $className;
        if (class_exists($classFullName)) {
            return new $classFullName();
        } else {
            throw new \InvalidArgumentException("Class " . $classFullName . " does not exist.");
        }
    }

    /**
     * @param array $locales
     * @param array $config
     * @param Concrete $object
     * @return void
     */
    private function populateObjectAttributes(Concrete $object, array $locales, array $config): void
    {
        foreach ($locales as $locale) {
            $factory = $this->getFactory($locale);
            foreach ($config as $attribute => $attributeConfig) {
                if (isset($attributeConfig['extension'])) {
                    $value = $attributeConfig['extension'];
                    $fakerValue = $factory->$value;
                    $isLocalized = $attributeConfig['isLocalized'] ?? false;
                    if ($isLocalized) {
                        $this->setValue($object, $attribute, $fakerValue, $locale);
                    } else {
                        $this->setValue($object, $attribute, $fakerValue);
                    }
                } elseif (isset($attributeConfig['isRelation'])) {
                    $className = $attributeConfig['className'];
                    $amount = $attributeConfig['amount'] ?? 1;
                    $objects = $this->generate($className, $amount);
                    FixturePurger::addObject($objects);
                    $this->setValue($object, $attributeConfig['attribute'], $objects);
                }
            }
        }
    }

    /**
     * @param mixed $locale
     * @return \Faker\Generator
     */
    private function getFactory(string $locale): \Faker\Generator
    {
        return Factory::create($locale);
    }
}
