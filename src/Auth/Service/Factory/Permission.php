<?php

namespace Auth\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka tworząca klasę z informacjami o dostępach
 *
 * @package Auth\Service\Factory
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
        $obj = new \Auth\Service\Permission();

        /** @var \Auth\Entity\ACL\Repository\View\Permission $permissionRepository */
        $permissionRepository = $serviceLocator->get('auth.repository.acl.view.permission');

        $obj->setPermissionRepository($permissionRepository);
        $obj->setSessionContainer($serviceLocator->get('auth.session.container'));
        $obj->setEventManager($serviceLocator->get('eventManager'));
        $obj->setPermissionCollector($serviceLocator->get('auth.toolbar'));

        return $obj;
    }
}