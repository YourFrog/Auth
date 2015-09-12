<?php

namespace Auth\Entity\ACL\Repository;

use Auth\Entity\ACL\Role as RoleEntity;
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
     * @return RoleEntity
     *
     * @throws \Exception
     */
    public function getDefaultRole()
    {
        $entity = $this->find(RoleEntity::DEFAULT_ROLE);

        if( $entity === null ) {
            throw new \Exception('Nie odnaleziono domyślnej encji w systemie');
        }

        return $entity;
    }
}