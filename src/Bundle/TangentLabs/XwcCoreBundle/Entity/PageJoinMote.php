<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;

/** @orm:Entity(repositoryClass="Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinMoteRepository")
 * doctrine2 doesn't allow to create manytomany with additional columns */
class PageJoinMote
{
    /** @orm:Id @orm:Column(type="integer") @orm:GeneratedValue(strategy="IDENTITY") */
	protected $id;	
    /** 
     *  @orm:ManyToOne(targetEntity="Page", inversedBy="joinMotes")
     *  @orm:JoinColumn(name="pageName", referencedColumnName="name")  */
    protected $page;
    /**
     *  @orm:ManyToOne(targetEntity="Mote", inversedBy="joinPages") 
     *  @orm:JoinColumn(name="moteName", referencedColumnName="name") */
    protected $mote;  
    /** Many-To-One - Unidirectional
     *  @orm:ManyToOne(targetEntity="Tag")
     *  @orm:JoinColumn(name="tagName", referencedColumnName="name")
     */
    private $tag;   
	/** @orm:Column(type="integer") */
    protected $tagOrder;

	public function __construct($page=false, $mote=false, $tag=false, $tagOrder=0)
	{
  		if ($page!==false)
     		$this->setPage($page);
     		  		
     	if ($mote!==false)
     		$this->setMote($mote);
     		
  		if ($tag!==false)
     		$this->setTag($tag);
     		
     	$this->setTagOrder($tagOrder);
     	 
	}  
  	// #TODO check if exist before taking the name...
	public function __toString()
	{	return "";//$this->getPage()->getName()."-".$this->getMote()->getName()."-".$this->getTag()->getName();
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
     * Set mote
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $mote
     */
    public function setMote(\Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $mote)
    {
        $this->mote = $mote;
    }

    /**
     * Get mote
     *
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $mote
     */
    public function getMote()
    {
        return $this->mote;
    }

    /**
     * Set tag
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $tag
     */
    public function setTag(\Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $tag, $order=false)
    {
        $this->tag = $tag;
        if ($order!==false)
        	$this->setTagOrder($order);        
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
}