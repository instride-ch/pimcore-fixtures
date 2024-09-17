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

namespace Instride\Bundle\PimcoreFixturesBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FixturesConfigCompilerPass implements CompilerPassInterface
{
    public const FIXTURE_CONFIG_TAG = 'pimcore_fixtures';

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('pimcore.fixtures.config.service');
        $fixturesConfig = $container->getExtensionConfig(self::FIXTURE_CONFIG_TAG);

        $definition->addMethodCall('addConfig', [$fixturesConfig]);
    }
}
