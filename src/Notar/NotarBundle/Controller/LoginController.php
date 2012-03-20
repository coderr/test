<?php

namespace Notar\NotarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Notar\NotarBundle\Form\ArticleType;
//use Notar\NotarBundle\Entity\Article;

class LoginController extends Controller {

    public function loginAction() {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $user_name = $request->get('user_name');
            $password = $request->get('password');
            if($user_name == 'admin' && $password == 'bestadmin') {
                $session = $this->getRequest()->getSession();
                $session->set('auth', 'in');
                return $this->redirect($this->generateUrl('NotarNotarBunde_admin_homepage'));
            }
        }
        return $this->render('NotarNotarBundle:Login:login.html.twig');
    }

}
