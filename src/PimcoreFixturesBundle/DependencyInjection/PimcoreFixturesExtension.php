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

namespace Instride\Bundle\PimcoreFixturesBundle\DependencyInjection;

use Instride\Bundle\PimcoreFixturesBundle\DependencyInjection\CompilerPass\FixturesRegisterCompilerPass;
use Instride\Bundle\PimcoreFixturesBundle\Fixture;
use Instride\Bundle\PimcoreFixturesBundle\FixtureInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

class PimcoreFixturesExtension extends Extension
{
    /**
     * @inheritDoc
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->getFixturesConfig($config, $container);
    }

    private function getFixturesConfig(array $config, ContainerBuilder $container): void
    {
        $fixtureFiles = \glob($container->getParameter('kernel.project_dir') . '/config/fixtures/*.yaml');

        foreach ($fixtureFiles as $file) {
            $yamlConfig = Yaml::parseFile($file);
            $config = \array_merge_recursive($config, $yamlConfig);
        }

        $container->setParameter('pimcore_fixtures', $config);
    }
}
