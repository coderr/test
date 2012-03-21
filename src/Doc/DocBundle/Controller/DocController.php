<?php

namespace Doc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\Doc;
use Doc\DocBundle\Form\DocType;
use Notar\NotarBundle\Additional\Debug;

class DocController extends Controller {

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

        $edit = false;

        $em = $this->getDoctrine()->getEntityManager();
        if (@is_numeric($_POST['doc_id'])) {
            $doc = $em->getRepository('DocDocBundle:Doc')->setDocId($_POST['doc_id'])->getDoc();
        } else {
            $doc = new Doc();
        }
        $form = $this->createForm(new DocType(), $doc);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $em->merge($data);
                    $em->flush();
                    $this->get('session')->setFlash('notice', 'Documentul a fost CREAT cu success');
                    return $this->redirect($this->generateUrl('DocDocBundle_doc'));
                }
            }
        }
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_doc':
                    $doc_id = (int) $this->get('request')->query->get('id');
                    if ($doc_id) {
                        $em->getRepository('DocDocBundle:Doc')->setDocId($doc_id)->deleteDoc();
                        $this->get('session')->setFlash('notice', 'Documentul a fost STERS cu success');
                        return $this->redirect($this->generateUrl('DocDocBundle_doc'));
                    }
                    break;
                case 'edit_doc':
                    $doc_id = (int) $this->get('request')->query->get('id');
                    if ($doc_id) {
                        $doc = $em->getRepository('DocDocBundle:Doc')->setDocId($doc_id)->getDoc();
                        $form = $this->createForm(new DocType(), $doc);
                        $edit = $doc_id;
                    }
                    break;
            }
        }

        $docs = $em->getRepository('DocDocBundle:Doc')->getDocs();

        return $this->render('DocDocBundle:Admin:doc.html.twig', array('form' => $form->createView(), 'docs' => $docs, 'edit' => $edit));
    }

}
