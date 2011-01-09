<?php
/**
 * Is not a real Entity, but become an entity because Doctrine2 doesn't allows to create
 * Many To Many with additional columns
 * Page ManyToMany with Widget
 * all the additional columns are Tag, TagOrder, parameter are optional
 *
 * @author liuggio <liuggio@gmail.com>
 * @version 0.1
 */
namespace Application\XwcCoreBundle\Entity;

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

    public function __construct($page = null, $widget = null, $tag = null, $tagOrder = 0, $parameter = null)
    {
        if (!is_null($page))
            $this->setPage($page);
        	
        if (is_null($widget))
            $this->setWidget($widget);
         
        if (is_null($tag))
            $this->setTag($tag);
         
        if (is_null($parameter))
            if (is_array($parameter))
     			$this->setParameter($parameter);
             else 
                 $this->setParameter(array("p"=>$parameter));

     		 $this->setTagOrder($tagOrder);
    }
    // #TODO check if exist before taking the name...
    public function __toString()
    {
        return $this->getPage()->getName() . "-" . $this->getWidget()->getName() . "-" . $this->getTag()->getName();
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
     * @param Application\XwcCoreBundle\Entity\Page $page
     */
    public function setPage(\Application\XwcCoreBundle\Entity\Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Application\XwcCoreBundle\Entity\Page $page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set widget
     *
     * @param Application\XwcCoreBundle\Entity\Widget $widget
     */
    public function setWidget(\Application\XwcCoreBundle\Entity\Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Get widget
     *
     * @return Application\XwcCoreBundle\Entity\Widget $widget
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * Set tag
     *
     * @param Application\XwcCoreBundle\Entity\Tag $tag
     */
    public function setTag(\Application\XwcCoreBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return Application\XwcCoreBundle\Entity\Tag $tag
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