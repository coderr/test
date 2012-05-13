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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    /**
     * @ORM\Column(type="string", length=10)
     */
    public $price;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->path = uniqid() . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
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

    public function setDocParentId($doc_parent_id) {
        $this->doc_parent_id = $doc_parent_id;
    }

    public function getDocParentId() {
        return $this->doc_parent_id;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

}