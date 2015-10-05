<?php

namespace Auth\EntityManager;

use Doctrine\ORM\EntityManagerInterface;

/**
 *  Repozytorium modułu
 *
 * @package Auth\EntityManager
 */
class Repository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Auth\Entity\User\Repository\Account
     */
    public function createUserAccount()
    {
        return $this->entityManager->getRepository('Auth\Entity\User\Account');
    }

    /**
     * @return \Auth\Entity\ACL\Repository\Role
     */
    public function createAclRole()
    {
        return $this->entityManager->getRepository('Auth\Entity\ACL\Role');
    }

    /**
     * @return \Auth\Entity\ACL\Repository\View\Permission
     */
    public function createAclPermissionView()
    {
        return $this->entityManager->getRepository('Auth\Entity\ACL\View\Permission');
    }
}