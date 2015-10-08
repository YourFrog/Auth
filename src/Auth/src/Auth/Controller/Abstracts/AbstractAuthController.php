<?php

namespace Auth\Controller\Abstracts;

use Auth\Business\ProccessList;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Request;

/**
 *  Abstrakcyjny kontroller udostępniający metody ułatwiające pracę z autoryzacja
 *
 * @method Request getRequest() Wskazanie konkretnej zwracanej klasy
 */
abstract class AbstractAuthController extends AbstractActionController
{
    /**
     * @return ProccessList
     */
    protected function getBusinessProccessList()
    {
        return $this->serviceLocator->get('auth.business');
    }
}