<?php

namespace Application\XwcCoreBundle\DataFixtures\ORM;
use Application\XwcCoreBundle\Entity\Page;
use Application\XwcCoreBundle\Entity\Mote;
use Application\XwcCoreBundle\Entity\PageJoinMote;
use Application\XwcCoreBundle\Entity\PageJoinWidget;
use Application\XwcCoreBundle\Entity\Widget;
use Application\XwcCoreBundle\Entity\WidgetFunction;
use Application\XwcCoreBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\FixtureInterface;

class TagData implements FixtureInterface
{
    public function load($manager)
    {
        /* Tags */
        $html = new Tag('html', NULL , '0');
        $html_attributes = new Tag('html_attributes', $html, 0);
        $html_body = new Tag('html_body', $html, 20);
        $html_body_footer = new Tag('html_body_footer', $html_body, 100);
        $html_body_header = new Tag('html_body_header', $html_body, 25);
        $html_head = new Tag('html_head', $html, 10);
        $html_head_meta = new Tag('html_head_meta', $html_head, 11);
        $html_head_title = new Tag('html_head_title', $html_head, 12);
        $html_head_link = new Tag('html_head_link', $html_head, 13);
        $html_head_script = new Tag('html_head_script', $html_head, 14);

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
         
        /* Widget */
        $W_TMCE = new Widget("TyneMCE"); //not implemented is only for example
        $W_TMCE_F1 = new WidgetFunction($W_TMCE, WidgetFunction::ACTION_GET, "SHOW", "show");
        $W_TMCE_F2 = new WidgetFunction($W_TMCE, WidgetFunction::ACTION_GET, "EDIT", "edit");

        $manager->persist($W_TMCE);
        $manager->persist($W_TMCE_F1);
        $manager->persist($W_TMCE_F2);

        $W_YT = new Widget("YouTube"); //not implemented is only for example
        $manager->persist($W_YT);

        /* Mote-Contents*/
        $content_title = new Mote("title01", "WebSite's Name", Mote::TYPE_TEXT);
        $content_body1 = new Mote("body01", "Welcome to the homepage", Mote::TYPE_TEXT);
        $content_body2 = new Mote("body02", "Welcome to the page 2", Mote::TYPE_TEXT);

        $manager->persist($content_title);
        $manager->persist($content_body1);
        $manager->persist($content_body2);

        /* Pages */
        // 1st way
        $homepage = new Page("HomePage");
        $PJM_01 = new PageJoinMote($homepage, $content_title, $html_head_title);
        $PJW_01 = new PageJoinWidget($homepage, $W_TMCE, $html_body, 20);
        $PJW_02 = new PageJoinWidget($homepage, $W_YT, $html_body, 15, "http://www.youtube.com/watch?v=GFFB4xGfzRk&feature=related");

        $manager->persist($homepage);
        $manager->persist($PJM_01);
        $manager->persist($PJW_01);
        $manager->persist($PJW_02);

        // 2nd way
        $secondpage = new Page("FirstPage");
        $PJM_02 = $secondpage->createJoinMotes($content_body1, $html_body, 100);
        $PJM_03 = $secondpage->createJoinMotes($content_body2, $html_body, 20);
        $PJW_03 = $secondpage->createJoinWidgets($W_YT, $html_body, 15, "http://www.youtube.com/watch?v=QwD981I4niI");

        $manager->persist($PJM_02);
        $manager->persist($PJM_03);
        $manager->persist($PJW_03);
        $manager->persist($secondpage);
    }
}