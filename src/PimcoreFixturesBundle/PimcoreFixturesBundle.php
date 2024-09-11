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

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Instride\Bundle\PimcoreFixturesBundle\DependencyInjection\CompilerPass\FixturesCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PimcoreFixturesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FixturesCompilerPass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
