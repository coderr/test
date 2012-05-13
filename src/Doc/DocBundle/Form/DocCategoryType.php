<?php
namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocCategoryType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('category_name_ro');
        $builder->add('category_name_ru');
        $builder->add('is_active', 'checkbox', array('required' => false));
        $builder->add('sorting', 'text', array('required' => false));
    }

    public function getName() {
        return 'doc_category';
    }

}