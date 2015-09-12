<?php

namespace Auth\Form\Validate;

use Auth\EntityManager\EntityManager;
use Zend\Validator\AbstractValidator;
use Auth\Form\Validate\DoctrineEntityManagerInterface;
use Zend\Validator\ValidatorInterface;

/**
 *  Validator sprawdzający czy dwa pola z formularza posiadają tą samą wartość
 *
 * @package Auth\Form\Validate
 */
class StringCompare implements DoctrineEntityManagerInterface, ValidatorInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     *  Opcje walidatora
     *
     * @var array
     */
    private $options;

    /**
     *  Ustawia opcje validatora
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     *  Ustawia entityManagera dla walidatora
     *
     * @param \Auth\EntityManager\EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *  Sprawdza czy login istnieje w bazie danych
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        $data = func_get_arg(1); //Pobranie ukrytego parametru (interfejs zenda go nie przewiduje)
        $fields = $this->options['fields'];

        return (strcmp($data[$fields[0]], $data[$fields[1]]) == 0);
    }

    /**
     * Returns an array of messages that explain why the most recent isValid()
     * call returned false. The array keys are validation failure message identifiers,
     * and the array values are the corresponding human-readable message strings.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns an empty array.
     *
     * @return array
     */
    public function getMessages()
    {
        return [
            'StringCompare' => $this->options['message']
        ];
    }
}