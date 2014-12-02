<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
/**
* Description
*
* @param type $var description
* @return type description
*/
function b_system_search_show() {
$block             = array();
$block['title']    = _MB_SYSTEM_SEARCH;
$block['content']  = "<div align='center'><form action='".RCX_URL."/search.php' method='post'>";
$block['content'] .= "<input type='text' class='text' name='query' size='14' />";
$block['content'] .= "<input type='hidden' name='action' value='results' /><br />";
$block['content'] .= "<input type='submit' class='button' value='"._MB_SYSTEM_SEARCH."' /></form>";
$block['content'] .= "<a href='".RCX_URL."/search.php'>"._MB_SYSTEM_ADVS."</a></div>";
return $block;
}
?>
