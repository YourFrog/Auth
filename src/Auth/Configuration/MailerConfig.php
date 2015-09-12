<?php

namespace Auth\Configuration;

/**
 *  Klasa wspomagajaca obsługę konfiguracji mailera
 *
 * @package Auth\Configuration
 */
class MailerConfig extends AbstractConfig
{
    const KEY_REGISTER = 'register';

    /**
     *  Scieżka w której znajduje się konfiguracja
     *
     * @return string
     */
    protected function getKeyPath()
    {
        return 'auth.mailer';
    }

    /**
     *  Zwraca informacje konfiguracyjne o mailu rejestracyjnym
     *
     * @return string[]
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getRegisterConfiguration()
    {
        return $this->getOption(self::KEY_REGISTER);
    }
}