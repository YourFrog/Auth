<?php

namespace Auth\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Auth\Entity\ACL\Role as EntityRole;

/**
 *  Encja opisująca konto użytkownika w systemie
 *
 * @ORM\Entity(repositoryClass="Auth\Entity\User\Repository\Account")
 * @ORM\Table(schema="""user""", name="account")
 */
class Account
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(name="account_id", type="integer")
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=32, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=false)
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="Auth\Entity\ACL\Role")
     * @ORM\JoinTable(name="""user"".role",
     *      joinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="account_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="role_id", unique=true)}
     * )
     * @ORM\OrderBy({"priority": "DESC"})
     */
    private $roles;

    /**
     *  Konstruktor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     *  Dodaje rolę do konta
     *
     * @param EntityRole $role
     */
    public function addRole(EntityRole $role)
    {
        $this->roles->add($role);
    }

    /**
     *  Generuje nowe losowe hasło
     *
     * @return string
     */
    public function generateRandomPassword()
    {
        $chars = array_merge(
            rand('a', 'z'),
            rand('A', 'Z'),
            ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')']
        );

        for($i = 0; $i < 8; $i++) {

        }
    }
}