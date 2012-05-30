<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Doc\DocBundle\Repository\DocFieldsRepository")
 * @ORM\Table(name="doc_fields")
 * @ORM\HasLifecycleCallbacks()
 */
class DocFields {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\DocList")
     * @ORM\JoinColumn(name="doc_list_id", referencedColumnName="id")
     */
    protected $doc_list_id;
    
    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $field_name_ro;
    
    /**
     * @ORM\Column(type="string", length="50")
     */
    protected $field_name_ru;
    
    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $field_desc_ro;
    
    /**
     * @ORM\Column(type="string", length="250")
     */
    protected $field_desc_ru;
    
    /**
     * @ORM\Column(type="string", length="45")
     */
    protected $field_ident;
    
    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_active;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $sorting;


    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDocListId($id) {
        $this->doc_list_id = $id;
    }

    public function getDocListId() {
        return $this->doc_list_id;
    }

    public function __toString() {
        return (string)$this->getId();
    }

    public function setFieldNameRo($name) {
        $this->field_name_ro = $name;
    }

    public function getFieldNameRo() {
        return $this->field_name_ro;
    }

    public function setFieldNameRu($name) {
        $this->field_name_ru = $name;
    }

    public function getFieldNameRu() {
        return $this->field_name_ru;
    }

    public function setFieldDescRo($name) {
        $this->field_desc_ro = $name;
    }

    public function getFieldDescRo() {
        return $this->field_desc_ro;
    }

    public function setFieldDescRu($name) {
        $this->field_desc_ru = $name;
    }

    public function getFieldDescRu() {
        return $this->field_desc_ru;
    }

    public function setFieldIdent($name) {
        $this->field_ident = $name;
    }

    public function getFieldIdent() {
        return $this->field_ident;
    }

    public function setIsActive($name) {
        $this->is_active = $name;
    }

    public function getIsActive() {
        return $this->is_active;
    }

    public function setSorting($name) {
        $this->sorting = $name;
    }

    public function getSorting() {
        return $this->sorting;
    }

}