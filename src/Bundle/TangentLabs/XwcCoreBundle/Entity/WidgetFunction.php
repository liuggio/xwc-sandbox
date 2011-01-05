<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
/** @orm:Entity */
class WidgetFunction {
    const ACTION_GET="get";
    const ACTION_POST="post";
    const ACTION_DEFAULT="get";
    
    /** @orm:Id @orm:Column(type="integer") @orm:GeneratedValue(strategy="IDENTITY") */
    private $id;
    /** @orm:Column(name="type", type="string", columnDefinition="enum('get', 'post')") */
    private $action;
    /** @orm:Column(type="string", length="25") */
    private $varName;
    /** @orm:Column(type="string", length="50") */    
    private $function;
    /** @orm:ManyToOne(targetEntity="Widget", inversedBy="WidgetFunctions")
     *  @orm:JoinColumn(name="widgetName", referencedColumnName="name") */
    private $widget;
    
    public function __construct($widget, $action, $varName=false, $function=false)
	{   
		if ($widget !== false)
			$this->setWidget($widget);
			
		$this->setAction($action);
			 		
	 	if ($varName !== false)
	 		$this->setVarName($varName);
	 			 		
	 	if ($function !== false)
	 		$this->function=$function;	 		
	 }	 
 

    /**
     * Set action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        if (($action==self::ACTION_GET) || ($action==self::ACTION_POST) )
	 	{	$this->action = $action;
	 	}else
	 		$this->action = self::ACTION_DEFAULT;
    }
  
    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get action
     *
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set varName
     *
     * @param string $varName
     */
    public function setVarName($varName)
    {
        $this->varName = $varName;
    }

    /**
     * Get varName
     *
     * @return string $varName
     */
    public function getVarName()
    {
        return $this->varName;
    }

    /**
     * Set function
     *
     * @param string $function
     */
    public function setFunction($function)
    {
        $this->function = $function;
    }

    /**
     * Get function
     *
     * @return string $function
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set widget
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Widget $widget
     */
    public function setWidget(\Bundle\TangentLabs\XwcCoreBundle\Entity\Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Get widget
     *
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Widget $widget
     */
    public function getWidget()
    {
        return $this->widget;
    }
}