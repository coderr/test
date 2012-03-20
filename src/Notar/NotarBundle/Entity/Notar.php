<?php

namespace Notar\NotarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="notar")
 */
class Notar {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="100")
     */
    protected $notar_name;

    /**
     * @ORM\Column(type="string", length="150")
     */
    protected $notar_address;

    /**
     * @ORM\Column(type="float")
     */
    protected $notar_lat;

    /**
     * @ORM\Column(type="float")
     */
    protected $notar_long;

    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $notar_logo;

    /**
     * @ORM\Column(type="string", length="45")
     */
    protected $working_schedule;

    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length="10")
     */
    protected $phone;

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
    public function setNotarName($notarName) {
        $this->notar_name = $notarName;
    }

    /**
     * Get notar_name
     *
     * @return string 
     */
    public function getNotarName() {
        return $this->notar_name;
    }

    /**
     * Set notar_address
     *
     * @param string $notarAddress
     */
    public function setNotarAddress($notarAddress) {
        $this->notar_address = $notarAddress;
    }

    /**
     * Get notar_address
     *
     * @return string 
     */
    public function getNotarAddress() {
        return $this->notar_address;
    }

    /**
     * Set notar_lat
     *
     * @param float $notarLat
     */
    public function setNotarLat($notarLat) {
        $this->notar_lat = $notarLat;
    }

    /**
     * Get notar_lat
     *
     * @return float 
     */
    public function getNotarLat() {
        return $this->notar_lat;
    }

    /**
     * Set notar_long
     *
     * @param float $notarLong
     */
    public function setNotarLong($notarLong) {
        $this->notar_long = $notarLong;
    }

    /**
     * Get notar_long
     *
     * @return float 
     */
    public function getNotarLong() {
        return $this->notar_long;
    }

    /**
     * Set notar_logo
     *
     * @param string $notarLogo
     */
    public function setNotarLogo($notarLogo) {
        $this->notar_logo = $notarLogo;
    }

    /**
     * Get notar_logo
     *
     * @return string 
     */
    public function getNotarLogo() {
        return $this->notar_logo;
    }

    /**
     * Set work_schedule
     *
     * @param string $workSchedule
     */
    public function setWorkingSchedule($workSchedule) {
        $this->working_schedule = $workSchedule;
    }

    /**
     * Get work_schedule
     *
     * @return string 
     */
    public function getWorkingSchedule() {
        return $this->working_schedule;
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

}