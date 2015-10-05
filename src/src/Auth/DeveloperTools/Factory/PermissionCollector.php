<?php

namespace Auth\DeveloperTools\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka obsługująca toolbar
 *
 * @package Auth\DeveloperTools\Factory
 */
class PermissionCollector implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $obj = new \Auth\DeveloperTools\PermissionCollector();
        $obj->setSessionContainer($serviceLocator->get('auth.session.container'));

        return $obj;
    }
}