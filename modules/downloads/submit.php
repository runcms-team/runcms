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

global $downloadsConfig, $rcxUser;

$eh     = new ErrorHandler();
$mytree = new RcxTree($db->prefix("downloads_cat"), "cid", "pid");
if ( !empty($_POST['submit']) ) {
  if ( !$rcxUser && empty($downloadsConfig['anon_add']) ) {
    redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
    exit();
  }
if ( empty($_POST['submitter']) ) {
  if (!$rcxUser) {
    $submitter = 0;
    } else {
      $submitter = $rcxUser->uid();
    }
     } else {
    $submitter = (int)$_POST['submitter'];
}
if ( !empty($_POST['cid']) ) {
  $cid = intval($_POST['cid']);
  } else {
    $cid = 0;
  }
$url         = formatURL($myts->makeTboxData4Save($_POST['url']));
$homepage    = formatURL($myts->makeTboxData4Save($_POST['homepage']));
$title       = $myts->makeTboxData4Save($_POST['title']);
$version     = $myts->makeTboxData4Save($_POST['version']);
$platform    = $myts->makeTboxData4Save($_POST['platform']);
$description = $myts->makeTboxData4Save($_POST['filedesc']);

$size        = $_POST["size"];
$date        = time();
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
      $upload->set_upload_dir('./cache/files/', 'download');
      $upload->set_max_file_size($downloadsConfig['upload_limit']);
      $upload->set_accepted($downloadsConfig['accepted_files'], 'download');
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
          redirect_header('submit.php', 4, $upload->errors());
          exit();
      }
  }
    
   if (!empty($_FILES['image']['name']) && $downloadsConfig['useshots'] == 1) {
       if ($result['image']['filename']) {
           $logourl = $result['image']['filename'];
       } else {
           @unlink(RCX_ROOT_PATH."/modules/downloads/cache/files/" . basename($url));
           redirect_header("submit.php", 4, $upload->errors());
           exit();
       }
   }
}
if ( empty($url) ) {
  $eh->show("1016");
}
$newid = $db->genId($db->prefix("downloads_downloads")."_lid_seq");
$sql   = "
  INSERT INTO ".$db->prefix("downloads_downloads")." SET
  lid=$newid,
  cid=$cid,
  title='$title',
  description='$description',
  url='$url',
  homepage='$homepage',
  version='$version',
  size='$size',
  platform='$platform', 
  logourl='$logourl', 
  submitter=$submitter,
  status=0,
  date=$date,
  hits=0,
  rating=0,
  votes=0";

  $db->query($sql) or $eh->show("0013");
  redirect_header("index.php", 2, _MD_RECEIVED."<br />"._MD_WHENAPPROVED."");
  exit();
} else {
  if ( !$rcxUser && empty($downloadsConfig['anon_add']) ) {
    redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
    exit();
  }
  
$pad_url = $_POST["pad_url"] ? $_POST["pad_url"] : "http://";
$pad_array = ($downloadsConfig['pad_file_prefilling'] && $pad_url != "http://") ? parse_pad_file($pad_url, $downloadsConfig['validate_pad_file']) : get_pad_array();

if (!empty($pad_array['error'])) {
    redirect_header("submit.php", 3, $pad_array['error']);
    exit();
} 
                
include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
mainheader();
if (!$rcxUser) {
  $uid = 0;
  } else {
    $uid = $rcxUser->uid();
  }
$disclaimer = join('', file("./cache/disclaimer.php"));
$myts->setType('admin');
echo $myts->makeTareaData4Show($disclaimer, 1, 1, 1)."<br /><br />";
?>
<?php if ($downloadsConfig['pad_file_prefilling']):?>
<h4><?php echo _MD_ADDWITHPADFILE;?></h4><br />
<form method="POST" action="submit.php">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>

<tr valign='top'><td class='bg3'><b><?php echo _MD_PAD_URL;?></b></td>
<td class='bg1'><input type="text" class="text" name="pad_url" size="50" maxlength="100" value="<?php echo $myts->oopsHtmlSpecialChars($pad_url);?>"/>
<input type="submit" class="button" value="<?php echo _SUBMIT_PAD_FILE;?>" />
</td></tr></table></td></tr></table></form>
<?php endif;?>
<h3><?php echo _MD_ADDNEWFILE;?></h3>
<form action="submit.php" method="post"<?php if ($downloadsConfig['allow_upload'] == 1):?> enctype="multipart/form-data"<?php endif;?>>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
<td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'>
<tr valign='top'>
<td class='bg3'>*<b><?php echo _MD_FILETITLE;?></b></td>
<td class='bg1'><input type="text" class="text" name="title" size="50" maxlength="100" value="<?php echo $pad_array['title'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'>*<b><?php echo _MD_DLURL;?></b></td>
<td class='bg1'><input type="text" class="text" name="url" size="50" maxlength="255" value="<?php echo $pad_array['url'];?>">
<?php
if ($downloadsConfig['allow_upload'] == 1) {
  $upload = new fileupload();
  $upload->set_max_file_size($downloadsConfig['upload_limit'], 'download');
  echo "<br />";
  $upload->render(1, 'download');
  echo " <b>" . ($downloadsConfig['upload_limit']/1024) . "</b> " . _KBYTES . " " . _MAX;
}
?>
</td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_CATEGORY;?></b></td>
<td class='bg1'><?php echo $mytree->makeMySelBox("title", "title");?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_SITEURL;?></b></td>
<td class='bg1'><input type="text" class="text" name="homepage" size="50" maxlength="255" value="<?php echo $pad_array['homepage'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_VERSIONC;?></b></td>
<td class='bg1'><input type="text" class="text" name="version" size="10" maxlength="10" value="<?php echo $pad_array['version'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_FILESIZEC;?></b></td>
<td class='bg1'><input type="text" class="text" name="size" size="10" maxlength="8" value="<?php echo $pad_array['size'];?>"> <?php echo _BYTES;?></td>
</tr><tr valign='top'>
<td class='bg3'><b><?php echo _MD_PLATFORMC;?></b></td>
<td class='bg1'><input type="text" class="text" name="platform" size="45" maxlength="50" value="<?php echo $pad_array['platform'];?>"></td>
</tr><tr valign='top'>
<td class='bg3'>*<b><?php echo _MD_DESCRIPTIONC;?></b></td>
<td class='bg1'>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'filedesc', '',10,58);
$desc = new RcxFormDhtmlTextArea('', 'filedesc', $pad_array['filedesc']);
echo $desc->render();
?>
</td>
</tr>
<?php if($downloadsConfig['useshots'] == 1):?>
<tr valign='top'>
<td class='bg3'><b><?php echo _MD_SHOTIMAGE;?></b></td>
<td class='bg1'>
<?php
echo "<i>"._AM_ADDANIMAGE."</i><br /><br />";
?>
<input type="text" class="text" name="logourl" id="logourl" size="50" maxlength="255" value="<?php echo $pad_array['logourl'];?>">
<?php
if ($downloadsConfig['allow_upload'] == 1) {
    echo "<br />";
    $upload = new fileupload();
    $upload->set_max_file_size($downloadsConfig['shot_upload_limit'], 'kb','image');
    $upload->render(1, "image");
    echo " <b>" . ($downloadsConfig['shot_upload_limit']) . "</b> " . _KBYTES . " " . _MAX;
}
?>
<br /><br />
<?php printf(_MD_SHOT, "modules/downloads/cache/images/shots/");?></td>
</tr>
<?php endif;?>
<tr valign='top'><td class='bg3'></td><td class='bg1'>
<input type="hidden" name="submitter" value="<?php echo $uid;?>">
<input type="submit" class="button" name="submit" value="<?php echo _SUBMIT;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)"></td></tr>
</table></td></tr></table>
</form>
<?php
CloseTable();
}
include_once("footer.php");
?>
