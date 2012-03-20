<?php

namespace Notar\NotarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {

    private function checkLogin() {
        $session = $this->getRequest()->getSession();
        if($session->get('auth') !== 'in') {
            return $this->redirect($this->generateUrl('NotarNotarBundle_login'));
        }
    }
    
    public function indexAction() {
        if($this->checkLogin()) {
            return $this->checkLogin();
        }
        return $this->render('NotarNotarBundle:Admin:homepage.html.twig');
    }

}
