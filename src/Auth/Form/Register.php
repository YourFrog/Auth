<?php

namespace Auth\Form;

use Auth\Entity\User\Account as AccountEntity;
use Zend\Form\Annotation;

/**
 *  Formularz rejestracji w systemie
 *
 * @package Auth\Form
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("RegisterForm")
 */
class Register
{
    /**
     *  Proponowany login
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":32}})
     * @Annotation\Validator({"name":"LoginIsNotExists"})
     * @Annotation\Options({"label":"Login:"})
     */
    public $login;

    /**
     *  Adres e=mail na który zostanie założone konto
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * @Annotation\Validator({"name":"StringCompare", "options":{"fields":{"email", "reEmail"}, "message": "Adresy e-mail nie są jednakowe"}})
     * @Annotation\Validator({"name":"EmailIsNotExists"})
     * @Annotation\Options({"label":"Email:"})
     */
    public $email;

    /**
     *  Powtórzony adres email
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * @Annotation\Options({"label":"Powtórz email:"})
     */
    public $reEmail;

    /**
     *  Nie zaszyfrowane hasło do konta
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"3", "max":"12"}})
     * @Annotation\Validator({"name":"StringCompare", "options":{"fields":{"password", "rePassword"}, "message": "Hasła nie są identyczne"}})
     * @Annotation\Options({"label":"Hasło:"})
     */
    public $password;

    /**
     *  Powtórzone nie zaszyfrowane hasło
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"3", "max":"12"}})
     * @Annotation\Options({"label":"Powtórz hasło:"})
     */
    public $rePassword;

    /**
     *  Przycisk do zatwierdzenia formularza
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Submit")
     */
    public $submit = 'Zarejestruj się';

    /**
     *  Utworzenie formularza
     *
     * @return \Zend\Form\Form
     */
    public function createForm(Annotation\AnnotationBuilder $annotationBuilder)
    {
        $form = $annotationBuilder->createForm($this);
        $form->bind($this);

        return $form;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *  Zwraca encje opisujące konta
     *
     * @return AccountEntity
     */
    public function getAccountEntity()
    {
        $entity = new AccountEntity();
        $entity->setLogin($this->login);
        $entity->setEmail($this->email);
        $entity->setPassword($this->password);

        return $entity;
    }
}