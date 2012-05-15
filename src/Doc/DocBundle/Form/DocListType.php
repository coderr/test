<?php

namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocListType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $doc_category_id_arr = array(
            'class' => 'Doc\DocBundle\Entity\DocCategory',
            'property' => 'category_name_ro',
        );
        
        if (isset($_GET['parent_doc_id']) && is_numeric($_GET['parent_doc_id'])) {
            $doc_category_id_arr['preferred_choices'] = array($_GET['parent_doc_id']);
        }
        $builder->add('doc_category_id', 'entity', $doc_category_id_arr);
        $builder->add('doc_name_ro');
        $builder->add('doc_name_ru');
        $builder->add('doc_description_ro', 'textarea');
        $builder->add('doc_description_ru', 'textarea');
        $builder->add('is_active', 'checkbox', array('required' => false));
        $builder->add('sorting', 'text', array('required' => false));
        $builder->add('price', 'text', array('required' => false));
        $builder->add('file', 'file');
    }

    public function getName() {
        return 'doc_list';
    }

}