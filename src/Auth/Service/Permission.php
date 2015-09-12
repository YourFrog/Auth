<?php

namespace Auth\Service;

use Auth\Service\Session\Container as SessionContainer;
use Zend\EventManager\EventManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Auth\DeveloperTools\PermissionCollector;

/**
 *  Klasa obsługująca informacje o dostępach do zasobów
 *
 * @package Auth\Service
 */
class Permission
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * @var PermissionCollector
     */
    private $permissionCollector;

    /**
     * @var SessionContainer
     */
    private $sessionContainer;

    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param mixed $permissionCollector
     */
    public function setPermissionCollector($permissionCollector)
    {
        $this->permissionCollector = $permissionCollector;
    }

    /**
     * @param SessionContainer $sessionContainer
     */
    public function setSessionContainer($sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    /**
     *  Sprawdza czy brakuje uprawnień do zasobu dla ról
     *
     * @param string $resourceName
     * @param string $permissionType
     *
     * @return bool
     */
    public function isDisallow($resourceName, $permissionType)
    {
        return ($this->isAllow($resourceName, $permissionType) == false);
    }

    /**
     *  Sprawdza czy mamy dostęp do zasobu
     *
     * @param string $resourceName
     * @param string $permissionType
     *
     * @return bool
     */
    public function isAllow($resourceName, $permissionType)
    {
        $roles = $this->sessionContainer->getRoles();

        $repo = $this->entityManager->getRepository('Auth\Entity\ACL\View\Permission');
        $permissions = $repo->findPermission($resourceName, $roles, $permissionType);

        if( count($permissions) == 0 ) {
            $result = false;
        } else {
            $result = $permissions[0]->isAllow();
        }

        $this->permissionCollector->addCheck($resourceName, $permissionType, $result);
        return $result;
    }
}