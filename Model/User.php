<?php
/**
 * User.php
 * @package Lazy
 */
 
namespace Lazy\UserBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use \Datetime;


/**
 * Lazy\UserBundle\Entity\User
 * @package Lazy
 * @subpackage UserBundle
 * @category Model
 *
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $email
     */
    private $email;

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var string $salt
     */
    private $salt;

    /**
     * @var string $token
     */
    private $token;

    /**
     * @var DateTime $tokenRequestedAt
     */
    private $tokenRequestedAt; 

    /**
     * @var boolean $enabled
     */
    private $enabled;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enabled = false;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setTokenRequestedAt(Datetime $tokenRequestedAt) 
    {
        $this->tokenRequestedAt = $tokenRequestedAt;
    }

    public function getTokenRequestedAt()
    {
        return $this->tokenRequestedAt;
    }


    /**
     * Returns Roles of the user (Method of UserInterface)
     * @return string Roles
     * @ignore 
     */
    public function getRoles()
    {
        return array();
    }


    /**
     * Erase the credentials (Method of UserInterface)
     * @ignore 
     */
    public function eraseCredentials()
    {
    }

    /**
     * Returns whether or not the given user is equivalent to *this* user. (Method of UserInterface)
     * @return boolean True if equals
     * @ignore 
     */
    public function equals(UserInterface $user)
    {
        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function generateToken($ttl = '+1 day')
    {
        $this->token = bin2hex(sha1(uniqid(mt_rand(), true)));
        $this->tokenRequestedAt = new DateTime($ttl);
    }

    public function isExpiredToken($ttl = '-1 day')
    {
        return ($this->tokenRequestedAt < new DateTime($ttl)) ? true : false;
    }

    public function eraseToken()
    {
        $this->token = null;
        $this->tokenRequestedAt = null;
    }


    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->email,
            $this->password,
            $this->salt,
            $this->token,
            $this->tokenRequestedAt
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->username,
            $this->email,
            $this->password,
            $this->salt,
            $this->token,
            $this->tokenRequestedAt
        ) = unserialize($serialized);
    }
    

}