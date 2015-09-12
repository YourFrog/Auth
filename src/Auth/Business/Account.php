<?php

namespace Auth\Business;

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

        $params = [
            'formClass' => $this->formClass
        ];

        $this->eventManager->trigger('AUTH_REGISTER_CLIENT', $this, $params);
        $this->registerMail();

        $this->entityManager->flush();
    }

    /**
     *  Rejestracja konta klienta
     *
     * @throws \Exception
     */
    private function registerAccountEntity()
    {
        $roleRepository = $this->entityManager->getRoleRepository();
        $defaultRole = $roleRepository->getDefaultRole();

        $entity = $this->formClass->getAccountEntity();
        $entity->addRole($defaultRole);

        $this->entityManager->persist($entity);
    }

    /**
     *  Rejestracja maila
     */
    private function registerMail()
    {
        $messageEntity = $this->registerMessage();
        $this->registerRecipient($messageEntity);
    }

    /**
     *  Dodanie odbiorcy maila
     *
     * @param MailerEntity\Message $messageEntity Wiadomość do której przypisujemy odbiorcę
     *
     * @return MailerEntity\Recipient
     */
    private function registerRecipient(MailerEntity\Message $messageEntity)
    {
        $recipientEntity = $this->entityManager->createMailerRecipientEntity();
        $recipientEntity->setEmail($this->formClass->getEmail());
        $recipientEntity->setMessage($messageEntity);

        $this->entityManager->persist($recipientEntity);

        return $recipientEntity;
    }

    /**
     *  Dodanie wiadomości do wysłania
     *
     * @return MailerEntity\Message
     */
    private function registerMessage()
    {
        $content = $this->mailerRegister->parseContent($this->formClass);
        $subject = $this->mailerRegister->getSubject();

        $messageEntity = $this->entityManager->createMailerMessageEntity();
        $messageEntity->setSubject($subject);
        $messageEntity->setContent($content);

        $this->entityManager->persist($messageEntity);

        return $messageEntity;
    }
}