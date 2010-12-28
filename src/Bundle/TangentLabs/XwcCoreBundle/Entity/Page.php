<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
use Bundle\TangentLabs\XwcCoreBundle\Util\Inflector;
/** @orm:Entity 
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
	

	 public function __construct($name=false,$route=false)
    {   if ($name!==false)
    		$this->setName($name);
    	if ($route!==false)
    		$this->setRoute($route);
    	elseif ($route===false && $name!==false)
    		$this->setRoute($name);// if the route is false, but not the name, we slugify the name
		$this->motes = new \Doctrine\Common\Collections\ArrayCollection();
		 
		$this->publishedAt = new \DateTime();
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
     * @param string $name
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
    public function addMotes(\Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $motes)
    {   $this->motes[]=$motes;    	
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
     * Get motes order and listed by Tag names
     *
     * @return Doctrine\Common\Collections\Collection $motes
     */
    public function getMotesByTag()
    {    
    	foreach($this->motes as $k)
    	{	$motesByTag[$k->getTag()][]=$k;
    	}
    	
        return $motesByTag;
    }
}