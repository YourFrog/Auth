<?php

namespace Auth\Entity\ACL\Repository;

use Auth\Entity\ACL\Role as RoleEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

/**
 *  Repozytorium obsługujące encje ról
 *
 * @package Auth\Entity\ACL\Repository
 */
class Role extends EntityRepository
{
    /**
     *  Zwraca domyślną role w systemie
     *
     * @return Collection kolekcja ról
     *
     * @throws \Exception
     */
    public function getDefaultRoles()
    {
        $criteria = [
            'isDefault' => true
        ];

        $arr = $this->findBy($criteria);

        if( count($arr) === 0 ) {
            throw new \Exception('Nie odnaleziono domyślnej encji w systemie');
        }

        return new ArrayCollection($arr);
    }

    /**
     *  Role które powinny być ustawiane przy rejestracji kont
     *
     * @return Collection kolekcja ról
     *
     * @throws \Exception
     */
    public function getRegisterRoles()
    {
        $criteria = [
            'isRegister' => true
        ];

        $arr = $this->findBy($criteria);

        if( count($arr) === 0 ) {
            throw new \Exception('Nie odnaleziono ról które ustawiamy nowym użytkownikom');
        }

        return new ArrayCollection($arr);
    }
}