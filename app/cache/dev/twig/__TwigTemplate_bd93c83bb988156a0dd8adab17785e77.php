<?php

/* /var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/trace.twig */
class __TwigTemplate_bd93c83bb988156a0dd8adab17785e77 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        // line 1
        if ($this->getAttribute($this->getContext($context, 'trace', '1'), "function", array(), "any")) {
            echo "    at <strong><abbr title=\"";
            // line 2
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'trace', '2'), "class", array(), "any"), "html");
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'trace', '2'), "short_class", array(), "any"), "html");
            echo "</abbr>";
            echo twig_escape_filter($this->env, ($this->getAttribute($this->getContext($context, 'trace', '2'), "type", array(), "any") . $this->getAttribute($this->getContext($context, 'trace', '2'), "function", array(), "any")), "html");
            echo "</strong>(";
            echo $this->getEnvironment()->getExtension('templating')->formatArgs($this->getAttribute($this->getContext($context, 'trace', '2'), "args", array(), "any"));
            echo ")<br />
";
        }
        // line 4
        if (($this->getAttribute($this->getContext($context, 'trace', '4'), "file", array(), "any", true) && $this->getAttribute($this->getContext($context, 'trace', '4'), "line", array(), "any", true))) {
            echo "    in <em>";
            // line 5
            echo $this->getEnvironment()->getExtension('templating')->formatFile($this->getAttribute($this->getContext($context, 'trace', '5'), "file", array(), "any"), $this->getAttribute($this->getContext($context, 'trace', '5'), "line", array(), "any"));
            echo "</em>
    <a href=\"#\" onclick=\"toggle('trace_";
            // line 6
            echo twig_escape_filter($this->env, (($this->getContext($context, 'prefix', '6') . "_") . $this->getContext($context, 'i', '6')), "html");
            echo "'); return false;\">&raquo;</a><br />
    <div id=\"trace_";
            // line 7
            echo twig_escape_filter($this->env, (($this->getContext($context, 'prefix', '7') . "_") . $this->getContext($context, 'i', '7')), "html");
            echo "\" class=\"trace\" style=\"display: ";
            echo ((0 == $this->getContext($context, 'i', '7'))) ? ("block") : ("none");
            echo "\">
        ";
            // line 8
            echo $this->getEnvironment()->getExtension('templating')->fileExcerpt($this->getAttribute($this->getContext($context, 'trace', '8'), "file", array(), "any"), $this->getAttribute($this->getContext($context, 'trace', '8'), "line", array(), "any"));
            echo "
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/trace.twig";
    }
}
