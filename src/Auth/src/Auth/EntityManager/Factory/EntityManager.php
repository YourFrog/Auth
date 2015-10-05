<?php

namespace Auth\EntityManager\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka tworząca managera encji
 *
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
        $configuration = $serviceLocator->get('auth.configuration');

        /** @var \Auth\Configuration\DoctrineConfig $doctrine */
        $doctrine = $configuration->getDoctrineConfiguration();
        $orm = $doctrine->getORM();

        return $serviceLocator->get($orm);
    }
}