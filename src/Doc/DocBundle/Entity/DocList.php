<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Doc\DocBundle\Repository\DocListRepository")
 * @ORM\Table(name="doc_list")
 * @ORM\HasLifecycleCallbacks()
 */
class DocList {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * ORM\OneToMany(targetEntity="Doc\DocBundle\Entity\Doc")
     * ORM\JoinColumn(name="id", referencedColumnName="doc_parent_id")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="DocCategory")
     * @ORM\JoinColumn(name="doc_category_id", referencedColumnName="id")
     */
    protected $doc_category_id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $doc_name_ro;
    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $doc_name_ru;
    /**
     * @ORM\Column(type="text")
     */
    protected $doc_description_ro;
    /**
     * @ORM\Column(type="text")
     */
    protected $doc_description_ru;

    /**
     * @ORM\Column(type="integer")
     */
    protected $is_active;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sorting;

    public function setDocCategoryId($category_id) {
        $this->doc_category_id = $category_id;
    }

    public function getDocCategoryId() {
        return $this->doc_category_id;
    }

    public function setIsActive($is_active) {
        $this->is_active = $is_active;
    }

    public function getIsActive() {
        return $this->is_active;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getSorting() {
        return $this->sorting;
    }

    public function setSorting($sorting) {
        $this->sorting = $sorting;
    }

    public function setDocNameRo($doc_name_ro) {
        $this->doc_name_ro = $doc_name_ro;
    }

    public function getDocNameRo() {
        return $this->doc_name_ro;
    }

    public function setDocNameRu($doc_name_ru) {
        $this->doc_name_ru = $doc_name_ru;
    }

    public function getDocNameRu() {
        return $this->doc_name_ru;
    }

    public function setDocDescriptionRo($doc_description_ro) {
        $this->doc_description_ro = $doc_description_ro;
    }

    public function getDocDescriptionRo() {
        return $this->doc_description_ro;
    }

    public function setDocDescriptionRu($doc_description_ru) {
        $this->doc_description_ru = $doc_description_ru;
    }

    public function getDocDescriptionRu() {
        return $this->doc_description_ru;
    }

    public function __toString() {
        return (string) $this->getId();
    }

}