<?php
/*
 * Breadcrumb navigation class
 * Mick Sear
 * eCreate April 25th 2003
 * Version 1.0
 * License: GPL
 * http://www.ecreate.co.uk
 * Please support my work by clicking the Google links on my site :)
 * 
 * The key to using this is to decide on a $level for each page.  (array, starting position 0)
 * This determines where in the trail a link will be placed.  So, I normally make the homepage level 0,
 * then every page that can be accessed from the top level nav becomes level 1, and every page
 * from that second level becomes level 2, and so on.  When users return to a higher level (e.g. level 1)
 * the surplus links are removed.  Only one page can occupy a $level in the crumb trail.
 * There might be several routes to a page.  In which case, the trail will reflect the route that the 
 * user actually took to get to that page.
 * 
 * Usage:
 * session_start();
 * $nav = new breadcrumb();
 * $nav ->add("descriptive name", "/page_url.php", 3);
 * or, if nav needs to be changed totally,
 * $nav->reset();
 * 
 * Example CSS: 
 * #breadcrumb ul li{
 *   list-style-image: none;
 *   display:inline;
 *   padding: 0 3px 0 0; 
 *   margin: 3px 0 0 0;
 * }
 *
 * #breadcrumb ul{
 *   margin:0;padding:0;
 *   list-style-type: none;
 *   padding-left: 1em;
 * }
 */

class Breadcrumb{

   var $output;
   var $crumbs = array();
   var $location;


   /*
    * Constructor
    */
   function Breadcrumb(){  
   
      if ($_SESSION['breadcrumb'] != null){
         $this->crumbs = $_SESSION['breadcrumb'];
      }  
   
   }

   /*
    * Add a crumb to the trail: 
    * @param $label - The string to display
    * @param $url - The url underlying the label
    * @param $level - The level of this link.  
    * 
    */
   function add($label, $url, $level){

      $crumb = array();
      $crumb['label'] = $label;
      $crumb['url'] = $url;

      if ($crumb['label'] != null && $crumb['url'] != null && isset($level)){       
            
         while(count($this->crumbs) > $level){

            array_pop($this->crumbs); //prune until we reach the $level we've allocated to this page

         }

         if (!isset($this->crumbs[0]) && $level > 0){ //If there's no session data yet, assume a homepage link

            $this->crumbs[0]['url'] = "index.php";
            $this->crumbs[0]['label'] = "Home";

         }

         $this->crumbs[$level] = $crumb;  
               
      }

        $_SESSION['breadcrumb'] = $this->crumbs; //Persist the data
        $this->crumbs[$level]['url'] = null; //Ditch the underlying url for the current page.
   }

   /* 
    * Output a semantic list of links.  See above for sample CSS.  Modify this to suit your design.
    */
   function output(){

      echo "<div id='breadcrumb'>";

      foreach ($this->crumbs as $crumb){  

         if ($crumb['url'] != null){

            echo "<a href='".$crumb['url']."' title='".$crumb['label']."'>".$crumb['label']."</a>&nbsp;&raquo; ";

         } else {

            echo " ".$crumb['label']." ";

         }
      }

      echo "</div>";
   }
   function reset()
   {
   $_SESSION['breadcrumb']="";
   }
}
?>