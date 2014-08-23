<?php

namespace FDevs\TagBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FDevsTagExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter($this->getAlias() . '.manager_name', null);
        $container->setParameter($this->getAlias() . '.backend_type_mongodb', true);
        $container->setParameter($this->getAlias() . '.list_type', $config['list_type']);

        if (!empty($config['model_class'])) {
            $container->setParameter($this->getAlias() . '.model_tag.class', $config['model_class']);
        }
        if (!empty($config['form_class'])) {
            $container->setParameter($this->getAlias() . '.form_type_tag.class', $config['form_class']);
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('sonata.xml');
    }
}
