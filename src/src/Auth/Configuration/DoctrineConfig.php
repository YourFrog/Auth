<?php

namespace Auth\Configuration;

/**
 *  Konfiguracja doctrine
 *
 * @package Auth\Configuration
 */
class DoctrineConfig extends AbstractConfig
{
    /**
     *  Scieżka w której znajduje się konfiguracja
     *
     * @return string
     */
    protected function getKeyPath()
    {
        return 'auth.doctrine';
    }

    /**
     *  Zwraca klucz do konfiguracji doctrine
     *
     * @return string
     *
     * @throws Exception\UnknownConfigurationException
     */
    public function getORM()
    {
        return $this->getOption('orm');
    }
}