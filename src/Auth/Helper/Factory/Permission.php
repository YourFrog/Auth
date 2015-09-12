<?php

namespace Auth\Helper\Factory;

use Auth\Helper;

/**
 *  Fabryka tworząca plugin autoryzacyjny
 *
 * @package Auth\Helper\Factory
 */
class Permission implements \Zend\ServiceManager\FactoryInterface
{
    /**
     * Create service
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $permissionService = $serviceLocator->getServiceLocator()->get('auth.service.permission');

        $obj = new Helper\Permission();
        $obj->setPermissionClass($permissionService);

        return $obj;
    }
}