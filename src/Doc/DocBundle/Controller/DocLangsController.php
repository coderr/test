<?php

namespace Doc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\DocLangs;
use Doc\DocBundle\Form\DocLangsType;
use Notar\NotarBundle\Additional\Debug;

class DocLangsController extends Controller {

    private function checkLogin() {
        $session = $this->getRequest()->getSession();
        if ($session->get('auth') !== 'in') {
            return $this->redirect($this->generateUrl('UserUserBundle_login'));
        }
    }

    public function indexAction() {
        if ($this->checkLogin()) {
            return $this->checkLogin();
        }

        $edit = false;

        $em = $this->getDoctrine()->getEntityManager();
        if (@is_numeric($_POST['lang_id'])) {
            $lang = $em->getRepository('DocDocBundle:DocLangs')->setLangId($_POST['lang_id'])->getLang();
        } else {
            $lang = new DocLangs();
        }
        $form = $this->createForm(new DocLangsType(), $lang);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $em->merge($data);
                    $em->flush();
                    $this->get('session')->setFlash('notice', 'Limba a fost ADAUGATA cu success');
                    return $this->redirect($this->generateUrl('DocDocBundle_doc_langs'));
                }
            }
        }
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_lang':
                    $lang_id = (int) $this->get('request')->query->get('id');
                    if ($lang_id) {
                        $em->getRepository('DocDocBundle:DocLangs')->setLangId($lang_id)->deleteLang();
                        $this->get('session')->setFlash('notice', 'Limba a fost STEARSA cu success');
                        return $this->redirect($this->generateUrl('DocDocBundle_doc_langs'));
                    }
                    break;
                case 'edit_lang':
                    $lang_id = (int) $this->get('request')->query->get('id');
                    if ($lang_id) {
                        $lang = $em->getRepository('DocDocBundle:DocLangs')->setLangId($lang_id)->getLang();
                        $form = $this->createForm(new DocLangsType(), $lang);
                        $edit = $lang_id;
                    }
                    break;
            }
        }

        $langs = $em->getRepository('DocDocBundle:DocLangs')->getLangs();

        return $this->render('DocDocBundle:Admin:doc_langs.html.twig', array('form' => $form->createView(), 'langs' => $langs, 'edit' => $edit));
    }

}
