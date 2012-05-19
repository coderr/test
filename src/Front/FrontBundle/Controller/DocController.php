<?php

namespace Front\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\DocCategory;
use Notar\NotarBundle\Additional\Debug;

class DocController extends Controller {

    public function step1Action() {
        $em = $this->getDoctrine()->getEntityManager();
        $docs = $em->getRepository('DocDocBundle:DocCategory')->getCategoriesWithDocs();
//        Debug::d1($doc_list_details);
        return $this->render('FrontFrontBundle:Doc:step1.html.twig', array('docs' => $docs));
    }

    public function step2Action() {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $_SESSION['added_docs'][$_POST['session_array_id']]['to_lang'] = (int) @$_POST['lang'];
        }

        if (!isset($_SESSION['added_docs'])) {
            $_SESSION['added_docs'] = array();
        }
        
        foreach ($_SESSION['added_docs'] as $key => $value) {
            if (!isset($_SESSION['added_docs'][$key]['to_lang'])) {
                foreach ($_SESSION['added_docs'][$key] as $key1) {
                    $doc = $key1;
                    break;
                }
                $em = $this->getDoctrine()->getEntityManager();
                $available_langs = $em->getRepository('DocDocBundle:DocLangs')->getDocAvailableLangs($doc->getId()); // get available langs for this document

                return $this->render('FrontFrontBundle:Doc:step2.html.twig', array('doc' => $doc, 'langs' => $available_langs, 'session_array_id' => $key));
            }
        }
        return $this->redirect($this->generateUrl('FrontFrontBundle_step3'));
    }

    public function step3Action() {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $_SESSION['added_docs'][$_POST['session_array_id']]['filled_fields'] = $_POST['fields'];
        }
        if (!isset($_SESSION['added_docs'])) {
            $_SESSION['added_docs'] = array();
        }

        foreach ($_SESSION['added_docs'] as $key => $value) {
            if (!isset($_SESSION['added_docs'][$key]['filled_fields'])) {
                foreach ($_SESSION['added_docs'][$key] as $key1) {
                    $doc = $key1;
                    break;
                }
                $em = $this->getDoctrine()->getEntityManager();
                $doc_fields = $em->getRepository('DocDocBundle:DocFields')->setDocListId($doc->getId())->getFields(); // get available fields for this document

                return $this->render('FrontFrontBundle:Doc:step3.html.twig', array('doc' => $doc, 'doc_fields' => $doc_fields, 'session_array_id' => $key));
            }
        }

        return $this->redirect($this->generateUrl('FrontFrontBundle_step4'));
    }

    public function step4Action() {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $_SESSION['added_docs'][$_POST['session_array_id']]['checked_fields'] = 'yes';
        }
        if (!isset($_SESSION['added_docs'])) {
            $_SESSION['added_docs'] = array();
        }
        
        foreach ($_SESSION['added_docs'] as $key => $value) {
            if (!isset($_SESSION['added_docs'][$key]['checked_fields'])) {
                foreach ($_SESSION['added_docs'][$key] as $key1) {
                    $doc = $key1;
                    break;
                }
                $em = $this->getDoctrine()->getEntityManager();
                $doc_fields = $em->getRepository('DocDocBundle:DocFields')->setDocListId($doc->getId())->getFields(); // get available fields for this document
                
                return $this->render('FrontFrontBundle:Doc:step4.html.twig', array('doc' => $doc, 'doc_fields' => $doc_fields, 'session_array_id' => $key, 'filled_fields' => $value['filled_fields']));
            }
        }

        return $this->redirect($this->generateUrl('FrontFrontBundle_step5'));
    }

}
