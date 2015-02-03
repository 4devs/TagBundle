<?php

namespace FDevs\TagBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SerializerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('jms_serializer.metadata.file_locator')) {
            return;
        }
        $def = $container->getDefinition('jms_serializer.metadata.file_locator');
        $arg = $def->getArgument(0);
        if (isset($arg['FDevs\TagBundle'])) {
            unset($arg['FDevs\TagBundle']);
        }
        if (!isset($arg['FDevs\Tag'])) {
            $refl = new \ReflectionClass('FDevs\Tag\TagManagerInterface');
            $arg['FDevs\Tag'] = dirname($refl->getFileName()).'/Resources/serializer';
            $def->replaceArgument(0, $arg);
        }
    }
}
