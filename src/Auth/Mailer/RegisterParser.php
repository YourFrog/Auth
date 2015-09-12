<?php

namespace Auth\Mailer;

use Twig_Environment;
use Auth\Form;
use Auth\Configuration;

/**
 *  Klasa obsługujaca parsowanie szablonu z trescia wiadomości po instalacyjnej
 *
 * @package Auth\Mailer
 */
class RegisterParser
{
    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @var Configuration\MailerConfig
     */
    private $mailerConfiguration;

    /**
     * @param Twig_Environment $twigEnvironment
     */
    public function setTwigEnvironment(Twig_Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * @param Configuration\MailerConfig $mailerConfiguration
     */
    public function setMailerConfiguration(Configuration\MailerConfig $mailerConfiguration)
    {
        $this->mailerConfiguration = $mailerConfiguration;
    }

    /**
     *  Parsowanie treści wiadomości
     *
     * @param Form\Register $registerFormClass
     *
     * @return string
     */
    public function parseContent(Form\Register $registerFormClass)
    {
        $mailerRegisterConfig = $this->mailerConfiguration->getRegisterConfiguration();

        return $this->twigEnvironment->render($mailerRegisterConfig['content-template'], [
            'user' => [
                'login' => $registerFormClass->getLogin(),
                'password' => $registerFormClass->getPassword()
            ]
        ]);
    }

    /**
     *  Zwraca tytuł maila rejestracyjnego
     *
     * @return string
     */
    public function getSubject()
    {
        $configuration = $this->mailerConfiguration->getRegisterConfiguration();

        return $configuration['subject'];
    }
}