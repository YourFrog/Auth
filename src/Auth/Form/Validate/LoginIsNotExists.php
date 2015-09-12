<?php

namespace Auth\Form\Validate;

use Auth\EntityManager\EntityManager;
use Zend\Validator\AbstractValidator;
use Auth\Form\Validate\DoctrineEntityManagerInterface;
use Zend\Validator\ValidatorInterface;

/**
 *  Validator sprawdzający czy login NIE istnieje w systemie
 *
 * @package Auth\Form\Validate
 */
class LoginIsNotExists implements DoctrineEntityManagerInterface, ValidatorInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     *  Ustawia entityManagera dla walidatora
     *
     * @param \Auth\EntityManager\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *  Sprawdza czy login istnieje w bazie danych
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        $accountRepository = $this->entityManager->getAccountRepository();
        return ($accountRepository->loginIsExists($value) === false);
    }

    /**
     * Returns an array of messages that explain why the most recent isValid()
     * call returned false. The array keys are validation failure message identifiers,
     * and the array values are the corresponding human-readable message strings.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns an empty array.
     *
     * @return array
     */
    public function getMessages()
    {
        return [
            'LoginIsExists' => 'Istnieje konto o podanym loginie'
        ];
    }
}