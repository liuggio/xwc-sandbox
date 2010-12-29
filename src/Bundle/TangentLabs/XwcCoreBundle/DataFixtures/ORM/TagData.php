<?php

namespace Bundle\TangentLabs\XwcCoreBundle\DataFixtures\ORM;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Page;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Mote;
use Bundle\TangentLabs\XwcCoreBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;

class TagData implements FixtureInterface
{
    public function load($manager)
    {
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
		
		$homepage=new page("HomePage");
		
		$body=new Mote("body","Welcome to the homepage", $html_body);
		
		$homepage->addMotes($body);
		
		$manager->persist($body);
		$manager->persist($homepage);
		
    }
}