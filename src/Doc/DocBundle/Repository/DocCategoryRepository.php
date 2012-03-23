<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocCategoryRepository extends EntityRepository {

    protected $category_id;

    /**
     * gets the list of langs
     */
    public function getCategories() {
        $q = $this->createQueryBuilder('c')
                ->select('c')
        ;
        return $q->getQuery()->getResult();
    }

    public function setCategoryId($category_id) {
        if (!$category_id) {
            throw new \Exception('Category id must be an int', 0, 0);
        }
        $this->category_id = $category_id;
        return $this;
    }

    public function deleteCategory() {
        $q = $this->createQueryBuilder('c')
                ->delete()
                ->where('c.id=:id')
                ->setParameters(array('id' => $this->category_id))
                ->getQuery()
                ->execute()
        ;
    }

    public function getCategory() {
        $q = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.id=:id')
                ->setParameters(array('id' => $this->category_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

}