<?php

namespace Auth\Controller\Website;

use Auth\Controller\Abstracts\AuthController;
use Zend\View\Model\ViewModel;
use Exception;

use Auth\Form\Login as LoginForm;
use Auth\Form\Register as RegisterForm;
use Auth\Form\ReminderPassword as ReminderPasswordForm;

/**
 *  Obsługa logowania do systemu
 *
 * @package Auth\Controller
 */
class LoginController extends AuthController
{
    /**
     *  Logowanie do systemu
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        $formClass = new LoginForm();
        $loginForm = $formClass->createForm($builder);

        $request = $this->getRequest();

        if( $request->isPost() ) {
            $loginForm->setData($request->getPost());

            if( $loginForm->isValid() ) {
                $repo = $this->getEntityManager()->getAccountRepository();
                $accountEntity = $repo->findByLoginForm($formClass);

                if( $accountEntity !== null ) {
                    $sessionContainer = $this->getSessionContainer();
                    $sessionContainer->setRoles($accountEntity->getRoles());

                    $this->redirectToAfterLoginPage();
                }
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $loginForm);

        return $viewModel;
    }

    /**
     *  Wylogowanie użytkownika
     */
    public function logoutAction()
    {
        $repo = $this->getEntityManager()->getRoleRepository();

        $sessionContainer = $this->getSessionContainer();
        $sessionContainer->clear();
        $sessionContainer->addRole($repo->getDefaultRole());

        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $this->serviceLocator->get('auth.configuration');
        $redirectConfiguration = $moduleConfiguration->getRedirectConfiguration();

        $routeName = $redirectConfiguration->getAfterLogout();

        $this->redirect()->toRoute($routeName);
    }

    /**
     *  Rejestracja konta w systemie
     */
    public function registerAction()
    {
        /** @var \Auth\Business\Account $businessAccount */
        $businessAccount = $this->serviceLocator->get('auth.business.account');


        /** @var \Zend\Form\Annotation\AnnotationBuilder $builder */
        $builder = $this->serviceLocator->get('auth.form.annotation.builder');

        $registerFormClass = new RegisterForm();
        $registerForm = $registerFormClass->createForm($builder);

        $request = $this->getRequest();

        if( $request->isPost() ) {
            $registerForm->setData($request->getPost());

            if( $registerForm->isValid() ) {
                try {
                    /** @var \Auth\Business\Account $businessAccount */
                    $businessAccount = $this->serviceLocator->get('auth.business.account');
                    $businessAccount->register($registerFormClass);

                    $this->redirect()->toRoute('user/after-register');
                } catch(Exception $e) {
                    //Rejestracja się nie powiodła
                }
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $registerForm);

        return $viewModel;
    }

    public function afterRegisterAction()
    {
        // Tylko dla celów obsługi
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
                $accountRepository = $this->getEntityManager()->getAccountRepository();
                $accountEntity = $accountRepository->findByEmail($passwordReminderFormClass->getEmail());

                $password = $accountEntity->generateRandomPassword();
                $accountEntity->setPassword($password);

                echo 'znaleziono';
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $form);

        return $viewModel;
    }
}