<?php

namespace Auth\Service\User;

use Auth\Service\Session\Container;
use Zend\View\HelperPluginManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 *  Plugin obsługujący autentykacje użytkownika
 *
 * @package Auth\Plugin
 */
class Authentication extends HelperPluginManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     *  Kontener przetrzymujący informacje o sesji dla autoryzacji
     *
     * @var Container
     */
    private $sessionContainer;

    /**
     *  Konstruktor
     */
    public function __construct()
    {
        $this->sessionContainer = new Container();
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *  Zwraca role na których znajduje się użytkownik
     */
    public function getRoles()
    {
        if( $this->sessionContainer->hasRole() == false) {
            $this->setDefaultRole();
        }

        return $this->sessionContainer->getRoles();
    }

    /**
     *  Ustawia domyślną rolę
     *
     * @throws \Exception
     */
    private function setDefaultRole()
    {
        /** @var \Auth\Entity\ACL\Repository\Role $repo */
        $repo = $this->entityManager->getRepository('Auth\Entity\ACL\Role');
        $role = $repo->getDefaultRole();

        $this->sessionContainer->addRole($role);
    }
}