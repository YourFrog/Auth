<?php

namespace Auth\Configuration;

/**
 *  Klasa pomagajaca obslugiwac konfiguracje modulu
 *
 * @package Auth\Configuration
 */
class Config extends AbstractConfig
{
    /**
     *  Konfiguracja doctrine
     *
     * @return DoctrineConfig
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getDoctrineConfiguration()
    {
        $options = $this->getOption('doctrine');

        return new DoctrineConfig($options);
    }

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
        $options = $this->getOption('redirect');

        return new RedirectConfig($options);
    }
}