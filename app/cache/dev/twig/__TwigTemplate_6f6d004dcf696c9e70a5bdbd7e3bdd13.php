<?php

/* WebProfilerBundle:Collector:security.twig */
class __TwigTemplate_6f6d004dcf696c9e70a5bdbd7e3bdd13 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
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
    public function block_toolbar($context, array $blocks = array())
    {
        echo "<img style=\"margin: 0 5px 0 10px; vertical-align: middle; height: 24px\" width=\"24\" height=\"24\" alt=\"Security\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB8AAAAfCAYAAAAfrhY5AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAftJREFUeNpi/P//P8NAASaGAQSjlg8IYEHmMDIyEqMnAYiDgZgHyv8CxGuBeAEhjeiJm4VExybEx8fX29vby3BwcID1/vjx48/Bgwd1Fi5cyECMA1A8i+waAj7nSUhIOOvi4qKGTXLPnj23FixYYAwNCaJ8TnSca2lpGVpaWir9/fuXARsGyYHU0CTBKSoqerOxsbH8+/ePARsGyYHUkJ3g8AFVVVWNP3/+EFRDE8tBvgMFLyE1NLGci4vrHSGfg9TQJM65ubl3gSzHh0FqaOJzTk7OHYR8DlJDE5+XlJR8ePfu3eHfv38zYMMgOZAampXtQJ/14QpykBypZTspJRwY1NXVYW19NDU1EdRMSdluAKpQ8MR7M7SCuUAtn4NqLhsgjldRUdEwNjaWkZOTE8Fm0KNHj96cPXv2yZ07d24AuaBa5gh6OY/uc1yWS4B8Ccy3vpqamvJASxWA2YiDGN98/fr1B9ARD65fv/7w27dvm6Gh8YIYy0E+bRYSErIA+VJZWVmClZWV1GoXDIA54M/du3dfgEIDmBNOAIVqgXZ9wWk5Pz9/iZubW7WoqKgANVssr1+//rBr167Wjx8/9uC03NHR8bGampoMLZpMt27derJ//35ZnKldSUlJhlApRi4AmY23eCW1VqJqA5JQlUltwDjaXRpxlgMEGAA2xSf2HpUp2wAAAABJRU5ErkJggg==\" />
";
        // line 5
        if ($this->getAttribute($this->getContext($context, 'collector', '5'), "authenticated", array(), "any")) {
            echo "    <span style=\"color: #3a3\">";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'collector', '6'), "user", array(), "any"), "html");
            echo "</span>
";
        } elseif ($this->getAttribute($this->getContext($context, 'collector', '7'), "enabled", array(), "any")) {
            // line 7
            echo "    <span style=\"color: #a33\">anon.</span>
";
        } else {
            // line 9
            echo "    <span style=\"color: #a33\">disabled</span>
";
        }
    }

    // line 14
    public function block_menu($context, array $blocks = array())
    {
        echo "<img style=\"margin: 0 5px 0 0; vertical-align: middle; width: 32px\" width=\"32\" height=\"32\" alt=\"Security\" src=\"";
        // line -1
        echo         // line 15
$this->env->getExtension("templating")->getContainer()->get("templating.helper.assets")->getUrl("bundles/webprofiler/images/security.png");
        echo "\" />
Security
";
    }

    // line 19
    public function block_panel($context, array $blocks = array())
    {
        echo "    <h2>Security</h2>
";
    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Collector:security.twig";
    }
}
