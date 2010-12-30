<?php

namespace Bundle\TangentLabs\XwcCoreBundle\DataFixtures\ORM;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\MoteContent;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;

class TagData implements FixtureInterface
{
    public function load($manager)
    {	
    	/* Tags */
		$html=new Tag('html', NULL , '0');
		$html_attributes=new Tag('html_attributes', $html, 0);
		$html_body=new Tag('html_body', $html, 20);
		$html_body_footer=new Tag('html_body_footer', $html_body, 100);
		$html_body_header=new Tag('html_body_header', $html_body, 25);
		$html_head=new Tag('html_head', $html, 10);
		$html_head_meta=new Tag('html_head_meta', $html_head, 11);
		$html_head_title=new Tag('html_head_title', $html_head, 12);
		$html_head_link=new Tag('html_head_link', $html_head, 13);
		$html_head_script=new Tag('html_head_script', $html_head, 14);
				
		$manager->persist($html);
		$manager->persist($html_attributes);
		$manager->persist($html_body);
		$manager->persist($html_body_footer);
		$manager->persist($html_body_header);
		$manager->persist($html_head);
		$manager->persist($html_head_meta);
		$manager->persist($html_head_title);
		$manager->persist($html_head_link);
		$manager->persist($html_head_script);
		
    	/* MoteContents */
		$content_title= new MoteContent("title01", "text", "WebSite's Name");
		$content_body1= new MoteContent("body01", "text", "Welcome to the homepage");
		$content_body2= new MoteContent("body02", "text", "Welcome to the page 2");  
		
		$manager->persist($content_title);
		$manager->persist($content_body1);
		$manager->persist($content_body2);
		
		/* Motes */
		$title01=new Mote("title1", $content_title, $html_head_title);
		$body01=new Mote("body1", $content_body1, $html_body);
		
		$title02=new Mote("title2", $content_title, $html_head_title);
		$body02=new Mote("body2", $content_title, $html_body_header); //same Content of the title but different position
		$body02b=new Mote("body2a", $content_body2, $html_body);
		

		
		/* Pages */
		$homepage=new Page("HomePage");
		$homepage->addMotes($title01);
		$homepage->addMotes($body01);
		
		$firstpage=new Page("FirstPage");
		$firstpage->addMotes($title02);
		$firstpage->addMotes($body02);	
		$firstpage->addMotes($body02b);	
		
		
		$manager->persist($title01);
		$manager->persist($body01);
		$manager->persist($title02);
		$manager->persist($body02);
		$manager->persist($body02b);
		
		$manager->persist($homepage);
		$manager->persist($firstpage);
    }
}