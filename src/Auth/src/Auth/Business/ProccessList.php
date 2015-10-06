<?php

namespace Auth\Business;

use Auth\Business\Proccess\SignIn;
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
     *  Stworzenie procesu biznesowego dotyczącego logowania
     *
     * @return SignIn
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

        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $this->serviceLocator->get('auth.configuration');
        $redirectConfiguration = $moduleConfiguration->getRedirectConfiguration();

        $object = new SignIn();
        $object->setAnnotationBuilder($builder);
        $object->setRequest($request);
        $object->setRepository($repository);
        $object->setSessionContainer($container);
        $object->setEventManager($eventManager);
        $object->setRedirectConfiguration($redirectConfiguration);
        $object->setRedirect($redirect);

        return $object;
    }
}