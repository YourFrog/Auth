<?php

namespace Auth\Entity\User;

use Auth\Entity\Exception\InvalidSaltException;
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
     *  Sól dodawana do hasła
     *
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32, nullable=false)
     */
    private $salt;

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
     *  Sprawdzenie czy hasło jest prawidłowe
     *
     * @param string $password Hasło które sprawdzamy
     *
     * @return bool
     */
    public function comparePassword($password)
    {
        $hash = $this->createHash($password, $this->salt);
        return (strcmp($this->password, $hash) === 0);
    }

    /**
     *  Ustawia hasło do konta
     *
     * @param string $password Hasło które chcemy ustalić do konta
     *
     * @throws InvalidSaltException
     */
    public function setPassword($password)
    {
        if( $this->salt === null ) {
            throw new InvalidSaltException('Nie zdefiniowano soli. Wywolaj metode "generateSalte"');
        }

        $this->password = $this->createHash($password, $this->salt);
    }

    /**
     *  Generuje hash hasła
     *
     * @param string $password Hasło
     * @param string $salt Ziarno
     *
     * @return string
     */
    private function createHash($password, $salt)
    {
        return md5($password . $salt);
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
        return $this->generateRandomString(8);
    }

    /**
     *  Generuje sól do hasła :)
     */
    public function generateSalt()
    {
        $this->salt = $this->generateRandomString(32);
    }

    /**
     *  Generuje losowy string o podanej długości
     *
     * @param integer $stringLength Interesujaca nas długość słowa
     *
     * @return string
     */
    private function generateRandomString($stringLength)
    {
        $chars = array_merge(
            range(0, 9),
            range('a', 'z'),
            range('A', 'Z'),
            ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')']
        );
        shuffle($chars);

        $max = count($chars) - 1;
        $arr = [];

        for( $i = 0; $i < $stringLength; $i++ ) {
            $index = rand(0, $max);
            $arr[] = $chars[$index];
        }

        return implode('', $arr);
    }
}