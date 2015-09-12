<?php

namespace Auth\Form\Validate;

/**
 *  Udostępnia do walidatora entityManager
 *
 * @package Auth\Form
 */
interface DoctrineEntityManagerInterface
{
    /**
     *  Ustawia entityManagera dla walidatora
     *
     * @param \Auth\EntityManager\EntityManager $entityManager
     */
    public function setEntityManager($entityManager);
}