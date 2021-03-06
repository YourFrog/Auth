<?php

namespace Auth\Form\Validate;

use Auth\EntityManager\Repository;
use Zend\Validator\ValidatorInterface;

/**
 *  Validator sprawdzający czy login istnieje w systemie
 *
 * @package Auth\Form\Validate
 */
class LoginIsExists implements RepositoryInterface, ValidatorInterface
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     *  Ustawia repozytorium z którego będziek orzystać walidator
     *
     * @param Repository $repository
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *  Sprawdza czy login istnieje w bazie danych
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        $accountRepository = $this->repository->createUserAccount();
        return $accountRepository->loginIsExists($value);
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
            'LoginIsExists' => 'Login nie został odnaleziony'
        ];
    }
}