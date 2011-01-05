<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinMote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinWidget;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Widget;
use Bundle\TangentLabs\XwcCoreBundle\Entity\WidgetFunction;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{	// render a page, its motes, tags
    public function showAction($route)
    {   
    	$em = $this->get('doctrine.orm.entity_manager'); 
    	$page = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Page')
					->findOneBy(array("route"=>$route));
  		
    	if (!$page)
		{   // DIE WITH ERROR #TODO 	
		}else
		{	return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->motesOrderedByTag()));	
		}
	}
   
}
