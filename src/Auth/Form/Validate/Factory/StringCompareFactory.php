<?php

namespace Auth\Form\Validate\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Form\Validate\DoctrineEntityManagerInterface;

use Auth\Form\Validate;

/**
 *  Fabryka tworząca walidatory
 *
 * @package Auth\Form\Validate\Factory
 */
class StringCompareFactory implements FactoryInterface
{
    /**
     *  Tablica z opcjami przekazywanymi do validatora
     *
     * @var array
     */
    private $options;

    /**
     *  Konstruktor
     *
     * @param array $options Tablica z opacjami z którymi chcemy utworzyć validator
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $object = new Validate\StringCompare();
        $object->setOptions($this->options);

        if( $object instanceof DoctrineEntityManagerInterface ) {
            $entityManager = $serviceLocator->getServiceLocator()->get('auth.entitymanager');
            $object->setEntityManager($entityManager);
        }

        return $object;
    }
}