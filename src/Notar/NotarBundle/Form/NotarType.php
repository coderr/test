<?php

namespace Notar\NotarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NotarType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('notar_name');
        $builder->add('notar_address');
        $builder->add('notar_lat');
        $builder->add('notar_long');
//        $builder->add('notar_logo', 'file');
        $builder->add('working_schedule', 'text');
        $builder->add('email', 'email');
        $builder->add('phone');
    }

    public function getName() {
        return 'notar';
    }

}