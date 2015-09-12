<?php

namespace Auth\Entity\ACL;

use Doctrine\ORM\Mapping as ORM;

/**
 *  Encja opisująca poziom dostępu do danych
 *
 * @package Auth\Entity\ACL
 *
 * @ORM\Entity
 * @ORM\Table(schema="acl", name="permission")
 */
class Permission
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="permission_id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="resource_id", type="integer", nullable=false)
     */
    private $resourceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     */
    private $roleId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="allow", type="boolean", nullable=false)
     */
    private $allow;
}