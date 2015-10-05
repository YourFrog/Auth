<?php

namespace Auth\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka obsługująca generowanie serwisu autentykacji
 *
 * @package Auth\Service\Factory
 */
class Authentication implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        $obj = new \Auth\Service\User\Authentication();
        $obj->setEntityManager($entityManager);

        return $obj;
    }
}