<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\DocCategory", inversedBy="doc")
     */
    protected $doc_category_id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="Doc\DocBundle\Entity\DocLangs", inversedBy="doc")
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

    public function setDocCategoryId($category_id) {
        $this->doc_category_id = $category_id;
    }

    public function getDocCategoryId() {
        return $this->doc_category_id;
    }

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

}