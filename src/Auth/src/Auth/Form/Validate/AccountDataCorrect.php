<?php

namespace Auth\Form\Validate;

use Auth\EntityManager\Repository;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Validator\Exception;
use Zend\Validator\ValidatorInterface;

/**
 *
 *
 * @package Auth\Form\Validate
 */
class AccountDataCorrect Implements RepositoryInterface, ValidatorInterface
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
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $data = func_get_arg(1);
        $accountRepository = $this->repository->createUserAccount();

        $login = $data['login'];
        $password = $data['password'];

        $entity = $accountRepository->findByLoginAndPassword($login, $password);

        return ($entity !== null);
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
            'AccountDataCorrect' => 'Nieprawidłowe hasło bądź Login'
        ];
    }
}