<?php

namespace Auth\Controller\Website;

use Auth\Controller\Abstracts\AbstractAuthController;
use Zend\View\Model\ViewModel;

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
        $business = $this->getBusinessProccessList();
        $proccess = $business->createPasswordReminder();

        if( $this->getRequest()->isPost() ) {
            $proccess->passwordReminder();
        }

        return new ViewModel([
           'form' => $proccess->getPasswordReminderForm()
        ]);
    }

    /**
     *  Poprawne przypomnienie hasła
     */
    public function afterPasswordReminderAction()
    {

    }
}