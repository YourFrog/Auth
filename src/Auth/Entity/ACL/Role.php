<?php

namespace Auth\Entity\ACL;

use Doctrine\ORM\Mapping AS ORM;

/**
 *  Encja opisujaca rolę w systemie
 *
 * @package Auth\Entity\ACL
 *
 * @ORM\Entity(repositoryClass="Auth\Entity\ACL\Repository\Role")
 * @ORM\Table(schema="acl", name="role")
 */
class Role
{
    // Identyfikator domyślnej roli użytkowników
    const DEFAULT_ROLE = 1;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="role_id", type="integer")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}