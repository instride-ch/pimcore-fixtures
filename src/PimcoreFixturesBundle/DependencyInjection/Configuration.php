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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('pimcore_fixtures');
        $rootNode = $treeBuilder->getRootNode();

        $this->addFixturesSection($rootNode);
        return $treeBuilder;
    }

    private function addFixturesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->useAttributeAsKey('attribute')
                        ->arrayPrototype()
                                ->children()
                                    ->scalarNode('extension')
                                        ->validate()
                                            ->ifTrue(function ($v) {
                                                return isset($v) && $v->isRelation;
                                            })
                                        ->thenInvalid('The "extension" field cannot be used when "isRelation" is true.')
                                    ->end()
                                ->end()
                                ->booleanNode('isRelation')->defaultFalse()
                                    ->validate()
                                        ->ifTrue(function ($v) {
                                            return $v && isset($v->extension);
                                        })
                                        ->thenInvalid('The "isRelation" field cannot be true when "extension" is set.')
                                    ->end()
                                ->end()
                                ->scalarNode('className')
                                    ->validate()
                                        ->ifTrue(function ($v) {
                                            return $v->isRelation && !isset($v);
                                        })
                                        ->thenInvalid('The "className" field must be set when "isRelation" is true.')
                                    ->end()
                                ->end()
                                ->integerNode('amount')->defaultValue(1)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
