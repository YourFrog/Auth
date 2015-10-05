<?php

namespace Auth\EntityManager\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Klasa obsługująca generowanie repozytoriów
 *
 * @package Auth\EntityManager\Factory
 */
class Repository implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('auth.entitymanager');

        $object = new \Auth\EntityManager\Repository();
        $object->setEntityManager($entityManager);

        return $object;
    }
}