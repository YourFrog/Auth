<?php

namespace Auth;

use Auth\EventManager\AuthEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

/**
 *  Podstawowy moduł aplikacji
 *
 * @package Application
 */
class Module
{
    /**
     *  Podpięcie pod bootstrap'a
     *
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $config = $e->getApplication()->getServiceManager()->get('config');

        $authEvent = new AuthEvent();
        $authEvent->setConfig($config['auth']);

        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$authEvent, 'dispatchEvent'], 100);

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     *  Zwrócenie konfiguracji
     *
     * @return array
     */
    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/router.module.config.php',
            include __DIR__ . '/config/doctrine.module.config.php'
        );
    }

    /**
     *  Zwrócenie danych do autoloadera
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
