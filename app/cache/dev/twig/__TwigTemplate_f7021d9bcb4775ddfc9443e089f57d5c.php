<?php

/* WebProfilerBundle:Collector:exception.twig */
class __TwigTemplate_f7021d9bcb4775ddfc9443e089f57d5c extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("WebProfilerBundle:Profiler:layout.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        echo "    <link href=\"";
        // line -1
        echo         // line 4
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/framework/css/exception.css");
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\" />
";
    }

    // line 7
    public function block_menu($context, array $blocks = array())
    {
        // line 8
        if ($this->getAttribute($this->getContext($context, 'collector', '8'), "hasexception", array(), "any")) {
            echo "    <span class=\"count\">1</span>
";
        }
        // line 10
        echo "<img style=\"margin: 0 5px 0 0; vertical-align: middle; width: 32px\" width=\"32\" height=\"32\" alt=\"Exception\" src=\"";
        // line -1
        echo         // line 11
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/webprofiler/images/exception.png");
        echo "\" />
Exception
";
    }

    // line 15
    public function block_panel($context, array $blocks = array())
    {
        echo "    <h2>Exception</h2>

    ";
        // line 18
        if ((!$this->getAttribute($this->getContext($context, 'collector', '18'), "hasexception", array(), "any"))) {
            echo "        <em>No exception was thrown and uncaught during the request.</em>
    ";
        } else {
            // line 20
            echo "        ";
            // line -1
            echo             // line 21
$this->env->getExtension("templating")->getContainer()->get("templating.helper.actions")->render("WebProfilerBundle:Exception:show", array("exception" => $this->getAttribute($this->getContext($context, 'collector', '21'), "exception", array(), "any"), "format" => "html"));
            echo "    ";
        }
    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Collector:exception.twig";
    }
}
