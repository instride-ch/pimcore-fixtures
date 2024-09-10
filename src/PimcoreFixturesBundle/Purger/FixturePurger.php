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

namespace Instride\PimcoreFixturesBundle\Purger;

use Pimcore\Model\DataObject\Concrete;

class FixturePurger
{
    public static array $objects = [];

    /**
     * Adds an object to the list of objects to be purged.
     *
     * @param mixed $object The object to add.
     */
    public static function addObject(Concrete $object): void
    {
        self::$objects[] = $object;
    }

    /**
     * Purges all fixtures from the database.
     *
     * @return bool True if the fixtures were purged successfully, false otherwise.
     * @throws \Exception If an object could not be deleted.
     */
    public static function purgeFixtures(): bool
    {
        foreach (self::$objects as $object) {
            if ($object instanceof Concrete) {
                try {
                    $object->delete();
                } catch (\Exception $e) {
                    throw new \Exception('Could not delete object: ' . $object->getId() . ' - ' . $e->getMessage());
                }
            } else {
                throw new \Exception('Object is not an instance of Concrete');
            }
        }
        self::$objects = [];
        return true;
    }

    public static function getObjects(): array
    {
        return self::$objects;
    }
}
