<?php

namespace Doc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\Doc;
use Doc\DocBundle\Entity\DocList;
use Doc\DocBundle\Form\DocType;
use Doc\DocBundle\Form\DocListType;
use Notar\NotarBundle\Additional\Debug;

class DocController extends Controller {

    private function checkLogin() {
        $session = $this->getRequest()->getSession();
        if ($session->get('auth') !== 'in') {
            return $this->redirect($this->generateUrl('NotarNotarBundle_login'));
        }
    }

    public function processFormAction() {
        if ($this->checkLogin()) {
            return $this->checkLogin();
        }
        $em = $this->getDoctrine()->getEntityManager();
//        when creating/modifying doc_list
        if(isset($_POST['doc_list'])) {
            if(isset($_POST['modify_id']) && is_numeric($_POST['modify_id'])) {
                $doc_list = $em->getRepository('DocDocBundle:DocList')->setDocListId($_POST['modify_id'])->getDocList();
            } else {
                $doc_list = new DocList();
            }
            $form = $this->createForm(new DocListType(), $doc_list);
        } elseif(isset($_POST['doc'])) { // when creating/modifying doc
            if(isset($_POST['modify_id']) && is_numeric($_POST['modify_id'])) {
                $doc = $em->getRepository('DocDocBundle:Doc')->setDocId($_POST['modify_id'])->getDoc();
            } else {
                $doc = new Doc();
            }
            $form = $this->createForm(new DocType(), $doc);
        }
        $request = $this->getRequest();
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

    public function indexAction() {
        if ($this->checkLogin()) {
            return $this->checkLogin();
        }
        $edit = false;

        $em = $this->getDoctrine()->getEntityManager();
        /**
         * doc form (doc)
         */
        if (@is_numeric($_POST['doc_id'])) {
            $doc = $em->getRepository('DocDocBundle:Doc')->setDocId($_POST['doc_id'])->getDoc();
            $form = $this->createForm(new DocType(), $doc);
        } elseif (isset($_GET['doc_list_id']) && is_numeric($_GET['doc_list_id'])) {
            $doc = new Doc();
            $form = $this->createForm(new DocType(), $doc);
            $edit = true;
        }

        /**
         * doc parent form (doc_list) 
         */
        if (@is_numeric($_POST['parent_doc_id'])) {
            $doc_list = $em->getRepository('DocDocBundle:DocList')->setDocListId($_POST['parent_doc_id'])->getDocList();
            $form = $this->createForm(new DocListType(), $doc_list);
        } else {
            $doc_list = new DocList();
            if (!isset($form)) {
                $form = $this->createForm(new DocListType(), $doc_list);
            }
        }
        
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_docs':
                    $cat_id = (int) $this->get('request')->query->get('id');
                    if ($cat_id) {
                        $em->getRepository('DocDocBundle:Doc')->setCategoryId($cat_id)->deleteCategoryDocs();
                        $this->get('session')->setFlash('notice', 'Documentule au fost STERSE cu success');
                        return $this->redirect($this->generateUrl('DocDocBundle_doc'));
                    }
                    break;
                case 'edit_doc':
                    $doc_id = (int) $this->get('request')->query->get('id');
                    if ($doc_id) {
                        $doc = $em->getRepository('DocDocBundle:Doc')->setDocId($doc_id)->getDoc();
//                        Debug::d1($doc);
                        $form = $this->createForm(new DocType(), $doc);
                        $edit = $doc_id;
                    }
                    break;
            }
        }

        $docs = $em->getRepository('DocDocBundle:Doc')->setWithLanguages()->getDocs();

//        Debug::d1($docs);

        return $this->render('DocDocBundle:Admin:doc.html.twig', array('form' => $form->createView(), 'docs' => $docs, 'edit' => $edit));
    }

}
