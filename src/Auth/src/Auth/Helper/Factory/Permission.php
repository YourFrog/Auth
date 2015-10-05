<?php

namespace Auth\Helper\Factory;

use Auth\Helper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka tworząca plugin autoryzacyjny
 *
 * @package Auth\Helper\Factory
 */
class Permission implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $permissionService = $serviceLocator->getServiceLocator()->get('auth.service.permission');

        $obj = new Helper\Permission();
        $obj->setPermissionClass($permissionService);

        return $obj;
    }
}