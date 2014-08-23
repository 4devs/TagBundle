<?php

namespace FDevs\TagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('f_devs_tag');

        $rootNode
            ->children()
                ->arrayNode('list_type')
                    ->defaultValue(['base'])
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('model_class')->end()
                ->scalarNode('form_class')->end()
            ->end();

        return $treeBuilder;
    }
}
