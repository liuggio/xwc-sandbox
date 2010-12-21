# Abstract:

* This is the traduction(more or less) of the class diagrams in uml and pseudo code
* i wrote(in hurry) the objects for a better understanding

# Entity "Page"
    id is the primary key
    $page[1]["name"]=string
    $page[1]["route"]=slugified(string)   indexed //contain the symfony route for the page ex ww.com/page1
    $page[1]["publishedAt"]= date()
    $page[1]["template"]=new array of template() manyToMany Entity;   //to a page are associated many template 
    $page[1]["tag"]["html"].attributes=new array of Mote() //eg.  addMote("attr1","xmlns=\"http://www.w3.org/1999/xhtml\""];)
    $page[1]["tag"]["html"]["head"]=array()  //array of array of Mote
    $page[1]["tag"]["html"]["head"]["script"]=new array of Mote()  OneToMany
    $page[1]["tag"]["html"]["head"]["link"]=new array of Mote()  OneToMany
    $page[1]["tag"]["html"]["head"]["title"]=new array of Mote()  OneToMany
    $page[1]["tag"]["html"]["head"]["meta"]=new array of Mote()  OneToMany
    $page[1]["tag"]["html"]["body"].attributes=new array of Mote() //addMote("attr1","onload..");addMote("attr1","onclose.."];)
    $page[1]["tag"]["html"]["body"]=new array of Mote()  OneToMany
   
##Operation:
* 1) we want to take all the Html data stored in the array "tag"
* 2) we want to add/modified/remove certain mote from a page
    eg. 
    * a) $page.Insert("script","alert","alert('hi')") 
          //add under ["tag"]["html"]["head"]["script"] the new mote called alert with the content alert('hi')
    * b) $page.Remove("script","alert") 
          // remove the mote called "alert" 
    * c) $page.Insert("title","title1","Web Site Title")  
          //"title" is where to push, "title1" is the name identifier of the mote, "Web Site Title" is the content
       $page.AppendTo("title1","Section")   
          //the result it'll be  "Web Site TitleSection"
* 3) we want to render a page with the template
    eg. 
    * a) $page.render($typeContent)  
          // load the twig and give to him the array tag.
          // $typeContent is the type of the template we want xml, html, js maybe there are more template associated to a page
		 									
								
## Entity "Mote"  is only a html content with an index name //maybe is not the best name (we shiould call obj or tag )
    $tag["name"]    is a primary key in his page
    $tag["content"]="html data"
  
    
## Entity "Template" 
    $template["id"] primary  indexed
    $template["type"]= enum{xml, html ...}   primary  
    $template["content-url or content-db"] 
    // the information of the template'd saved or in a twig file or in the database.   
   
## Entity "PageTemplate"
    $PageTemplate["template_id"] primary
    $PageTemplate["page_id"]     primary
     
   
# TODO list (limit 0,2 is very long :) )
* step0 
    -> create the doctrine Entity
    -> create the operation for page
    -> test page
* step1
    -> add attributes to the page: author, father page, section
