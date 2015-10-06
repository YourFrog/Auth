<?php

namespace Auth\Business\Proccess;

use Auth\Configuration\RedirectConfig;
use Auth\EventManager\AuthEvent;
use Auth\Service\Session;
use Auth\EntityManager\Repository;
use Zend\EventManager\EventManager;
use Zend\Mvc\Controller\Plugin\Redirect;

/**
 *  Obsługa wylogowania z aplikacji
 *
 * @package Auth\Business\Proccess
 */
class SignOut
{
    /**
     * @var Session\Container
     */
    private $sessionContainer;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var RedirectConfig
     */
    private $redirectConfiguration;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @param Session\Container $sessionContainer
     */
    public function setSessionContainer($sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * @param Repository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager($eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param RedirectConfig $redirectConfiguration
     */
    public function setRedirectConfiguration($redirectConfiguration)
    {
        $this->redirectConfiguration = $redirectConfiguration;
    }

    /**
     * @param Redirect $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     *  Wylogowanie
     *
     * @throws \Exception
     */
    public function signOut()
    {
        $repo = $this->repository->createAclRole();

        $this->eventManager->trigger(AuthEvent::EVENT_PRE_LOGOUT, null, ['session' => $this->sessionContainer]);

        $this->sessionContainer->clear();
        $this->sessionContainer->setRoles($repo->getDefaultRoles());

        $routeName = $this->redirectConfiguration->getAfterLogout();

        $this->eventManager->trigger(AuthEvent::EVENT_POST_LOGOUT);
        $this->redirect->toRoute($routeName);
    }
}