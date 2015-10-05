<?php

namespace Auth\Form\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Validator\ValidatorChain;
use Zend\InputFilter;
use Zend\Form;

/**
 *  Fabryka budująca annotation buildera
 *
 * @package Auth
 */
class AnnotationBuilder implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $validateChain = new ValidatorChain();
        $validateChain->setPluginManager($serviceLocator->get('ValidatorManager'));

        $input = new InputFilter\Factory();
        $input->setDefaultValidatorChain($validateChain);

        $formFactory = new Form\Factory($serviceLocator->get('FormElementManager'));
        $formFactory->setInputFilterFactory($input);

        $annotationBuilder = new Form\Annotation\AnnotationBuilder();
        $annotationBuilder->setFormFactory($formFactory);

        return $annotationBuilder;
    }
}