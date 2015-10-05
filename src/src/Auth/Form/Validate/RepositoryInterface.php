<?php

namespace Auth\Form\Validate;

use Auth\EntityManager\Repository;

/**
 *  Informacja o możliwości obsługi repozytorium
 *
 * @package Auth\Form
 */
interface RepositoryInterface
{
    /**
     *  Ustawia repozytorium z którego będziek orzystać walidator
     *
     * @param Repository $repository
     */
    public function setRepository(Repository $repository);
}