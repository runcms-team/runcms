<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("../../mainfile.php");
include_once("../../header.php");

include_once("simplepie/autoloader.php");

$rcxOption['show_rblock'] = 1;

if ($rcxConfig['startpage'] == "headlines") {
	make_cblock();
	echo "<br />";
	OpenTable();
		} else {
		OpenTable();
		echo "<h4>"._MI_HEADLINES_NAME."<hr /></h4>";
}


$cache_dir = RCX_ROOT_PATH."/modules/headlines/cache";

$result = $db->query("SELECT id, headlineurl, template, cache, items FROM ".$db->prefix("headlines")." WHERE (type='main' OR type='both') AND status=1 ORDER BY weight ASC");
while ( list($id, $headlineurl, $template, $cache, $num_items) = $db->fetch_row($result) )
{
	if (substr($template, -4) == '.txt')
	{
		$template = substr($template, 0, -4);
	}

	$rss = new SimplePie();
	$rss->set_cache_location($cache_dir);
	$rss->set_cache_duration((intval($cache) * 60));
	$rss->set_output_encoding(_CHARSET);
	$rss->set_feed_url($headlineurl); 
	$rss->init();
        
	if(!$rss->error)
	{
		include_once 'templates/'.$template.'.php';
		echo call_user_func ($template, $rss, $num_items);
	}
        
	$rss->__destruct(); 
	unset($rss);         
}

CloseTable();
include_once("../../footer.php");
?>
