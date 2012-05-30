<?php

namespace Front\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doc\DocBundle\Entity\DocCategory;
use Notar\NotarBundle\Additional\Debug;
use User\UserBundle\Entity\User;
use Doc\DocBundle\Entity\UserDoc;

class DocController extends Controller {
    
    private function checkLogin() {
        $session = $this->getRequest()->getSession();
        if ($session->get('auth') !== 'in') {
            return $this->redirect($this->generateUrl('FrontFrontBundle_login_register'));
        }
    }

    public function step1Action() {
        $em = $this->getDoctrine()->getEntityManager();
        $docs = $em->getRepository('DocDocBundle:DocCategory')->getCategoriesWithDocs();
//        Debug::d1($docs);
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
        $em = $this->getDoctrine()->getEntityManager();
        if ($request->getMethod() == 'POST') {
            $_SESSION['added_docs'][$_POST['session_array_id']]['filled_fields'] = $_POST['fields'];
        }
        if (!isset($_SESSION['added_docs'])) {
            $_SESSION['added_docs'] = array();
        }

        $modify_id = $request->query->get('modify_id');
        if (is_numeric($modify_id)) {
            reset($_SESSION['added_docs'][$modify_id]);
            $first_element_id = key($_SESSION['added_docs'][$modify_id]);
            $doc = $_SESSION['added_docs'][$modify_id][$first_element_id];
            $filled_fields = $_SESSION['added_docs'][$modify_id]['filled_fields'];
            $doc_fields = $em->getRepository('DocDocBundle:DocFields')->setDocListId($doc->getId())->getFields(); // get available fields for this document

            return $this->render('FrontFrontBundle:Doc:step3.html.twig', array('doc' => $doc, 'doc_fields' => $doc_fields, 'session_array_id' => $modify_id, 'filled_fields' => $filled_fields));
        } else {
            foreach ($_SESSION['added_docs'] as $key => $value) {
                if (!isset($_SESSION['added_docs'][$key]['filled_fields'])) {
                    foreach ($_SESSION['added_docs'][$key] as $key1) {
                        $doc = $key1;
                        break;
                    }
                    $doc_fields = $em->getRepository('DocDocBundle:DocFields')->setDocListId($doc->getId())->getFields(); // get available fields for this document

                    return $this->render('FrontFrontBundle:Doc:step3.html.twig', array('doc' => $doc, 'doc_fields' => $doc_fields, 'session_array_id' => $key));
                }
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

    public function step5Action() {
        $request = $this->getRequest();
        $notar_id = @$_GET['notar_id'];
        if(is_numeric($notar_id)) {
            $notar_details = $this->getDoctrine()->getRepository('NotarNotarBundle:Notar')->setNotarId($notar_id)->getNotar();
        } else {
            $notar_details = $this->getDoctrine()->getRepository('NotarNotarBundle:Notar')->getRandomNotar();
        }
        if ($request->getMethod() == 'POST') {
            if (is_numeric($_POST['notar_id'])) {
                $_SESSION['notar_id'] = $_POST['notar_id'];
                return $this->redirect($this->generateUrl('FrontFrontBundle_login_register'));
            } else {
                die('Wrong notar_id');
            }
        }
        if (empty($_SESSION['added_docs'])) {
            die('Nu ati ales nici un document, va rugam apasati "Inapoi"');
        }
        $em = $this->getDoctrine()->getEntityManager();
        $notars = $em->getRepository('NotarNotarBundle:Notar')->getNotars();

        return $this->render('FrontFrontBundle:Doc:step5.html.twig', array('notars' => $notars, 'notar' => $notar_details));
    }

    public function loginRegisterAction() {
        return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
    }

    public function RegisterAction() {
        if (!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/i", $_POST['email'])) {
            $this->get('session')->setFlash('error', 'Ati introdus un email eronat.');
            return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
        }
        if(strlen($_POST['pass'])<6) {
            $this->get('session')->setFlash('error', 'Lungimea parolei trebuie sa fie cel putin 6 caractere.');
            return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
        }
        if($_POST['pass'] != $_POST['repass']) {
            $this->get('session')->setFlash('error', 'Parolele nu coincid.');
            return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
        }
        if(!strlen($_POST['full_name'])) {
            $this->get('session')->setFlash('error', 'Va rugam sa specificati un nume.');
            return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
        }
        if(!strlen($_POST['phone'])) {
            $this->get('session')->setFlash('error', 'Va rugam sa specificati un numar de telefon.');
            return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
        }
        $em = $this->getDoctrine()->getEntityManager();
        $email_exists = $em->getRepository('UserUserBundle:User')->checkEmail($_POST['email']);
        if($email_exists['cnt'] > 0) { // email already exists
            $this->get('session')->setFlash('error', 'Acest email deja e inregistrat in sistem.');
            return $this->render('FrontFrontBundle:Doc:login_register.html.twig');
        }
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setPass($_POST['pass']);
        $user->setFullName($_POST['full_name']);
        $user->setPhone($_POST['phone']);
        $em->persist($user);
        $em->flush();
        
        $session = $this->getRequest()->getSession();
        $session->set('auth', 'in');
        $session->set('user_id', $user->getId());
        
        return $this->redirect($this->generateUrl('FrontFrontBundle_my_orders'));
    }
    
    public function myOrdersAction() {
        $query = '
            INSERT INTO user_doc(doc_id, user_id, notar_id, lang_id, added)
            VALUE(2, 1, 1, 3, NOW())
        ';
        $q = $this->getDoctrine()->getConnection();
        $return = $q->executeUpdate($query);
        var_dump($return->lastInsertId());die;
        die('adsf');
        
        if ($this->checkLogin()) {
            return $this->checkLogin();
        }
        $notar_id = $_SESSION['notar_id'];
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getEntityManager();
        if(!empty($_SESSION['added_docs'])) {
            foreach($_SESSION['added_docs'] as $key) {
                $notars = $em->getRepository('DocDocBundle:UserDoc')->storeSessionUserDoc($key, $notar_id, $session->get('user_id'));
            }
        }
        Debug::d1($_SESSION['added_docs']);
        
        return $this->render('FrontFrontBundle:Doc:my_orders.html.twig');
    }

}
