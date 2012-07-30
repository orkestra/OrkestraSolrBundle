<?php

namespace Orkestra\Bundle\SolrBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('orkestra_solr');

        $rootNode
            ->beforeNormalization()
                ->ifTrue(function($v) {
                    return isset($v['auto_mapping']) && $v['auto_mapping'] == true;
                })
                ->then(function($v) {
                    unset($v['mappings']);
                    return $v;
                })
            ->end()
            ->children()
                ->booleanNode('auto_mapping')->defaultTrue()->end()
                ->arrayNode('connection')
                    ->isRequired()
                    ->children()
                        ->scalarNode('hostname')->isRequired()->end()
                        ->scalarNode('port')->defaultValue('8983')->end()
                        ->scalarNode('username')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('mappings')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('driver')->end()
                            ->scalarNode('path')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
