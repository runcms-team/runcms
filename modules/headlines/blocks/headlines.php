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
function b_headlines_show() {
global $db;

include_once(RCX_ROOT_PATH."/modules/headlines/magpierss/rss_fetch.inc");

$block = array();
$block['title'] = _MB_HEADLINES_TITLE;
$block['content'] = '';

$result = $db->query("SELECT id, headlineurl, template, cache, items FROM ".$db->prefix("headlines")." WHERE (type='block' OR type='both') AND status=1 ORDER BY weight ASC");
while ( list($id, $headlineurl, $template, $cache, $num_items) = $db->fetch_row($result) )
{
	if (substr($template, -4) == '.txt')
	{
		$template = substr($template, 0, -4);
	}

	define('MAGPIE_CACHE_ON', 1);
	define('MAGPIE_CACHE_AGE', (intval($cache) * 60));

	$rss = @fetch_rss( $headlineurl );
	if($rss)
	{
		include_once RCX_ROOT_PATH.'/modules/headlines/templates/'.$template.'.php';
		$block['content'] .= call_user_func ($template, $rss, $num_items);
	}
}
return $block;
}
?>
