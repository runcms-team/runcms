<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function b_LysAvis_show($options) {
        global $db, $rcxConfig;

        $block = array();
        $block['title'] = _MI_NEWS_BNAME8;
        $block['content'] ="";

/*      Variables       */
$newstoshow = $options[0];
$scrolldirection = $options[3];
$boxheight = $options[2];

/*     End Variables    */

global $prefix, $db;

$block['content'] .= "<Marquee Behavior=\"Scroll\" Direction=\"$scrolldirection\" Height=\"$boxheight\" ScrollAmount=\"2\" ScrollDelay=\"30\" onMouseOver=\"this.stop()\" onMouseOut=\"this.start()\">";

// Latest News
$result = $db->query("select storyid, title, published from ".$db->prefix("stories")." Where published > 0 order by published DESC ",$newstoshow,0);

while(list($storyid, $title, $published) = $db->fetch_row($result)) {
                $title2 = ereg_replace("_", " ", $title);
                 if ( strlen($title2) > $options[1] ) {
                $title2 = substr($title2, 0, $options[1])."..";
                }
$block['content'] .= "<a href=\"".RCX_URL."/modules/news/article.php?storyid=$storyid&amp;title=$title\">$title2</a> (".formatTimestamp($published, "s").")"."&nbsp;&nbsp;&nbsp;&nbsp;";
                
}

return $block;
}

function b_LysAvis_edit($options)
{
        $form = _MI_NEWSTOSHOW."&nbsp;<input type='text' name='options[]' value='".$options[0]."' /><br />";
        $form .= _MI_NEWSTRIM."&nbsp;<input type='text' name='options[]' value='".$options[1]."' /><br />";
        $form .= _MI_NEWSHEIGHT."&nbsp;<input type='text' name='options[]' value='".$options[2]."' /><br />";
// select Down,Up
        $form .= _MI_SCROLLDIRECTION."&nbsp;<select name='options[]'>";
        $selup=$seldown="";
        switch($option[3])
        {
  case "Down":
            $seldown="selected";
            break;
            case "Up":
            $selup="selected";
            break;
            case "left":
            $selleft="selected";
            break;
            case "right":
            $selright="selected";
            break;
               }
      $form .= ""
   ."<option name=scrolldir value='Down' $seldown>"._MI_DOWN."</option>"
     ."<option name=scrolldir value='Up' $selup>"._MI_UP."</option>"
     ."<option name=scrolldir value='left' $selleft>"._MI_LEFT."</option>"
     ."<option name=scrolldir value='right' $selright>"._MI_RIGHT."</option>"
     ."</select>";
     return $form;
}
?>
