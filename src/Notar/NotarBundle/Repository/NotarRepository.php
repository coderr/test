<?php

namespace Notar\NotarBundle\Repository;

use Doctrine\ORM\EntityRepository;

class NotarRepository extends EntityRepository {

    protected $notar_id;
    
    /**
     * gets the list of reposiotries
     */
    public function getNotars() {
        $q = $this->createQueryBuilder('n')
                        ->select('n')
                        ->addOrderBy('n.added', 'DESC');
        return $q->getQuery()->getResult();
    }

    public function setNotarId($notar_id) {
        if (!$notar_id) {
            throw new \Exception('Notar id must be an int', 0, 0);
        }
        $this->notar_id = $notar_id;
        return $this;
    }
    
    public function deleteNotar() {
        $q = $this->createQueryBuilder('n')
                        ->delete()
                        ->where('n.id=:id')
                        ->setParameters(array('id' => $this->notar_id))
                        ->getQuery()
                        ->execute()
        ;
    }

    public function getNotar() {
        $q = $this->createQueryBuilder('n')
                        ->select('n')
                        ->where('n.id=:id')
                        ->setParameters(array('id' => $this->notar_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

}