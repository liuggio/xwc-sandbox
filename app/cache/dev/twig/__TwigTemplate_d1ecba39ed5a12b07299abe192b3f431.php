<?php

/* /var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/logs.twig */
class __TwigTemplate_d1ecba39ed5a12b07299abe192b3f431 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        // line 1
        echo "<ol>
    ";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array($this->getContext($context, 'logs', '2'));
        foreach ($context['_seq'] as $context['_key'] => $context['log']) {
            echo "        <li";
            // line 3
            if (("ERR" == $this->getAttribute($this->getContext($context, 'log', '3'), "priorityName", array(), "any"))) {
                echo " class=\"error\"";
            }
            echo ">
            ";
            // line 4
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'log', '4'), "priorityName", array(), "any"), "html");
            echo "
            ";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'log', '5'), "message", array(), "any"), "html");
            echo "
        </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['log'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 7
        echo "</ol>
";
    }

    public function getTemplateName()
    {
        return "/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/logs.twig";
    }
}
