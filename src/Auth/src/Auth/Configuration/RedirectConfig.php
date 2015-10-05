<?php

namespace Auth\Configuration;

/**
 *  Wspomaganie konfiguracji przekierowań
 *
 * @package Auth\Configuration
 */
class RedirectConfig extends AbstractConfig
{
    const KEY_AFTER_REGISTER = 'after-register';
    const KEY_AFTER_LOGIN = 'after-login';
    const KEY_AFTER_LOGOUT = 'after-logout';
    const KEY_PASSWORD_REMINDER = 'after-password-reminder';

    /**
     *  Nazwa router na który zostanie przekierowana osoba po przypomnieniu hasła
     *
     * @return string
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getAfterPasswordReminder()
    {
        return $this->getoption(self::KEY_PASSWORD_REMINDER);
    }

    /**
     *  Scieżka w której znajduje się konfiguracja
     *
     * @return string
     */
    protected function getKeyPath()
    {
        return 'auth.redirect';
    }

    /**
     *  Nazwa routera na który zostanie przekierowana osoba po rejestracji
     *
     * @return mixed
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getAfterRegisterPage()
    {
        return $this->getOption(self::KEY_AFTER_REGISTER);
    }

    /**
     *  Nazwa routera na który zostanie przekierowania osoba która się zalogowała
     *
     * @return string
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getAfterLogin()
    {
        return $this->getOption(self::KEY_AFTER_LOGIN);
    }

    /**
     *  Nazwa routera na który zostanie przekierowana osoba po PEŁNYM wylogowaniu
     *
     * @return string
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getAfterLogout()
    {
        return $this->getOption(self::KEY_AFTER_LOGOUT);
    }
}