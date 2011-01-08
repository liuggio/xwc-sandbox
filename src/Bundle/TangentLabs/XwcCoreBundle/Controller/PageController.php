<?php
namespace Application\XwcCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    // render a page, its motes, tags
    public function showAction($route)
    {
        /*$em = $this->get('doctrine.orm.entity_manager');
        $page = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Page')
        ->findOneBy(array("route"=>$route));
    
        if (!$page)
        {   // DIE WITH ERROR #TODO
            return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->motesOrderedByTag()));
    
        }else
        {	return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->motesOrderedByTag()));
        }*/
        return $this->render('HelloBundle:Hello:index.twig', array('name' => $name));
    }
    // render a page, its motes, tags but we add some information
    public function editAction($route)
    {	$em = $this->get('doctrine.orm.entity_manager');
        $page = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Page')
                ->findOneBy(array("route"=>$route));
    
        if (!$page)
        { // DIE WITH ERROR #TODO
        }else
        {
            $html_body = $em->getRepository('Bundle\TangentLabs\XwcCoreBundle\Entity\Tag')
                ->findOneBy(array("name"=>"html_body"));
            if (!$html_body)
            { // DIE WITH ERROR #TODO
            }else
            {
                $rand=rand();
                $mote = new Mote("CNT-" . $rand, "In this page we create and modify a content in a  page", Mote::TYPE_TEXT);
                $join = $page->createJoinMotes($mote, $html_body, 120);
                //modified the content of
                $mote->appendTo("post. ", " | ");
                $mote->prependTo("Pre ", " | ");
                //$page->removeMote("Body21"); //not implemented yet
                //if we want to save to db the new mote
                $em->persist($mote);
                $em->persist($join);
                $em->persist($page);
                $em->flush();
        
                return $this->render('TangentLabs\XwcCoreBundle:Page:show.twig',array("page"=>$page,"motesByTag"=>$page->motesOrderedByTag()));
            }
        }
    }
}
