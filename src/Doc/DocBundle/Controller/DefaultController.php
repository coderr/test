<?php

namespace Doc\DocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('DocDocBundle:Default:index.html.twig', array('name' => $name));
    }
}
