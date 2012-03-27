<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocListRepository extends EntityRepository {

    protected $doc_list_id;

    public function setDocListId($doc_list_id) {
        if (!$doc_list_id) {
            throw new \Exception('DocumentList id must be an int', 0, 0);
        }
        $this->doc_list_id = $doc_list_id;
        return $this;
    }

    public function setCategoryId($category_id) {
        if (!$category_id) {
            throw new \Exception('Category id must be an int', 0, 0);
        }
        $this->category_id = $category_id;
        return $this;
    }

    public function deleteDocList() {
        $q = $this->createQueryBuilder('d')
                ->delete()
                ->where('d.id=:id')
                ->setParameters(array('id' => $this->doc_list_id))
                ->getQuery()
                ->execute()
        ;
    }

    public function getDocList() {
        $q = $this->createQueryBuilder('d')
                ->select('d')
                ->where('d.id=:id')
                ->setParameters(array('id' => $this->doc_list_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

    public function deleteCategoryDoc() {
        $q = $this->createQueryBuilder('d')
                ->delete()
                ->where('d.doc_category_id=:doc_category_id')
                ->setParameters(array('doc_category_id' => $this->category_id))
                ->getQuery()
                ->execute()
        ;
    }

}