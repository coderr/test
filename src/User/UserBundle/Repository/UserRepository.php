<?php

namespace User\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    protected $user_id;

    /**
     * gets the list of reposiotries
     */
    public function getUsers() {
        $q = $this->createQueryBuilder('u')
                        ->select('u')
                        ->addOrderBy('u.added', 'DESC');
        return $q->getQuery()->getResult();
    }

    public function setUserId($user_id) {
        if (!$user_id) {
            throw new \Exception('User id must be an int', 0, 0);
        }
        $this->user_id = $user_id;
        return $this;
    }

    public function deleteUser() {
        $q = $this->createQueryBuilder('u')
                        ->delete()
                        ->where('u.id=:id')
                        ->setParameters(array('id' => $this->user_id))
                        ->getQuery()
                        ->execute()
        ;
    }

    public function getUser() {
        $q = $this->createQueryBuilder('u')
                        ->select('u')
                        ->where('u.id=:id')
                        ->setParameters(array('id' => $this->user_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

}