<?php

namespace Auth\Business\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Business\ProccessList;

/**
 *  Fabryka procesów biznesowych dla modułu autoryzacyjnego
 *
 * @package Auth\Business\Factory
 */
class BusinessFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $object = new ProccessList();
        $object->setServiceLocator($serviceLocator);

        return $object;
    }
}