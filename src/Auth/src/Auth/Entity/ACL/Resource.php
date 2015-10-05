<?php

namespace Auth\Entity\ACL;

use Doctrine\ORM\Mapping as ORM;

/**
 *  Encja opisująca pojedyńczy zasób
 *
 * @package Auth\Entity\ACL
 *
 * @ORM\Entity
 * @ORM\Table(schema="acl", name="resource")
 */
class Resource
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="resource_id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=32, nullable=false)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;
}