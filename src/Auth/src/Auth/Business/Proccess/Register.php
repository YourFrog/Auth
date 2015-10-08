<?php

namespace Auth\Business\Proccess;

use Auth\Configuration\RedirectConfig;
use Auth\Form\Register as RegisterClass;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Form\Form;
use Zend\Http\Request;

/**
 *  Rejestracja
 *
 * @package Auth\Business\Proccess
 */
class Register
{
    /**
     * @var Form
     */
    private $registerForm;

    /**
     * @var RegisterClass
     */
    private $registerClass;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @var AnnotationBuilder
     */
    private $annotationBuilder;

    /**
     * @var \Auth\Business\Account
     */
    private $businessAccount;

    /**
     * @var RedirectConfig
     */
    private $redirectConfiguration;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Redirect $redirect
     */
    public function setRedirect(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param AnnotationBuilder $annotationBuilder
     */
    public function setAnnotationBuilder(AnnotationBuilder $annotationBuilder)
    {
        $this->annotationBuilder = $annotationBuilder;
    }

    /**
     * @param \Auth\Business\Account $businessAccount
     */
    public function setBusinessAccount(\Auth\Business\Account $businessAccount)
    {
        $this->businessAccount = $businessAccount;
    }

    /**
     * @param RedirectConfig $redirectConfiguration
     */
    public function setRedirectConfiguration(RedirectConfig $redirectConfiguration)
    {
        $this->redirectConfiguration = $redirectConfiguration;
    }

    /**
     *  Rejestracja nowego konta
     */
    public function register()
    {
        $registerForm = $this->getRegisterForm();

        $registerForm->setData($this->request->getPost());

        if( $registerForm->isValid() == false ) {
            return;
        }

        try {
            $this->businessAccount->register($this->getRegisterClass());

            $routeName = $this->redirectConfiguration->getAfterRegisterPage();

            $this->redirect->toRoute($routeName);
        } catch(\Exception $e) {
            //Rejestracja się nie powiodła
            //@TODO wymyśleć co zrobić gdy się wywoła bład...
        }
    }

    /**
     * @return Form
     */
    public function getRegisterForm()
    {
        if( $this->registerForm === null ) {
            $formClass = $this->getRegisterClass();

            $this->registerForm = $this->annotationBuilder->createForm($formClass);
            $this->registerForm->bind($this);
        }

        return $this->registerForm;
    }

    /**
     * @return RegisterClass
     */
    private function getRegisterClass()
    {
        if( $this->registerClass === null) {
            $this->registerClass = new RegisterClass();
        }

        return $this->registerClass;
    }
}