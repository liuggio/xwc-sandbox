<?php

/* /var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/traces.twig */
class __TwigTemplate_6dbd01fcd93259419f4fe7971e6bed4c extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"block\">
    ";
        // line 2
        if (($this->getContext($context, 'count', '2') > 0)) {
            echo "        <h3>
            <span>";
            // line 4
            echo twig_escape_filter($this->env, (($this->getContext($context, 'count', '4') - $this->getContext($context, 'position', '4')) + 1), "html");
            echo "/";
            echo twig_escape_filter($this->env, ($this->getContext($context, 'count', '4') + 1), "html");
            echo "</span>
            ";
            // line 5
            echo $this->getEnvironment()->getExtension('templating')->abbrClass($this->getAttribute($this->getContext($context, 'exception', '5'), "class", array(), "any"));
            echo ": ";
            echo twig_escape_filter($this->env, twig_strtr($this->getAttribute($this->getContext($context, 'exception', '5'), "message", array(), "any"), array("
" => "<br />")), "html");
            echo "
            <a href=\"#\" onclick=\"toggle('traces_";
            // line 6
            echo twig_escape_filter($this->env, $this->getContext($context, 'position', '6'), "html");
            echo "', 'traces'); return false;\">&raquo;</a><br />
        </h3>
    ";
        } else {
            // line 8
            echo "        <h3>Stack Trace</h3>
    ";
        }
        // line 10
        echo "
    <a id=\"traces_link_";
        // line 12
        echo twig_escape_filter($this->env, $this->getContext($context, 'position', '12'), "html");
        echo "\"></a>
    <ol class=\"traces\" id=\"traces_";
        // line 13
        echo twig_escape_filter($this->env, $this->getContext($context, 'position', '13'), "html");
        echo "\" style=\"display: ";
        echo ((0 == $this->getContext($context, 'position', '13'))) ? ("block") : ("none");
        echo "\">
        ";
        // line 14
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array($this->getAttribute($this->getContext($context, 'exception', '14'), "trace", array(), "any"));
        foreach ($context['_seq'] as $context['i'] => $context['trace']) {
            echo "            <li>
                ";
            // line 16
            $template = "FrameworkBundle:Exception:trace.twig";
            if ($template instanceof Twig_Template) {
                $template->display(array("prefix" => $this->getContext($context, 'position', '16'), "i" => $this->getContext($context, 'i', '16'), "trace" => $this->getContext($context, 'trace', '16')));
            } else {
                echo $this->env->getExtension('templating')->getTemplating()->render($template, array("prefix" => $this->getContext($context, 'position', '16'), "i" => $this->getContext($context, 'i', '16'), "trace" => $this->getContext($context, 'trace', '16')));
            }
            echo "            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['i'], $context['trace'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 18
        echo "    </ol>
</div>
";
    }

    public function getTemplateName()
    {
        return "/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/FrameworkBundle/Resources/views/Exception/traces.twig";
    }
}
