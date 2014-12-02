<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

class RcxFormDateTime extends RcxFormElementTray
{

	function RcxFormDateTime($caption, $name, $size = 15, $value=0)
	{
		$this->RcxFormElementTray($caption, '&nbsp;');
		$value = intval($value);
		$value = ($value > 0) ? $value : time();
		$datetime = getDate($value);
		$this->addElement(new RcxFormTextDateSelect('', $name.'[date]', $size, $value));
		$timearray = array();
		for ($i = 0; $i < 24; $i++) {
			for ($j = 0; $j < 60; $j = $j + 05) {
				$key = ($i * 3600) + ($j * 60);
				$timearray[$key] = ($j != 0 and $j != 5) ? $i.':'.$j : $i.':0'.$j;
			}
		}
		ksort($timearray);
		$timeselect = new RcxFormSelect('', $name.'[time]', $datetime['hours'] * 3600 + 600 * ceil($datetime['minutes'] / 10));
		$timeselect->addOptionArray($timearray);
		$this->addElement($timeselect);
	}
}
?>