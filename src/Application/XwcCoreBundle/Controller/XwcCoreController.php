<?php

namespace Application\XwcCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Application\XwcCoreBundle\Entity\Page;
use Application\XwcCoreBundle\Entity\Mote;
use Application\XwcCoreBundle\Entity\PageJoinMote;
use Application\XwcCoreBundle\Entity\PageJoinWidget;
use Application\XwcCoreBundle\Entity\Widget;
use Application\XwcCoreBundle\Entity\WidgetFunction;
use Application\XwcCoreBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;


class XwcCoreController extends Controller
{
    public function indexAction($route)
    {   
        $em = $this->get('doctrine.orm.entity_manager');
        $page = $em->getRepository('Application\XwcCoreBundle\Entity\Page')
            ->findOneBy(array("route"=>$route));
    
        if (!$page)
        {   // DIE WITH ERROR #TODO
            return $this->render('XwcCoreBundle:Default:index.php');
        }else
        {	return $this->render('XwcCoreBundle:Page:show.twig',array("page"=>$page, "motesByTag"=>$page->motesOrderedByTag()));
        }
   
        //return $this->render('XwcCoreBundle:Default:index.php');
    }
}
