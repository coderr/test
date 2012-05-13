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
            $_SESSION['added_docs'][$_POST['session_array_id']]['to_lang'] = (int)@$_POST['lang'];
        }
        
        foreach($_SESSION['added_docs'] as $key => $value) {
            if(!isset($_SESSION['added_docs'][$key]['to_lang'])) {
                foreach($_SESSION['added_docs'][$key] as $key1) {
                    $doc = $key1;
                }
                $em = $this->getDoctrine()->getEntityManager(); 
                $available_langs = $em->getRepository('DocDocBundle:DocLangs')->getDocAvailableLangs($doc->getId()); // get available langs for this document
                
                return $this->render('FrontFrontBundle:Doc:step2.html.twig', array('doc' => $doc, 'langs' => $available_langs, 'session_array_id' => $key));
            }
        }
        echo '<pre>';print_r($_SESSION['added_docs']);die;
    }

}
