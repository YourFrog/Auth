<?php

namespace Auth\Business;

use Auth\Business\Proccess;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Klasa obsługująca procesy biznesowe logowań
 *
 * @package Auth\Business
 */
class ProccessList
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return Proccess\SignOut
     */
    public function createSignOut()
    {
        /** @var \Auth\EntityManager\Repository $repository */
        $repository = $this->serviceLocator->get('auth.repository');

        /** @var \Auth\Service\Session\Container $container */
        $container = $this->serviceLocator->get('auth.session.container');

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $this->serviceLocator->get('Application')->getEventManager();

        /** @var \Zend\Mvc\Controller\Plugin\Redirect $redirect */
        $redirect = $this->serviceLocator->get('ControllerPluginManager')->get('redirect');

        $redirectConfiguration = $this->getRedirectConfiguration();

        $object = new Proccess\SignOut();
        $object->setRedirect($redirect);
        $object->setRedirectConfiguration($redirectConfiguration);
        $object->setRepository($repository);
        $object->setSessionContainer($container);
        $object->setEventManager($eventManager);

        return $object;
    }

    /**
     *  Stworzenie procesu biznesowego dotyczącego logowania
     *
     * @return Proccess\SignIn
     */
    public function createSignIn()
    {
        /** @var \Auth\EntityManager\Repository $repository */
        $repository = $this->serviceLocator->get('auth.repository');

        /** @var \Zend\Form\Annotation\AnnotationBuilder $builder */
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        /** @var \Zend\Http\Request $request */
        $request = $this->serviceLocator->get('request');

        /** @var \Auth\Service\Session\Container $container */
        $container = $this->serviceLocator->get('auth.session.container');

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $this->serviceLocator->get('Application')->getEventManager();

        /** @var \Zend\Mvc\Controller\Plugin\Redirect $redirect */
        $redirect = $this->serviceLocator->get('ControllerPluginManager')->get('redirect');

        $redirectConfiguration = $this->getRedirectConfiguration();

        $object = new Proccess\SignIn();
        $object->setAnnotationBuilder($builder);
        $object->setRequest($request);
        $object->setRepository($repository);
        $object->setSessionContainer($container);
        $object->setEventManager($eventManager);
        $object->setRedirectConfiguration($redirectConfiguration);
        $object->setRedirect($redirect);

        return $object;
    }

    /**
     * @return Proccess\Register
     */
    public function createRegister()
    {
        /** @var \Zend\Form\Annotation\AnnotationBuilder $builder */
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        /** @var \Zend\Http\Request $request */
        $request = $this->serviceLocator->get('request');

        /** @var \Zend\Mvc\Controller\Plugin\Redirect $redirect */
        $redirect = $this->serviceLocator->get('ControllerPluginManager')->get('redirect');

        /** @var \Auth\Business\Account $businessAccount */
        $businessAccount = $this->serviceLocator->get('auth.business.account');

        $redirectConfiguration = $this->getRedirectConfiguration();

        $object = new Proccess\Register();
        $object->setRequest($request);
        $object->setRedirect($redirect);
        $object->setBusinessAccount($businessAccount);
        $object->setAnnotationBuilder($builder);
        $object->setRedirectConfiguration($redirectConfiguration);

        return $object;
    }

    /**
     * @return \Auth\Configuration\RedirectConfig
     */
    private function getRedirectConfiguration()
    {
        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $this->serviceLocator->get('auth.configuration');
        return $moduleConfiguration->getRedirectConfiguration();
    }

    /**
     * @return Proccess\PasswordReminder
     */
    public function createPasswordReminder()
    {
        /** @var \Zend\Form\Annotation\AnnotationBuilder $builder */
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        /** @var \Zend\Http\Request $request */
        $request = $this->serviceLocator->get('request');

        /** @var \Auth\EntityManager\Repository $repository */
        $repository = $this->serviceLocator->get('auth.repository');

        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $this->serviceLocator->get('auth.entitymanager');

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $this->serviceLocator->get('Application')->getEventManager();

        /** @var \Zend\Mvc\Controller\Plugin\Redirect $redirect */
        $redirect = $this->serviceLocator->get('ControllerPluginManager')->get('redirect');

        $redirectConfiguration = $this->getRedirectConfiguration();

        $object = new Proccess\PasswordReminder();
        $object->setRepository($repository);
        $object->setAnnotationBuilder($builder);
        $object->setRequest($request);
        $object->setRedirect($redirect);
        $object->setRedirectConfiguration($redirectConfiguration);
        $object->setEntityManager($entityManager);
        $object->setEventManager($eventManager);

        return $object;
    }
}