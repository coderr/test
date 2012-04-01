<?php

namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocFieldsType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $doc_list_id_arr = array(
            'class' => 'Doc\DocBundle\Entity\DocList',
            'property' => 'name',
        );
        if(isset($_GET['doc_list_id']) && is_numeric($_GET['doc_list_id'])) {
            $doc_list_id_arr['preferred_choices'] = array($_GET['doc_list_id']);
            
        }
        $builder->add('doc_list_id', 'entity', $doc_list_id_arr);

        $builder->add('field_name_ro');
        $builder->add('field_name_ru');
        $builder->add('field_desc_ro');
        $builder->add('field_desc_ru');
        $builder->add('field_ident');
        $builder->add('is_active', 'checkbox');
        $builder->add('sorting');
    }

    public function getName() {
        return 'doc_fields';
    }

}