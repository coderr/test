<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocLangsRepository extends EntityRepository {

    protected $lang_id;

    /**
     * gets the list of langs
     */
    public function getLangs() {
        $q = $this->createQueryBuilder('l')
                ->select('l')
        ;
        return $q->getQuery()->getResult();
    }

    public function setLangId($lang_id) {
        if (!$lang_id) {
            throw new \Exception('Lang id must be an int', 0, 0);
        }
        $this->lang_id = $lang_id;
        return $this;
    }

    public function deleteLang() {
        $q = $this->createQueryBuilder('l')
                ->delete()
                ->where('l.id=:id')
                ->setParameters(array('id' => $this->lang_id))
                ->getQuery()
                ->execute()
        ;
    }

    public function getLang() {
        $q = $this->createQueryBuilder('l')
                ->select('l')
                ->where('l.id=:id')
                ->setParameters(array('id' => $this->lang_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

}