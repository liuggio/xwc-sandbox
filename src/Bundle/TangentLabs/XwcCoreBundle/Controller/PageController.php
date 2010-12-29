<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function showAction($route)
    {   
    	$em = $this->get('doctrine.orm.entity_manager'); 
    	$page = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Page')
						->findOneBy(array("route"=>$route));
		if (!$page)
		{   // DIE WITH ERROR #TODO 	
		}else
		{
			$html_head_title = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Tag')
					->findOneBy(array("name"=>"html_head_title"));
		
			if (!$html_head_title)
			{	// DIE WITH ERROR #TODO 
			}else
			{		
				$mote1=new Mote("Title","Page's Title", $html_head_title);
				$page->addMotes($mote1);
		    	$page->appendToMote("Title", "XWC", " | ");
				/*
				$page->removeMote("Body21"); //not yet (well) implemented
		    	//if we want to save to db the new mote
		    	$em->persist($mote1); 
		    	$em->persist($page);
		       	$em->flush();
		       	*/
				return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->getMotesByTag()));	
			}
		}
	}
    /*public function createFromScratchPageAction($name)
    {	$page = new Page($name);
    	$mote1 = new Mote("Title01(". rand(1,9999).")" ,"First Page");
        $em->persist($page);
		$em->flush();
		return $this->render('TangentLabs\XwcCoreBundle:Page:new.twig',array("name"=>$page->getName(),"route"=>$page->getRoute()));
    	
    }
    public function createCloningDefaultPageAction($name)
    {
    }*/       
}
