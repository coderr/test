<?php

namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $doc_langs_id_arr = array(
            'class' => 'Doc\DocBundle\Entity\DocLangs',
            'property' => 'lang_name',
        );
        if(isset($_GET['add_language']) && is_numeric($_GET['add_language'])) {
            $doc_langs_id_arr['preferred_choices'] = array($_GET['add_language']);
            
        }
        $builder->add('doc_langs_id', 'entity', $doc_langs_id_arr);

        $doc_parent_id_arr = array(
            'class' => 'Doc\DocBundle\Entity\DocList',
            'property' => 'doc_name_ro'
        );
        if(isset($_GET['doc_list_id']) && is_numeric($_GET['doc_list_id'])) {
            $doc_parent_id_arr['preferred_choices'] = array($_GET['doc_list_id']);
        }
        $builder->add('doc_parent_id', 'entity', $doc_parent_id_arr);
        $builder->add('content', 'textarea');
        
        $builder->add('is_active', 'checkbox', array('required' => false));
        $builder->add('sorting', 'text', array('required' => false));
    }

    public function getName() {
        return 'doc';
    }

}