<?php

namespace FDevs\TagBundle;

use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FDevsTagBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(
            DoctrineMongoDBMappingsPass::createXmlMappingDriver(
                array(
                    realpath(__DIR__ . '/Resources/config/doctrine/model') => 'FDevs\TagBundle\Model',
                ),
                array('f_devs_tag.manager_name'),
                'f_devs_tag.backend_type_mongodb'
            )
        );
    }

}
