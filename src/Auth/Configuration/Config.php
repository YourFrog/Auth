<?php

namespace Auth\Configuration;

/**
 *  Klasa pomagajaca obslugiwac konfiguracje modulu
 *
 * @package Auth\Configuration
 */
class Config extends AbstractConfig
{
    const KEY_REDIRECT = 'redirect';
    const KEY_MAILER = 'mailer';

    /**
     *  Scieżka w której znajduje się konfiguracja
     *
     * @return string
     */
    protected function getKeyPath()
    {
        return 'auth';
    }

    /**
     *  Zwraca klasę obsługujc przekierowania w module
     *
     * @return RedirectConfig
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getRedirectConfiguration()
    {
        $options = $this->getOption(self::KEY_REDIRECT);

        return new RedirectConfig($options);
    }

    /**
     *  Zwraca konfiguracje mailera dla modułu
     *
     * @return MailerConfig
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getMailerConfiguration()
    {
        $options = $this->getOption(self::KEY_MAILER);

        return new MailerConfig($options);
    }
}