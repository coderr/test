<?php

namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocListType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name');
        $builder->add('is_active', 'checkbox');
        $doc_category_id_arr = array(
            'class' => 'Doc\DocBundle\Entity\DocCategory',
            'property' => 'category_name_ro',
        );
        
        if (isset($_GET['parent_doc_id']) && is_numeric($_GET['parent_doc_id'])) {
            $doc_category_id_arr['preferred_choices'] = array($_GET['parent_doc_id']);
        }
        $builder->add('doc_category_id', 'entity', $doc_category_id_arr);
    }

    public function getName() {
        return 'doc_list';
    }

}