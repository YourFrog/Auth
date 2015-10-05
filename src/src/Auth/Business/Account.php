<?php

namespace Auth\Business;

use Auth\EventManager\AuthEvent;
use Doctrine\ORM\EntityManagerInterface;
use Auth\Form\Register as FormRegister;
use Mailer\Entity\Mailer as MailerEntity;
use Zend\EventManager\EventManager;
use Auth\Entity\ACL\Repository\Role as RoleRepository;

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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     *  Obiekt obsługujący zdarzenia
     *
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     *  Klasa formularza wykorzystywana do rejestracji
     *
     * @var FormRegister
     */
    private $formClass;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
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
        $entity = $this->formClass->getAccountEntity();

        foreach($this->roleRepository->getRegisterRoles() as $role) {
            $entity->addRole($role);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param RoleRepository $roleRepository
     */
    public function setRoleRepository(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
}