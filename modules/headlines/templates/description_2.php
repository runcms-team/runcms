<?php
function description_2 ($rss, $num_items = 0)
{
	$title = $rss->channel['title'];
	$link = $rss->channel['link'];
	$image = $rss->image;

	$content  = '';
	$content .= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	$content .= '<tr><td>';
	$content .= '<div class="indextitle">';

	if ($rss->get_image_url())
	{
		$content .= '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>';
		$content .= '<img src="'.$rss->get_image_url().'" alt="" />';
		$content .= '</td><td style="vertical-align: top;">';
		$content .= '<a href="'.$rss->get_permalink().'" target="_blank"><b>'.$rss->get_title().'</b></a><br />'.$rss->get_image_title();
		$content .= '</td></tr></table>';
	}
	else
	{
		$content .= '  <a href="'.$rss->get_permalink().'" target="_blank">'.$rss->get_title().'</a>';
	}

	$content .= '</div>';
	$content .= '</td></tr>';

	$content .= '<tr><td class="more">';
	$content .= '<div class="indextext">';
	
	$items = $rss->get_items( 0, $rss->get_item_quantity($num_items) );
	
	foreach ($items as $item ) {	
		$content .= '<a href="'.$item->get_permalink().'" target="_blank"><b>'.$item->get_title().'</b></a><br />';
		$content .= $item->get_description().'<br /><br />';
	}

	$content .= '</div>';
	$content .= '</td></tr>';
	$content .= '</table>';

	return $content;
}
?>