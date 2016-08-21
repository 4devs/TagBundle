<?php

namespace FDevs\TagBundle\DependencyInjection;

use FDevs\Tag\Form\Type\TagType;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('f_devs_tag');

        $supportedAdmins = ['sonata', 'none'];

        $rootNode
            ->children()
                ->append($this->dbDriver())
                ->scalarNode('class_name')->defaultValue('FDevs\Tag\Model\Tag')->end()
                ->scalarNode('tag_form')->defaultValue(TagType::class)->end()
                ->scalarNode('admin_driver')->defaultValue('none')
                    ->validate()
                        ->ifNotInArray($supportedAdmins)
                        ->thenInvalid('The admin %s is not supported. Please choose one of '.json_encode($supportedAdmins))
                    ->end()
                ->end()
                ->arrayNode('default_criteria')
                    ->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('type_list')
                    ->requiresAtLeastOneElement()
                    ->defaultValue(['tag' => 'Tag'])
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
    private function dbDriver()
    {
        $supportedDrivers = ['mongodb'];
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('db');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')
                    ->defaultValue('mongodb')
                        ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                ->end()
                ->scalarNode('manager_name')->defaultNull()->end()
            ->end()
        ;

        return $rootNode;
    }
}
