#Abstract
* This is the traduction (more or less) in pseudocode of the diagram class written in UML
* This is [the Uml-ClassDiagram](https://github.com/liuggio/xwc-sandbox/blob/master/ClassDiagram.gif "Class Diagram").

      A "Page" has a lot of content (called "Mote").
      A "Mote" is positioned in a "Tag".
      The "Mote" can have multiple types of "Content": html, text, (...).
      A Widget is a PHP-Class.
      A Widget may be placed in any "Tag" of the Page.
      A Widget can modify any motes of his page.
      A Widget may call a function of his class with Get/Post variables.
      A "Page" has a "Template".
      The "Template" can be a twig file or a twig content stored into db.
      The page has a template that will contain all the motes' content (sorted by tag).
 
#Entity "Page"
 * Description: this table content all the pages of the CMS 
 * Attributes:
   * name: primary key, string
   * route: string, indexed, slugified
   * publishedAt: datetime()
   * modifiedAt: datetime()

#Entity "Mote"
 * Description: is a simple content of data (now only text)
 * Attributes
   * name: primary key, string 
   * content: text
   * type: html/text

#Entity "Tag"
 * Description: this table content all the information about the allowed tags. is possibile from a leaf reach the root.
 * Attributes
   * name: primary key, string
   * parent: string, manyToOne
   * order: integer

#Association Class "PageJoinMote" implemented like an Entity
 * is an implementation of ManyToMany between Page and Mote, however, 
between the two entities have add the association class with extra columns: Tag, tagOrder. 
Tag indicates where Mote will have to be positiones and tagOrder indicates the order in its group tag.
   * page: Page
   * mote: Mote
   * tag: Tag
   * tagOrder: integer

#Entity "Widget"
 * Description: the Widget is a tool that allows you to add dynamic content to the page (a widget is a bundle)
A Widget takes in input some parameters and a position as a Tag, but the Widget being dynamic can access to all motes in all sections of the page.
A Widget is a class that is included in a particular folder, is possible to execute different functions of the class with the GET / POST 
 * Attributes
   * name: primary key, string
   * className: string
   * status: integer

#Association Class "PageJoinWidget" implemented like an Entity
 * is an implementation of ManyToMany between Page and Widget, however, between the two entities have add the association class with extra optional column: Tag, tagOrder, parameter.
   * page: Page
   * widget: Widget
   * tag: Tag (optional)
   * tagOrder: integer (optional)
   * parameter: array (optional)
      
# TODO list limit 0,2
 1. +Start-up (Resolved)
    * -clean this file (formatting and adding: ideas, entities, corrections, comments)  
    * +create the doctrine ORM Entities for the Page/Mote/Tag
    * +create the operations
    * +create a test page
    * +add onpreUpdate modify page.modifiedAt with now()
    * +add fixtures in doctrine2 for tag element
 2. Widget
    * +add Entities and Association
    * -create the method for load the class and the correct Widgetfunction
    * -create a Widget's Example
 3. Template/Theme
    * -create Template Entity
    * -create a Theme entity
 4. Unit Test for 1., 2., 3.
 5. Add entities and page's attributes: author of the page, parent of the page, users, permissions, ajax, etc..
 6. License
 
 
 
 

 liuggio