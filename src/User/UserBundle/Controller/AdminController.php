<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use User\UserBundle\Entity\User;
use User\UserBundle\Form\UserType;
use Notar\NotarBundle\Additional\Debug;

class AdminController extends Controller {

    private function checkLogin() {
        $session = $this->getRequest()->getSession();
        if ($session->get('auth') !== 'in') {
            return $this->redirect($this->generateUrl('NotarNotarBundle_login'));
        }
    }

    /**
     * Notar
     */
    public function indexAction() {
        if ($this->checkLogin()) {
            return $this->checkLogin();
        }

        $edit = false;

        $em = $this->getDoctrine()->getEntityManager();
        if (@is_numeric($_POST['user_id'])) {
            $user = $em->getRepository('UserUserBundle:User')->setUserId($_POST['user_id'])->getUser();
            $form = $this->createForm(new UserType(), $user);
            $edit = $_POST['user_id'];
            $template_params = array('form' => $form->createView());
        }

        $request = $this->getRequest();

            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $em->merge($data);
                    $em->flush();
                    $this->get('session')->setFlash('notice', 'Notarul a fost MODIFICAT cu success');
                    return $this->redirect($this->generateUrl('UserUserBunde_admin_homepage'));
                }
            }
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_user':
                    $user_id = (int) $this->get('request')->query->get('id');
                    if ($user_id) {
                        $em->getRepository('UserUserBundle:User')->setUserId($user_id)->deleteUser();
                        $this->get('session')->setFlash('notice', 'Utilizatorul a fost STERS cu success');
                        return $this->redirect($this->generateUrl('UserUserBunde_admin_homepage'));
                    }
                    break;
            }
        }

        $users = $em->getRepository('UserUserBundle:User')->getUsers();

        $template_params['users'] = $users;
        $template_params['edit'] = $edit;
        return $this->render('UserUserBundle:Admin:homepage.html.twig', $template_params);
    }


}
