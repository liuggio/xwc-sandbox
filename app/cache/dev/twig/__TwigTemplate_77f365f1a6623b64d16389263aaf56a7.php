<?php

/* HelloBundle::layout.twig */
class __TwigTemplate_77f365f1a6623b64d16389263aaf56a7 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'body' => array($this, 'block_body'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("::layout.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        echo "    <h1>Hello Application</h1>

    ";
        // line 6
        $this->getBlock('content', $context, $blocks);
    }

    public function getTemplateName()
    {
        return "HelloBundle::layout.twig";
    }
}
