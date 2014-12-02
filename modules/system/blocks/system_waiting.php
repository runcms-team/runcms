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
* Description
*
* @param type $var description
* @return type description
*/
function b_system_waiting_show() {
global $db, $myts, $rcxConfig;
$block            = array();
$block['title']   = _MB_SYSTEM_WCNT;
$block['content'] = '';
$query = $db->query('SELECT dirname FROM '.RC_MODULES_TBL.' WHERE isactive=1 AND haswaiting=1');
if ($query) {
  while (list($dirname) = @$db->fetch_row($query)) {
    include(RCX_ROOT_PATH.'/modules/'.$dirname.'/include/rcxv.php');
    if (@file_exists(RCX_ROOT_PATH.'/modules/'.$dirname.'/'.$modversion['waiting']['file'])) {
      if (@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/language/".RC_UNAME."/blocks.php"))
        include_once(RCX_ROOT_PATH."/modules/".$dirname."/language/".RC_UNAME."/blocks.php");
     elseif(@file_exists(RCX_ROOT_PATH."/modules/".$dirname."/language/english/blocks.php"))
        include_once(RCX_ROOT_PATH."/modules/".$dirname."/language/english/blocks.php");

      include_once(RCX_ROOT_PATH.'/modules/'.$dirname.'/'.$modversion['waiting']['file']);
      $func = $modversion['waiting']['func'];
      if (function_exists($func)) {
        $content = $func();
        $size    = count($content);
        for ($i=0; $i<$size; $i++) {
          if ( !empty($content[$i]['image']) ) {
            $block['content'] .= '<img src="'.$content[$i]['image'].'" /> ';
          }
          if ( !empty($content[$i]['link']) && !empty($content[$i]['text']) ) {
            $block['content'] .= '<a href="'.$content[$i]['link'].'">'.$myts->makeTboxData4Show($content[$i]['text']).'</a>';
          }
          if ( !empty($content[$i]['count']) ) {
            $block['content'] .= ': '.intval($content[$i]['count']);
          }
          $block['content'] .= '<br />';
        }
        if ($size > 0) {
          $block['content'] .= '<br />';
        }
      }
    }
  }
}
if ($block['content'] == '') {
  $block['content'] = _NONE;
}
return $block;
}
?>
