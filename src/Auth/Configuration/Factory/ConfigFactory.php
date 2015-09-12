<?php

namespace Auth\Configuration\Factory;

use Auth\Configuration\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *  Fabryka tworzaca klasę wspomagajaca obsluge konfiguracji modulu
 *
 * @package Auth\Configuration
 */
class ConfigFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $options = $config['auth'];

        return new Config($options);
    }
}