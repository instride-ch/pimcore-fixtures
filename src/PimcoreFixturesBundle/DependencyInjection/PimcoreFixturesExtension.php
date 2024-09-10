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

namespace Instride\PimcoreFixturesBundle\DependencyInjection;

use Instride\PimcoreFixturesBundle\DependencyInjection\CompilerPass\FixturesCompilerPass;
use Instride\PimcoreFixturesBundle\Fixture;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PimcoreFixturesExtension extends Extension
{
    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');

        $container->registerForAutoconfiguration(Fixture::class)
            ->addTag(FixturesCompilerPass::FIXTURE_TAG);
    }
}
