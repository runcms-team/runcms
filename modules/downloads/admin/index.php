<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("admin_header.php");
include_once(RCX_ROOT_PATH."/class/groupaccess.php");
$eh     = new ErrorHandler(0);
$mytree = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
// Do this to retrieve the images list...
include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH."/class/form/formselect.php");
$imgarr_logos = RcxLists::getImgListAsArray(RCX_ROOT_PATH."/modules/downloads/cache/logos");
$select_logos = new RcxFormSelect("indirlogos", "indirlogos", "", 1, false);
$select_logos->addOption("", "-----");
$select_logos->addOptionArray($imgarr_logos);
$imgarr_shots = RcxLists::getImgListAsArray(RCX_ROOT_PATH."/modules/downloads/cache/shots");
$select_shots = new RcxFormSelect("indirshots", "indirshots", "", 1, false);
$select_shots->addOption("", "-----");
$select_shots->addOptionArray($imgarr_shots);
$files_arr = RcxLists::getFilesListAsArray(RCX_ROOT_PATH."/modules/downloads/cache/files");
$files_without_hash = array();
foreach($files_arr as $fname) {
  $fname2 = substr($fname, 33, strlen($fname));
  $files_without_hash[$fname] = $fname2;
}
$select_files = new RcxFormSelect("indirfiles", "indirfiles", "", 1, false);
$select_files->addOption("", "-----");
$select_files->addOptionArray($files_without_hash);
/**
* Description
*
* @param type $var description
* @return type description
*/
function downloads() {
global $db;
rcx_cp_header();
OpenTable();
// Temporarily 'homeless' downloads (to be revised in index.php breakup)
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_broken")."");
list($totalbrokendownloads) = $db->fetch_row($result);
if ($totalbrokendownloads > 0) {
  $totalbrokendownloads = "<span style='font-weight: bold'>$totalbrokendownloads</span>";
}
$result2 = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_mod")."");
list($totalmodrequests) = $db->fetch_row($result2);
if ($totalmodrequests > 0) {
  $totalmodrequests = "<span style='font-weight: bold'>$totalmodrequests</span>";
}
$result3 = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_downloads")." WHERE status=0");
list($totalnewdownloads) = $db->fetch_row($result3);
if ($totalnewdownloads > 0) {
  $totalnewdownloads = "<span style='font-weight: bold'>$totalnewdownloads</span>";
}
?>
    <h4><?php echo _MI_DOWNLOADS_NAME;?></h4>
	<br /><br /><br /><br />
	<div class="kpicon"><table><tr><td>
	<a href="index.php?op=downloadsConfigAdmin"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MD_GENERALSET;?>">
	<br /><?php echo _MD_GENERALSET;?></a>
	<a href="index.php?op=downloadsConfigMenu"><img src="<?php echo RCX_URL;?>/images/system/moduler.png" alt="<?php echo _MD_ADDMODDELETE;?>"/>	
	<br /><?php echo _MD_ADDMODDELETE;?></a>
	<a href="index.php?op=listNewDownloads"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MD_DLSWAITING;?>"/>
	<br /><?php echo _MD_DLSWAITING;?> (<?php echo $totalnewdownloads;?>)</a>
	<a href="index.php?op=listBrokenDownloads"><img src="<?php echo RCX_URL;?>/images/system/disclaimer.png" alt="<?php echo _MD_BROKENREPORTS;?>"/>
	<br /><?php echo _MD_BROKENREPORTS;?> (<?php echo $totalbrokendownloads;?>)</a>
	<a href="index.php?op=listModReq"><img src="<?php echo RCX_URL;?>/images/system/disclaimer.png" alt="<?php echo _MD_MODREQUESTS;?>"/>
	<br /><?php echo _MD_MODREQUESTS;?> (<?php echo $totalmodrequests;?>)</a>
	</td></tr></table></div>
<?php
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_downloads")." WHERE status>0");
list($numrows) = $db->fetch_row($result);
echo "<br /><br /><div align='center'>";
printf(_MD_THEREARE, $numrows);
echo "</div>";
CloseTable();
rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function listNewDownloads() {
global $db, $myts, $eh, $mytree, $rcxConfig;
// List downloads waiting for validation
$result  = $db->query("SELECT lid, cid, title, description, url, homepage, version, size, platform, logourl, submitter FROM ".$db->prefix("downloads_downloads")." WHERE status=0 ORDER BY date DESC");
$numrows = $db->num_rows($result);
rcx_cp_header();
OpenTable();
echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_DLSWAITING." ($numrows)</h4><br />";
if ($numrows > 0) {
  while (list($lid, $cid, $title, $description, $url, $homepage, $version, $size, $platform, $logourl, $uid) = $db->fetch_row($result)) {
    $title       = $myts->makeTboxData4Edit($title);
    $url         = $myts->makeTboxData4Edit($url);
    $homepage    = $myts->makeTboxData4Edit($homepage);
    $version     = $myts->makeTboxData4Edit($version);
    $size        = $myts->makeTboxData4Edit($size);
    $platform    = $myts->makeTboxData4Edit($platform);
    $description = $myts->makeTboxData4Edit($description);
    if ($uid != 0) {
      $submitter = RcxUser::getUnameFromId($uid);
      $submitter = $myts->makeTboxData4Show($submitter);
      } else {
        $submitter = $myts->makeTboxData4Show($rcxConfig['anonymous']);
      }
?>
<form action="index.php" method="post">
<table width="100%">
<tr><td valign="top"><?php echo _MD_GROUPSACCESS;?></td>
<td valign="top"><?php RcxDownload::printGroups();?></td></tr>
<tr><td nowrap><?php echo _MD_SUBMITTER;?></td>
<td><a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $uid;?>"><?php echo $submitter;?></a></td>
</tr><tr>
<td nowrap><?php echo _MD_FILETITLE;?></td>
<td><input type="text" class="text" name="title" size="50" maxlength="100" value="<?php echo $title;?>"></td>
</tr><tr>
<td nowrap><?php echo _MD_DLURL;?></td>
<td><input type="text" class="text" name="url" size="50" maxlength="255" value="<?php echo $url;?>"> [ <a href="<?php echo formatURL(RCX_URL."/modules/downloads/cache/files/", $url);?>" target="_blank"><?php echo _MD_DOWNLOAD;?></a> ]</td>
</tr><tr>
<td nowrap><?php echo _MD_CATEGORYC;?></td>
<td><?php $mytree->makeMySelBox("title", "title", $cid);?></td>
</tr><tr>
<td nowrap><?php echo _MD_SITEURL;?></td>
<td><input type="text" class="text" name="homepage" size="50" maxlength="255" value="<?php echo $homepage;?>"> [ <a href="<?php echo $homepage;?>" target="_blank"><?php echo _MD_VISIT;?></a> ]</td>
</tr><tr>
<td><?php echo _MD_VERSIONC;?></td>
<td><input type="text" class="text" name="version" size="10" maxlength="10" value="<?php echo $version;?>"></td>
</tr><tr>
<td><?php echo _MD_FILESIZEC;?></td>
<td><input type="text" class="text" name="size" size="10" maxlength="8" value="<?php echo $size;?>"> <?php echo _BYTES;?></td>
</tr><tr>
<td><?php echo _MD_PLATFORMC;?></td>
<td><input type="text" class="text" name="platform" size="45" maxlength="50" value="<?php echo $platform;?>"></td>
</tr><tr>
<td valign="top" nowrap><?php echo _MD_DESCRIPTIONC;?></td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'filedesc', $description, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'filedesc', $description);
echo $desc->render();
?>
</td>
</tr><tr>
<td align="right">
<tr valign='top'>
<td class='bg3'><b><?php echo _MD_SHOTIMAGE;?></b></td> 
<td class='bg1'>
<input type="text" class="text" name="logourl" id="logourl" size="50" maxlength="255" value="<?php echo $logourl;?>"> [ <a href="<?php echo formatURL(RCX_URL."/modules/downloads/cache/shots/", $logourl);?>" target="_blank"><?php echo _MD_DOWNLOAD;?></a> ]
</td></tr>
</tr><tr valign='top'>
<td class='bg1'>
<input type="hidden" name="op" value="approve">
<input type="hidden" name="lid" value="<?php echo $lid;?>">
<input type="submit" class="button" value="<?php echo _MD_APPROVE;?>">
</form></td>
<td align="left"><?php echo myTextForm("index.php?op=delNewDownload&lid=$lid", _DELETE);?></td>
</tr></table>
<?php
  }
  } else {
    echo _MD_NOSUBMITTED;
  }
CloseTable();
rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function downloadsConfigMenu() {
global $db, $myts, $eh, $mytree, $select_files, $select_shots, $downloadsConfig;
$pad_url = $_POST["pad_url"] ? $_POST["pad_url"] : "http://";
$pad_array = ($pad_url != "http://") ? parse_pad_file($pad_url, $downloadsConfig['validate_pad_file']) : get_pad_array();
if (!empty($pad_array['error'])) {
redirect_header("index.php?op=downloadsConfigMenu", 3, $pad_array['error']);
exit();
} 
rcx_cp_header();
$result=$db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_cat")."");
list($numrows) = $db->fetch_row($result);
if ($numrows > 0) {
  OpenTable();
  // If there is a category, add a New Download
$upload = new fileupload();
?>
<h4><a href="index.php"><?php echo _MAIN;?></a>: <?php echo _MD_ADDWITHPADFILE;?></h4>
<form method="post" action="index.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

<tr valign='top'><td class='bg3'><b><?php echo _MD_PAD_URL;?></b></td>
<td class='bg1'>
<input type="text" class="text" name="pad_url" size="50" maxlength="100" value="<?php echo $myts->oopsHtmlSpecialChars($pad_url);?>"/>
<input type="hidden" name="op" value="downloadsConfigMenu" />
<input type="submit" class="button" value="<?php echo _SUBMIT_PAD_FILE;?>" />
</td></tr>
</table></td></tr></table></form>
<form method="post" action="index.php" enctype="multipart/form-data">
<h4><?php echo _MD_ADDNEWFILE;?></h4>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

<tr valign='top'>
<td class='bg3'><b><?php echo _MD_GROUPSACCESS;?></b></td>
<td class='bg1'><?php RcxDownload::printGroups();?></td></tr>
<tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILETITLE;?></b></td>
<td class='bg1'><input type="text" class="text" name="title" size="50" maxlength="100" value="<?php echo $pad_array['title'];?>"/></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_DLURL;?></b></td>
<td class='bg1'>
<?php
echo "<i>"._AM_ADDAFILE."</i><br /><br />";
echo _AM_FILESAVAILLIST."<br />";
$select_files->setExtra("onchange=\"javascript:$('url').value = this.options[this.selectedIndex].value;\"");
echo $select_files->render(); ?><br /><br />
<input type="text" class="text" name="url" id="url" size="50" maxlength="255" value="<?php echo $pad_array['url'];?>"/>
<?php
echo "<br />";
$upload->render(1, "download");
?>
<br /><br />
<?php printf(_MD_FILE, "modules/downloads/cache/files/");?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_CATEGORYC;?></b></td>
<td class='bg1'><?php $mytree->makeMySelBox("title", "title");?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_SITEURL;?></b></td>
<td class='bg1'><input type="text" class="text" name="homepage" size="50" maxlength="255" value="<?php echo $pad_array['homepage'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_VERSIONC;?></b></td>
<td class='bg1'><input type="text" class="text" name="version" size="10" maxlength="10" value="<?php echo $pad_array['version'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILESIZEC;?></b></td>
<td class='bg1'><i><?php echo _AM_DOWNLOADS_BYTES;?></i><br /><input type="text" class="text" name="size" size="10" maxlength="100" value="<?php echo $pad_array['size'];?>"> <?php echo _BYTES;?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_PLATFORMC;?></b></td>
<td class='bg1'><input type="text" class="text" name="platform" size="45" maxlength="60" value="<?php echo $pad_array['platform'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_DESCRIPTIONC;?></b></td>
<td class='bg1'>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'filedesc', '',10,58);
$desc = new RcxFormDhtmlTextArea('', 'filedesc', $pad_array['filedesc']);
echo $desc->render();
?>
</td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_SHOTIMAGE;?></b></td>
<td class='bg1'>
<?php
echo "<i>"._AM_ADDANIMAGE."</i><br /><br />";
echo _AM_IMGAVAILLIST."<br />";
$select_shots->setExtra("onchange=\"javascript:$('logourl').value = this.options[this.selectedIndex].value;\"");
echo $select_shots->render(); ?> [<a href="javascript:openWithSelfMain('<?php echo RCX_URL."/downloads/cache/shots/";?>' + $('indirshots').options[$('indirshots').selectedIndex].value + '','view',550,200);"><?php echo _PREVIEW;?></a>]<br /><br />
<input type="text" class="text" name="logourl" id="logourl" size="50" maxlength="255" value="<?php echo $pad_array['logourl'];?>">
<?php
echo "<br />";
$upload->render(1, "image");
?>
<br /><br />
<?php printf(_MD_SHOT, "modules/downloads/cache/images/shots/");?></td>
</tr>
<tr valign='top'><td class='bg3'></td><td class='bg1'>
<input type="hidden" name="op" value="addDownload" />
<input type="submit" class="button" value="<?php echo _ADD;?>" /></td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
echo "<br />";
OpenTable();
// Modify Download by number
$dwlslist = $db->query("select lid,title from ".$db->prefix("downloads_downloads")." order by title asc");
?>
<form method="post" action="index.php">
<h4><?php echo _MD_MODDL;?></h4>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'><td class='bg3'><b><?php echo _MD_FILEID;?></b></td>
<td class='bg1'><input type="text" class="text" name="lid" size="12" maxlength="11">
<input type="hidden" name="fct" value="downloads">
<input type="hidden" name="op" value="modDownload">
<input type="submit" class="button" value="<?php echo _MD_MODIFY;?>"></td>
</tr>
</table></td></tr></table>
</form>
<?php
//echo "<nobr />";
// Modify Download by name
$dwlslist = $db->query("select lid,title from ".$db->prefix("downloads_downloads")." order by title asc");
?>
<form method="post" action="index.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'><td class='bg3'><b><?php echo _MD_FILENAME;?></b></td>
<td class='bg1'><select name="lid" class="select">
<option value="" selected>-----</option>
<?php
while ( $dl = $db->fetch_array($dwlslist) ) {
?>
<option value="<?php echo $dl['lid'];?>"><?php echo $dl['title']?></option>
<?php
}
?>
</select>
<input type="hidden" name="fct" value="downloads">
<input type="hidden" name="op" value="modDownload">
<input type="submit" class="button" value="<?php echo _MD_MODIFY;?>">
</td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
echo "<br />";
OpenTable();
// Modify Category
?>

<h4><?php echo _MD_MODCAT;?></h4>
<form method="post" action="index.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'><td class='bg1'><b><?php echo _MD_CATEGORYC;?></b></td>
<td class='bg1'><?php $mytree->makeMySelBox("title", "title");?>
<input type="hidden" name="op" value="modCat">
<input type="submit" class="button" value="<?php echo _MD_MODIFY;?>">
</td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
echo "<br />";
OpenTable();
// Add a New Sub-Category
?>
<h4><?php echo _MD_ADDSUB;?></h4>
<form method="post" action="index.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'><td class='bg1'><b><?php echo _MD_TITLEC;?></b>
<input type="text" class="text" name="title" size="30" maxlength="50">
<b><?php echo _MD_IN;?></b>&nbsp;
<?php $mytree->makeMySelBox("title", "title");?>
<input type="hidden" name="op" value="addCat">
<input type="submit" class="button" value="<?php echo _ADD;?>">
</td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
echo "<br />";
   }
   // Add a New Main Category
   OpenTable();
?>
<h4><?php echo _MD_ADDMAIN;?></h4>
<form method="post" action="index.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'><td class='bg1'><b><?php echo _MD_TITLEC;?></b>
<input type="text" class="text" name="title" size="30" maxlength="50">
<input type="hidden" name="op" value="addCat">
<input type="submit" class="button" value="<?php echo _ADD;?>">
</td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delVote()
{
   global $db, $eh;
   $rid = intval($_GET['rid']);
   $lid = intval($_GET['lid']);
   $query = "DELETE FROM ".$db->prefix("downloads_votedata")." WHERE ratingid=$rid";
   $db->query($query) or $eh->show("0013");
   downloads_update_rating($lid);
   redirect_header("index.php", 1, _MD_VOTEDELETED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function listBrokenDownloads()
{
   global $db, $myts, $eh, $rcxConfig;
   $result = $db->query("SELECT reportid, lid, sender, ip FROM ".$db->prefix("downloads_broken")." ORDER BY reportid");
   $totalbrokendownloads = $db->num_rows($result);
   rcx_cp_header();
   OpenTable();
   echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_BROKENREPORTS." ($totalbrokendownloads)</h4><br />";

   if ($totalbrokendownloads == 0) {
      echo _MD_NOBROKEN;
   } else {
      $colorswitch = "bg1";
    ?>
    <div class='center'><?php echo _MD_IGNOREDESC;?><br /><?php echo _MD_DELETEDESC;?></div>
    <br /><br /><br />
    <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
    <tr>
    <th><?php echo _MD_FILETITLE;?></th>
    <th><?php echo _MD_REPORTER;?></th>
    <th><?php echo _MD_FILESUBMITTER;?></th>
    <th><?php echo _MD_IGNORE;?></th>
    <th><?php echo _EDIT;?></th>
    <th><?php echo _DELETE;?></th>
    </tr>
    <?php
    while (list($reportid, $lid, $senderid, $ip) = $db->fetch_row($result))
    {
       $result2 = $db->query("SELECT title, url, submitter FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid");
       list($title, $url, $ownerid) = $db->fetch_row($result2);
       $title = $myts->makeTboxData4Show($title);

       $ip = $myts->makeClickable($ip);
       echo "<tr>
  <td class='$colorswitch'><a href='".formatURL(RCX_URL."/modules/downloads/cache/files/", $url)."' target='_blank'>$title</a></td>
  <td class='$colorswitch'>".get_user_url($senderid,RcxUser::getUnameFromId($senderid))." ($ip)</td>
  <td class='$colorswitch'>".get_user_url($ownerid,RcxUser::getUnameFromId($ownerid))."</td>
  <td class='$colorswitch center'>";
       echo myTextForm("index.php?op=ignoreBrokenDownloads&lid=$lid" , "X");
       echo "</td><td class='$colorswitch' style='text-align: center;'>";
       echo myTextForm("index.php?op=modDownload&lid=$lid" , "X");
       echo "</td><td class='$colorswitch' style='text-align: center;'>";
       echo myTextForm("index.php?op=delBrokenDownloads&lid=$lid" , "X");
       echo "</td></tr>";
       if ($colorswitch == "bg1") {
          $colorswitch = "bg3";
       } else {
          $colorswitch="bg1";
       }
    }
    echo "</table></td></tr></table>";
   }
   CloseTable();
   rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delBrokenDownloads()
{
   global $db, $_GET, $eh;
   $lid = intval($_GET['lid']);
   $query = "DELETE FROM ".$db->prefix("downloads_broken")." WHERE lid=$lid";
   $db->query($query) or $eh->show("0013");
   $query  = "SELECT url, logourl FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid";
   $result = $db->query($query);
   list($url, $logourl) = $db->fetch_row($result);
   @unlink("../cache/files/" . basename($url));
   @unlink("../cache/shots/" . basename($logourl));
   $query = "DELETE FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid";
   $db->query($query) or $eh->show("0013");
   build_rss();
   redirect_header("./index.php?op=listBrokenDownloads", 1, _MD_FILEDELETED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function ignoreBrokenDownloads()
{
   global $db, $eh;
   $lid   = intval($_GET['lid']);
   $query = "DELETE FROM ".$db->prefix("downloads_broken")." WHERE lid=$lid";
   $db->query($query) or $eh->show("0013");
   redirect_header("./index.php?op=listBrokenDownloads", 1, _MD_BROKENDELETED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function listModReq()
{
   global $db, $myts, $eh, $mytree, $downloadsConfig;
   rcx_cp_header();
   OpenTable();
   $sql_mod = $db->query("SELECT requestid, lid, cid, title, description, url, homepage, version, size, platform, modifysubmitter, logourl FROM ".$db->prefix("downloads_mod")." ORDER BY requestid");
   $totalmodrequests = $db->num_rows($sql_mod);
   echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_USERMODREQ." ($totalmodrequests)</h4><br />";
   if ($totalmodrequests > 0)
   {
      while (list($requestid, $lid, $cid, $title, $description, $url, $homepage, $version, $size, $platform, $modifysubmitter, $logourl) = $db->fetch_row($sql_mod)) {
         $cidtitle      = $mytree->getNicePathFromId($cid, "title", RCX_URL."/downloads/viewcat.php?");
         $cidtitle      = substr($cidtitle, 0, -2);
         $title         = $myts->makeTboxData4Show($title);
         $url           = formatURL(RCX_URL."/modules/downloads/cache/files/", $myts->makeTboxData4Show($url));
         $homepage      = $myts->makeTboxData4Show($homepage);
         $version       = $myts->makeTboxData4Show($version);
         $size          = $myts->makeTboxData4Show($size);
         $platform      = $myts->makeTboxData4Show($platform);
         $description   = $myts->makeTareaData4Show($description);
         $logourl     = formatURL(RCX_URL."/downloads/cache/shots/", $myts->makeTboxData4Edit($logourl));

         if ($modifysubmitter != 0)
         {
            $submittername = RcxUser::getUnameFromId($modifysubmitter);
            $submittername = $myts->makeTareaData4Show($submittername);
         }
         $sql_original = $db->query("SELECT cid, title, description, url, homepage, version, size, platform, submitter, logourl FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid");
         list($origcid, $origtitle, $origdescription, $origurl, $orighomepage, $origversion, $origsize, $origplatform, $owner, $origlogourl) = $db->fetch_row($sql_original);
         $origcidtitle    = $mytree->getNicePathFromId($origcid, "title", RCX_URL."/modules/downloads/viewcat.php?");
         $origcidtitle    = substr($origcidtitle, 0, -2);
         $origtitle       = $myts->makeTboxData4Show($origtitle);
         $origurl         = formatURL(RCX_URL."/modules/downloads/cache/files/", $myts->makeTboxData4Show($origurl));
         $orighomepage    = $myts->makeTboxData4Show($orighomepage);
         $origversion     = $myts->makeTboxData4Show($origversion);
         $origsize        = $myts->makeTboxData4Show($origsize);
         $origplatform    = $myts->makeTboxData4Show($origplatform);
         $origdescription = $myts->makeTareaData4Show($origdescription);
         $origlogourl     = formatURL(RCX_URL."/modules/downloads/cache/shots/", $myts->makeTboxData4Edit($origlogourl));
         if ($owner != 0)
         {
            $ownername       = RcxUser::getUnameFromId($owner);
            $ownername       = $myts->makeTareaData4Show($ownername);
         }
?>
<hr style="text-align: center;" size="1" noshade="noshade" />
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'>
<td class='bg3'><small><?php echo _MD_REQUESTID;?></small></td>
<td class='bg3'><b><?php echo $requestid;?></b></td>
</tr><tr valign='top'>
<td class='bg1'><b><?php echo _MD_PROPOSED;?></b></td>
<td width="50%" rowspan="10" class='bg1'><b><?php echo _MD_DESCRIPTIONC;?></b><br /><br /><?php echo $description;?></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_FILETITLE;?></b> <?php echo $title;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_DLURL;?></b> <a href="<?php echo $url;?>" target="_blank"><?php echo $url;?></a></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_CATEGORYC;?></b> <?php echo $cidtitle;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_SITEURL;?></b> <a href="<?php echo $homepage;?>" target="_blank"><?php echo $homepage;?></a></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_VERSIONC;?></b> <?php echo $version;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_FILESIZEC;?></b> <?php echo $size;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_PLATFORMC;?></b> <?php echo $platform;?></small></td></tr>
<tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_SHOTIMAGE;?></b> <a href="<?php echo $logourl;?>" target="_blank"><?php echo $logourl;?></a></small></td></tr>
<tr valign='top'><td class='bg1'><small><b><?php echo _MD_SUBMITTER;?></b> <a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $modifysubmitter;?>" target="_blank"><?php echo $submittername;?></a></small></td>
</tr><tr valign='top'>
<td class='bg3' colspan="2">&nbsp;</td>
</tr><tr valign='top'>
<td class='bg1'><b><?php echo _MD_ORIGINAL;?></b></td>
<td width="50%" rowspan="10" class='bg1'><b><?php echo _MD_DESCRIPTIONC;?></b><br /><br /><?php echo $origdescription;?></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_FILETITLE;?></b> <?php echo $origtitle;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_DLURL;?></b> <a href="<?php echo $origurl;?>" target="_blank"><?php echo $origurl;?></a></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_CATEGORYC;?></b> <?php echo $origcidtitle;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_SITEURL;?></b> <a href="<?php echo $orighomepage;?>" target="_blank"><?php echo $orighomepage;?></a></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_VERSIONC;?></b> <?php echo $origversion;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_FILESIZEC;?></b> <?php echo $origsize;?></small></td>
</tr><tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_PLATFORMC;?></b> <?php echo $origplatform;?></small></td></tr>
<tr valign='top'>
<td class='bg1'><small><b><?php echo _MD_SHOTIMAGE;?></b> <a href="<?php echo $origlogourl;?>" target="_blank"><?php echo $origlogourl;?></a></small></td></tr>
<tr valign='top'><td class='bg1'><small><b><?php echo _MD_OWNER;?></b> <a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $owner;?>" target="_blank"><?php echo $ownername;?></a></small></td>
</tr><tr style="text-align: center;">
<td colspan="2" class='bg3'>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td style="vertical-align: top;" width="5%"><?php echo myTextForm("index.php?op=changeModReq&requestid=$requestid" , _MD_APPROVE);?></td>
<td style="vertical-align: top;" width="5%"><?php echo myTextForm("index.php?op=modDownload&lid=$lid" , _EDIT);?></td>
<td style="vertical-align: top;" width="5%"><?php echo myTextForm("index.php?op=ignoreModReq&requestid=$requestid", _MD_IGNORE);?></td>
</tr></table>
</td>
</tr>
</table></td></tr></table>
<?php
      }
   } else {
      echo _MD_NOMODREQ;
   }
   CloseTable();
   rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function changeModReq()
{
   global $db, $_GET, $eh, $myts;
   $requestid = intval($_GET['requestid']);
   $sql = "SELECT
  lid,
  cid,
  title,
  url,
  homepage,
  version,
  size,
  platform,
  logourl,
  description
  FROM ".$db->prefix("downloads_mod")."
  WHERE requestid=$requestid";
   $result = $db->query($sql);
   list($lid, $cid, $title, $url, $homepage, $version, $size, $platform, $logourl, $description) = $db->fetch_row($result); 
   $sql_original = $db->query("SELECT url, logourl FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid");
   list($origurl, $origlogourl) = $db->fetch_row($sql_original);
   if ($url != $origurl) @unlink(RCX_ROOT_PATH."/modules/downloads/cache/files/" . basename($origurl));
   if ($logourl != $origlogourl) @unlink(RCX_ROOT_PATH."/modules/downloads/cache/shots/" . basename($origlogourl));
   
   $title       = $myts->oopsAddSlashesRT($title);
   $url         = $myts->oopsAddSlashesRT($url);
   $homepage    = $myts->oopsAddSlashesRT($homepage);
   $description = $myts->oopsAddSlashesRT($description);
   $platform    = $myts->oopsAddSlashesRT($platform);
   $logourl    = $myts->oopsAddSlashesRT($logourl);
  
   $sql = "UPDATE ".$db->prefix("downloads_downloads")." SET
  cid=$cid,
  title='$title',
  description='$description',
  url='$url',
  homepage='$homepage',
  version='$version',
  size='$size',
  platform='$platform',
  logourl='$logourl', 
  status=2,
  date=".time()."
  WHERE lid=$lid";
   $db->query($sql) or $eh->show("0013");
   $db->query("DELETE FROM ".$db->prefix("downloads_mod")." WHERE requestid=$requestid") or $eh->show("0013");
   redirect_header("index.php?op=listModReq", 1, _UPDATED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function ignoreModReq()
{
   global $db, $_GET, $eh;
   $requestid = intval($_GET['requestid']);
   $query     = "DELETE FROM ".$db->prefix("downloads_mod")." WHERE requestid=$requestid";
   $db->query($query) or $eh->show("0013");
   redirect_header("./index.php?op=listModReq", 1, _MD_MODREQDELETED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delDownload()
{
   global $db, $_GET, $eh;
   $lid = intval($_GET['lid']);
   $query  = "SELECT url, logourl FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid";
   $result = $db->query($query);
   list($url, $logourl) = $db->fetch_row($result);
   @unlink("../cache/files/" . basename($url));
   @unlink("../cache/shots/" . basename($logourl));
   $query = "DELETE FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid";
   $db->query($query) or $eh->show("0013");
   $query = "DELETE FROM ".$db->prefix("downloads_votedata")." WHERE lid=$lid";
   $db->query($query) or $eh->show("0013");
   build_rss();
   redirect_header("index.php", 1, _MD_FILEDELETED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function modCat()
{
   global $db, $rcxModule, $_POST, $_GET, $myts, $eh, $mytree, $select_logos;
   $cid = !empty($_POST["cid"]) ? intval($_POST["cid"]) : intval($_GET["cid"]);
   rcx_cp_header();
   OpenTable();
   echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_MODCAT."</h4><br />";
   $result = $db->query("SELECT pid, title, imgurl, description FROM ".$db->prefix("downloads_cat")." WHERE cid=$cid");
   global $desc;
   list($pid, $title, $imgurl, $description) = $db->fetch_row($result);
   $title  = $myts->makeTboxData4Edit($title);
   $imgurl = $myts->makeTboxData4Edit($imgurl);
   $desc   = $myts->makeTboxData4Edit($description);
?>
<form action="./index.php" method="post" enctype="multipart/form-data">
<?php echo _MD_TITLEC;?><br />
<input type="text" class="text" name="title" value="<?php echo $title;?>" size="51" maxlength="50">
<br /><br />
<?php
echo "<i>"._AM_ADDANIMAGE."</i><br /><br />";
echo _AM_IMGAVAILLIST."<br />";
$select_logos->setValue($imgurl);
$select_logos->setExtra("onchange=\"javascript:$('imgurl').value = this.options[this.selectedIndex].value;\"");
echo $select_logos->render(); ?> [<a href="javascript:openWithSelfMain('<?php echo RCX_URL."/downloads/cache/logos/";?>' + $('indirlogos').options[$('indirlogos').selectedIndex].value + '','view',550,200);"><?php echo _PREVIEW;?></a>]<br /><br />
<input type="text" class="text" name="imgurl" id="imgurl" value="<?php echo $imgurl;?>" size="51" maxlength="255"><br />
<?php
$upload = new fileupload();
$upload->set_basename($cid, 'image');
$upload->render(1, 'image');
echo "<br />".sprintf(_AM_IMGLOCATION, "modules/".$rcxModule->dirname()."/cache/logos/");
?>
<br /><br />
<?php echo _MD_DESCRIPTION;?>:<br />
<?php
//$desc = new RcxFormDhtmlTextArea('', 'desc', $desc, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'desc', $desc);
echo $desc->render();
?>
<br /><br />
<?php echo _MD_PARENT;?><br />
<?php $mytree->makeMySelBox("title", "title", $pid, 1, "pid");?>
<br /><br />
<input type="hidden" name="cid" value="<?php echo $cid;?>" />
<input type="hidden" name="op" value="modCatS" /><br />
<input type="submit" class="button" value="<?php echo _SAVE;?>" />
<input type="button" class="button" value="<?php echo _DELETE;?>" onclick="location='index.php?pid=<?php echo $pid;?>&cid=<?php echo $cid;?>&op=delCat';" />
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="location='index.php';" />
</form>
<?php
CloseTable();
rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function modCatS()
{
   global $db, $myts, $_POST, $_FILES;
   $cid         = intval($_POST['cid']);
   $pid         = intval($_POST['pid']);
   $imgurl      = $_POST['imgurl'];
   $title       = $_POST['title'];
   $description = $_POST['desc'];
   if ( !empty($_FILES['image']['name']) )
   {
      $upload = new fileupload();
      $upload->set_upload_dir("../cache/logos/");
      $upload->set_accepted("gif|jpg|png");
      $upload->set_overwrite(2);
      $result = $upload->upload();
      if ($result['image'])
      {
         $imgurl = $result['image']['filename'];
      }
      else
      {
         redirect_header("index.php?op=modCat&cid=$cid", 3, $upload->errors());
         exit();
      }
   }
   // categorizer
   if ( $cid == $pid )
   {
      redirect_header("index.php?op=modCat&cid=$cid", 3, _AM_DOWNLOADS_SELECTCORRECTPID);
      exit();
   }
   $catlist = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
   $allcats = $catlist->getAllParentId($pid);
   foreach ( $allcats as $cat )
   {
      if ( $cat == $cid )
      {
         redirect_header("index.php?op=modCat&cid=$cid", 3, _AM_DOWNLOADS_SELECTCORRECTPID);
         exit();
      }
   }
   $db->query("UPDATE ".$db->prefix("downloads_cat")." SET title='$title', imgurl='$imgurl', pid='$pid', description='$description' WHERE cid=$cid");
   build_rss();
   redirect_header("index.php?op=modCat&cid=$cid", 1, _UPDATED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function addCat()
{
   global $db, $_POST, $myts, $eh;
   $pid   = intval($_POST['cid']);
   $title = $_POST["title"];
   $newid = $db->genId($db->prefix("downloads_cat")."_cid_seq");
   $query = $db->query("INSERT INTO ".$db->prefix("downloads_cat")." (cid,pid,title,imgurl,description) VALUES (".intval($newid).", ".intval($pid).", '$title', '', '')") or $eh->show("0013");
   if ($newid == 0) {
      $newid = $db->insert_id($query);
   }
   redirect_header("index.php?op=modCat&cid=$newid", 1, _MD_NEWCATADDED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delCat()
{
   global $db, $_GET, $mytree;
   $cid = intval($_GET['cid']);
   if ($_GET['ok'] == 1) {
      //get all subcategories under the specified category
      $arr  = $mytree->getAllChildId($cid);
      $size = count($arr);
      for ($i=0; $i<$size; $i++)
      {
         //get all downloads in each subcategory
         $result = $db->query("SELECT lid, url, logourl FROM ".$db->prefix("downloads_downloads")." WHERE cid=".$arr[$i]."");
         //now for each download, delete the text data and vote ata associated with the download
         while (list($lid, $url, $logourl) = $db->fetch_row($result))
         {
            @unlink("../cache/files/" . basename($url));
            @unlink("../cache/shots/" . basename($logourl));
            $db->query("DELETE FROM ".$db->prefix("downloads_votedata")." WHERE lid=$lid");
            $db->query("DELETE FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid)");
         }
         //all downloads for each subcategory is deleted, now delete the subcategory data
         $result = $db->query("SELECT imgurl FROM ".$db->prefix("downloads_cat")." WHERE cid=".$arr[$i]."");
         list($imgurl) = $db->fetch_row($result);
         @unlink("../cache/logos/" . basename($imgurl));
         $db->query("DELETE FROM ".$db->prefix("downloads_cat")." WHERE cid=".$arr[$i]."");
      }
      //all subcategory and associated data are deleted, now delete category data and its associated data
      $result = $db->query("SELECT lid, url, logourl FROM ".$db->prefix("downloads_downloads")." WHERE cid=$cid");
      while (list($lid, $url, $logourl) = $db->fetch_row($result))
      {
         @unlink("../cache/files/" . basename($url));
         @unlink("../cache/shots/" . basename($logourl));
         $db->query("DELETE FROM ".$db->prefix("downloads_votedata")." WHERE lid=$lid");
         $db->query("DELETE FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid");
      }
      $result = $db->query("SELECT imgurl FROM ".$db->prefix("downloads_cat")." WHERE cid=$cid");
      list($imgurl) = $db->fetch_row($result);
      @unlink("../cache/logos/" . basename($imgurl));
      $db->query("DELETE FROM ".$db->prefix("downloads_cat")." WHERE cid=$cid");
      build_rss();
      redirect_header("index.php", 1, _MD_CATDELETED);
      exit();
   }
   else
   {
      rcx_cp_header();
      OpenTable();
      echo "<h4>"._MD_WARNING."</h4><br /><table><tr><td>";
      echo myTextForm("index.php?op=delCat&cid=$cid&ok=1", _YES);
      echo "</td><td>";
      echo myTextForm("index.php", _NO);
      echo "</td></tr></table>";
      CloseTable();
      rcx_cp_footer();
   }
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function addDownload()
{
   global $db, $myts, $rcxUser, $eh, $rcxModule, $_FILES, $_POST;
   $groups  = RcxDownload::makeTboxData4SaveGroups($_POST["group_ids"]);
 $homepage    = formatURL($myts->makeTboxData4Save($_POST["homepage"]));
$url         = $myts->makeTboxData4Save($_POST["url"]);
$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$version     = $myts->makeTboxData4Save($_POST["version"]);
$size        = $myts->makeTboxData4Save($_POST["size"]);
$platform    = $myts->makeTboxData4Save($_POST["platform"]);
$description = $myts->makeTboxData4Save($_POST["filedesc"]);


   $submitter   = intval($rcxUser->uid());
   $result        = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_downloads")." WHERE url='$url'");
   list($numrows) = $db->fetch_row($result);
   // Check if Download exist
   if ($numrows > 0)
   {
      redirect_header("index.php?op=downloadsConfigMenu", 3, _MD_ERROREXIST);
      exit();
   }
   // Check if Title is empty
   if ( empty($title) )
   {
      redirect_header("index.php?op=downloadsConfigMenu", 3, _MD_ERRORTITLE);
      exit();
   }
   // Check if Description is empty
   if ( empty($description) )
   {
      redirect_header("index.php?op=downloadsConfigMenu", 3, _MD_ERRORDESC);
      exit();
   }
   if ( empty($size) || !is_numeric($size) ) {
      $size = 0;
   }
   if ( !empty($_POST['cid']) )
   {
      $cid = intval($_POST['cid']);
   }
   else
   {
      $cid = 0;
   }
   if ( !empty($_FILES['download']['name']) )
   {
      $upload = new fileupload();
      $upload->set_upload_dir("../cache/files/", "download");
      $upload->set_upload_dir("../cache/shots/", "image");
      $upload->set_overwrite(2);
      $result = $upload->upload();
      if ($result['download']) {
         $url  = $result['download']['filename'];
         $size = $result['download']['size'];
      } else {
         redirect_header("index.php?op=downloadsConfigMenu", 3, $upload->errors());
         exit();
      }
      if ( !empty($_FILES['image']['name']) )
      {
         if ($result['image'])
         {
            $logourl = $result['image']['filename'];
         }
         else
         {
            redirect_header("index.php?op=downloadsConfigMenu", 3, $upload->errors());
            exit();
         }
      }
   }
   // Check if URL is empty
   if ( empty($url) )
   {
      redirect_header("index.php?op=downloadsConfigMenu", 3, _MD_ERRORURL);
      exit();
   }
   $newid = $db->genId($db->prefix("downloads_downloads")."_lid_seq");
   $ptime = time();
   $sql   = "INSERT INTO ".$db->prefix("downloads_downloads")." VALUES (".intval($newid).",".intval($cid).",'$groups','$title','$description','$url','$homepage','$version',".intval($size).",'$platform','$logourl',".intval($submitter).",1,".intval($ptime).",0,0,0,0)";
   $db->query($sql) or $eh->show("0013");
   build_rss();
   redirect_header("index.php", 1, _MD_NEWDLADDED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function delNewDownload()
{
   global $db, $_GET;
   $lid   = intval($_GET['lid']);
   $query  = "SELECT url, logourl FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid";
   $result = $db->query($query);
   list($url, $logourl) = $db->fetch_row($result);
   @unlink("../cache/files/" . basename($url));
   @unlink("../cache/shots/" . basename($logourl));
   $query = "DELETE FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid";
   $db->query($query);
   redirect_header("./index.php?op=listNewDownloads", 1, _MD_FILEDELETED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function modDownload()
{
   global $db, $select_files, $select_shots, $myts, $eh, $mytree, $downloadsConfig;
   
   $lid= !empty($_POST['lid']) ? intval($_POST['lid']) : intval($_GET['lid']);
   if ( $lid == "" ) {
      redirect_header("index.php?op=downloadsConfigMenu",1);
      exit();
   }
   
   $pad_url = $_POST["pad_url"] ? $_POST["pad_url"] : "http://";
   if ($pad_url != "http://") {
       $pad_array = parse_pad_file($pad_url, $downloadsConfig['validate_pad_file']);
       if (!empty($pad_array['error'])) {
            redirect_header("index.php?op=modDownload&lid=" . (int)$lid, 3, $pad_array['error']);
            exit();
       } 
       $title       = $pad_array['title'];
       $url         = $pad_array['url'];
       $homepage    = $pad_array['homepage'];
       $version     = $pad_array['version'];
       $size        = $pad_array['size'];
       $platform    = $pad_array['platform'];
       $description = $pad_array['filedesc'];
       $logourl     = $pad_array['logourl'];
       $status = intval($_POST["status"]);
       $groups = $myts->oopsHtmlSpecialChars($_POST["groups"]);
       $cid = intval($_POST["cid"]);
       
   } else {
   
   $result = $db->query("SELECT cid, title, groups, description, url, homepage, version, size, platform, logourl, status FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid") or $eh->show("0013");
   list($cid, $title, $groups, $description, $url, $homepage, $version, $size, $platform, $logourl, $status) = $db->fetch_row($result);
   $homepage    = $myts->makeTboxData4Edit($homepage);
   $title       = $myts->makeTboxData4Edit($title);
   $description = $myts->makeTboxData4Edit($description);
   $url         = $myts->makeTboxData4Edit($url);
   $version     = $myts->makeTboxData4Edit($version);
   $size        = $myts->makeTboxData4Edit($size);
   $platform    = $myts->makeTboxData4Edit($platform);
   $logourl     = $myts->makeTboxData4Edit($logourl);
 }
   rcx_cp_header();
   OpenTable();
?>
<h4><a href="index.php"><?php echo _MAIN;?></a>: <?php echo _MD_MODIFY_WITHPADFILE;?></h4>
<form method="post" action="index.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'><td class='bg3'><b><?php echo _MD_PAD_URL;?></b></td>
<td class='bg1'>
<input type="text" class="text" name="pad_url" size="50" maxlength="100" value="<?php echo $myts->oopsHtmlSpecialChars($pad_url);?>"/>
<input type="hidden" name="lid" value="<?php echo (int)$lid;?>" />
<input type="hidden" name="cid" value="<?php echo (int)$cid;?>" />
<input type="hidden" name="status" value="<?php echo (int)$status;?>" />
<input type="hidden" name="groups" value="<?php echo $groups;?>" />
<input type="hidden" name="op" value="modDownload" />
<input type="submit" class="button" value="<?php echo _SUBMIT_PAD_FILE;?>" />
</td></tr>
</table></td></tr></table></form>
<form method="post" action="index.php" enctype="multipart/form-data">
<h4><?php echo _MD_MODDL;?></h4>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'>
<td class='bg3'><b><?php echo _MD_GROUPSACCESS;?></b></td>
<td class='bg1'><?php RcxDownload::printGroups(explode(",",$groups));?></td></tr>
<tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILEID;?></b></td>
<td class='bg1'><b><?php echo $lid;?></b></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILETITLE;?></b></td>
<td class='bg1'><input type="text" class="text" name="title" value="<?php echo $title;?>" size="50" maxlength="100" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_DLURL;?></b></td>
<td class='bg1'>
<?php
echo "<i>"._AM_ADDAFILE."</i><br /><br />";
echo _AM_FILESAVAILLIST."<br />";
$select_files->setValue($url);
$select_files->setExtra("onchange=\"javascript:$('url').value = this.options[this.selectedIndex].value;\"");
echo $select_files->render(); ?><br /><br />
<input type="text" class="text" name="url" id="url" value="<?php echo $url;?>" size="50" maxlength="255" /> [ <a href="<?php echo formatURL(RC_MOD_URL."/downloads/cache/files/", $url);?>" target="_blank"><?php echo _MD_DOWNLOAD;?></a> ]
<br /><input type="file" class="file" name="download">
<br /><br />
<?php printf(_MD_FILE, "modules/downloads/cache/files/");?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_CATEGORYC;?></b></td>
<td class='bg1'><?php $mytree->makeMySelBox("title", "title", $cid);?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_SITEURL;?></b></td>
<td class='bg1'><input type="text" class="text" name="homepage" value="<?php echo $homepage;?>" size="50" maxlength="255" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_VERSIONC;?></b></td>
<td class='bg1'><input type="text" class="text" name="version" value="<?php echo $version;?>" size="10" maxlength="10" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILESIZEC;?></b></td>
<td class='bg1'><input type="text" class="text" name="size" value="<?php echo $size;?>" size="10" maxlength="100" /> <?php echo _BYTES;?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_PLATFORMC;?></b></td>
<td class='bg1'><input type="text" class="text" name="platform" value="<?php echo $platform;?>" size="45" maxlength="60" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_DESCRIPTIONC;?></b></td>
<td class='bg1'>
<?php
$desc = new RcxFormDhtmlTextArea('', 'filedesc', $description);
echo $desc->render();
?>
</td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_SHOTIMAGE;?></b></td>
<td class='bg1'>
<?php
echo "<i>"._AM_ADDANIMAGE."</i><br /><br />";
echo _AM_IMGAVAILLIST."<br />";
$select_shots->setValue($logourl);
$select_shots->setExtra("onchange=\"javascript:$('logourl').value = this.options[this.selectedIndex].value;\"");
echo $select_shots->render(); ?> [<a href="javascript:openWithSelfMain('<?php echo RCX_URL."/downloads/cache/shots/";?>' + $('indirshots').options[$('indirshots').selectedIndex].value + '','view',550,200);"><?php echo _PREVIEW;?></a>]<br /><br />
<input type="text" class="text" name="logourl" id="logourl" value="<?php echo $logourl;?>" size="50" maxlength="255" />
<br /><input type="file" class="file" name="image">
<br /><br /><?php printf(_MD_SHOT, "modules/downloads/cache/images/shots/");?></td>
</tr>
<tr>
<td class='bg3'><b><?php echo _MD_DLSTATUS; ?></b></td>
<td class='bg1'><select name="dlstatus" id="dlstatus" class="select">
<option value="3"<?php if ( intval($status) == 3 ) { echo " selected"; } ?>><?php echo _MD_DLSTATUSNORMAL; ?></option>
<option value="1"<?php if ( intval($status) == 1 ) { echo " selected"; } ?>><?php echo _MD_DLSTATUSNEW; ?></option>
<option value="2"<?php if ( intval($status) == 2 ) { echo " selected"; } ?>><?php echo _MD_DLSTATUSUPDATED; ?></option>
</select></td>
</tr>
<tr valign='top'>
<td class='bg3'>
<input type="hidden" name="lid" value="<?php echo $lid;?>" />
<input type="hidden" name="op" value="modDownloadS" />
<input type="submit" class="button" value="<?php echo _SUBMIT;?>" />
</form>
</td>
<td class='bg1'>
<table><tr >
<td><?php echo myTextForm("index.php?op=delDownload&lid=$lid" , _DELETE);?></td>
<td><?php echo myTextForm("index.php?op=downloadsConfigMenu", _CANCEL);?></td>
</tr></table>
</td>
</tr>
</table></td></tr></table>
<br /><br />
<?php
$result5 = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_votedata")."");
list($totalvotes) = $db->fetch_row($result5);
echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'><tr class='bg3'><td colspan='7'><b>";
printf(_MD_DLRATINGS, $totalvotes);
echo "</b><br /><br /></td></tr>";
// Show Registered Users Votes
$result5 = $db->query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM ".$db->prefix("downloads_votedata")." WHERE lid = ".sql_safe($lid)." AND ratinguser != 0 ORDER BY ratingtimestamp DESC");
$votes   = $db->num_rows($result5);
echo "<tr class='bg3'><td colspan='7'><br /><br /><b>";
printf(_MD_REGUSERVOTES, $votes);
echo "
</b><br /><br /></td>
</tr><tr class='bg3'>
<td><b>"._MD_USER."</b></td>
<td><b>"._MD_IP."</b></td>
<td><b>"._MD_RATING."</b></td>
<td><b>"._MD_USERAVG."</b></td>
<td><b>"._MD_TOTALRATE."</b></td>
<td><b>"._MD_DATE."</b></td>
<td style='text-align: center;'><b>"._DELETE."</b></td>
</tr>";
if ($votes == 0) {
   echo "<tr class='bg3'><td style='text-align: center;' colspan='7'>"._MD_NOREGVOTES."<br /></td></tr>";
}
$x=0;
$colorswitch = "bg1";
while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp)=$db->fetch_row($result5)) {
   $formatted_date = formatTimestamp($ratingtimestamp, "s");
   $result2        = $db->query("SELECT rating FROM ".$db->prefix("downloads_votedata")." WHERE ratinguser=$ratinguser");
   $uservotes      = $db->num_rows($result2);
   $useravgrating  = 0;
   while (list($rating2) = $db->fetch_row($result2))
   {
      $useravgrating = ($useravgrating + $rating2);
   }
   $useravgrating = ($useravgrating / $uservotes);
   $useravgrating = number_format($useravgrating, 1);
   $ratinguname   = RcxUser::getUnameFromId($ratinguser);
   echo "<tr class='bg3'>
  <td class='$colorswitch'>$ratinguname</td>
  <td class='$colorswitch'>$ratinghostname</td>
  <td class='$colorswitch'>$rating</td>
  <td class='$colorswitch'>$useravgrating</td>
  <td class='$colorswitch'>$uservotes</td>
  <td class='$colorswitch'>$formatted_date</td>
  <td class='$colorswitch' style='text-align: center;'>";
   echo myTextForm("index.php?op=delVote&lid=$lid&rid=$ratingid", "X");
   echo "</td></tr>";
   $x++;
   if ($colorswitch == "bg1")
   {
      $colorswitch = "bg3";
   }
   else
   {
      $colorswitch = "bg1";
   }
}
// Show Unregistered Users Votes
$result5 = $db->query("SELECT ratingid, rating, ratinghostname, ratingtimestamp FROM ".$db->prefix("downloads_votedata")." WHERE lid = $lid AND ratinguser = 0 ORDER BY ratingtimestamp DESC");
$votes   = $db->num_rows($result5);
echo "<tr class='bg3'><td colspan='7'><br /><br /><b>";
printf(_MD_ANONUSERVOTES, $votes);
echo "
</b><br /><br /></td>
</tr><tr class='bg3'>
<td colspan='2'><b>"._MD_IP."</b></td>
<td colspan='3'><b>"._MD_RATING."</b></td>
<td><b>"._MD_DATE."</b></td>
<td style='text-align: center;'><b>"._DELETE."</b></td>
</tr>";
if ($votes == 0) {
   echo "<tr class='bg3'><td colspan='7' style='text-align: center;'>"._MD_NOUNREGVOTES."</td></tr>";
}
$x=0;
$colorswitch = "bg1";
while (list($ratingid, $rating, $ratinghostname, $ratingtimestamp) = $db->fetch_row($result5)) {
   $formatted_date = formatTimestamp($ratingtimestamp, "s");
   echo "
  <td colspan='2' class='$colorswitch'>$ratinghostname</td>
  <td colspan='3' class='$colorswitch'>$rating</td>
  <td class='$colorswitch'>$formatted_date</td>
  <td class='$colorswitch' style='text-align: center;'>";
   echo myTextForm("index.php?op=delVote&lid=$lid&rid=$ratingid", "X");
   echo "</td></tr>";
   $x++;
   if ($colorswitch == "bg1") {
      $colorswitch = "bg3";
   } else {
      $colorswitch="bg1";
   }
}
echo "<tr class='bg3'><td colspan='7'>&nbsp;</td></tr></table></td></tr></table>";
CloseTable();
rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function modDownloadS()
{
   global $db, $myts, $eh, $_POST, $_FILES, $rcxModule;
   $groups  = RcxDownload::makeTboxData4SaveGroups($_POST["group_ids"]);
  $cid         = intval($_POST['cid']);
$lid         = intval($_POST['lid']);
$homepage    = formatURL($myts->makeTboxData4Save($_POST["homepage"]));
$url         = $myts->makeTboxData4Save($_POST["url"]);
$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$version     = $myts->makeTboxData4Save($_POST["version"]);
$platform    = $myts->makeTboxData4Save($_POST["platform"]);
$description = $myts->makeTboxData4Save($_POST["filedesc"]);
$size        = intval($_POST['size']);
$dlstatus	 = intval($_POST['dlstatus']);
   // Check if Title is empty
   if ( empty($title) ) {
      redirect_header("index.php?op=modDownload&lid=$lid", 3, _MD_ERRORTITLE);
      exit();
   }
   // Check if Description is empty
   if ( empty($description) ) {
      redirect_header("index.php?op=modDownload&lid=$lid", 3, _MD_ERRORDESC);
      exit();
   }
   if ( empty($size) || !is_numeric($size) ) {
      $size = 0;
   }
   if ( !empty($_FILES['download']['name']) || !empty($_FILES['image']['name']) ) {
      $upload = new fileupload();
      $upload->set_upload_dir('../cache/files/', 'download');
      $upload->set_overwrite(1, 'download');
      $upload->set_upload_dir('../cache/shots/', 'image');
      $upload->set_basename($lid, 'image');
      $upload->set_overwrite(2, 'image');
      $result = $upload->upload();
      if (!empty($_FILES['download']['name'])) {
         if ($result['download']['filename']) {
            $url  = $result['download']['filename'];
            $size = $result['download']['size'];
         } else {
            redirect_header("index.php?op=modDownload&lid=$lid", 3, $upload->errors());
            exit();
         }
      }
      if ( !empty($_FILES['image']['name']) ) {
         if ($result['image']['filename']) {
            $logourl = $result['image']['filename'];
         } else {
            redirect_header("index.php?op=modDownload&lid=$lid", 3, $upload->errors());
            exit();
         }
      }
   }
   // Check if URL is empty
   if ( empty($url) ) {
      redirect_header("index.php?op=modDownload&lid=$lid", 3, _MD_ERRORURL);
      exit();
   }
   $updtime = time();
   $sql = "UPDATE ".$db->prefix("downloads_downloads")." SET cid=$cid, title='$title', groups='$groups', description='$description', url='$url',homepage='$homepage',version='$version',size='$size',platform='$platform',logourl='$logourl',status=".$dlstatus." ,date=".$updtime." WHERE lid=$lid";
   $db->query($sql) or $eh->show("0013");
   build_rss();
   redirect_header("index.php", 1, _UPDATED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function approve()
{
   global $rcxConfig, $db, $_POST, $myts, $eh, $meta;
   $lid = intval($_POST['lid']);
   $cid = intval($_POST['cid']);

   if ( empty($cid) )
   {
      $cid = 0;
   }
 $groups	 = RcxDownload::makeTboxData4SaveGroups($_POST["group_ids"]);
$homepage    = formatURL($myts->makeTboxData4Save($_POST["homepage"]));
$url         = $myts->makeTboxData4Save($_POST["url"]);
$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$version     = $myts->makeTboxData4Save($_POST["version"]);
$size        = $myts->makeTboxData4Save($_POST["size"]);
$platform    = $myts->makeTboxData4Save($_POST["platform"]);
$description = $myts->makeTboxData4Save($_POST["filedesc"]);

   $query = "UPDATE
  ".$db->prefix("downloads_downloads")."
  SET
  cid=$cid,
  title='$title',
  groups='$groups',
  description='$description',
  url='$url',
  homepage='$homepage',
  version='$version',
  size='$size',
  platform='$platform',
  logourl='$logourl',
  status=1,
  date=".time()."
  WHERE
  lid=$lid";

   $db->query($query) or $eh->show("0013");
   $result = $db->query("SELECT submitter FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid");
   list($submitter) = $db->fetch_row($result);
   $submitter = New RcxUser($submitter);
	   $subject   = sprintf(_MD_YOURFILEAT, $meta['title']);
	   $message   = sprintf(_MD_HELLO, $submitter->uname());
	   $message  .= "\n\n"._MD_WEAPPROVED."\n\n";
	   $siteurl   = RCX_URL."/modules/downloads/";
	   $message  .= sprintf(_MD_VISITAT, $siteurl);
	   $message  .= "\n\n"._MD_THANKSSUBMIT."\n\n".$meta['title']."\n".RCX_URL."\n".$rcxConfig['adminmail']."";
	   $rcxMailer =& getMailer();
	   $rcxMailer->useMail();
	   $rcxMailer->setToEmails($submitter->getVar("email"));
	   $rcxMailer->setFromEmail($rcxConfig['adminmail']);
	   $rcxMailer->setFromName($meta['title']);
	   $rcxMailer->setSubject($subject);
	   $rcxMailer->setBody($message);
	   $rcxMailer->send();
   
   build_rss();
   redirect_header("./index.php?op=listNewDownloads", 1, _MD_NEWDLADDED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function downloadsConfigAdmin()
{
   global $myts, $downloadsConfig;
   include_once(RCX_ROOT_PATH.'/class/form/formselectgroup.php');
   $gselect = new RcxFormSelectGroup('', 'aa_groups', true, explode(",", $downloadsConfig['autoapp_groups']), 5, true);
   rcx_cp_header();
   
   echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_GENERALSET.'</div>
            <br />
            <br />';
   
   OpenTable();
?>
<form action="index.php" method="post">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

<tr valign='top'>
<td class='bg3'><?php echo _MD_DLSPERPAGE;?></td>
<td class='bg1'>
<select class="select" name="perpage">
<option value="<?php echo $downloadsConfig['perpage'];?>" selected="selected"><?php echo $downloadsConfig['perpage'];?></option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="50">50</option>
</select>
</td>
</tr><tr valign='top'>
<td class='bg3'><?php echo _MD_HITSPOP;?></td>
<td class='bg1'>
<select class="select" name="popular">
<option value="<?php echo $downloadsConfig['popular'];?>" selected="selected"><?php echo $downloadsConfig['popular'];?></option>
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
<option value="500">500</option>
<option value="1000">1000</option>
</select>
</td>
</tr><tr valign='top'>
<td class='bg3'><?php echo _MD_DLSNEW;?></td>
<td class='bg1'>
<select class="select" name="newdownloads">
<option value="<?php echo $downloadsConfig['newdownloads'];?>" selected="selected"><?php echo $downloadsConfig['newdownloads'];?></option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="50">50</option>
</select>
</td>
</tr>
<tr valign='top'>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['allow_upload'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _UPLOADENABLE;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="allow_upload" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="allow_upload" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr>
<tr valign='top'>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['check_external'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _AM_CHECK_EXTERNAL;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="check_external" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="check_external" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr>
<tr valign='top'>
<td colspan="2">&nbsp;</td></tr>
<tr valign='top'>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['anon_add'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _AM_ANON_ADD;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="anon_add" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="anon_add" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr>
<tr valign='top'>
<td class='bg3'><?php echo _UPLOADACCEPTED;?></td>
<td class='bg1'>
<input type="text" class="text" size="30" name="accepted_files" value="<?php echo $downloadsConfig['accepted_files'];?>" />
</td></tr><tr valign='top'>
<td class='bg3'><?php echo _UPLOADLIMIT;?></td>
<td class='bg1'>
<input type="text" class="text" size="10" name="upload_limit" value="<?php echo $downloadsConfig['upload_limit']/1024;?>" /> <?php echo _KBYTES;?>
</td></tr>
<tr valign='top'>
<td colspan="2">&nbsp;</td></tr><tr>
<tr valign='top'>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['useshots'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _MD_USESHOTS;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="useshots" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="useshots" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td>
</tr><tr valign='top'>
<td class='bg3'><?php echo _MD_IMGWIDTH;?></td>
<td class='bg1'>
<input type="text" class="text" size="10" name="shotwidth" value="<?php echo $downloadsConfig['shotwidth'];?>" />
</td>
</tr>
<tr valign='top'>
<td class='bg3'><?php echo _MD_SHOT_UPLOAD_LIMIT;?></td>
<td class='bg1'>
<input type="text" class="text" size="10" name="shot_upload_limit" value="<?php echo $downloadsConfig['shot_upload_limit'];?>" /> <?php echo _KBYTES;?>
</td></tr>
<tr valign='top'>
<td class='bg3'><?php echo _MD_SHOT_UPLOAD_ACCEPTED;?></td>
<td class='bg1'>
<input type="text" class="text" size="30" name="shot_accepted_files" value="<?php echo $downloadsConfig['shot_accepted_files'];?>" />
</td>
<tr valign='top'>
<td colspan="2">&nbsp;</td></tr><tr>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['pad_file_prefilling'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _AM_USE_PAD_FILE_PREFILLING;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="pad_file_prefilling" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="pad_file_prefilling" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr><tr valign='top'>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['validate_pad_file'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _AM_USE_VALIDATE_PAD_FILE;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="validate_pad_file" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="validate_pad_file" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr><tr valign='top'>
<td colspan="2">&nbsp;</td>
</tr><tr valign='top'>
<?php
$chk1 = ''; $chk0 = '';
($downloadsConfig['rss_enable'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td class='bg3'><?php echo _AM_RSS_ENABLE;?></td>
<td class='bg1'>
<input type="radio" class="radio" name="rss_enable" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="rss_enable" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr><tr valign='top'>
<td class='bg3'><?php echo _AM_RSS_MAXITEMS;?></td>
<td class='bg1'>
<select class="select" name="rss_maxitems">
<option value="<?php echo $downloadsConfig['rss_maxitems'];?>" selected="selected"><?php echo $downloadsConfig['rss_maxitems'];?></option>
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
</select>
</td></tr><tr valign='top'>
<td class='bg3'><?php echo _AM_RSS_MAXDESCRIPTION;?></td>
<td class='bg1'>
<select class="select" name="rss_maxdescription">
<option value="<?php echo $downloadsConfig['rss_maxdescription'];?>" selected="selected"><?php echo $downloadsConfig['rss_maxdescription'];?></option>
<option value="50">50</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="250">250</option>
<option value="300">300</option>
</select>
</td></tr><tr valign='top'>
<td colspan="2">&nbsp;</td>
</tr><tr>
<td class='bg3'><?php echo _AM_DISCLAIMER;?></td>
<td class='bg1'>
<?php
$disclaimer = join('', file("../cache/disclaimer.php"));
$disclaimer = $myts->makeTboxData4PreviewInForm($disclaimer);
$desc       = new RcxFormDhtmlTextArea('', 'disclaimer', $disclaimer);
echo $desc->render();
?>
</td></tr><tr valign='top'>
<td colspan="2">
<input type="hidden" name="op" value="downloadsConfigChange">
<input type="submit" class="button" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)">
</td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();

echo "                        
        </td>
    </tr>
</table>";
rcx_cp_footer();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function downloadsConfigChange()
{
   global  $myts;
   $content  = "<?php\n";
   $content .= "\$downloadsConfig['popular']            = ".intval($_POST['popular']).";\n";
   $content .= "\$downloadsConfig['newdownloads']       = ".intval($_POST['newdownloads']).";\n";
   $content .= "\$downloadsConfig['perpage']            = ".intval($_POST['perpage']).";\n";
   $content .= "\$downloadsConfig['useshots']           = ".intval($_POST['useshots']).";\n";
   $content .= "\$downloadsConfig['shotwidth']          = ".intval($_POST['shotwidth']).";\n";
   $content .= "\$downloadsConfig['anon_add']           = ".intval($_POST['anon_add']).";\n";
   $content .= "\$downloadsConfig['check_external']     = ".intval($_POST['check_external']).";\n";
   $content .= "\$downloadsConfig['rss_enable']         = ".intval($_POST['rss_enable']).";\n";
   $content .= "\$downloadsConfig['rss_maxitems']       = ".intval($_POST['rss_maxitems']).";\n";
   $content .= "\$downloadsConfig['rss_maxdescription'] = ".intval($_POST['rss_maxdescription']).";\n";
   $content .= "\$downloadsConfig['allow_upload']       = ".intval($_POST['allow_upload']).";\n";
   $content .= "\$downloadsConfig['accepted_files']     = '".$myts->stripPHP($myts->oopsStripSlashesGPC($_POST['accepted_files']))."';\n";
   $content .= "\$downloadsConfig['upload_limit']       = ".(intval($_POST['upload_limit'])*1024).";\n";
   $content .= "\$downloadsConfig['pad_file_prefilling']     = ".intval($_POST['pad_file_prefilling']).";\n";
   $content .= "\$downloadsConfig['validate_pad_file']     = ".intval($_POST['validate_pad_file']).";\n";
   $content .= "\$downloadsConfig['shot_upload_limit']     = ".intval($_POST['shot_upload_limit']).";\n";
   $content .= "\$downloadsConfig['shot_accepted_files']     = '".$myts->stripPHP($myts->oopsStripSlashesGPC($_POST['shot_accepted_files']))."';\n";
   $content .= "?>";
   $filename = "../cache/config.php";
   if ( $file = fopen($filename, "w") ) {
      fwrite($file, $content);
      fclose($file);
   } else {
      redirect_header("index.php", 1, _NOTUPDATED);
      exit();
   }
   $filename = "../cache/disclaimer.php";
   if ( $file = fopen($filename, "wb") ) {
      $disclaimer = $myts->oopsStripSlashesGPC($_POST['disclaimer']);
      $disclaimer = $myts->stripPHP($disclaimer);
      fwrite($file, $disclaimer);
      fclose($file);
   } else {
      redirect_header("index.php", 1, _NOTUPDATED);
      exit();
   }
   redirect_header("index.php", 1, _UPDATED);
   exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function build_rss()
{
   global $db, $downloadsConfig;
   if ($downloadsConfig['rss_enable'] == 1) {
      $SQL= "SELECT title, lid, version, description FROM ".$db->prefix("downloads_downloads")." WHERE status <> 0 ORDER BY date DESC";
      $query = $db->query($SQL, $downloadsConfig['rss_maxitems']);
      if ($query) {
         $rss = new xml_rss(RCX_ROOT_PATH. '/modules/downloads/cache/downloads.xml');
         $rss->channel_title       .= " :: " . _MI_DOWNLOADS_NAME;
         $rss->image_title         .= " :: " . _MI_DOWNLOADS_NAME;
         $rss->max_items            = $downloadsConfig['rss_maxitems'];
         $rss->max_item_description = $downloadsConfig['rss_maxdescription'];

         while ( list($title, $link, $version, $description) = $db->fetch_row($query) ) {
            $link = 'visit.php?lid='.$link;
            if ( !empty($version) ) { $title .= " - ".$version; }
            $rss->build($title, $link, $description);
         }
         $rss->save();
      }
   }
}

switch($_REQUEST['op'])
{
   case "delNewDownload":
      delNewDownload();
      break;
   case "approve":
      approve();
      break;
   case "addCat":
      addCat();
      break;
   case "addSubCat":
      addSubCat();
      break;
   case "addDownload":
      addDownload();
      break;
   case "listBrokenDownloads":
      listBrokenDownloads();
      break;
   case "delBrokenDownloads":
      delBrokenDownloads();
      break;
   case "ignoreBrokenDownloads":
      ignoreBrokenDownloads();
      break;
   case "listModReq":
      listModReq();
      break;
   case "changeModReq":
      changeModReq();
      break;
   case "ignoreModReq":
      ignoreModReq();
      break;
   case "delCat":
      delCat();
      break;
   case "modCat":
      modCat();
      break;
   case "modCatS":
      modCatS();
      break;
   case "modDownload":
      modDownload();
      break;
   case "modDownloadS":
      modDownloadS();
      break;
   case "delDownload":
      delDownload();
      break;
   case "delVote":
      delVote();
      break;
   case "downloadsConfigAdmin":
      downloadsConfigAdmin();
      break;
   case "downloadsConfigChange":
      downloadsConfigChange();
      break;
   case "downloadsConfigMenu":
      downloadsConfigMenu();
      break;
   case "listNewDownloads":
      listNewDownloads();
      break;
   default:
      downloads();
      break;
}
?>
