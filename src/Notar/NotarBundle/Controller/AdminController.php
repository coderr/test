<?php

namespace Notar\NotarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Notar\NotarBundle\Entity\Notar;
use Notar\NotarBundle\Form\NotarType;

class AdminController extends Controller {

    private function checkLogin() {
        $session = $this->getRequest()->getSession();
        if ($session->get('auth') !== 'in') {
            return $this->redirect($this->generateUrl('NotarNotarBundle_login'));
        }
    }

    public function indexAction() {
        if ($this->checkLogin()) {
            return $this->checkLogin();
        }

        $notar = new Notar();
        $form = $this->createForm(new NotarType(), $notar);
        $em = $this->getDoctrine()->getEntityManager();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $em->merge($data);
                    $em->flush();
                    $this->get('session')->setFlash('notice', 'Notarul a fost adaugat cu success');
                    return $this->redirect($this->generateUrl('NotarNotarBunde_admin_homepage'));
                }
            }
        }

        return $this->render('NotarNotarBundle:Admin:homepage.html.twig', array('form' => $form->createView()));
    }

}
