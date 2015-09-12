<?php

namespace Auth\Helper;

use Zend\View\Helper\AbstractHelper;
use Auth\Service\Permission as PermissionService;

/**
 *  Helper widoku wspomagający rozpoznanie czy osoba jest zalogowana
 *
 * @package Auth\Helper
 */
class Permission extends AbstractHelper //extends \Twig_Extension
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
     *  Metoda wywoływana z szablonu
     *
     * @return mixed|string
     */
    public function __invoke()
    {
        return $this->permission;
    }
}