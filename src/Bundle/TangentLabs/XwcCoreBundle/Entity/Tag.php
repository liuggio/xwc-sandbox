<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
//removed children and parent association (see #)
/** @orm:Entity */
class Tag 
{
	/** @orm:Id
     *  @orm:Column(type="string", length="255") */
    private $name;
	/** #orm:OneToMany(targetEntity="Tag", mappedBy="parent")
     */
    private $children;
    /** #orm:ManyToOne(targetEntity="Tag", inversedBy="children")
     *  #orm:JoinColumn(name="parentName", referencedColumnName="name")
     */
    private $parentName;
	/** @orm:Column(type="integer") */
	private $tagOrder;
    
     
     public function __construct($name=false, $parentName=false, $tagOrder=0)
     {  if ($name !== false)
     		$this->name = $name;
  		if ($parentName !== false)
     		$this->setParentName($parentName);
     	 
     	$this->setTagOrder($tagOrder);     			
     	// # $this->children = new \Doctrine\Common\Collections\ArrayCollection();
     }  
  	
    public function __toString()
	{
		return $this->getName();
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
     * Add children
     *
     * @param $children
     */
    public function addChildren($children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection $children
     */
    public function getChildren()
    {
        return $this->children;
    }

 
    /**
     * Set parent_name
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $parentName
     */
    public function setParentName($parentName)
    {
        $this->parent_name = $parentName;
    }

    /**
     * Get parent_name
     *
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $parentName
     */
    public function getParentName()
    {
        return $this->parentName;
    }
    
    
 	/**
     * Set tag_order
     *
     * @param integer $tag_order
     */
    public function setTagOrder($tagOrder)
    {
        $this->tagOrder = $tagOrder;
    }
    
    /**
     * Get tag_order
     *
     * @return integer tag_order
     */
    public function getTagOrder()
    {
        return $this->tagOrder;
    }
}