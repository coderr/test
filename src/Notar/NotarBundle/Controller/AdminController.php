<?php

namespace Notar\NotarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Notar\NotarBundle\Entity\Notar;
use Notar\NotarBundle\Form\NotarType;
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
        if (@is_numeric($_POST['notar_id'])) {
            $notar = $em->getRepository('NotarNotarBundle:Notar')->setNotarId($_POST['notar_id'])->getNotar();
        } else {
            $notar = new Notar();
        }
        $form = $this->createForm(new NotarType(), $notar);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $em->merge($data);
                    $em->flush();
                    $this->get('session')->setFlash('notice', 'Notarul a fost ADAUGAT cu success');
                    return $this->redirect($this->generateUrl('NotarNotarBunde_admin_homepage'));
                }
            }
        }
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_notar':
                    $notar_id = (int) $this->get('request')->query->get('id');
                    if ($notar_id) {
                        $em->getRepository('NotarNotarBundle:Notar')->setNotarId($notar_id)->deleteNotar();
                        $this->get('session')->setFlash('notice', 'Notarul a fost STERS cu success');
                        return $this->redirect($this->generateUrl('NotarNotarBunde_admin_homepage'));
                    }
                    break;
                case 'edit_notar':
                    $notar_id = (int) $this->get('request')->query->get('id');
                    if ($notar_id) {
                        $notar = $em->getRepository('NotarNotarBundle:Notar')->setNotarId($notar_id)->getNotar();
                        $form = $this->createForm(new NotarType(), $notar);
                        $edit = $notar_id;
                    }
                    break;
            }
        }

        $notars = $em->getRepository('NotarNotarBundle:Notar')->getNotars();

        return $this->render('NotarNotarBundle:Admin:homepage.html.twig', array('form' => $form->createView(), 'notars' => $notars, 'edit' => $edit));
    }

}
