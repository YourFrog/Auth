<?php

namespace Auth\Service\Session;

use Auth\Entity\ACL\Role as RoleEntity;
use Doctrine\Common\Collections\Collection;
use Zend\Session\Container as SessionContainer;

/**
 *  Obsługa kontenera sesji
 *
 * @package Auth\Service\Session
 */
class Container
{
    /**
     * @var SessionContainer SessionContainer
     */
    private $sessionContainer;

    /**
     *  Konstruktor
     */
    public function __construct()
    {
        $this->sessionContainer = new SessionContainer('Auth');
    }

    /**
     * @return RoleEntity[]
     *
     * @throws \Exception
     */
    public function getRoles()
    {
        $roles = $this->sessionContainer->roles;

        if( $this->hasRole() == false ) {
            throw new \Exception('Rola nie odnaleziona w sesji');
        }

        return $roles;
    }

    /**
     * @param RoleEntity $role
     */
    public function addRole(RoleEntity $role)
    {
        if( $this->hasRole() == false ) {
            $this->clear();
        }

        $this->sessionContainer->roles[] = $role;
    }

    /**
     *  Ustawia kilka ról jednocześnie w kontenerze
     *
     * @param Collection $roles
     */
    public function setRoles(Collection $roles)
    {
        $this->clear();

        foreach($roles as $role) {
            $this->addRole($role);
        }
    }

    /**
     *  Sprawdzenie czy przechowujemy jakąś role
     *
     * @return bool
     */
    public function hasRole()
    {
        if( $this->sessionContainer->roles === null ) {
            return false;
        }

        return (count($this->sessionContainer->roles) > 0);
    }

    /**
     *  Czyści kontener dla sesji
     */
    public function clear()
    {
        $this->sessionContainer->roles = [];
    }
}