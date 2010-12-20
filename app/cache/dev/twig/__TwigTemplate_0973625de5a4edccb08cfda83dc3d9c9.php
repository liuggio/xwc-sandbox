<?php

/* ::layout.twig */
class __TwigTemplate_0973625de5a4edccb08cfda83dc3d9c9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    public function display(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <title>";
        // line 5
        $this->getBlock('title', $context, $blocks);
        echo "</title>
    </head>
    <body>
        ";
        // line 8
        $this->getBlock('body', $context, $blocks);
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Hello Application";
    }

    // line 8
    public function block_body($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::layout.twig";
    }
}
