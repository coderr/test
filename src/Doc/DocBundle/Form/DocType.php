<?php

namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('doc_category_id', 'entity', array(
            'class' => 'Doc\DocBundle\Entity\DocCategory',
            'property' => 'category_name_ro',
        ));

        $builder->add('doc_langs_id', 'entity', array(
            'class' => 'Doc\DocBundle\Entity\DocLangs',
            'property' => 'lang_name',
        ));

//        $builder->add('doc_category_id');
//        $builder->add('doc_langs_id');

        $builder->add('content', 'text');
        $builder->add('is_active', 'checkbox');
        $builder->add('sorting');
    }

    public function getName() {
        return 'doc_category';
    }

}