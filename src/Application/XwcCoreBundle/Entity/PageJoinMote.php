<?php
/**
 * Is not a real Entity, but become an entity because Doctrine2 doesn't allows to create
 * Many To Many with additional columns
 * Page ManyToMany with Mote
 * the additional columns are Tag, TagOrder
 *
 * @author liuggio <liuggio@gmail.com>
 * @version 0.1
 */
namespace Application\XwcCoreBundle\Entity;
/** @orm:Entity(repositoryClass="Application\XwcCoreBundle\Entity\PageJoinMoteRepository") */
class PageJoinMote
{
    /** @orm:Id @orm:Column(type="integer") @orm:GeneratedValue(strategy="IDENTITY") */
    protected $id;
    /**
     *  @orm:ManyToOne(targetEntity="Page", inversedBy="joinMotes")
     *  @orm:JoinColumn(name="pageName", referencedColumnName="name")  
     */
    protected $page;
    /**
     *  @orm:ManyToOne(targetEntity="Mote", inversedBy="joinPages")
     *  @orm:JoinColumn(name="moteName", referencedColumnName="name") 
     */
    protected $mote;
    /** Many-To-One - Unidirectional
     *  @orm:ManyToOne(targetEntity="Tag")
     *  @orm:JoinColumn(name="tagName", referencedColumnName="name")
     */
    private $tag;
    /** @orm:Column(type="integer") */
    protected $tagOrder;

    public function __construct($page = null, $mote = null, $tag = null, $tagOrder = 0)
    {
        if (!is_null($page))
            $this->setPage($page);
        	
        if (!is_null($mote))
            $this->setMote($mote);
         
        if (!is_null($tag))
            $this->setTag($tag);
         
        $this->setTagOrder($tagOrder);
         
    }
    // #TODO check if exist before taking the name...
    public function __toString()
    {
        return "";//$this->getPage()->getName()."-".$this->getMote()->getName()."-".$this->getTag()->getName();
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
     * Set mote
     *
     * @param Application\XwcCoreBundle\Entity\Mote $mote
     */
    public function setMote(\Application\XwcCoreBundle\Entity\Mote $mote)
    {
        $this->mote = $mote;
    }

    /**
     * Get mote
     *
     * @return Application\XwcCoreBundle\Entity\Mote $mote
     */
    public function getMote()
    {
        return $this->mote;
    }

    /**
     * Set tag
     *
     * @param Application\XwcCoreBundle\Entity\Tag $tag
     */
    public function setTag(\Application\XwcCoreBundle\Entity\Tag $tag, $order = null)
    {
        $this->tag = $tag;
        if (!is_null($order))
            $this->setTagOrder($order);
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
}