<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Doc\DocBundle\Repository\DocRepository")
 * @ORM\Table(name="doc")
 * @ORM\HasLifecycleCallbacks()
 */
class Doc {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * ORM\ManyToOne(targetEntity="DocCategory")
     * ORM\JoinColumn(name="doc_category_id", referencedColumnName="id")
     */
//    protected $doc_category_id;
    /**
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\DocLangs")
     * @ORM\JoinColumn(name="doc_langs_id", referencedColumnName="id")
     */
    protected $doc_langs_id;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_active;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sorting;

    /**
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\DocList")
     * @ORM\JoinColumn(name="doc_parent_id", referencedColumnName="id")
     */
    protected $doc_parent_id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    public $price;

    public function setDocLangsId($lang_id) {
        $this->doc_langs_id = $lang_id;
    }

    public function getDocLangsId() {
        return $this->doc_langs_id;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getContent() {
        return $this->content;
    }

    public function setIsActive($is_active) {
        $this->is_active = $is_active;
    }

    public function getIsActive() {
        return $this->is_active;
    }

    public function setSorting($sorting) {
        $this->sorting = $sorting;
    }

    public function getSorting() {
        return $this->sorting;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDocParentId($doc_parent_id) {
        $this->doc_parent_id = $doc_parent_id;
    }

    public function getDocParentId() {
        return $this->doc_parent_id;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

}