<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Doc\DocBundle\Repository\DocCategoryRepository")
 * @ORM\Table(name="doc_category")
 * @ORM\HasLifecycleCallbacks()
 */
class DocCategory {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="150")
     */
    protected $category_name_ro;

    /**
     * @ORM\Column(type="string", length="150")
     */
    protected $category_name_ru;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_active;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sorting;

    public function setCategoryNameRo($category_name_ro) {
        $this->category_name_ro = $category_name_ro;
    }

    public function getCategoryNameRo() {
        return $this->category_name_ro;
    }

    public function setCategoryNameRu($category_name_ru) {
        $this->category_name_ru = $category_name_ru;
    }

    public function getCategoryNameRu() {
        return $this->category_name_ru;
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

    public function setLangName($lang) {
        $this->lang_name = $lang;
    }

    public function getLangName() {
        return $this->lang_name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

}