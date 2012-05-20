<?php

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('full_name');
        $builder->add('email');
        $builder->add('phone');
        $builder->add('pass', 'password');
    }

    public function getName() {
        return 'user';
    }

}