<?php

namespace Auth\Form;

use Zend\Form\Annotation;

/**
 *  Formularz rejestracji w systemie
 *
 * @package Auth\Form
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("ReminderPasswordForm")
 */
class ReminderPassword
{
    /**
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * @Annotation\Validator({"name":"EmailIsExists"})
     * @Annotation\Options({"label":"Email:"})
     */
    public $email;

    /**
     *  Przycisk zatwierdzający wysłanie danych
     *
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Submit")
     */
    public $submit = 'Wyślij hasło';

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}