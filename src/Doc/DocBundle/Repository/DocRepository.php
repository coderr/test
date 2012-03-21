<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocRepository extends EntityRepository {

    protected $doc_id;

    /**
     * gets the list of langs
     */
    public function getDocs() {
        $q = $this->createQueryBuilder('d')
                ->select('d')
        ;
        return $q->getQuery()->getResult();
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