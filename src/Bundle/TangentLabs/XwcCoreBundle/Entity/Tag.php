<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
//removed children and parent association
/** @orm:Entity */
/* one Tag can be associated to more Motes */
class Tag 
{
	/** @orm:Id
     *  @orm:Column(type="string", length="255") */
    private $name;
	/** �orm:OneToMany(targetEntity="Tag", mappedBy="parent")
     */
    private $children;
    /** �orm:ManyToOne(targetEntity="Tag", inversedBy="children")
     *  �orm:JoinColumn(name="parent_name", referencedColumnName="name")
     */
    private $parent_name;
	/** @orm:Column(type="integer") */
	protected $tag_order;
    
     
     public function __construct($name=false, $parent_name=false, $tag_order=0)
     {  if ($name!==false)
     		$this->name=$name;
  		if ($parent_name!==false)
     		$this->setParentName($parent_name);
     	 
     	$this->setTagOrder($tag_order);     			
     	$this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->parent_name;
    }
    
    
 	/**
     * Set tag_order
     *
     * @param integer $tag_order
     */
    public function setTagOrder($tag_order)
    {
        $this->tag_order = $tag_order;
    }
    
    /**
     * Get tag_order
     *
     * @return integer tag_order
     */
    public function getTagOrder()
    {
        return $this->tag_order;
    }
}