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

//        $doc_category_obj = new \Doc\DocBundle\Entity\DocCategory();
//        $doc_category_obj->setId(1);
//
//        $doc_langs_obj = new \Doc\DocBundle\Entity\DocLangs();
//        $doc_langs_obj->setId(1);
//
//        $doc->setDocCategoryId($doc_category_obj);
//        $doc->setDocLangsId($doc_langs_obj);
//        $doc->setDocCategoryId($_POST['doc_category']['doc_category_id']);
//        $doc->setDocLangsId($_POST['doc_category']['doc_langs_id']);
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

//        Debug::d($docs);
        
        return $this->render('DocDocBundle:Admin:doc.html.twig', array('form' => $form->createView(), 'docs' => $docs, 'edit' => $edit));
    }

}
