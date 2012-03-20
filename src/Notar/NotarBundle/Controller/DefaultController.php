<?php

namespace Notar\NotarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('NotarNotarBundle:Default:index.html.twig', array('name' => $name));
    }
}
