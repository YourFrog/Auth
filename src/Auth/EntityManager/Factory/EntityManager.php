<?php

namespace Auth\EntityManager\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EntityManager
 * @package Auth\EntityManager\Factory
 */
class EntityManager implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $obj = new \Auth\EntityManager\EntityManager();
        $obj->setEntityManager($serviceLocator->get('doctrine.entitymanager.orm_default'));

        return $obj;
    }
}