<?
namespace Bundle\TangentLabs\XwcCoreBundle\Entity;
use Bundle\TangentLabs\XwcCoreBundle\Util\Inflector;
 
/** @orm:Entity(repositoryClass="Bundle\TangentLabs\XwcCoreBundle\Entity\PageRepository")
 *  @orm:HasLifecycleCallbacks 
 * */
class Page
{
	/** @orm:Id
     *  @orm:Column(type="string", length="50") */
    private $name;
    /** @orm:Column(type="string", length=50, unique=true, nullable="false") @orm:Index */
    private $route;
    /** @orm:Column(type="datetime") @orm:Index */
    private $publishedAt;
    /** @orm:Column(type="datetime") */
    private $updatedAt = null;
    /** @orm:OneToMany(targetEntity="PageJoinMote", mappedBy="page") 
     *  @orm:OrderBy({"tagOrder" = "ASC"})*/
    private $joinMotes;
    /** @orm:OneToMany(targetEntity="PageJoinWidget", mappedBy="page") 
     *  @orm:OrderBy({"tagOrder" = "ASC"})*/
    private $joinWidgets;
 	/** not for orm */
	private $motesByTag;
	

	public function __construct($name = false, $route = false)
    {   if ($name !== false)
    		$this->name=$name;
    		
    	if ($route!==false)
    		$this->setRoute($route);
    	elseif ($route === false && $name !== false)
    		$this->setRoute($name);// if the route is false, but not the name, we slugify the name
		
		$this->updatedAt = $this->publishedAt = new \DateTime();	 
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
    
    /** @orm:PreUpdate */
    public function markAsUpdated()
    {
        $this->updatedAt = new \DateTime();
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
     * Set publishedAt
     *
     * @param datetime $publishedAt
     */
    public function setPublishedAt($publishedAt=false)
    {	if ($publishedAt===false)
    		$publishedAt=new \DateTime();	
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

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {	if ($updatedAt===false)
    		$updatedAt=new \DateTime();
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
   
    /**
     * Add joinMotes
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinMote $joinMotes
     */
    public function addJoinMotes(\Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinMote $joinMotes)
    {	
        $this->joinMotes[] = $joinMotes;
    }  
 
    /**
     * Create a joinMotes and associates it
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Mote $aMote
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $aTag
     * @param integer $tagOrder
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinMote $tmp
     */
    public function createJoinMotes($aMote, $aTag, $tagOrder=false)
    {	$tmp= new PageJoinMote($this, $aMote, $aTag, $tagOrder);
    	$this->joinMotes[] = $tmp;
    	return $tmp;
    }
    /**
     * Create an array of tags, each item contains some motes
     *
     * @return array $this->motesByTag
     */  
    public function motesOrderedByTag()
    {   unset($this->motesByTag);
    	$this->motesByTag= array();
    	foreach($this->joinMotes as $v)
    	{	$this->motesByTag[$v->getTag()->getName()][] = $v->getMote();
    	}
    	return $this->motesByTag;
    }

    /**
     * Get joinMotes
     *
     * @return Doctrine\Common\Collections\Collection $joinMotes
     */
    public function getJoinMotes()
    {
        return $this->joinMotes;
    }

    /**
     * Add joinWidgets
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinWidget $joinWidgets
     */
    public function addJoinWidgets(\Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinWidget $joinWidgets)
    {
        $this->joinWidgets[] = $joinWidgets;
    }
    /**
     * Create a joinWidgets and associates it
     *
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Widget $awidget
     * @param Bundle\TangentLabs\XwcCoreBundle\Entity\Tag $aTag
     * @param integer $tagOrder
     * @return Bundle\TangentLabs\XwcCoreBundle\Entity\PageJoinMote $tmp
     */
    public function createJoinWidgets($awidget, $aTag, $tagOrder=false, $parameter=false)
    {	$tmp= new PageJoinWidget($this, $awidget, $aTag, $tagOrder, $parameter);
    	$this->joinWidgets[] = $tmp;
    	return $tmp;
    }
    /**
     * Get joinWidgets
     *
     * @return Doctrine\Common\Collections\Collection $joinWidgets
     */
    public function getJoinWidgets()
    {
        return $this->joinWidgets;
    }
}