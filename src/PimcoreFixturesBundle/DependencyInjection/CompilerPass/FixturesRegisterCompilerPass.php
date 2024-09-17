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
use Symfony\Component\DependencyInjection\Reference;

class FixturesRegisterCompilerPass implements CompilerPassInterface
{
    public const FIXTURE_TAG = 'instride.pimcore.fixture';

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('pimcore.fixtures.loader');
        $taggedServices = $container->findTaggedServiceIds(self::FIXTURE_TAG);

        $fixtures = [];

        foreach ($taggedServices as $serviceId => $tags) {
            $fixtures[] = [
                'fixture' => new Reference($serviceId),
            ];
        }

        $definition->addMethodCall('addFixtures', [$fixtures]);
    }
}
