<?php
function simple ($rss, $num_items = 0)
{

	$content = '';
	$content .= "<p><a href={$rss->get_permalink()}><b>{$rss->get_title()}</b></a></p>";
        
        $content .= "<ul>";
	
	$items = $rss->get_items( 0, $rss->get_item_quantity($num_items) );
	
	foreach ($items as $item ) {
		$content .= "<li><a href={$item->get_permalink()}>{$item->get_title()}</a></li>";
	}
	$content .= "</ul>";

	return $content;
}

?>