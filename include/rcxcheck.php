<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined("ERCX_RCXCHECK_INCLUDED")) {
  define("ERCX_RCXCHECK_INCLUDED", 1);
/**
*
* @param type $var description
* @return type description
*/
function rcxfwrite() {
if ( !isPost() ) {
  return false;
  }
if ( !myRefererCheck($errstr) ) {
  return false;
  }
return true;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function isPost() {
if (_REQUEST_METHOD == "POST") {
  return true;
  } else {
    return false;
  }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function myRefererCheck(&$errstr) {
if ( strlen(_HTTP_REFERER) == 0 ) {
  return false;
  }
$my_url    = 'http://'._HTTP_HOST._PHP_SELF;
if ( strpos(_HTTP_REFERER, $my_url) != 0 ) {
  return false;
  }
return true;
}
/**
* Takes $url as the input & builds a FORM from the variables in the $url.
* Note: All variables in $url are transformed into POST/GET, like this one can use
* whichever best fits the current situation.
*
* @param type $url URL to parse into form elements
* @param type $caption Caption of the submit button
* @return string Form to display
*/
function myTextForm($url, $caption, $addtoken = false) {
global $myts;
$parsed = parse_url($myts->undoHtmlSpecialChars($url));
parse_str($parsed['query'], $query);
$result  = "<form action='".$url."' method='post'>";
if ( !empty($query) ) {
  foreach($query as $k=>$v) {
    $result .= "<input type='hidden' name='".$myts->makeTboxData4PreviewInForm($k)."' value='".$myts->makeTboxData4PreviewInForm($v)."' />";
  }
}
if ($addtoken != false) {
    $rcx_token = & RcxToken::getInstance();
    $result .= $rcx_token->getTokenHTML();
}
$result .= "<input type='submit' class='button' name='submit' value='".$myts->makeTboxData4Preview($caption)."' />";
$result .= "</form>";
return $result;
}
}
?>
