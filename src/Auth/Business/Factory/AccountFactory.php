<?php

namespace Auth\Business\Factory;

use Auth\Business;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka tworzaca obsługę biznesowa kont
 *
 * @package Auth\Business\Factory
 */
class AccountFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Auth\EntityManager\EntityManager $entityManager */
        $entityManager = $serviceLocator->get('auth.entitymanager');

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $serviceLocator->get('EventManager');

        /** @var \Auth\Mailer\RegisterParser $mailerRegister */
        $mailerRegister = $serviceLocator->get('auth.mailer.register');

        $object = new Business\Account();
        $object->setEntityManager($entityManager);
        $object->setEventManager($eventManager);
        $object->setMailerRegister($mailerRegister);

        return $object;
    }
}