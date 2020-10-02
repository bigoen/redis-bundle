<?php

declare(strict_types=1);

namespace Bigoen\RedisBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Şafak Saylam <safak@bigoen.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bigoen_redis');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('clients')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('dsn')->end()
                            ->scalarNode('prefix')->end()
                            ->scalarNode('key')->end()
                            ->scalarNode('namespace')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
