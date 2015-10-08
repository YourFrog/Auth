<?php

namespace Auth\Business\Proccess;

use Auth\Configuration\RedirectConfig;
use Auth\EventManager\AuthEvent;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Auth\Form\ReminderPassword as ReminderPasswordForm;
use Zend\Form\Form;
use Zend\Http\Request;
use Auth\EntityManager\Repository;
use Zend\EventManager\EventManager;
use Zend\Mvc\Controller\Plugin\Redirect;

/**
 *  Proces przypominania hasła
 *
 * @package Auth\Business\Proccess
 */
class PasswordReminder
{
    /**
     * @var AnnotationBuilder
     */
    private $annotationBuilder;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var \Auth\EntityManager\Repository
     */
    private $repository;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RedirectConfig
     */
    private $redirectConfiguration;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @var ReminderPasswordForm
     */
    private $formClass;

    /**
     * @param mixed $annotationBuilder
     */
    public function setAnnotationBuilder($annotationBuilder)
    {
        $this->annotationBuilder = $annotationBuilder;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Repository $repository
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param RedirectConfig $redirectConfiguration
     */
    public function setRedirectConfiguration(RedirectConfig $redirectConfiguration)
    {
        $this->redirectConfiguration = $redirectConfiguration;
    }

    /**
     * @param Redirect $redirect
     */
    public function setRedirect(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    public function passwordReminder()
    {
        $form = $this->getPasswordReminderForm();
        $form->setData($this->request->getPost());

        if( $form->isValid() === false ) {
            return;
        }

        $accountEntity = $this->getAccount();

        $password = $accountEntity->generateRandomPassword();
        $accountEntity->setPassword($password);

        $this->entityManager->persist($accountEntity);
        $this->entityManager->flush();

        $this->redirect();
    }

    /**
     *  Przekierowanie
     */
    private function redirect()
    {
        $routeName = $this->redirectConfiguration->getAfterPasswordReminder();

        $this->eventManager->trigger(AuthEvent::EVENT_REMINDER_PASSWORD);
        $this->redirect->toRoute($routeName);
    }

    /**
     * @return \Auth\Entity\User\Account
     */
    private function getAccount()
    {
        $email = $this->getFormClass()->getEmail();

        $accountRepository = $this->repository->createUserAccount();
        return $accountRepository->findByEmail($email);
    }

    /**
     * @return Form
     */
    public function getPasswordReminderForm()
    {
        $formClass = $this->getFormClass();

        $form = $this->annotationBuilder->createForm($formClass);
        $form->bind($formClass);

        return $form;
    }

    /**
     * @return ReminderPasswordForm
     */
    private function getFormClass()
    {
        if( $this->formClass === null ) {
            $this->formClass = new ReminderPasswordForm();
        }

        return $this->formClass;
    }
}