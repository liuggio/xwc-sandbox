<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
/** @orm:Entity */
class Mote
{
	/** @orm:Id
     *  @orm:Column(type="string", length="50") */
    private $name;
	/** @orm:Entity  
     *  @orm:ManyToMany(targetEntity="Page", mappedBy="motes") */
    private $pages;
    /** @orm:Column(type="string", nullable=false)
     *  #TODO should be clob (may I define "clob" in doctrine2.0 ??)  */
    private $content;   
	/** Many-To-One - Unidirectional
     *  @orm:ManyToOne(targetEntity="Tag")
     *  @orm:JoinColumn(name="tag_id", referencedColumnName="name") 
     *  #TODO NOT NULL
     *  */   
    private $tag;    
    
    
 	public function __construct($name=false,$content=false,$tag=false)
     {
     	if ($name !== false)
     		$this->name=$name;
     	
        if ($content !== false)
     		$this->content=$content;
     	
     	if ($tag !== false)
     		  $this->setTag($tag);
     		  
     	$this->pages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add pages
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Page $pages
     */
    public function addPages(\Bundle\TangentLabs\XwcCoreBundle\Entity\Page $pages)
    {
        $this->pages[] = $pages;
    }

    /**
     * Get pages
     *
     * @return Doctrine\Common\Collections\Collection $pages
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set tag
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $tag
     */
    public function setTag($tag)
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
}