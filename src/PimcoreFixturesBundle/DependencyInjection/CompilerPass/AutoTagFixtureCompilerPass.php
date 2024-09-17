<?php

declare(strict_types=1);

namespace Instride\Bundle\PimcoreFixturesBundle\DependencyInjection\CompilerPass;

use Instride\Bundle\PimcoreFixturesBundle\Fixture;
use Instride\Bundle\PimcoreFixturesBundle\FixtureDataProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AutoTagFixtureCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->getDefinitions() as $definition) {
            if ($this->isFixtureClass($definition)) {
                $definition->addTag(FixturesRegisterCompilerPass::FIXTURE_TAG);
            }
        }
    }

    private function isFixtureClass(Definition $definition): bool
    {
        $class = $definition?->getClass();
        if ($class === null) {
            return false;
        }

        if (!\class_exists($class)) {
            return false;
        } else {
            return \is_subclass_of($class, Fixture::class) || \is_subclass_of($class, FixtureDataProvider::class);
        }
    }
}
