<?php

namespace Bundle\TangentLabs\XwcCoreBundle\Controller;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\TagPath;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function showAction($route)
    {   
    	$page = new Page($route);
     	 
    	$mote[]=new mote("Title","Page's Title","html_head_title");
    	$mote[]=new mote("Script","//javascript","html_head_script");
    	$mote[]=new mote("Body","First Content","html_body");
    	$mote[]=new mote("Body2","and first page","html_body");
		$mote[]=new mote("Body21","AIAIAIAIAAIAIAIAIAIAIAI","html_body");
		
    	foreach($mote as $oneM)
    	{	$page->addMotes($oneM);
    	}
    	$page->appendToMote("Title", "XWC", " | ");
    	$page->removeMote("Body21");
    	
    	return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->getMotesByTag()));
    }
    public function createAction($name)
    {   
    	/*$page = new Page($name);
    	$mote1 = new Mote("Title01(". rand(1,9999).")" ,"First Page");

        $em->persist($page);
        
		$em->flush();
	   	  
    	
    	return $this->render('TangentLabs\XwcCoreBundle:Page:new.twig',array("name"=>$page->getName(),"route"=>$page->getRoute()));
    	*/
    }   
}
