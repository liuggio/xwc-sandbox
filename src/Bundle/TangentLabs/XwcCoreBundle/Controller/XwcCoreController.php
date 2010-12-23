<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class XwcCoreController extends Controller
{
    public function indexAction()
    {   var_dump($this->container->getParameter('doctrine.orm.entity_dirs'));
        return $this->render('TangentLabs\XwcCoreBundle:Core:layout.twig');
    }
    
}
