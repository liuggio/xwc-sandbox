<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
use Bundle\TangentLabs\XwcCoreBundle\Util\Inflector;
 
/** @orm:Entity(repositoryClass="Bundle\TangentLabs\XwcCoreBundle\Entity\PageRepository")
 *  @orm:HasLifecycleCallbacks 
 * */
class Page
{
    /** @orm:Id @orm:Column(type="integer") @orm:GeneratedValue(strategy="IDENTITY") */
    private $id;
    /** @orm:Column(type="string") */
    private $name;
    /** @orm:Column(type="string", length=50, unique=true, nullable=false) @orm:Index */
    private $route;
    /** @orm:Column(type="datetime") @orm:Index */
    protected $publishedAt;
    /** @orm:Column(type="datetime") */
    protected $updatedAt = null;
	 /**
     * @orm:ManyToMany(targetEntity="Mote", inversedBy="pages")
     * @orm:JoinTable(name="pages_motes",
     *      joinColumns={@orm:JoinColumn(name="page_id", referencedColumnName="id")},
     *      inverseJoinColumns={@orm:JoinColumn(name="mode_name", referencedColumnName="name")}
     *      )
     */
	private $motes;
	/** not for orm or db */
	private $html;
	

	 public function __construct($name=false, $route=false)
    {   if ($name!==false)
    		$this->setName($name);
    	if ($route!==false)
    		$this->setRoute($route);
    	elseif ($route===false && $name!==false)
    		$this->setRoute($name);// if the route is false, but not the name, we slugify the name
		$this->motes = new \Doctrine\Common\Collections\ArrayCollection();
		$this->updatedAt = $this->publishedAt = new \DateTime();	 
    }
    
    /**
     * Clean the name of the route
     * 
     * @param string $text
     * @param string $default
     * @return string or false
     */
    public function slugify($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');
		
        return $text ? $text : false;
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
     * Set name
     *
     * @param string $nameRepositoryInterface
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set route
     *
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = Inflector::slugify($route);
    }

    /**
     * Get route
     *
     * @return string $route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add motes
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $motes
     */
    public function addMotes(Mote $mote)
    {   //$this->motes[]=$motes;  
    	$this->motes[$mote->getName()]=$mote;   	
    }

    /**
     * Get motes order and listed by names
     *
     * @return Doctrine\Common\Collections\Collection $motes
     */
    public function getMotes()
    {
        return $this->motes;
    }
    
    /**
     * getUpdatedAt 
     * 
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the updated date
     *
     * @return null
     **/
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    
    /** @PreUpdate */
    public function markAsUpdated()
    {
        $this->updatedAt = new \DateTime();
    }
 /**
     * Get motes order and listed by Tag names
     *
     * @return Doctrine\Common\Collections\Collection $motes
     */
    public function getMotesByTag()
    {   $motesByTag=  array();
    	foreach($this->motes as $k)
    	{	$motesByTag[$k->getTag()->getName()][]=$k;
    	}
    	
        return $motesByTag;
    }
    
    /**
     * Get motes order and listed by Tag names
     * @param $motename the name of the mote (is the pk)
     * @param $string
     * @param $delimiter
     * 
     * @return boolean
     */
    public function appendToMote($motename, $string, $delimiter=" ")
    {  
    	if (isset($this->motes[$motename])) //we cannot use in_array this->motes is an object
    	{   $this->motes[$motename]->appendToContent($string, $delimiter);
    		return true;    		  
    	}else
    		 return false;
    }
    /**
     * Get ONE mote
     * @param $motename the name of the mote (is the pk)
     * 
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $mote or false
     */
    public function getMote($motename)
    {  
    	if (isset($this->motes[$motename])) //we cannot use in_array this->motes is an object
    	{    return $this->motes[$motename];        		  
    	}else 
    		 return false;
    }
    /**
     * remove ONE mote
     * @param $motename the name of the mote (is the pk)
     * 
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $mote or false
     */
    public function removeMote(Mote $motename)
    {  
    	if (isset($this->motes[$motename->getName()])) //we cannot use in_array this->motes is an object
    	{	//#TODO clean remove the element (both ways)
    		//$this->motes->removeElement($comment);
        	//$motes->removePage($this);
    		unset($this->motes[$motename]);    		
    		return true;       		  
    	}else 
    		 return false;
    }
    /**
     * Set publishedAt
     *
     * @param datetime $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * Get publishedAt
     *
     * @return datetime $publishedAt
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
}