#Abstract
* This is the traduction (more or less) in pseudocode of the diagram class written in UML

#Entity "Page"
 * Description: this table content all the pages of the CMS 
 * Attributes:
   * id: primary key  
   * name: string 
   * route: string, indexed, slugified
   * publishedAt: datetime()
   * modifiedAt: datetime()

#Entity "Mote"
 * Description: is a simple content of data (now only html)
 * Attributes
   * name: primary key, string 
   * content: clob
   * tag_name: string, oneToMany with Tag, indexed
   * publishedAt: datetime()

#Entity "Tag"
 * Description: this table content all the information about the allowed tags. is possibile from a leaf reach the root.
 * Attributes
   * name: primary key, string
   * parent: string, manyToOne
   * order: integer

#Association Class "PageMote"
 * PageMote-Attributes
   * page_id
   * mote_name

#Operations

 1. $page=new Page("Page name", "RouteName")
 2. $page->getMotesByTag()
     
      return all the motes grouped by tag owned by that page;
      a twig template will organize the content;
      @return array of array eg.  ["tags'name"]=array of motes

 3. $mote= new Mote("Name", "HtmlContent", "tagname")

     eg. $mote("title01", "HomePage", "html_head_title")
     $page->addMote($mote)
     $page->removeMote($mote)
     $page->appentContentToMote("Name","htmlContent")

   
# TODO list limit 0,2
Start-up
  * clean this file (formatting and adding: ideas, entities, corrections, comments)  
  * create the doctrine ORM Entities for the Page/Mote/Tag
  * create the operations of the page
  * create a test page
  * add onpreUpdate modify page.modifiedAt with now()
  * add fixtures in doctrine2 for tag element (now only sql)
  * add template entity
Add attributes to the page: author, father page, sections, users etc..
