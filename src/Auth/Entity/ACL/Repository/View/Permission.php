<?php

namespace Auth\Entity\ACL\Repository\View;

use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Router\RouteMatch;

use Auth\Entity\ACL\Role as RoleEntity;
use Auth\Entity\ACL\View\Permission as EntityPermission;

/**
 *  Repozytorium obsługujące widok uprawnień
 *
 * @package Auth\Entity\ACL\Repository\View
 */
class Permission extends EntityRepository
{
    /**
     *  Odnajduje scieżkę w bazie danych na podstawie kontrollera i akcji
     *
     * @param string $resourceName
     * @param RoleEntity[] $roles
     *
     * @return EntityPermission[]
     */
    public function findByResourceAndRoles($resourceName, array $roles)
    {
        return $this->findPermission($resourceName, $roles, EntityPermission::TYPE_READ);
    }

    /**
     *  Odnajduje uprawnienie
     *
     * @param string $resourceName Nazwa zasobu
     * @param array $roles Tablica ról
     * @param string $permissionType Nazwa uprawnienia
     *
     * @return EntityPermission[]
     */
    public function findPermission($resourceName, array $roles, $permissionType)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c')
            ->where("c.resourceName = :resourceName")
            ->andWhere("c.typeName = :typeName")
            ->andWhere("c.roleId IN (" . implode(",", array_map(function($item) { return $item->getId(); }, $roles)). ")")
            ->getQuery();

        $query->setParameters([
            'resourceName' => $resourceName,
            'typeName' => $permissionType
        ]);

        return $query->getResult();
    }
}