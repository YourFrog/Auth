<?php

namespace Auth\Entity\User\Repository;

use Doctrine\ORM\EntityRepository;
use Auth\Form\Login as LoginForm;
use Auth\Entity\User\Account as AccountEntity;

/**
 *  Repozytorium obsługujące konta użytkowników
 *
 * @package Auth\Entity
 */
class Account extends EntityRepository
{
    /**
     *  Odnajduje konto na podstawie adresu e-mail
     *
     * @param string $email
     *
     * @return AccountEntity
     */
    public function findByEmail($email)
    {
        $criteria = [
            'email' => $email
        ];

        return $this->findOneBy($criteria);
    }

    /**
     *  Zwraca konto użytkownika pasujące do formularza logowania
     *
     * @param LoginForm $form
     *
     * @return null|AccountEntity
     */
    public function findByLoginForm(LoginForm $form)
    {
        return $this->findByLoginAndPassword($form->getLogin(), $form->getPassword());
    }

    /**
     *  Odnajduje konto na podstawie loginu i hasła
     *
     * @param string $login
     * @param string $password
     *
     * @return null|AccountEntity
     */
    public function findByLoginAndPassword($login, $password)
    {
        $criteria = [
            'login' => $login,
        ];

        /** @var AccountEntity $entity */
        $entity = $this->findOneBy($criteria);

        if( $entity === null ) {
            return null;
        }

        if( $entity->comparePassword($password) ) {
            return $entity;
        }

        return null;
    }

    /**
     *  Sprawdza czy istnieje login w bazie danych
     *
     * @param string $login
     *
     * @return boolean
     */
    public function loginIsExists($login)
    {
        $criteria = [
            'login' => $login
        ];

        return ($this->findOneBy($criteria) !== null);
    }

    /**
     *  Sprawdza czy istnieje email w bazie danych
     *
     * @param $email
     *
     * @return boolean
     */
    public function emailIsExists($email)
    {
        return ($this->findByEmail($email) !== null);
    }
}