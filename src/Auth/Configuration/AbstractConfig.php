<?php

namespace Auth\Configuration;

use Auth\Configuration\Exception\UnknownConfigurationException;

/**
 *  Abstrakcyjna klasa wspomagajaca konfiguracje w aplikacji
 *
 * @package Auth\Configuration
 */
abstract class AbstractConfig
{
    /**
     *  Tablica z opcjami konfiguracji
     *
     * @var array
     */
    private $options;

    /**
     *  Konstruktor
     *
     * @param array $options Tablica z opcjami z konfiguracji
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     *  Scieżka w której znajduje się konfiguracja
     *
     * @return string
     */
    abstract protected function getKeyPath();

    /**
     *  Zwraca wartość spod klucza w konfiguracji
     *
     * @param string $key Klucz pod którym szukamy konfiguracji
     *
     * @return mixed
     *
     * @throws Exception\UnknownConfigurationException
     */
    protected function getOption($key)
    {
        if( array_key_exists($key, $this->options) === false ) {
            $path = $this->getKeyPath() . '.' . $key;
            throw new UnknownConfigurationException('Nie odnaleziono klucza "' . $path . '');
        }

        return $this->options[$key];
    }
}