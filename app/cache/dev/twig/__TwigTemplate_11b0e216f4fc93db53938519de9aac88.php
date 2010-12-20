<?php

/* WebProfilerBundle:Profiler:base.twig */
class __TwigTemplate_11b0e216f4fc93db53938519de9aac88 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
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
        <link href=\"";
        // line -1
        echo         // line 6
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/webprofiler/css/profiler.css");
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />
        <link href=\"";
        // line -1
        echo         // line 7
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/webprofiler/css/toolbar.css");
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />
        <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"";
        // line -1
        echo         // line 8
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/webprofiler/favicon.ico");
        echo "\" />
        ";
        // line 9
        $this->getBlock('head', $context, $blocks);
        echo "    </head>
    <body>
        ";
        // line 12
        $this->getBlock('body', $context, $blocks);
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Profiler";
    }

    // line 9
    public function block_head($context, array $blocks = array())
    {
        echo "";
    }

    // line 12
    public function block_body($context, array $blocks = array())
    {
        echo "";
    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:base.twig";
    }
}
