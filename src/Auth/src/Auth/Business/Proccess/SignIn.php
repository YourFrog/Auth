<?php

namespace Auth\Business\Proccess;

use Auth\Configuration\RedirectConfig;
use Auth\EventManager\AuthEvent;
use Auth\Form\Login as LoginClass;
use Zend\EventManager\EventManager;
use Zend\Form\Form;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Http\Request;
use Auth\EntityManager\Repository;
use Auth\Service\Session;

/**
 *  Proces biznesowy logowania się
 *
 * @package Auth\Business\Proccess
 */
class SignIn
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
     * @var Session\Container
     */
    private $sessionContainer;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var RedirectConfig
     */
    private $redirectConfiguration;

    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @var Form
     */
    private $loginForm;

    /**
     * @var LoginClass
     */
    private $loginClass;

    /**
     * @param Redirect $redirect
     */
    public function setRedirect(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param RedirectConfig $redirectConfiguration
     */
    public function setRedirectConfiguration(RedirectConfig $redirectConfiguration)
    {
        $this->redirectConfiguration = $redirectConfiguration;
    }

    /**
     * @param AnnotationBuilder $annotationBuilder
     */
    public function setAnnotationBuilder(AnnotationBuilder $annotationBuilder)
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
     * @param Session\Container $sessionContainer
     */
    public function setSessionContainer(Session\Container $sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param Repository $repository
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *  Wykonuje logowanie do aplikacji
     *
     * @throws \Exception
     */
    public function signIn()
    {
        $loginForm = $this->getLoginForm();
        $loginForm->setData($this->request->getPost());

        if( $loginForm->isValid() ) {

            $account = $this->getAccount();

            $this->sessionContainer->setAccount($account);
            $this->sessionContainer->setRoles($account->getRoles());

            $this->eventManager->trigger(AuthEvent::EVENT_SIGN_IN, null, ['sessionContainer' => $this->sessionContainer]);
            $this->redirectToAfterLoginPage();
        }
    }

    /**
     *  Przekierowanie na stronę po zalogowaniu
     */
    protected function redirectToAfterLoginPage()
    {
        $routeName = $this->redirectConfiguration->getAfterLogin();
        $this->redirect->toRoute($routeName);
    }

    /**
     * @return \Auth\Entity\User\Account
     *
     * @throws \Exception
     */
    public function getAccount()
    {
        $accountRepository = $this->repository->createUserAccount();
        $account = $accountRepository->findByLoginForm($this->getFormClass());

        if( $account === null ) {
            throw new \Exception('Nie odnaleziono konta');
        }

        return $account;
    }

    /**
     *  Zwraca formularz logowania
     *
     * @return Form
     */
    public function getLoginForm()
    {
        if( $this->loginForm === null ) {
            $formClass = $this->getFormClass();

            $this->loginForm = $this->annotationBuilder->createForm($formClass);
            $this->loginForm->bind($formClass);
        }

        return $this->loginForm;
    }

    /**
     *  Zwraca klasę z której jest tworzony formularz
     *
     * @return LoginClass
     */
    private function getFormClass()
    {
        if( $this->loginClass === null ) {
            $this->loginClass = new LoginClass();
        }

        return $this->loginClass;
    }
}