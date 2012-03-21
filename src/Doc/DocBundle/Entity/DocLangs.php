<?php

namespace Doc\DocBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Doc\DocBundle\Repository\DocLangsRepository")
 * @ORM\Table(name="doc_langs")
 * @ORM\HasLifecycleCallbacks()
 */
class DocLangs {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="45")
     */
    protected $lang_name;

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