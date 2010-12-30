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
	/** Many-To-One - Unidirectional
     *  @orm:ManyToOne(targetEntity="Tag")
     *  @orm:JoinColumn(name="tag_name", referencedColumnName="name") 
     *  #TODO NOT NULL
     */   
    private $tag;    
 	/** Many-To-One - Unidirectional
     *  @orm:ManyToOne(targetEntity="MoteContent")
     *  @orm:JoinColumn(name="content_name", referencedColumnName="name")
     */   
    private $mote_content;    
       
    
 	public function __construct($name=false, $content=false, $tag=false)
     {
     	if ($name !== false)
     		$this->name=$name;
     	
        if ($content !== false)
     		$this->setMoteContent($content);
     	
     	if ($tag !== false)
     		  $this->setTag($tag);
     		  
     	$this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
	{
		//return $this->getContent();
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
     * Append a string to MoteContent
     * is a shortcut for $this->mote_content->appendToContent
     * @param $string
     * @param $delimiter
     * @return string $content
     */
     public function appendToContent($string, $delimiter=" ")
    {
         $this->mote_content->appendToContent($string, $delimiter);
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
    /**
     * Set the MoteContent associated
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\MoteContent $content
     */
    public function setMoteContent(\Bundle\TangentLabs\XwcCoreBundle\Entity\MoteContent $motecontent)
    {
        $this->mote_content = $motecontent;
    }

     /**
     * Get the MoteContent associated
     *
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\MoteContent $content
     */
    public function getMoteContent()
    {
        return $this->mote_content;
    }
   
 

     /**
     * Get the MoteContent->getContent associated
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->mote_content->getContent();
    }    
    
}