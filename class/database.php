<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !defined("ERCX_ABSDATABASE_INCLUDED") ) {
	define("ERCX_ABSDATABASE_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class AbsDatabase {
	var $prefix;
	var $debug;

/**
* Description
*
* @param type $var description
* @return type description
*/
function setPrefix($value='') {
	$this->prefix = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function prefix($tablename='') {

if ($tablename == '') {
	return $this->prefix;
	} else {
		if ($this->prefix == '') {
			return $tablename;
			} else {
				return $this->prefix ."_". $tablename;
			}
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setDebug($level=1) {

if (intval($level) & 1) {
	error_reporting(2039);
	} else {
		error_reporting(0);
	}

$this->debug = intval($level);
}
} // END ABSDATABASE
}
?>
