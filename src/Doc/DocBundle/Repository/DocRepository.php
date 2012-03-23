<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocRepository extends EntityRepository {

    protected $doc_id;

    /**
     * gets the list of langs
     */
    public function getDocs() {
        $q = $this->getEntityManager()->getConnection()
                ->prepare('SELECT d.*, dc.category_name_ro FROM doc d, doc_category dc WHERE dc.id=d.doc_category_id GROUP BY dc.id');
        $q->execute();

        $return = $q->fetchAll(2);
        $cnt = count($return);
        for($i=0;$i<$cnt;$i++) {
            $q = $this->getEntityManager()->getConnection()
                    ->prepare('SELECT dl.* FROM doc_langs dl WHERE dl.id IN (SELECT doc_langs_id FROM doc WHERE doc_category_id='.$return[$i]['doc_category_id'].')');
            $q->execute();
            $return[$i]['filled_langs'] = $q->fetchAll(2);
            
        }
        for($i=0;$i<$cnt;$i++) {
            $q = $this->getEntityManager()->getConnection()
                    ->prepare('SELECT dl.* FROM doc_langs dl WHERE dl.id NOT IN (SELECT doc_langs_id FROM doc WHERE doc_category_id='.$return[$i]['doc_category_id'].')');
            $q->execute();
            $return[$i]['not_filled_langs'] = $q->fetchAll(2);
            
        }
        
        return $return;
    }

    public function setDocId($doc_id) {
        if (!$doc_id) {
            throw new \Exception('Document id must be an int', 0, 0);
        }
        $this->doc_id = $doc_id;
        return $this;
    }

    public function deleteDoc() {
        $q = $this->createQueryBuilder('d')
                ->delete()
                ->where('d.id=:id')
                ->setParameters(array('id' => $this->doc_id))
                ->getQuery()
                ->execute()
        ;
    }

    public function getDoc() {
        $q = $this->createQueryBuilder('d')
                ->select('d')
                ->where('d.id=:id')
                ->setParameters(array('id' => $this->doc_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

}