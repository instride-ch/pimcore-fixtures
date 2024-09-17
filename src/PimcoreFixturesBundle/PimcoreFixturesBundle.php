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

namespace Instride\Bundle\PimcoreFixturesBundle;

use Instride\Bundle\PimcoreFixturesBundle\DependencyInjection\CompilerPass\FixturesConfigCompilerPass;
use Instride\Bundle\PimcoreFixturesBundle\DependencyInjection\CompilerPass\FixturesRegisterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PimcoreFixturesBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new FixturesRegisterCompilerPass());
        $container->addCompilerPass(new FixturesConfigCompilerPass());
//        $container->addCompilerPass(new AutoTagFixtureCompilerPass());

        $container->registerForAutoconfiguration(FixtureInterface::class)
            ->addTag(FixturesRegisterCompilerPass::FIXTURE_TAG);
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
