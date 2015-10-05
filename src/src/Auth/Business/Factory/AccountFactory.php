<?php

namespace Auth\Business\Factory;

use Auth\Business;
use Auth\Configuration\Config;
use Doctrine\ORM\EntityManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;

/**
 *  Fabryka tworzaca obsługę biznesowa kont
 *
 * @package Auth\Business\Factory
 */
class AccountFactory implements FactoryInterface
{
    /**
     * @var Config
     */
    private $configuration;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->configuration = $serviceLocator->get('auth.configuration');

        return $this->createBusinessAccount();
    }

    /**
     * @return Business\Account
     */
    private function createBusinessAccount()
    {
        $object = new Business\Account();

        $entityManager = $this->getEntityManager();
        $object->setEntityManager($entityManager);

        $roleRepository = $this->getRepositoryRole();
        $object->setRoleRepository($roleRepository);

        $eventManager = $this->getEventManager();
        $object->setEventManager($eventManager);

        return $object;
    }

    /**
     * @return EntityManagerInterface
     */
    private function getEntityManager()
    {
        return $this->serviceLocator->get('auth.entitymanager');
    }

    /**
     * @return EventManager
     */
    private function getEventManager()
    {
        $application = $this->serviceLocator->get('Application');
        return $application->getEventMaanager();
    }

    /**
     * @return \Auth\Entity\ACL\Repository\Role
     */
    private function getRepositoryRole()
    {
        /** @var \Auth\EntityManager\Repository $repository */
        $repository = $this->serviceLocator->get('auth.repository');

        return $repository->createAclRole();
    }
}