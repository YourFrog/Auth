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
        /** @var \Zend\Form\Annotation\AnnotationBuilder $builder */
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        $object = new SignIn();
        $object->setAnnotationBuilder($builder);

        return $object;
    }
}