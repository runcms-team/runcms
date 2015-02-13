<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("../../mainfile.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function partners_main() {
global $db, $myts, $meta, $rcxUser, $rcxModule, $rcxConfig;

if ( $rcxConfig['startpage'] == "partners" ) {
  $rcxOption['show_rblock'] = 1;
  include_once(RCX_ROOT_PATH."/header.php");
  make_cblock();
  echo "<br />";
  } else {
    $rcxOption['show_rblock'] = 0;
    include_once(RCX_ROOT_PATH."/header.php");
  }

include("./cache/config.php");

$query         = $db->query("SELECT COUNT(*) FROM ".$db->prefix("partners")." WHERE status=1");
list($numrows) = $db->fetch_row($query);

OpenTable();
printf("<h4>"._MD_PARTNERS."</h4>", $meta['title']);


if ( $numrows > 0 ) {
  $sql = "
    SELECT id, hits, url, image, title, description
    FROM ".$db->prefix("partners")."
    WHERE status=1 ORDER BY";

  if ( !empty($partners_randomize) ) {
    $sql .= " RAND(),";
    }

  $sql .= " $partners_order $partners_orderd";

  $_GET['show'] ? $show = $_GET['show'] : $show = 0;
  $query = $db->query($sql, $partners_limit, $show);

  echo "
  <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
  <td class='bg2'>

  <table width='100%' border='0' cellpadding='4' cellspacing='1'><tr>
  <td width='1%' align='left' nowrap>"._MD_PARTNER."</td>
  <td align='left'>"._MD_DESC."</td>
  <td width='5' align='left' nowrap>"._MD_HITS."</td>
  <td width='1%' align='left' nowrap>"._MD_VISIT."</td>";
  if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) { echo "<td width='1'>&nbsp</td>"; }
  echo "</tr>";

while (list($id, $hits, $url, $image, $title, $description) = $db->fetch_row($query)) {
  $url         = $myts->makeTboxData4Show($url);
  $title       = $myts->makeTboxData4Show($title);
  $description = $myts->makeTboxData4Show($description);

  echo "
  <tr>
  <td width='1%' align='left' valign='top' class='bg3' nowrap>$title</td>
  <td align='left' valign='top' class='bg3'>$description</td>
  <td width='5' align='left' valign='top' class='bg3' nowrap>$hits</td>
  <td width='1%' align='center' valign='top' class='bg3' nowrap>
  <a href='".RCX_URL."/modules/partners/index.php?op=visit_partner&amp;id=$id' target='_blank'>";
  if ( !empty($image) && ($partners_show == 1 || $partners_show == 3) ) {
    echo "<img src='".formatURL(RCX_URL . "/modules/partners/cache/images/", $image)."' alt='$url' border='0' />";
    }
  if ( $partners_show == 3 ) {
    echo "<br />";
    }
  if ( empty($image) || $partners_show == 2 || $partners_show == 3 ) {
    echo $title;
    }
  echo "</a></td>";
  if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid())) {
    echo "<td width='5' align='center' valign='top' class='bg1'>
      <a href='./admin/index.php?op=edit_partner&amp;id=$id'><img src='./images/info.gif' border='0' alt='"._MD_EDIT."'></a>
      </td>";
      }
  echo "</tr>";
  }

  echo "
  </table>
  </td></tr></table>";
}

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr><td>";

if ($rcxUser) {
  printf("<a href='mailto:".$rcxConfig['adminmail']."'><b>"._MD_JOIN."</b></a>", $meta['title']);
  }
  printf(" "._MD_COUNT, $numrows);
  echo "</td>";

if ( ($numrows > 0) && ($partners_limit != 0) ) {
  include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
  $nav = new RcxPageNav($numrows, $partners_limit, $show, "show");
  echo "<td align='right'>".$nav->renderNav()."</td>";
  }

echo "</tr></table>";

CloseTable();
include_once("../../footer.php");
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function visit_partner($id) {
global $db;

$id = intval($id);

if ( !is_numeric($id) || empty($id) ) {
  redirect_header("index.php", 1, _MD_NOSUCH);
  exit();
  }

$query = $db->query("SELECT url FROM ".$db->prefix("partners")." WHERE id=$id AND status=1");
list($url) = @$db->fetch_row($query);

if ( !empty($url) ) {
  include_once("./cache/config.php");


  if ( !isset($_COOKIE['mypartners'][$id]) ) {
    cookie("mypartners[$id]", $id, $partners_cookietime);
    $db->query("UPDATE ".$db->prefix("partners")." SET hits=hits+1 WHERE id=$id");
  }

  echo "<html><head><meta http-equiv='Refresh' content='0; URL=$url'></head><body></body></html>";
  } else {
    redirect_header("index.php", 1, _MD_NOSUCH);
  }

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
switch($_GET['op']) {

  case "visit_partner":
    visit_partner( $_GET['id'] );
    break;

  default:
    partners_main();
    break;
}
?>
