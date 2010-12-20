<?php

/* /var/www/xwc-sandbox/app/../src/Application/HelloBundle/Resources/views/Hello/index.twig */
class __TwigTemplate_ee54bb1700e21388a22383cd4e14dcf2 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("HelloBundle::layout.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        echo "    Hello ";
        // line 4
        echo twig_escape_filter($this->env, $this->getContext($context, 'name', '4'), "html");
        echo "!
";
    }

    public function getTemplateName()
    {
        return "/var/www/xwc-sandbox/app/../src/Application/HelloBundle/Resources/views/Hello/index.twig";
    }
}
