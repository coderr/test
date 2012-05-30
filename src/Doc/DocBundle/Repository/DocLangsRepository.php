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
    
    public function getDocAvailableLangs($doc_id) {
        if(!is_numeric($doc_id)) {
            return;
        }
        $query = "SELECT dl.id, dl.lang_name FROM doc_langs dl WHERE dl.id IN (SELECT doc_langs_id FROM doc WHERE doc_parent_id=".$doc_id.")";
        $q = $this->getEntityManager()->getConnection()
                ->prepare($query);
        $q->execute();
        return $q->fetchAll(2);
    }

}