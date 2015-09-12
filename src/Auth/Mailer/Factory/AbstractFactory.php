<?php

namespace Auth\Mailer\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Abstrakcyjna fabryka tworzaca parsery wiadomości email
 *
 * @package Auth\Mailer\Factory
 */
class AbstractFactory implements AbstractFactoryInterface
{
    /**
     *  Tablica z instancjami które mogą zostać utworzone przez abstrakcyjną fabrykę
     *
     * @var array
     */
    private $instance = [
        'auth.mailer.register' => 'Auth\Mailer\RegisterParser'
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

        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $serviceLocator->get('auth.configuration');

        $object->setTwigEnvironment($serviceLocator->get('\Twig_Environment'));
        $object->setMailerConfiguration($moduleConfiguration->getMailerConfiguration());

        return $object;
    }
}