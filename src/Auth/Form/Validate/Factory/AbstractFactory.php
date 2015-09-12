<?php

namespace Auth\Form\Validate\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Form\Validate\DoctrineEntityManagerInterface;

/**
 *  Fabryka tworząca walidatory
 *
 * @package Auth\Form\Validate\Factory
 */
class AbstractFactory implements AbstractFactoryInterface
{
    /**
     *  Tablica z instancjami które mogą zostać utworzone przez abstrakcyjną fabrykę
     *
     * @var array
     */
    private $instance = [
        'LoginIsExists' => 'Auth\Form\Validate\LoginIsExists',
        'LoginIsNotExists' => 'Auth\Form\Validate\LoginIsNotExists',
        'EmailIsNotExists' => 'Auth\Form\Validate\EmailIsNotExists',
        'EmailIsExists' => 'Auth\Form\Validate\EmailIsExists',
        'AccountDataCorrect' => 'Auth\Form\Validate\AccountDataCorrect'
    ];

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return isset($this->instance[$requestedName]);
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $class = $this->instance[$requestedName];
        $object = new $class();

        if( $object instanceof DoctrineEntityManagerInterface ) {
            $entityManager = $serviceLocator->getServiceLocator()->get('auth.entitymanager');
            $object->setEntityManager($entityManager);
        }

        return $object;
    }
}