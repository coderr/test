<?php

namespace Front\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocController extends Controller {

    public function indexAction($name) {
        return $this->render('FrontFrontBundle:Doc:index.html.twig');
    }

}
