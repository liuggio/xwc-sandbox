<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;

/** @orm:Entity
 * doctrine2 doesn't allow to create manytomany with additional columns,
 * tag is an association class*/
class PageJoinWidget
{
    /** @orm:Id @orm:Column(type="integer") @orm:GeneratedValue(strategy="IDENTITY") */
    protected $id;
    /** @orm:ManyToOne(targetEntity="Page", inversedBy="apagewidget")
     *  @orm:JoinColumn(name="pageName", referencedColumnName="name") */
    protected $page;
    /** @orm:ManyToOne(targetEntity="Widget", inversedBy="awidget")
     *  @orm:JoinColumn(name="widgetName", referencedColumnName="name") */
    protected $widget;  
    /** Many-To-One - Unidirectional
     *  @orm:ManyToOne(targetEntity="Tag")
     *  @orm:JoinColumn(name="tagName", referencedColumnName="name")
     */
    private $tag;   
	/** @orm:Column(type="integer") */
    protected $tagOrder;
	/** @orm:Column(type="array") */
    protected $parameter;
    
	public function __construct($page=false, $widget=false, $tag=false, $tagOrder=0, $parameter=false)
	{
  		if ($page !== false)
     		$this->setPage($page);
     		  		
     	if ($widget !== false)
     		$this->setWidget($widget);
     		
  		if ($tag !== false)
     		$this->setTag($tag);
     		
  		if ($parameter !== false)
     		if (is_array($parameter))
     			$this->setParameter($parameter);
     		 else $this->setParameter(array("p"=>$parameter)); 
     		 		
     	$this->setTagOrder($tagOrder); 
	}  
  	// #TODO check if exist before taking the name...
	public function __toString()
	{	return $this->getPage()->getName()."-".$this->getWidget()->getName()."-".$this->getTag()->getName();
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
     * Set tagOrder
     *
     * @param integer $tagOrder
     */
    public function setTagOrder($tagOrder)
    {
        $this->tagOrder = $tagOrder;
    }

    /**
     * Get tagOrder
     *
     * @return integer $tagOrder
     */
    public function getTagOrder()
    {
        return $this->tagOrder;
    }

    /**
     * Set page
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Page $page
     */
    public function setPage(\Bundle\TangentLabs\XwcCoreBundle\Entity\Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Page $page
     */
    public function getPage()
    {
        return $this->page;
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

    /**
     * Set tag
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $tag
     */
    public function setTag(\Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $tag
     */
    public function getTag()
    {
        return $this->tag;
    }
    /**
     * Set parameter
     *
     * @param array $parameter
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * Get parameter
     *
     * @return array $parameter
     */
    public function getParameter()
    {
        return $this->parameter;
    }
}