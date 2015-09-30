<?php

namespace Auth\EntityManager\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Klasa obsługująca generowanie repozytoriów
 *
 * @package Auth\EntityManager\Factory
 */
class Repository implements AbstractFactoryInterface
{
    private $mapper = [
        'auth.repository.acl.view.permission' => 'Auth\Entity\ACL\View\Permission',

        'auth.repository.user.account' => 'Auth\Entity\User\Account',
        'auth.repository.acl.role' => 'Auth\Entity\ACL\Role'
    ];

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return array_key_exists($name, $this->mapper);
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

        $repoName = $this->mapper[$name];
        return $entityManager->getRepository($repoName);
    }

}