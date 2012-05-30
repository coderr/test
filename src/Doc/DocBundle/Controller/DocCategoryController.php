<?php

namespace Doc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\DocCategory;
use Doc\DocBundle\Form\DocCategoryType;
use Notar\NotarBundle\Additional\Debug;

class DocCategoryController extends Controller {

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
        if (@is_numeric($_POST['category_id'])) {
            $category = $em->getRepository('DocDocBundle:DocCategory')->setCategoryId($_POST['category_id'])->getCategory();
        } else {
            $category = new DocCategory();
        }
        $form = $this->createForm(new DocCategoryType(), $category);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->merge($data);
                $em->flush();
                $this->get('session')->setFlash('notice', 'Categoria a fost ADAUGATA cu success');
                return $this->redirect($this->generateUrl('DocDocBundle_doc_categories'));
            }
        }
        if ($this->get('request')->query->get('action')) {
            switch ($this->get('request')->query->get('action')) {
                case 'delete_category':
                    $category_id = (int) $this->get('request')->query->get('id');
                    if ($category_id) {
                        $em->getRepository('DocDocBundle:DocCategory')->setCategoryId($category_id)->deleteCategory();
                        $this->get('session')->setFlash('notice', 'Categoria a fost STEARSA cu success');
                        return $this->redirect($this->generateUrl('DocDocBundle_doc_categories'));
                    }
                    break;
                case 'edit_category':
                    $category_id = (int) $this->get('request')->query->get('id');
                    if ($category_id) {
                        $category = $em->getRepository('DocDocBundle:DocCategory')->setCategoryId($category_id)->getCategory();
                        $form = $this->createForm(new DocCategoryType(), $category);
                        $edit = $category_id;
                    }
                    break;
            }
        }

        $categories = $em->getRepository('DocDocBundle:DocCategory')->getCategories();

        return $this->render('DocDocBundle:Admin:doc_categories.html.twig', array('form' => $form->createView(), 'categories' => $categories, 'edit' => $edit));
    }

}
