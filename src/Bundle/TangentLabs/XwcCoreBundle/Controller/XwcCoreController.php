<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class XwcCoreController extends Controller
{
    public function indexAction()
    {   return $this->render('TangentLabs\XwcCoreBundle:Core:layout.twig');
    }
    
}
