<?php

namespace FDevs\TagBundle;

use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use FDevs\TagBundle\DependencyInjection\Compiler\SerializerPass;
use FDevs\TagBundle\DependencyInjection\Compiler\ValidationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDevsTagBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->addRegisterMappingsPass($container);
        $container
            ->addCompilerPass(new SerializerPass())
            ->addCompilerPass(new ValidationPass())
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $refl = new \ReflectionClass('FDevs\Tag\TagInterface');

        $mappings = [realpath(dirname($refl->getFileName()).'/Resources/doctrine/model') => 'FDevs\Tag\Model'];

        if (class_exists('Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass')) {
            $container->addCompilerPass(
                DoctrineMongoDBMappingsPass::createXmlMappingDriver(
                    $mappings,
                    ['f_devs_tag.model_manager_name'],
                    'f_devs_tag.backend_type_mongodb'
                )
            );
        }
    }
}
