<?php
function simple_2 ($rss, $num_items = 0)
{

	$content  = '';
	$content .= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	$content .= '<tr><td>';
	$content .= '<div class="indextitle">';
	$content .= '  <a href="'.$rss->get_permalink().'" target="_blank">'.$rss->get_title().'</a>';
	$content .= '</div>';
	$content .= '</td></tr>';

	$content .= '<tr><td class="more">';
	$content .= '<div class="indextext">';
	
	$items = $rss->get_items( 0, $rss->get_item_quantity($num_items) );
	
	foreach ($items as $item ) {	
		$content .= '<a href="'.$item->get_permalink().'" target="_blank">'.$item->get_title().'</a><br />';
	}
	$content .= '</div>';
	$content .= '</td></tr>';
	$content .= '</table>';

	return $content;
}
?>