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

	if (!empty($image['url']))
	{
		$content .= '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>';
		$content .= '<img src="'.$image['url'].'">';
		$content .= '</td><td valign=top>';
		$content .= '<a href="'.$link.'" target="_blank"><b>'.$title.'</b></a><br />'.$image['description'];
		$content .= '</td></tr></table>';
	}
	else
	{
		$content .= '  <a href="'.$link.'" target="_blank">'.$title.'</a>';
	}

	$content .= '</div>';
	$content .= '</td></tr>';

	$content .= '<tr><td class="more">';
	$content .= '<div class="indextext">';
	$items = ($num_items > 0) ? array_slice($rss->items, 0, $num_items) : $rss->items;
	foreach ($items as $item ) {
		$href = $item['link'];
		$title = $item['title'];	
		$desc = $item['description'];	
		$content .= '<a href="'.$href.'" target="_blank"><b>'.$title.'</b></a><br />';
		$content .= $desc.'<br /><br />';
	}

	$content .= '</div>';
	$content .= '</td></tr>';
	$content .= '</table>';

	return $content;
}
?>