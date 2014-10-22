<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 22/10/2014
 * Time: 0:49
 */

namespace RumeauLibAclBackend\Service;


use RumeauLibAclBackend\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['rumeaulib_aclbackend'];

        return new ModuleOptions($config);
    }

} 