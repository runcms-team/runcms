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
 * @package     modules
 * @subpackage  downloads
 */

include_once("header.php");
include_once(RCX_ROOT_PATH."/class/fileupload.php");
include_once(RCX_ROOT_PATH."/class/module.errorhandler.php");
include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
include_once(RCX_ROOT_PATH."/class/groupaccess.php");

$lid         = intval($_REQUEST["lid"]);
$cid         = intval($_POST["cid"]);

if ( empty($lid) ) {
  redirect_header(RCX_URL."/modules/downloads",3);
  exit();
} elseif ( !RcxDownload::isAccessible($lid) ) {
  redirect_header(RCX_URL."/modules/downloads",3,_AM_DOWNLOADNOPERMS);
  exit();
}
$eh     = new ErrorHandler();
$mytree = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
if ( !empty($_POST['submit']) ) {
  if (!$rcxUser) {
    redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
    exit();
    } else {
      $modifysubmitter = $rcxUser->uid();
    }

$homepage    = formatURL($myts->makeTboxData4Save($_POST["homepage"]));
$url         = $myts->makeTboxData4Save($_POST["url"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$version     = $myts->makeTboxData4Save($_POST["version"]);
$platform    = $myts->makeTboxData4Save($_POST["platform"]);
$description = $myts->makeTboxData4Save($_POST["filedesc"]);

$size        = $_POST["size"];
$logourl     = $_POST["logourl"];
// Check if Title exist
if ( empty($title) ) {
  $eh->show("1001");
}
// Check if Description exist
if ( empty($description) ) {
  $eh->show("1008");
}
if ( empty($size) || !is_numeric($size) ) {
  $size = 0;
}
if (($downloadsConfig['allow_upload'] == 1) && (!empty($_FILES['download']['name']) || !empty($_FILES['image']['name']))) {
  $upload = new fileupload();
  
  if (!empty($_FILES['download']['name'])) {
      $upload->set_upload_dir("./cache/files/", 'download');
      $upload->set_accepted($downloadsConfig['accepted_files'], 'download');
      $upload->set_max_file_size($downloadsConfig['upload_limit']);
      $upload->set_overwrite(1, 'download');
  }
  
  if ($downloadsConfig['useshots'] == 1 && !empty($_FILES['image']['name'])) {
      $upload->set_upload_dir('./cache/shots/', 'image');
      $upload->set_max_file_size($downloadsConfig['shot_upload_limit'], 'kb', 'image');
      $upload->set_accepted($downloadsConfig['shot_accepted_files'], 'image');
      $upload->set_overwrite(1, 'image');
  }
  
  $result = $upload->upload();
  
  if (!empty($_FILES['download']['name'])) {
      if ($result['download']['filename']) {
          $url  = $result['download']['filename'];
          $size = $result['download']['size'];
      } else {
          redirect_header("modfile.php?lid=$lid", 3, $upload->errors());
          exit();
    }
  }
    
  if (!empty($_FILES['image']['name']) && $downloadsConfig['useshots'] == 1) {
      if ($result['image']['filename']) {
           $logourl = $result['image']['filename'];
      } else {
          @unlink(RC_MOD_PATH."/downloads/cache/files/" . basename($url));
          redirect_header("modfile.php?lid=$lid", 4, $upload->errors());
          exit();
      }
  }
}
// Check if URL exist
if ( empty($url) ) {
  $eh->show("1016");
}
$newid = $db->genId($db->prefix("downloads_mod")."_requestid_seq");
$sql   = "
  INSERT INTO
  ".$db->prefix("downloads_mod")."
  SET
  requestid=$newid,
  lid=$lid,
  cid=$cid,
  title='$title',
  url='$url',
  homepage='$homepage',
  version='$version',
  size='$size',
  platform='$platform',
  logourl='$logourl', 
  description='$description',
  modifysubmitter=$modifysubmitter";
$db->query($sql) or $eh->show("0013");
redirect_header("index.php", 2, _MD_THANKSFORINFO);
exit();
} else {
$lid = intval($_REQUEST['lid']);
if (!$rcxUser) {
  redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
  exit();
}

$pad_url = $_POST["pad_url"] ? $_POST["pad_url"] : "http://";
if ($downloadsConfig['pad_file_prefilling'] && $pad_url != "http://") {
    $pad_array = parse_pad_file($pad_url, $downloadsConfig['validate_pad_file']);
        if (!empty($pad_array['error'])) {
            redirect_header("modfile.php?lid=" . (int)$lid, 3, $pad_array['error']);
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
} else {
	$result = $db->query("SELECT cid, title, description, url, homepage, version, size, platform, submitter, logourl FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid AND status>0");
    list($cid, $title, $description, $url, $homepage, $version, $size, $platform, $submitter, $logourl) = $db->fetch_row($result);
    $title       = $myts->makeTboxData4Edit($title);
    $url         = $myts->makeTboxData4Edit($url);
    $homepage    = $myts->makeTboxData4Edit($homepage);
    $version     = $myts->makeTboxData4Edit($version);
    $size        = $myts->makeTboxData4Edit($size);
    $platform    = $myts->makeTboxData4Edit($platform);
    $description = $myts->makeTboxData4Edit($description);
    $logourl     = $myts->makeTboxData4Edit($logourl); 
}

include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
mainheader();
?>

<?php if ($downloadsConfig['pad_file_prefilling']):?>
<h4><?php echo _MD_MODIFY_WITHPADFILE;?></h4><br />
<form method="POST" action="modfile.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

<tr valign='top'><td class='bg3'><b><?php echo _MD_PAD_URL;?></b></td>
<td class='bg1'><input type="text" class="text" name="pad_url" size="50" maxlength="100" value="<?php echo $myts->oopsHtmlSpecialChars($pad_url);?>"/>
<input type="hidden" name="lid" value="<?php echo (int)$lid;?>" />
<input type="hidden" name="cid" value="<?php echo (int)$cid;?>" />
<input type="submit" class="button" value="<?php echo _SUBMIT_PAD_FILE;?>" />
</td></tr></table></td></tr></table></form>
<?php endif;?>

<h3><?php echo _MD_REQUESTMOD;?></h3>
<form action="modfile.php" <?php if ((($rcxUser->uid() == $submitter) || $rcxUser->isAdmin($rcxModule->mid())) && ($downloadsConfig['allow_upload'] == 1)):?>enctype="multipart/form-data"<?php endif;?> method="post">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

<tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILEID;?></b></td>
<td class='bg1'><?php echo $lid;?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILETITLE;?></b></td>
<td class='bg1'><input type="text" class="text" name="title" size="50" maxlength="100" value="<?php echo $title;?>" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_DLURL;?></b></td>
<td class='bg1'>
<input type="text" class="text" name="url" size="50" maxlength="255" value="<?php echo $url;?>" />
<?php
if ( (($rcxUser->uid() == $submitter) || $rcxUser->isAdmin($rcxModule->mid())) && ($downloadsConfig['allow_upload'] == 1) ) {
  $upload = new fileupload();
  $upload->set_max_file_size($downloadsConfig['upload_limit'], 'download');
  echo "<br />";
  $upload->render(1, 'download');
}
?>
</td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_CATEGORYC;?></b></td>
<td class='bg1'><?php $mytree->makeMySelBox("title", "title", $cid);?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_SITEURL;?></b></td>
<td class='bg1'><input type="text" class="text" name="homepage" size="50" maxlength="255" value="<?php echo $homepage;?>" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_VERSIONC;?></b></td>
<td class='bg1'><input type="text" class="text" name="version" size="10" maxlength="10" value="<?php echo $version;?>" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILESIZEC;?></b></td>
<td class='bg1'><input type="text" class="text" name="size" size="10" maxlength="8" value="<?php echo $size;?>" /> <?php echo _BYTES;?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_PLATFORMC;?></b></td>
<td class='bg1'><input type="text" class="text" name="platform" size="45" maxlength="50" value="<?php echo $platform;?>" /></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_DESCRIPTIONC;?></b></td>
<td class='bg1'>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'filedesc', $description, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'filedesc', $description);
echo $desc->render();
?>
</td>
</tr>
<?php if($downloadsConfig['useshots'] == 1):?>
<tr valign='top'>
<td class='bg3'><b><?php echo _MD_SHOTIMAGE;?></b></td>
<td class='bg1'>
<input type="text" class="text" name="logourl" id="logourl" size="50" maxlength="255" value="<?php echo $logourl;?>">
<?php
if ((($rcxUser->uid() == $submitter) || $rcxUser->isAdmin($rcxModule->mid())) && ($downloadsConfig['allow_upload'] == 1)) {
    echo "<br />";
    $upload = new fileupload();
    $upload->set_max_file_size($downloadsConfig['shot_upload_limit'], 'kb','image');
    $upload->render(1, "image");
    echo " <b>" . ($downloadsConfig['shot_upload_limit']) . "</b> " . _KBYTES . " " . _MAX;
}
?>
</td></tr>
<?php endif;?>
<tr valign='top'>
<td class='bg3'></td><td class='bg1'>
<input type="hidden" name="lid" value="<?php echo $lid;?>" />
<input name="submit" class="button" type="submit" value="<?php echo _SUBMIT;?>" />
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)" />
</td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
}
include_once("footer.php");
?>
