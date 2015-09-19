<?php

namespace Auth\Controller\Website;

use Auth\Controller\Abstracts\AuthController;
use Auth\EventManager\AuthEvent;
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

                    $this->serviceLocator->get('Application')->getEventManager()->trigger(AuthEvent::EVENT_SIGN_IN, null, ['sessionContainer' => $sessionContainer]);
                    $this->getEventManager()->trigger(AuthEvent::EVENT_SIGN_IN, null, ['sessionContainer' => $sessionContainer]);
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
        $sessionContainer = $this->getSessionContainer();
        $repo = $this->getEntityManager()->getRoleRepository();

        $this->serviceLocator->get('Application')->getEventManager()->trigger(AuthEvent::EVENT_PRE_LOGOUT, null, ['session' => $sessionContainer]);

        $sessionContainer->clear();
        $sessionContainer->setRoles($repo->getDefaultRoles());

        /** @var \Auth\Configuration\Config $moduleConfiguration */
        $moduleConfiguration = $this->serviceLocator->get('auth.configuration');
        $redirectConfiguration = $moduleConfiguration->getRedirectConfiguration();

        $routeName = $redirectConfiguration->getAfterLogout();

        $this->serviceLocator->get('Application')->getEventManager()->trigger(AuthEvent::EVENT_POST_LOGOUT);
        $this->redirect()->toRoute($routeName);
    }

    /**
     *  Rejestracja konta w systemie
     */
    public function registerAction()
    {
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
                    //@TODO wymyśleć co zrobić gdy się wywoła bład...
                }
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariable('form', $registerForm);

        return $viewModel;
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