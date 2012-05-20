<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserDocRepository extends EntityRepository {

    protected $user_doc_id;

    public function getUserDocs() {
        $q = $this->createQueryBuilder('u')
                ->select('u')
        ;
        return $q->getQuery()->getResult();
    }

    public function setUserDocId($user_doc_id) {
        if (!$user_doc_id) {
            throw new \Exception('Lang id must be an int', 0, 0);
        }
        $this->user_doc_id = $user_doc_id;
        return $this;
    }

    public function deleteUserDoc() {
        $q = $this->createQueryBuilder('l')
                ->delete()
                ->where('l.id=:id')
                ->setParameters(array('id' => $this->user_doc_id))
                ->getQuery()
                ->execute()
        ;
    }

    public function getUserDoc() {
        $q = $this->createQueryBuilder('l')
                ->select('l')
                ->where('l.id=:id')
                ->setParameters(array('id' => $this->user_doc_id))
        ;
        return $q->getQuery()->getSingleResult();
    }
    
    public function storeSessionUserDoc($doc, $notar_id, $user_id) {
        
    }

}