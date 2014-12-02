<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined("ERCX_SQL_PARSE_INCLUDED")) {
	define("ERCX_SQL_PARSE_INCLUDED", 1);
global $_SERVER;
if ( preg_match("/sql_parse\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
	}
/**
* remove_remarks will strip the sql comment lines out of an uploaded sql file
*
* @param type $var description
* @return type description
*/
function remove_remarks($sql) {

$lines     = explode("\n", trim($sql));
$sql       = '';
$linecount = count($lines);
$output    = '';
for ($i=0; $i<$linecount; $i++) {
	if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0)) {
		if ($lines[$i][0] != '#') {
			$output .= $lines[$i] . "\n";
			} else {
				$output .= "\n";
			}
		$lines[$i] = '';
	}
}
return trim($output);
}

/**
* split_sql_file will split an uploaded sql file into single sql statements.
*
* @param type $var description
* @return type description
*/
function split_sql_file($sql, $delimiter) {

$tokens      = explode($delimiter, trim($sql));
$sql         = '';
$output      = array();
$matches     = array();
$token_count = count($tokens);
for ($i=0; $i<$token_count; $i++) {
	if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))) {
		$total_quotes     = preg_match_all("/'/", $tokens[$i], $matches);
		$escaped_quotes   = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
		$unescaped_quotes = ($total_quotes - $escaped_quotes);
	if (($unescaped_quotes % 2) == 0) {
		$output[]   = trim($tokens[$i]);
		$tokens[$i] = '';
		} else {
			$temp          = $tokens[$i] . $delimiter;
			$tokens[$i]    = '';
			$complete_stmt = false;
			for ($j=($i+1); (!$complete_stmt && ($j < $token_count)); $j++) {
				$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
				$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
				$unescaped_quotes = $total_quotes - $escaped_quotes;
				if (($unescaped_quotes % 2) == 1) {
					$output[]      = trim($temp . $tokens[$j]);
					$tokens[$j]    = '';
					$temp          = '';
					$complete_stmt = true;
					$i             = $j;
					} else {
						$temp      .= $tokens[$j] . $delimiter;
						$tokens[$j] = '';
					}
			}
		}
	}
}
return $output;
}
/**
*
* @param type $var description
* @return type description
*/
function prefixQuery($query, $prefix) {
// $pattern = "/^(DROP TABLE IF EXISTS|ALTER TABLE|INSERT INTO|CREATE TABLE)(\s)+([`]?)([^`\s]+)\\3/siU";
$pattern = "/^(ALTER TABLE|INSERT INTO|CREATE TABLE)(\s)+([`]?)([^`\s]+)\\3/siU";
if ( preg_match($pattern, $query, $matches) ) {
	$replace = "\\1 ".$prefix."_\\4\\5";
	$matches[0]  = preg_replace($pattern, $replace, $query);
	return $matches;
}
return false;
}
}
?>
