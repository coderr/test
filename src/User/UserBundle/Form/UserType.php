<?php

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name');
        $builder->add('l_name');
        $builder->add('email');
        $builder->add('phone');
    }

    public function getName() {
        return 'user';
    }

}