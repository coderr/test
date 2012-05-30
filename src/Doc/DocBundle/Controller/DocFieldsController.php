<?php

namespace Doc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\DocFields;
use Doc\DocBundle\Form\DocFieldsType;
use Notar\NotarBundle\Additional\Debug;

class DocFieldsController extends Controller {

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
        if (@is_numeric($_POST['field_id'])) {
            $doc_field = $em->getRepository('DocDocBundle:DocFields')->setFieldId($_POST['field_id'])->getField();
//            Debug::d1($doc_field);
        } else {
            $doc_field = new DocFields();
        }
        $form = $this->createForm(new DocFieldsType(), $doc_field);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->merge($data);
                $em->flush();
                $this->get('session')->setFlash('notice', 'Cimpul a fost ADAUGAT cu success');
                
                return $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_field':
                    $field_id = (int) $this->get('request')->query->get('id');
                    if ($field_id) {
                        $em->getRepository('DocDocBundle:DocFields')->setFieldId($field_id)->deleteField();
                        $this->get('session')->setFlash('notice', 'Cimpul a fost STEARS cu success');
                        return $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                    break;
                case 'edit_field':
                    $field_id = (int) $this->get('request')->query->get('id');
                    if ($field_id) {
                        $field = $em->getRepository('DocDocBundle:DocFields')->setFieldId($field_id)->getField();
//                        Debug::d1($field);
                        $form = $this->createForm(new DocFieldsType(), $field);
                        $edit = $field_id;
                    }
                    break;
            }
        }
        $fields = $em->getRepository('DocDocBundle:DocFields');
        if(is_numeric($this->get('request')->query->get('doc_list_id'))) {
            $fields->setDocListId($this->get('request')->query->get('doc_list_id'));
        }
        $doc_lists = $em->getRepository('DocDocBundle:DocList')->getDocLists();
//        Debug::d1($doc_lists);

        return $this->render('DocDocBundle:Admin:doc_fields.html.twig', array('form' => $form->createView(), 'fields' => $fields->getFields(), 'edit' => $edit, 'doc_listss' => $doc_lists));
    }

}
