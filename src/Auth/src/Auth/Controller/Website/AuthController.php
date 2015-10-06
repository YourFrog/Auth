<?php

namespace Auth\Controller\Website;

use Auth\Controller\Abstracts\AbstractAuthController;
use Auth\EventManager\AuthEvent;
use Zend\View\Model\ViewModel;
use Auth\Form\ReminderPassword as ReminderPasswordForm;

/**
 *  Obsługa logowania do systemu
 *
 * @package Auth\Controller
 */
class AuthController extends AbstractAuthController
{
    /**
     *  Brak uprawnień
     */
    public function disallowAction()
    {

    }

    /**
     *  Logowanie do systemu
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $business = $this->getBusinessProccessList();
        $proccess = $business->createSignIn();

        if( $this->getRequest()->isPost() ) {
            $proccess->signIn();
        }

        return new ViewModel([
            'form' => $proccess->getLoginForm()
        ]);
    }

    /**
     *  Wylogowanie użytkownika
     */
    public function logoutAction()
    {
        $business = $this->getBusinessProccessList();
        $proccess = $business->createSignOut();
        $proccess->signOut();
    }

    /**
     *  Rejestracja konta w systemie
     */
    public function registerAction()
    {
        $business = $this->getBusinessProccessList();
        $proccess = $business->createRegister();

        if( $this->getRequest()->isPost() ) {
            $proccess->register();
        }

        return new ViewModel([
            'form' => $proccess->getRegisterForm()
        ]);
    }

    /**
     *  Przypomnienie hasła
     *
     * @return ViewModel
     */
    public function passwordReminderAction()
    {
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        $passwordReminderFormClass = new ReminderPasswordForm();
        $form = $passwordReminderFormClass->createForm($builder);

        $request = $this->getRequest();

        if( $request->isPost() ) {
            $form->setData($request->getPost());

            if( $form->isValid() ) {
                /** @var \Auth\EntityManager\Repository $repository */
                $repository = $this->getServiceLocator()->get('auth.repository');
                $accountRepository = $repository->createUserAccount();
                $accountEntity = $accountRepository->findByEmail($passwordReminderFormClass->getEmail());

                $password = $accountEntity->generateRandomPassword();
                $accountEntity->setPassword($password);

                $this->getEntityManager()->persist($accountEntity);
                $this->getEntityManager()->flush();

                $this->serviceLocator->get('Application')->getEventManager()->trigger(AuthEvent::EVENT_REMINDER_PASSWORD);
                $this->redirectToAfterReminderPasswordPage();
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);

        return $viewModel;
    }

    /**
     *  Poprawne przypomnienie hasła
     */
    public function afterPasswordReminderAction()
    {

    }
}