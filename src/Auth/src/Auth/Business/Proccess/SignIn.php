<?php

namespace Auth\Business\Proccess;

use Auth\Configuration\RedirectConfig;
use Auth\EventManager\AuthEvent;
use Auth\Form\Login as LoginForm;
use Zend\EventManager\EventManager;
use Zend\Form\Form;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\View\Model\ViewModel;
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
     * @var LoginForm
     */
    private $loginForm;

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
     * @return ViewModel
     *
     * @throws \Exception
     */
    public function signIn()
    {
        $loginForm = $this->getLoginForm();
        $loginForm->setData($this->request->getPost());

        if( $loginForm->isValid() ) {

            $account = $this->getAccount();

            $this->sessionContainer->setRoles($account->getRoles());

            $this->eventManager->trigger(AuthEvent::EVENT_SIGN_IN, null, ['sessionContainer' => $this->sessionContainer]);
            $this->redirectToAfterLoginPage();
        }

        return new ViewModel([
            'form' => $loginForm
        ]);
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
        $formClass = $this->getFormClass();

        $form = $this->annotationBuilder->createForm($formClass);
        $form->bind($formClass);

        return $form;
    }

    /**
     *  Zwraca klasę z której jest tworzony formularz
     *
     * @return LoginForm
     */
    private function getFormClass()
    {
        if( $this->loginForm === null ) {
            $this->loginForm = new LoginForm();
        }

        return $this->loginForm;
    }
}