<?php

namespace User\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="User\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="45")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length="45")
     */
    protected $l_name;

    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length="10")
     */
    protected $phone;

    /**
     * @ORM\Column(type="date")
     */
    protected $added;



    public function __construct() {
        $this->setAdded(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set notar_name
     *
     * @param string $notarName
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get notar_name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set notar_address
     *
     * @param string $notarAddress
     */
    public function setLName($l_name) {
        $this->l_name = $l_name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set added
     *
     * @param string $added
     */
    public function setAdded($added) {
        $this->added = $added;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getAdded() {
        return $this->added;
    }

}