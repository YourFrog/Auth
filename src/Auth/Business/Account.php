<?php

namespace Auth\Business;

use Auth\EventManager\AuthEvent;
use Auth\Mailer;
use Auth\EntityManager\EntityManager;
use Auth\Form\Register as FormRegister;
use Mailer\Entity\Mailer as MailerEntity;
use Zend\EventManager\EventManager;

/**
 *  Klasa obsługujaca procesy biznesowe
 *
 * @package Auth\Business
 */
class Account
{
    /**
     *  EntityManager obsługujcy bazę danych
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *  Obiekt obsługujący zdarzenia
     *
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var Mailer\RegisterParser
     */
    private $mailerRegister;

    /**
     *  Klasa formularza wykorzystywana do rejestracji
     *
     * @var FormRegister
     */
    private $formClass;

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param Mailer\RegisterParser $mailerRegister
     */
    public function setMailerRegister(Mailer\RegisterParser $mailerRegister)
    {
        $this->mailerRegister = $mailerRegister;
    }

    /**
     *  Proces biznesowy rejestracji nowego użytkownika
     *
     * @param FormRegister $formClass Klasa opisujaca formularz rejestracyjny
     *
     * @throws \Exception
     */
    public function register(FormRegister $formClass)
    {
        $this->formClass = $formClass;

        $object = $this;
        $this->entityManager->transactional(function() use ($object) {
            $object->process();
        });
    }

    /**
     *  Właściwy proces rejestracji klienta
     */
    protected function process()
    {
        $this->registerAccountEntity();
        $this->runTrigger();
    }

    /**
     *  Uruchamia triggera podpiętego pod rejestracje klienta
     */
    private function runTrigger()
    {
        $params = [
            'formClass' => $this->formClass
        ];

        $this->eventManager->trigger(AuthEvent::EVENT_REGISTER_CLIENT, $this, $params);
    }

    /**
     *  Rejestracja konta klienta
     *
     * @throws \Exception
     */
    private function registerAccountEntity()
    {
        $roleRepository = $this->entityManager->getRoleRepository();
        $entity = $this->formClass->getAccountEntity();

        foreach($roleRepository->getRegisterRoles() as $role) {
            $entity->addRole($role);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}