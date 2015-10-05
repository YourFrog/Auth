<?php

namespace Auth\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Auth\Service\Permission as PermissionService;

/**
 *  Plugin obsługujący informacje o dostępach
 *
 * @package Auth\Plugin
 */
class Permission extends AbstractPlugin
{
    /**
     * @var PermissionService
     */
    private $permission;

    /**
     * @param PermissionService $permission
     */
    public function setPermissionClass(PermissionService $permission)
    {
        $this->permission = $permission;
    }

    /**
     *  Sprawdza czy mamy dostęp do zasobu i uprawnienia
     *
     * @param string $resourceName Nazwa zasobu który sprawdzamy
     * @param string $permissionType Typ uprawnienia jaki sprawdzamy
     *
     * @return boolean
     */
    public function isAllow($resourceName, $permissionType)
    {
        return $this->permission->isAllow($resourceName, $permissionType);
    }

    /**
     *  Sprawdza czy nie mamy dostępu do zasobu i uprawnienia
     *
     * @param string $resourceName Nazwa zasobu który sprawdzamy
     * @param string $permissionType Typ uprawnienia jaki sprawdzamy
     *
     * @return boolean
     */
    public function isDisallow($resourceName, $permissionType)
    {
        return $this->permission->isDisallow($resourceName, $permissionType);
    }
}