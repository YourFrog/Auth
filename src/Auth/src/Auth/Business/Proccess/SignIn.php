<?php

namespace Auth\Business\Proccess;

use Auth\Form\Login as LoginForm;
use Zend\Form\Form;
use Zend\Form\Annotation\AnnotationBuilder;

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
     * @param AnnotationBuilder $annotationBuilder
     */
    public function setAnnotationBuilder(AnnotationBuilder $annotationBuilder)
    {
        $this->annotationBuilder = $annotationBuilder;
    }

    public function signIn()
    {
        $loginForm = $this->getLoginForm();
        $loginForm->setData($request->getPost());

        if( $loginForm->isValid() ) {
            /** @var \Auth\EntityManager\Repository $repository */
            $repository = $this->getServiceLocator()->get('auth.repository');
            $accountRepository = $repository->createUserAccount();
            $accountEntity = $accountRepository->findByLoginForm($formClass);

            if( $accountEntity !== null ) {
                $sessionContainer = $this->getSessionContainer();
                $sessionContainer->setRoles($accountEntity->getRoles());

                $this->serviceLocator->get('Application')->getEventManager()->trigger(AuthEvent::EVENT_SIGN_IN, null, ['sessionContainer' => $sessionContainer]);
                $this-> ()->trigger(AuthEvent::EVENT_SIGN_IN, null, ['sessionContainer' => $sessionContainer]);
                $this->redirectToAfterLoginPage();
            }
        }

        return new ViewModel([
            'form' => $loginForm
        ]);
    }

    /**
     *  Zwraca formularz logowania
     *
     * @return Form
     */
    public function getLoginForm()
    {
        $formClass = new LoginForm();

        $form = $this->annotationBuilder->createForm($formClass);
        $form->bind($formClass);

        return $form;
    }
}