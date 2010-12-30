<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\MoteContent;
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
		{	return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->getMotesByTag()));	
		}
	}
	// render a page, its motes, tags but we add some information
    public function editAction($route)
    {   
    	$em = $this->get('doctrine.orm.entity_manager'); 
    	$page = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Page')
					->findOneBy(array("route"=>$route));
		if (!$page)
		{   // DIE WITH ERROR #TODO 	
		}else
		{
			$html_body = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Tag')
					->findOneBy(array("name"=>"html_body"));
		
			if (!$html_body)
			{	// DIE WITH ERROR #TODO 
			}else
			{	$rand=rand();
				$content= new MoteContent("b2-".$rand, "text", "We add this text and we store into db"); 
				$mote=new Mote("CNT-".$rand,$content, $html_body);
				$page->addMotes($mote);
		    	//modified the content of 
				$page->appendToMote("CNT-".$rand, "XWC", " | ");
				 
				//$page->removeMote("Body21"); //not (well) implemented yet 
		    	//if we want to save to db the new mote
		    	$em->persist($content);
		    	$em->persist($mote); 
		    	$em->persist($page);
		       	$em->flush();
		        
			 
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
