<?php

namespace Auth\Entity\ACL\View;

use Doctrine\ORM\Mapping as ORM;

/**
 *  Widok określający szczegółowo uprawnienia
 *
 * @package Auth\Entity\ACL\View
 *
 * @ORM\Entity(readOnly=true, repositoryClass="Auth\Entity\ACL\Repository\View\Permission")
 * @ORM\Table(schema="acl", name="v_permission")
 */
class Permission
{
    const TYPE_READ = 'read';
    const TYPE_EDIT = 'edit';
    const TYPE_WRITE = 'write';
    const TYPE_EXECUTE = 'execute';

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     */
    private $roleId;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="resource_name", type="string", length=32, nullable=false)
     */
    private $resourceName;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="type_name", type="string", length=32, nullable=false)
     */
    private $typeName;

    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=32, nullable=false)
     */
    private $roleName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="allow", type="boolean", nullable=false)
     */
    private $allow;

    /**
     *  Sprawdza czy osoba posiada uprawnienia
     *
     * @return boolean
     */
    public function isAllow()
    {
        return $this->allow;
    }
}