<?php

namespace Auth\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka obsługująca tworzenie sesji
 *
 * @package Auth\Service\Factory
 */
class SessionContainer implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $obj = new \Auth\Service\Session\Container();

        if( $obj->hasRole() == false ) {
            $authentication = $serviceLocator->get('auth.service.authentication');
            $authentication->getRoles();
        }

        return $obj;
    }

}