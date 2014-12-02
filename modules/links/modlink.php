<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("header.php");
include_once(RCX_ROOT_PATH."/class/module.errorhandler.php");
include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");

$eh     = new ErrorHandler();
$mytree = new RcxTree($db->prefix("links_cat"), "cid", "pid");

if ( !empty($_POST['submit']) ) {
        if (!$rcxUser) {
                redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
                exit();
                } else {
                        $modifysubmitter = $rcxUser->uid();
                }

$lid         = intval($_POST["lid"]);
$cid         = intval($_POST["cid"]);
$url         = formatURL($myts->makeTboxData4Save($_POST["url"]));
$title       = $myts->makeTboxData4Save($_POST["title"]);
$email       = $myts->makeTboxData4Save($_POST["email"]);
$description = $myts->makeTboxData4Save($_POST["linkdesc"]);

// Check if Title exist
if ( empty($title) ) {
        $eh->show("1001");
}

// Check if URL exist
if ( empty($url) ) {
        $eh->show("1016");
}

// Check if Description exist
if ( empty($description) ) {
        $eh->show("1008");
}

$newid = $db->genId($db->prefix("links_mod")."_requestid_seq");
$sql   = "
INSERT INTO 
  ".$db->prefix("links_mod")." 
  SET 
  requestid=$newid,
        lid=$lid,
        cid=$cid,
        title='$title',
        url='$url',
        email='$email',
        description='$description',
        modifysubmitter=$modifysubmitter";

$db->query($sql) or $eh->show("0013");
redirect_header("index.php", 2, _MD_THANKSFORINFO);
exit();

} else {

$lid = intval($_GET['lid']);

if (!$rcxUser) {
        redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
        exit();
}

include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
mainheader();

echo "<table align='center'>";
$result = $db->query("SELECT cid, title, description, url, email FROM ".$db->prefix("links_links")." WHERE lid=$lid AND status>0");
echo "<h4>"._MD_REQUESTMOD."</h4>";
list($cid, $title, $description, $url, $email) = $db->fetch_row($result);

$title       = $myts->makeTboxData4Edit($title);
$url         = $myts->makeTboxData4Edit($url);
$email       = $myts->makeTboxData4Edit($email);
$description = $myts->makeTboxData4Edit($description);

?>
<form action="modlink.php" method="post">
<table width="80%"><tr>
<td align="right"><?php echo _MD_LINKID;?></td>
<td><b><?php echo $lid;?></b></td>
</tr><tr>
<td align="right"><?php echo _MD_SITETITLE;?></td>
<td><input type="text" class="text" name="title" size="50" maxlength="100" value="<?php echo $title;?>" /></td>
</tr><tr>
<td align="right"><?php echo _MD_SITEURL;?></td>
<td><input type="text" class="text" name="url" size="50" maxlength="255" value="<?php echo $url;?>" /></td>
</tr><tr>
<td align="right"><?php echo _MD_CATEGORYC;?></td>
<td><?php $mytree->makeMySelBox("title", "title", $cid);?></td>
</tr><tr>
<td align="right"><?php echo _MD_CONTACTEMAIL;?></td>
<td><input type="text" class="text" name="email" size="50" maxlength="60" value="<?php echo $email;?>" /></td>
</tr><tr>
<td align="right" valign="top"><?php echo _MD_DESCRIPTIONC;?></td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'linkdesc', $description, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'linkdesc', $description);
echo $desc->render();
?>
</td>
</tr><tr>
<td colspan="2" align="center"><br />
<input type="hidden" name="lid" value="<?php echo $lid;?>" />
<input type="hidden" name="modifysubmitter" value="<?php echo $rcxUser->uid();?>" />
<input type="submit" class="button" name="submit" value="<?php echo _MD_SENDREQUEST;?>" />
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)" />
</form>
</td></tr></table>
<?php

CloseTable();
}

include_once("footer.php");
?>