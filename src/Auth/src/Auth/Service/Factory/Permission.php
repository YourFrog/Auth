<?php

namespace Auth\Service\Factory;

use Auth\Service;
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
        /** @var \Auth\EntityManager\Repository $repository */
        $repository = $serviceLocator->get('auth.repository');

        $obj = new Service\Permission();
        $obj->setPermissionRepository($repository->createAclPermissionView());
        $obj->setSessionContainer($serviceLocator->get('auth.session.container'));
        $obj->setEventManager($serviceLocator->get('eventManager'));
        $obj->setPermissionCollector($serviceLocator->get('auth.toolbar'));

        return $obj;
    }
}