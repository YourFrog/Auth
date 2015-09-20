<?php

namespace Auth\EventManager;

use Auth\Entity\ACL\Repository\View\Permission as RepositoryPermission;
use Auth\Entity\ACL\View\Permission as EntityPermission;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Zdarzenie sprawdzające czy osoba jest zarejestrowana
 *
 * @package Auth\EventManager
 */
class AuthEvent
{
    // Zdarzenia
    const EVENT_REGISTER_CLIENT = 'AUTH_REGISTER_CLIENT';
    const EVENT_SIGN_IN = 'AUTH_SIGN_IN';
    const EVENT_PRE_LOGOUT = 'AUTH_PRE_LOGOUT';
    const EVENT_POST_LOGOUT = 'AUTH_POST_LOGOUT';
    const EVENT_REMINDER_PASSWORD = 'AUTH_REMINDER_PASSWORD';

    /**
     *  Zdarzenie które wywołało klasę
     *
     * @var MvcEvent
     */
    private $event;

    /**
     *  ServiceLocator pomagający w wyciąganiu zależności
     *
     * @var ServiceLocatorInterface
     */
    private $serviceManager;

    /**
     *  Aktualna scieżka która została dopasowana do żądania
     *
     * @var RouteMatch
     */
    private $routeMatch;

    /**
     *  Konfiguracja modułu
     *
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     *  Zdarzenie podpięte w modulo do wywołań
     *
     * @param MvcEvent $event
     */
    public function dispatchEvent(MvcEvent $event)
    {
        $this->event = $event;
        $this->serviceManager = $event->getApplication()->getServiceManager();
        $this->routeMatch = $event->getRouteMatch();

        if( $this->isAuthorization() ) {
            return;
        }

        // Przekierujmy go na stronę logowania
        $this->redirect();
    }

    /**
     *  Sprawdza czy klient jest autoryzowany aby podejrzeć aktualną stronę
     *
     * @return bool
     */
    private function isAuthorization()
    {
        if( $this->isRedirectRoute() ) {
            return true;
        }

        $permissionsEntity = $this->getPermissionsViewEntity();

        if( count($permissionsEntity) == 0 ) {
            return false;
        }

        return $permissionsEntity[0]->isAllow();
    }

    /**
     *  Sprawdza czy znajdujemy się na scieżce na którą przekierowujemy z powodu braku uprawnień
     *
     * @return bool
     */
    private function isRedirectRoute()
    {
        return ($this->routeMatch->getMatchedRouteName() == $this->config['redirect']['disallow']);
    }

    /**
     *  Zwraca encje odpowiedzialną za informacje o dostępności w acl
     *
     * @return EntityPermission[]
     */
    private function getPermissionsViewEntity()
    {
        /** @var \Auth\Service\User\Authentication $authentication */
        $authentication = $this->serviceManager->get('auth.service.authentication');
        $roles = $authentication->getRoles();

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->serviceManager->get('doctrine.entitymanager.orm_default');

        /** @var RepositoryPermission $repo */
        $repo = $entityManager->getRepository('Auth\Entity\ACL\View\Permission');

        return $repo->findByResourceAndRoles($this->routeMatch->getMatchedRouteName(), $roles);
    }

    /**
     *  Przekierowanie na stronę logowania
     */
    private function redirect()
    {
        $url = $this->event->getRouter()->assemble([], ['name' => $this->config['redirect']['disallow']]);

        $response = $this->event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();
        exit;
    }
}