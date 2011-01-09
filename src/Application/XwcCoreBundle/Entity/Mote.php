<?php
/**
 * Entity Mote
 * A Mote is a Static Cotent
 * A page has a lot of Mote
 *
 * @author liuggio <liuggio@gmail.com>
 * @version 0.1
 */
namespace Application\XwcCoreBundle\Entity;
/** @orm:Entity */
class Mote
{
    const TYPE_HTML="html";
    const TYPE_TEXT="text";
    const TYPE_DEFAULT="text";
    /** @orm:Id
     *  @orm:Column(type="string", length="50") */
    private $name;
    /** @orm:Column(type="text") */
    private $content;
    /** @orm:Column(name="type", type="string", columnDefinition="enum('html', 'text')", nullable="false") */
    private $type;
    /** @orm:OneToMany(targetEntity="PageJoinMote", mappedBy="mote") */
    private $joinPages;

    public function __construct($name = null, $content = null, $type = null)
    {
        if (!is_null($name))
            $this->name = $name;
        else
            $this->name = "Content-" . rand();
         
        if (!is_null($content))
            $this->setContent($content);
         
        $this->setType($type);
    }
     
    public function __toString()
    {
        return $this->getContent();
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
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type = false)
    {
        if (($type == self::TYPE_HTML) || ($type == self::TYPE_TEXT) )
            $this->type = $type;
        else
            $this->type = self::TYPE_DEFAULT;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Append a string to Content
     *
     * @param $string
     * @param $delimiter
     * @return string $content
     */
    public function appendTo($string, $delimiter = " ")
    {
        $this->setContent($this->getContent() . $delimiter . $string);
    }
    /**
     * Prepend a string to  Content
     *
     * @param $string
     * @param $delimiter
     * @return string $content
     */
    public function prependTo($string, $delimiter = " ")
    {
        $this->setContent($string . $delimiter . $this->getContent());
    }
    /**
     * Add joinPages
     *
     * @param Application\XwcCoreBundle\Entity\PageJoinMote $joinPages
     */
    public function addJoinPages(\Application\XwcCoreBundle\Entity\PageJoinMote $joinPages)
    {
        $this->joinPages[] = $joinPages;
    }

    /**
     * Get joinPages
     *
     * @return Doctrine\Common\Collections\Collection $joinPages
     */
    public function getjoinPages()
    {
        return $this->joinPages;
    }
}