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

}
