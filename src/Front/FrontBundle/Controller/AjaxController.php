<?php

namespace Front\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\DocCategory;
use Doc\DocBundle\Entity\Doc;
use Notar\NotarBundle\Additional\Debug;

class AjaxController extends Controller {

    public function ajaxAction() {
        if(!isset($_SESSION['added_docs'])) {
            $_SESSION['added_docs'] = array();
        }
        if($_GET['action'] == 'add' && is_numeric($_GET['doc_id'])) { // adding new doc to list
            $doc_list_details = $this->getDoctrine()->getRepository('DocDocBundle:DocList')->setDocListId($_GET['doc_id'])->getDocList();
            $_SESSION['added_docs'][][$_GET['doc_id']] = $doc_list_details;
        } elseif($_GET['action'] == 'remove' && is_numeric($_GET['doc_id'])) { // removing doc from list
            foreach($_SESSION['added_docs'] as $key => $value) {
                foreach($value as $key1 => $value1) {
                    if($value1 == $_GET['doc_id']) {
                        unset($_SESSION['added_docs'][$key]);
                        break 2;
                    }
                }
            }
        }
        return $this->render('FrontFrontBundle:Ajax:selected_docs.html.twig', array('docs' => $_SESSION['added_docs']));
    }
    
    public function ajaxNotarAction() {
        $notar_id = $_GET['notar_id'];
        if(is_numeric($notar_id)) {
            $notar_details = $this->getDoctrine()->getRepository('NotarNotarBundle:Notar')->setNotarId($notar_id)->getNotar();
            return $this->render('FrontFrontBundle:Ajax:notar_details.html.twig', array('notar' => $notar_details));
        }
    }

}
