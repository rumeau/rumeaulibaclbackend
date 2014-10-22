<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 22/10/2014
 * Time: 0:39
 */

namespace RumeauLibAclBackend\Service;


use RumeauLibAclBackend\Mapper\RoleMapperDoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleMapperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RoleMapperDoctrineObject(
            $serviceLocator->get('doctrine.entitymanager.orm_default'),
            $serviceLocator->get('RumeauLibAclBackend\Options\Module')
        );
    }

} 