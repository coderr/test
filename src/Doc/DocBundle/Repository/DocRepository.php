<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocRepository extends EntityRepository {

    protected $doc_id;

    /**
     * gets the list of langs
     */
    public function getDocs() {
        $query = '
            SELECT dc.category_name_ro, dl.*, dl.id AS doc_list_id
            FROM doc_list dl, doc_category dc 
            WHERE dl.doc_category_id=dc.id
            GROUP BY dl.id';
        $q = $this->getEntityManager()->getConnection()
                ->prepare($query);
        $q->execute();

        $return = $q->fetchAll(2);
        if ($this->with_languages) {
            $cnt = count($return);
            for ($i = 0; $i < $cnt; $i++) {
                $query = "SELECT dl.*, d.id AS document_id FROM doc_langs dl, doc d, doc_list list WHERE dl.id=d.doc_langs_id AND d.doc_parent_id=list.id AND list.id=" . $return[$i]['doc_list_id'];
                $q = $this->getEntityManager()->getConnection()
                        ->prepare($query);
                $q->execute();
                $return[$i]['filled_langs'] = $q->fetchAll(2);
            }
            for ($i = 0; $i < $cnt; $i++) {
                $q = $this->getEntityManager()->getConnection()
                        ->prepare('SELECT dl.* FROM doc_langs dl WHERE dl.id NOT IN (SELECT doc_langs_id FROM doc WHERE doc_parent_id=' . $return[$i]['doc_list_id'] . ')');
                $q->execute();
                $return[$i]['not_filled_langs'] = $q->fetchAll(2);
            }
        }

        return $return;
    }

    public function setWithLanguages($with_languages = true) {
        $this->with_languages = $with_languages;
        return $this;
    }

    public function setDocId($doc_id) {
        if (!$doc_id) {
            throw new \Exception('Document id must be an int', 0, 0);
        }
        $this->doc_id = $doc_id;
        return $this;
    }

    public function setCategoryId($category_id) {
        if (!$category_id) {
            throw new \Exception('Category id must be an int', 0, 0);
        }
        $this->category_id = $category_id;
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

    public function deleteCategoryDocs() {
        $q = $this->createQueryBuilder('d')
                ->delete()
                ->where('d.doc_category_id=:doc_category_id')
                ->setParameters(array('doc_category_id' => $this->category_id))
                ->getQuery()
                ->execute()
        ;
    }

}