<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
/** @orm:Entity */
class Tag
{
	/** @orm:Id
     *  @orm:Column(type="string", length="255") */
    private $name;
	/** @orm:OneToMany(targetEntity="Tag", mappedBy="parent")
     */
    private $children;
    /** @orm:ManyToOne(targetEntity="Tag", inversedBy="children")
     *  @orm:JoinColumn(name="parent_name", referencedColumnName="name")
     */
    private $parent_name;
	/** @orm:Column(type="integer") */
	protected $tag_order;
    
     
     public function __construct($name=false,$parent_name=false,$type_tag=false)
     {  if ($name!==false)
     		$this->name=$name;
  		if ($parent_name!==false)
     		$this->setParentName($parent_name);
     			
     	$this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
}