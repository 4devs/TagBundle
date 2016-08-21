<?php

namespace FDevs\TagBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FDevsTagExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setParameter($this->getAlias().'.type_list', $config['type_list']);
        $container->setParameter($this->getAlias().'.class_name', $config['class_name']);
        $container->setParameter($this->getAlias().'.model_manager_name', $config['db']['manager_name']);
        $container->setParameter($this->getAlias().'.backend_type_'.$config['db']['driver'], true);
        $container->setParameter($this->getAlias().'.storage', $config['db']['driver']);
        $container->setParameter($this->getAlias().'.default_criteria', $config['default_criteria']);
        $container->setParameter($this->getAlias().'.form', $config['tag_form']);

        $loader->load($config['db']['driver'].'.xml');

        $loader->load('services.xml');
        $loader->load('form.xml');

        if ($config['admin_driver'] !== 'none') {
            $loader->load(sprintf('admin/%s.xml', $config['admin_driver']));
        }
    }
}
