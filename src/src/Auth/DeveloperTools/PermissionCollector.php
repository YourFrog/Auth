<?php

namespace Auth\DeveloperTools;

use Auth\Service\Session\Container;
use Zend\Mvc\MvcEvent;
use ZendDeveloperTools\Collector\CollectorInterface;
use Auth\Helper;

/**
 *  Klasa obsługująca zakładki w zend developer tools
 *
 * @package Auth\DeveloperTools
 */
class PermissionCollector implements CollectorInterface
{
    /**
     *  Tablica zgromadzonych danych
     *
     * @var array
     */
    private $data;

    /**
     * @var Container
     */
    private $sessionContainer;

    /**
     *  Konsturktor
     */
    public function __construct()
    {
        $this->data = [];
    }


    /**
     * Collector Name.
     *
     * @return string
     */
    public function getName()
    {
        return 'auth.toolbar';
    }

    /**
     * Collector Priority.
     *
     * @return integer
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * Collects data.
     *
     * @param MvcEvent $mvcEvent
     */
    public function collect(MvcEvent $mvcEvent)
    {

    }

    public function addCheck($routeName, $permissionType, $result)
    {
        $this->data[] = [
            'routeName' => $routeName,
            'permissionType' => $permissionType,
            'result' => $result
        ];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Container $container
     */
    public function setSessionContainer($container)
    {
        $this->sessionContainer = $container;
    }

    /**
     * @return \Auth\Entity\ACL\Role[]
     *
     * @throws \Exception
     */
    public function getRoles()
    {
        return $this->sessionContainer->getRoles();
    }
}