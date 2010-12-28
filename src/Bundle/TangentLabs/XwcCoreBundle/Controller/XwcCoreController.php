<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;
use  Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use  Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use  Bundle\TangentLabs\XwcCoreBundle\Entity\TagPath;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class XwcCoreController extends Controller
{
	/*
	 * used as test page
	 * */
    public function indexAction()
    {   
    	//should check db connection
    	//log file
    	return $this->render('TangentLabs\XwcCoreBundle:Core:layout.twig');
    }
    
}
