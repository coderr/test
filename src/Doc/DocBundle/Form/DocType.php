<?php

namespace Doc\DocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('doc_category_id', 'entity', array(
            'class' => 'Doc\\DocBundle\\Entity\\DocCategory',
            'multiple' => true,
            'expanded' => true,
            'required' => true,
            'query_builder' => function(EntityRepository $er) use (new \Doc\DocBundle\Entity\DocCategory) {
                return $er->createQueryBuilder('c');
            }
        ));
//        $builder->add('doc_category_id', 'choice', array('type' => new DocCategoryType()));
        $builder->add('doc_langs_id');
        $builder->add('content', 'text');
        $builder->add('is_active', 'checkbox');
        $builder->add('sorting');
    }

    public function getName() {
        return 'doc_category';
    }

}