<?php
namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocLangsType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('lang_name');
    }

    public function getName() {
        return 'doc_langs';
    }

}