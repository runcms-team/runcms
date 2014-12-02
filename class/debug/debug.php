<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH')) 
  die('Sorry, but this file cannot be requested directly');

if (!defined("ERCX_DEBUG_INCLUDED")) {
  define("ERCX_DEBUG_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
function get_micro_time() {
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_queries($executed_queries, $sorted=0) {
global $db;

$executed_queries = unserialize(urldecode($executed_queries));

if ($sorted == 1) {
  sort($executed_queries);
  $is_sorted = _DBG_SORTEDR;
  } else {
    array_reverse($executed_queries);
    $is_sorted = _DBG_NSORTEDR;
  }

OpenTable();

$fulldebug = "
    <h4>($is_sorted) "._DBG_QEXECED.": ".count($executed_queries)."</h4>
    <table width='100%' cellpadding='3' cellspacing='1'>";

$size = count($executed_queries);
for ($i=0; $i<$size; $i++) {
  $stime = get_micro_time();

  // EXPLAIN seems to have problems with layer
  $query      = $db->query("EXPLAIN ".$executed_queries[$i]."");
  $querytime  = (get_micro_time() - $stime);
  $totaltime += $querytime;
  //$result     = @$db->fetch_array($query);

  $fulldebug .= "
      <tr>
      <td nowrap class='bg2'><b>"._DBG_QUERY.": ".($i+1)."</b></td>
      <td colspan='7' class='bg3'>$executed_queries[$i]</td>
      </tr><tr>
      <td nowrap class='bg2'><b>"._DBG_TIME.":</b></td>
      <td colspan='7' class='bg3'>".round($querytime, 4)." "._DBG_SECONDS."</td>
      </tr><tr>
      <td nowrap class='bg2'><b>"._DBG_TABLE.":</b></td>
      <td nowrap class='bg2'><b>"._DBG_TYPE.":</b></td>
      <td nowrap class='bg2'><b>"._DBG_POSSKEYS.":</b></td>
      <td nowrap class='bg2'><b>"._DBG_KEY.":</b></td>
      <td nowrap class='bg2'><b>"._DBG_KEYLEN.":</b></td>
      <td nowrap class='bg2'><b>"._DBG_ROWS.":</b></td>
      <td nowrap class='bg2'><b>"._DBG_EXTRA.":</b></td>
      </tr><tr>";
      while ($result = $db->fetch_array($query)) 
      {      
      $fulldebug .= "<td class='bg3' nowrap>{$result['table']}&nbsp;</td>
      <td class='bg3' nowrap>{$result['type']}&nbsp;</td>
      <td class='bg3'>{$result['possible_keys']}&nbsp;</td>
      <td class='bg3' nowrap>{$result['key']}&nbsp;</td>
      <td class='bg3' nowrap>{$result['key_len']}&nbsp;</td>
      <td class='bg3' nowrap>{$result['rows']}&nbsp;</td>
      <td class='bg3'>{$result['Extra']}&nbsp;</td>
      </tr>";
      } 
      $fulldebug .="<tr>
      <td colspan='8' class='bg1'>"._DBG_CUMULATED.":".round($totaltime, 4)." "._DBG_SECONDS."<hr noshade></td>
      </tr>"; 
}

$fulldebug .= "</table>";

echo $fulldebug;
CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_files($loaded_files) {

$loaded_files = unserialize(urldecode($loaded_files));
OpenTable();

$files = "
  <h4>"._DBG_FILESL.": ".count($loaded_files)."</h4>
  <table width='100%' cellpadding='3' cellspacing='0'><tr>
  <td class='bg2'><b>"._DBG_PATH.":</b></td><td class='bg3'><b>"._DBG_SIZE.":</b></td>";

foreach($loaded_files as $fname) {
  $fsize     = filesize($fname);
  $totfsize += $fsize;
  $files    .= "<tr><td style='border-bottom:solid 1px;'>".$fname."</td><td style='border-bottom:solid 1px;'>".round(($fsize/1024), 2)." "._DBG_KO."</td></tr>";
}

$files .= "<tr><td class='bg2'><b>"._DBG_TOTSIZE.":</b></td><td class='bg3'><b>".round(($totfsize/1024),2)." "._DBG_KO."</b></td></tr></table>";

echo $files;

CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function debug_info($show_debug = 0) {
global $db;

$out = array();

// Timing
if ($show_debug & 2) {
  $time   = round( (get_micro_time() - _time_start), 6);
  $out[1] = _DBG_CREATEDIN." ".$time." "._DBG_SECONDS;
}

//Info
if (($show_debug & 4) || ($show_debug & 8)) {
  $included_files = get_included_files();
  $included_count = count($included_files);
  $query_count    = count($db->query_log);
  natsort($included_files);
  $totsize=0;
  foreach($included_files as $fname) {
    $fsize    = round( (filesize($fname)/1024), 2);
    $totsize += $fsize;
  }
  $page_buffer = round( (ob_get_length()/1024), 2);

  $out[2] = $query_count." "._DBG_QUERIES." | ".$included_count." "._DBG_FILESL.": ".$totsize." "._DBG_KO;
  $out[3] = _DBG_RAW.": ".$page_buffer." "._DBG_KO;
}

//Log
if ($show_debug & 8) {
  $classes_loaded   = count(get_declared_classes());
  $out[2] = $query_count." <a style='cursor:hand' onclick='document.queries.sorted.value=0; document.queries.submit();'><u>"._DBG_QUERIES."</u></a> ( <a style='cursor:hand' onclick='document.queries.sorted.value=1; document.queries.submit();'><u>"._DBG_SORTED."</u></a> ) | ".$included_count." <a style='cursor:hand' onclick='document.files.submit();'><u>"._DBG_FILESL."</u></a> | ".$classes_loaded." "._DBG_CLASSESL;

  $loaded_files     = urlencode(serialize($included_files));
  $executed_queries = urlencode(serialize($db->query_log));

  $form = "
    <form name='files' action='".RCX_URL."/class/debug/debug_show.php' method='post' target='_blank'>
    <input type='hidden' name='debug_show' value='show_files'>
    <input type='hidden' name='loaded_files' value='$loaded_files'>
    <input type='hidden' name='executed_queries' value='$executed_queries'>
    </form>

    <form name='queries' action='".RCX_URL."/class/debug/debug_show.php' method='post' target='_blank'>
    <input type='hidden' name='debug_show' value='show_queries'>
    <input type='hidden' name='executed_queries' value='$executed_queries'>
    <input type='hidden' name='sorted' value='0'></form>";
}

if (!empty($out)) {
  echo "<div class='debug' align='center'>- ".join(" | ", $out)." -</div>";
  if (!empty($form))
    echo $form;
}

} // END FUNCTION


if (!defined("_time_start")) {
  define("_time_start", get_micro_time());
}
}
?>
