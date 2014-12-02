<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/


if (!defined('RCX_ROOT_PATH')) {
	exit();
}
class MyPageNav
{
	var $total;
	var $perpage;
	var $current;
	var $url;

	function MyPageNav($total_items, $items_perpage, $current_start, $start_name="start", $extra_arg="")
	{
		$this->total   = intval($total_items);
		$this->perpage = intval($items_perpage);
		$this->current = intval($current_start);
		if ( $extra_arg != '' && ( substr($extra_arg, -5) != '&amp;' || substr($extra_arg, -1) != '&' ) )
		{
			$extra_arg .= '&amp;';
		}
		$this->url = _PHP_SELF.'?'.$extra_arg.trim($start_name).'=';
	}

	function renderNav()
	{
		$offset=4;

		if ($this->total <= $this->perpage)
			return;

		$total_pages = ceil($this->total / $this->perpage);
		$current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));

		$ret   = '<table border="0" cellpadding="0" cellspacing="0" valign="top"><tr><td class="bg2">';
		$ret  .= '<table border="0" cellpadding="2" cellspacing="1" width="100%"><tr>';
		$ret  .= '<td class="bg3">'. _MD_PAGE .'&nbsp;'.$current_page.'&nbsp;'. _MD_PAGEOF .'&nbsp;'.$total_pages.'&nbsp;</td>';

		if ($total_pages > 1)
		{
			$prev = ($this->current - $this->perpage);
			if ($prev >= 0)
			{
				$ret .= '<td class="bg1"><a href="'.$this->url.$prev.'"><u>&laquo;</u></a></td>';
			}

			$counter      = 1;
			while ($counter <= $total_pages)
			{
				if ($counter == $current_page)
				{
					$ret .= '<td class="bg4"><b>['.$counter.']</b></td>';
				}
				elseif ( ($counter > $current_page-$offset && $counter < $current_page + $offset ) || $counter == 1 || $counter == $total_pages )
				{
					if ( $counter == $total_pages && $current_page < $total_pages - $offset )
					{
						$ret .= '<td class="bg4">...</td>';
					}
					$ret .= '<td class="bg4"><a href="'.$this->url.(($counter - 1) * $this->perpage).'">'.$counter.'</a></td>';
					if ( ($counter == 1) && ($current_page > (1 + $offset) ) )
					{
						$ret .= '<td class="bg4">...</td>';
					}
				}
				$counter++;
			}
			$next = ($this->current + $this->perpage);
	
			if ($this->total > $next)
			{
				$ret .= '<td class="bg1"><a href="'.$this->url.$next.'"><u>&raquo;</u></a></td>';
			}
			$ret  .= '</tr></table>';
			$ret  .= '</td></tr></table>';

		}
		return $ret;
	}
}
?>
