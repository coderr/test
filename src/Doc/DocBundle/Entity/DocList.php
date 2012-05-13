<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="boolean")
     */
    protected $is_active;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sorting;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
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
//        var_dump($this->path);die;
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
    
    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function __toString() {
        return (string) $this->getId();
    }

}