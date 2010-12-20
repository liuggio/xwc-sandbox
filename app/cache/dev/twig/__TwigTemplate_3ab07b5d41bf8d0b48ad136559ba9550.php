<?php

/* /var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Profiler/toolbar.twig */
class __TwigTemplate_3ab07b5d41bf8d0b48ad136559ba9550 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- START of Symfony2 Web Debug Toolbar -->
";
        // line 2
        if (("normal" != $this->getContext($context, 'position', '2'))) {
            echo "    <div style=\"clear: both; height: 40px;\"></div>
";
        }
        // line 4
        echo "<div
    class=\"sf-toolbarreset\"
    ";
        // line 7
        if (("normal" != $this->getContext($context, 'position', '7'))) {
            echo "        style=\"position: ";
            // line 8
            echo twig_escape_filter($this->env, $this->getContext($context, 'position', '8'), "html");
            echo ";
        background: #cbcbcb;
        background-image: -moz-linear-gradient(-90deg, #e8e8e8, #cbcbcb);
        background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#e8e8e8), to(#cbcbcb));
        bottom: 0;
        left:0;
        z-index: 6000000;
        width: 100%;
        border-top: 1px solid #bbb;
        padding: 5px;
        margin: 0;
        font: 11px Verdana, Arial, sans-serif;
        color: #000;
    \"
    ";
        }
        // line 22
        echo ">
";
        // line 24
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_iterator_to_array($this->getContext($context, 'templates', '24'));
        foreach ($context['_seq'] as $context['name'] => $context['template']) {
            echo "    ";
            // line 25
            ob_start();
            echo $this->getAttribute($this->getContext($context, 'template', '25'), "block", array("toolbar", array("collector" => $this->getAttribute($this->getContext($context, 'profiler', '25'), "get", array($this->getContext($context, 'name', '25'), ), "method")), ), "method");
            $context['content'] = ob_get_clean();
            echo "    ";
            // line 26
            if ($this->getContext($context, 'content', '26')) {
                echo $this->getContext($context, 'content', '26');
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['template'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 27
        echo "</div>
<!-- END of Symfony2 Web Debug Toolbar -->
";
    }

    public function getTemplateName()
    {
        return "/var/www/xwc-sandbox/app/../src/vendor/symfony/src/Symfony/Bundle/WebProfilerBundle/Resources/views/Profiler/toolbar.twig";
    }
}
