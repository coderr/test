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

    public function getCategoriesWithDocs() {
        $query = '
            SELECT dc.*
            FROM doc_category dc 
            WHERE dc.is_active=1
            AND (SELECT COUNT(id) FROM doc_list dl WHERE dl.doc_category_id=dc.id)>0
            ORDER BY dc.sorting ASC';
        $q = $this->getEntityManager()->getConnection()
                ->prepare($query);
        $q->execute();

        $return = $q->fetchAll(2);
        $cnt = count($return);
        for ($i = 0; $i < $cnt; $i++) {
            $query = "SELECT * FROM doc_list dl WHERE dl.doc_category_id=" . $return[$i]['id']." AND dl.is_active=1 ORDER BY dl.sorting ASC";
            $q = $this->getEntityManager()->getConnection()
                    ->prepare($query);
            $q->execute();
            $return[$i]['category_docs'] = $q->fetchAll(2);
        }

        return $return;
    }

}