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
 * @package     kernel
 */

if (!defined('RCX_ROOT_PATH'))  exit();

/**
* Class for showing navigation between pages
*
* @param type $var description
* @return type description
*/
class RcxPageNav 
{
	/**
	 * Overall number of items
	 *
	 * @var Number
	 */
	var $total;
	
	/**
	 * How mage items shown on one page
	 *
	 * @var Number
	 */
	var $perpage;
	
	/**
	 * Current number of page
	 *
	 * @var Number
	 */
	var $current;
	
	/**
	 * Url of page
	 *
	 * @var String
	 */
	var $url;


	function RcxPageNav($total_items, $items_perpage, $current_start, $start_name="start", $extra_arg="")
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

	/**
	 * Render navigation block
	 *
	 * @param unknown_type $offset
	 * @param unknown_type $renderstyle
	 * @return unknown
	 */
	function renderNav($offset=4, $renderstyle=1) 
	{
		//Add condition if number of page is equal to 0
		//by zebulon
		if (($this->total < $this->perpage) || ($this->perpage == 0)) 
		{
			return;
		}
		$total_pages = ceil($this->total / $this->perpage);
		if ($total_pages > 1) 
		{
			$ret  = '';
			$prev = ($this->current - $this->perpage);
			if ($renderstyle == 1)
			{
				if ($prev >= 0) 
				{
					$ret .= '<a href="'.$this->url.$prev.'">&laquo;</a> ';
				}
			}
			else
			{
				$ret .= '<div class="prenext">';
				if( $prev >= 0)
				{
   				    $ret .= '<a class="prev" href="'.$this->url.'0">&laquo; '._START.'</a> ';
       	            if( $prev > $this->perpage)
	  				   $ret .= '<a class="prev" href="'.$this->url.$prev.'">&laquo; '._PREVIOUS.'</a> ';
                }
			}
			$counter      = 1;
			$current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
			while ($counter <= $total_pages)
			{
				if ($counter == $current_page)
				{
					$ret .= '<a class="active">'.$counter.'</a> ';
				}
				elseif ( ($counter > $current_page-$offset && $counter < $current_page + $offset ) || $counter == 1 || $counter == $total_pages )
				{
					if ( $counter == $total_pages && $current_page < $total_pages - $offset )
					{
						$ret .= '... ';
					}
					$ret .= '<a href="'.$this->url.(($counter - 1) * $this->perpage).'">'.$counter.'</a> ';
					
					if ( ($counter == 1) && ($current_page > (1 + $offset) ) ) 
					{
						$ret .= '... ';
					}
				}
				$counter++;
			}
			$next = ($this->current + $this->perpage);
			if ($renderstyle == 1)
			{
				if ($this->total > $next)
				{
					$ret .= '<a href="'.$this->url.$next.'">&raquo;</a> ';
				}
			}
			else
			{
				if($this->total > $next)
				{
					$ret .=  '<a class="next" href="'.$this->url.$next.'">'._NEXT.' &raquo;</a>';
				    if( $this->total - $this->perpage > $next  )
   				      $ret .= '<a class="next" href="'.$this->url.($this->total-$this->perpage).'">'._LAST.' &raquo;</a>';
				}
				$ret .= '</div>';
			}
		}
		return $ret;
	}

	/**
	 * Render select
	 *
	 * @param unknown_type $showbutton
	 * @return unknown
	 */
	function renderSelect($showbutton=false) 
	{
		if ( $this->total < $this->perpage ) 
		{
			return;
		}
		$total_pages = ceil($this->total / $this->perpage);
		$ret = '';
		if ($total_pages > 1) 
		{
			$ret          = '<form name="pagenavform">';
			$ret         .= '<select class="select" name="pagenavselect" id="pagenavselect" onchange="location=this.options[this.options.selectedIndex].value;">';
			$counter      = 1;
			$current_page = intval(floor(($this->current + $this->perpage) / $this->perpage));
			
			while ($counter <= $total_pages) 
			{
				$ret .= '<option value="'.$this->url.(($counter - 1) * $this->perpage).'"';
				$ret .= (($counter == $current_page) ? ' selected="selected"' : '') .'>'.$counter.'</option>';
				$counter++;
			}
			
			$ret .= '</select>';
			if ($showbutton) 
			{
				$ret .= '&nbsp;<input type="submit" class="button" value="'._GO.'" />';
			}
			
			$ret .= '</form>';
		}
		return $ret;
	}
} // END PAGENAV
?>