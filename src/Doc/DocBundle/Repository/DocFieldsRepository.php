<?php

namespace Doc\DocBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DocFieldsRepository extends EntityRepository {

    protected $doc_fields_id;
    protected $doc_list_id;

    /**
     * gets the list of langs
     */
    public function getFields() {
        $and = false;
        if(isset($this->doc_list_id)) {
            $and = ' AND df.doc_list_id='.$this->doc_list_id;
        }
        $query = '
            SELECT df.*, dl.doc_name_ro AS doc_name 
            FROM doc_fields df LEFT JOIN doc_list dl ON dl.id=df.doc_list_id
            WHERE 1=1 '.$and.'
            ORDER BY df.sorting ASC
            ';
        $q = $this->getEntityManager()->getConnection()
                ->prepare($query);
        $q->execute();
        $return = $q->fetchAll(2);
        return $return;
    }

    public function setDocListId($doc_list_id) {
        if (!$doc_list_id) {
            throw new \Exception('DocList id must be an int', 0, 0);
        }
        $this->doc_list_id = $doc_list_id;
        return $this;
    }
    
    public function setFieldId($field_id) {
        if (!$field_id) {
            throw new \Exception('Field id must be an int', 0, 0);
        }
        $this->doc_fields_id = $field_id;
        return $this;
    }

    public function deleteField() {
        $q = $this->createQueryBuilder('l')
                ->delete()
                ->where('l.id=:id')
                ->setParameters(array('id' => $this->doc_fields_id))
                ->getQuery()
                ->execute()
        ;
    }

    public function getField() {
        $q = $this->createQueryBuilder('l')
                ->select('l')
                ->where('l.id=:id')
                ->setParameters(array('id' => $this->doc_fields_id))
        ;
        return $q->getQuery()->getSingleResult();
    }

}