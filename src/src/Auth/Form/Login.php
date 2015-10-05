<?php

namespace Auth\Form;

use Zend\Form\Annotation;

/**
 *  Formularz logowania do aplikacji
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("LoginForm")
 */
class Login
{
    /**
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":32}})
     * @Annotation\Validator({"name":"LoginIsExists", "break_chain_on_failure":true})
     * @Annotation\Validator({"name":"AccountDataCorrect"})
     * @Annotation\Options({"label":"Login:"})
     */
    public $login;

    /**
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":"3", "max":"12"}})
     * @Annotation\Options({"label":"Hasło:"})
     */
    public $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     */
    public $submit = "Zaloguj się";

    /**
     *  Zwraca zakodowane hasło
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }
}