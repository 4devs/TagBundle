<?php

namespace FDevs\TagBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ValidationPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('f_devs_tag.storage')) {
            return;
        }

        $storage = $container->getParameter('f_devs_tag.storage');

        if ('custom' === $storage) {
            return;
        }

        $validationFile = __DIR__.'/../../Resources/config/validation/'.$storage.'.xml';

        $container->getDefinition('validator.builder')->addMethodCall('addXmlMapping', [$validationFile]);
    }
}
