<?php

namespace Auth\Controller\Abstracts;

use Auth\Business\ProccessList;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 *  Abstrakcyjny kontroller udostępniający metody ułatwiające pracę z autoryzacja
 *
 * @method \Zend\Http\PhpEnvironment\Request getRequest() Wskazanie konkretnej zwracanej klasy
 */
abstract class AbstractAuthController extends AbstractActionController
{
    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->serviceLocator->get('auth.entitymanager');
    }

    /**
     * @return ProccessList
     */
    protected function getBusinessProccessList()
    {
        return $this->serviceLocator->get('auth.business');
    }

    /**
     * @return \Auth\Service\Session\Container
     */
    protected function getSessionContainer()
    {
        return $this->serviceLocator->get('auth.session.container');
    }

    /**
     *  Przekierowanie na stronę po zalogowaniu
     */
    protected function redirectToAfterLoginPage()
    {
        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $this->serviceLocator->get('auth.configuration');
        $redirectConfiguration = $moduleConfiguration->getRedirectConfiguration();

        $routeName = $redirectConfiguration->getAfterLogin();
        $this->redirect()->toRoute($routeName);
    }

    /**
     *  Przekierowanie na stronę po przypomnieniu hasła
     */
    protected function redirectToAfterReminderPasswordPage()
    {
        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $this->serviceLocator->get('auth.configuration');
        $redirectConfiguration = $moduleConfiguration->getRedirectConfiguration();

        $routeName = $redirectConfiguration->getAfterPasswordReminder();
        $this->redirect()->toRoute($routeName);
    }
}