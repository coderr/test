<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UserDoc\UserDocBundle\Repository\UserDocRepository")
 * @ORM\Table(name="user_doc")
 * @ORM\HasLifecycleCallbacks()
 */
class UserDoc {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\Doc")
     * @ORM\JoinColumn(name="doc_id", referencedColumnName="id")
     */
    protected $doc_id;

    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="Notar\NotarBundle\Entity\Notar")
     * @ORM\JoinColumn(name="notar_id", referencedColumnName="id")
     */
    protected $notar_id;

    /**
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\DocLangs")
     * @ORM\JoinColumn(name="lang_id", referencedColumnName="id")
     */
    protected $lang_id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $added;

    public function __construct() {
        $this->setAdded(new \DateTime());
    }
    
    public function setDocId($doc_id) {
        $this->doc_id = $doc_id;
    }

    public function getDocId() {
        return $this->doc_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setNotarId($notar_id) {
        $this->notar_id = $notar_id;
    }

    public function getNotarId() {
        return $this->notar_id;
    }

    public function setAdded($added) {
        $this->added = $added;
    }

    public function getAdded() {
        return $this->added;
    }

}