<?php

namespace Auth\Entity\ACL;

use Doctrine\ORM\Mapping as ORM;

/**
 *  Typy uprawnień
 *
 * @package Auth\Entity\ACL
 *
 * @ORM\Entity
 * @ORM\Table(schema="acl", name="permission_type")
 */
class PermissionType
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="type_id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;
}