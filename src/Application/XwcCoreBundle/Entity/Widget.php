<?php
/**
 * Entity Widget
 * A Widget is a Bundle.
 * A Widget can modify all the Motes of the page.
 * A Page may have some Widget
 *
 * @author liuggio <liuggio@gmail.com>
 * @version 0.1
 */
namespace Application\XwcCoreBundle\Entity;
/** @orm:Entity
 *  @orm:HasLifecycleCallbacks */
/* Widget execute a function and fills some Page motes */
class Widget
{   
    const STATUS_ON="on";
    const STATUS_OFF="off";
    const STATUS_DRAFT="draft";
    const STATUS_DEFAULT="draft";
    const FUNCTION_DEFAULT="index";  //following the symfony standard for the bundle
    /** @orm:Id
     *  @orm:Column(type="string", length="50") */
    private $name;
    /** @orm:Column(type="string", length="100") */
    private $className;
    /** @orm:OneToMany(targetEntity="PageJoinMote", mappedBy="awidget") */
    private $widget;
    /** @orm:Column(type="string", columnDefinition="enum('on', 'draft', 'off')") 
     * default and not null are implemented by the LifeCycleCallbacks */
    private $status;
    /** @orm:OneToMany(targetEntity="WidgetFunction", mappedBy="name") */
    private $function;
    
    public function __construct($name, $className = null, $status = null, $function = null)
    {
        $this->name = $name;
    
        if (is_null($className))
            $this->setClassname($name);
        else
            $this->setClassname($className);
         
        $this->setStatus($status);
    
        if (!is_null($function))
            $this->addFunction($function);
    }
    
    public function execute()
    {
        //#TODO with parameter, array of functions and the tag's position
        /*
        if $this->status==ON
        Check if exist the widget's folder called $class
        load the file called widgetFolder/$class/$class.php
        allocate the classes
        foreach in WidgetFunction as Fun
        if there's in QueryString Fun.varName execute $class::Fun.function()
        if there's not any varName execute $class::index
        */
    }
    
    public function __toString()
    {
        return $this->getName() . " (".$this->getStatus() . ")";
    }
    
    
    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        if (($status == self::STATUS_ON) || ($status == self::STATUS_OFF) || ($status == self::STATUS_DRAFT) )
        	$this->status=$status;
        else
            $this->status=self::STATUS_DEFAULT;
    
    }
    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set className
     *
     * @param string $className
     */
    public function setClassname($className)
    {
        $this->className = $className;
    }
    
    /**
     * Get className
     *
     * @return string $className
     */
    public function getClassname()
    {
        return $this->className;
    }
    
    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Add function
     *
     * @param Application\XwcCoreBundle\Entity\WidgetFunction $function
     */
    public function addFunction(\Application\XwcCoreBundle\Entity\WidgetFunction $function)
    {
        $this->function[] = $function;
    }
    
    /**
     * Get function
     *
     * @return Doctrine\Common\Collections\Collection $function
     */
    public function getFunction()
    {
        return $this->function;
    }
    /**
     * Add widget
     *
     * @param Application\XwcCoreBundle\Entity\PageJoinMote $widget
     */
    public function addWidget(\Application\XwcCoreBundle\Entity\PageJoinMote $widget)
    {
        $this->widget[] = $widget;
    }
    
    /**
     * Get widget
     *
     * @return Doctrine\Common\Collections\Collection $widget
     */
    public function getWidget()
    {
        return $this->widget;
    }
    
    /** @orm:PreUpdate */
    public function PreUpdate()
    {	// default value and not null
        $this->setStatus($this->status);
    }
}