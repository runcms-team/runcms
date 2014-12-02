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
        if ( !$rcxUser && empty($linksConfig['anon_add']) ) {
                redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
                exit();
        }

if ( empty($_POST['submitter']) ) {
        if (!$rcxUser) {
                $submitter = 0;
                } else {
                        $submitter = $rcxUser->uid();
                }
        }

$cid         = intval($_POST['cid']);
$url         = formatURL($myts->makeTboxData4Save($_POST['url']));
$title       = $myts->makeTboxData4Save($_POST['title']);
$email       = $myts->makeTboxData4Save($_POST['email']);
$description = $myts->makeTboxData4Save($_POST['linkdesc']);
$date        = time();

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
$newid = $db->genId($db->prefix("links_links")."_lid_seq");
$sql   = "INSERT INTO ".$db->prefix("links_links")." VALUES (
        ".intval($newid).",
        ".intval($cid).",
        '$title',
        '$description',
        '$url',
        '$email',
        '$url',
        ".intval($submitter).",
        0,
        ".time().",
        0,
        0,
        0,
        0)";


$db->query($sql) or $eh->show("0013");
redirect_header("index.php", 2, _MD_RECEIVED."<br />"._MD_WHENAPPROVED."");
exit();

} else {
        if ( !$rcxUser && empty($linksConfig['anon_add']) ) {
                redirect_header(RCX_URL."/user.php", 2, _MD_MUSTREGFIRST);
                exit();
        }

include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
mainheader();

if (!$rcxUser) {
        $uid   = 0;
        $email = '';
        $lock  = 'text';
        } else {
                $uid   = $rcxUser->uid();
                $email = $rcxUser->getVar("email");
                $lock  = 'hidden';
        }

$disclaimer = join('', file("./cache/disclaimer.php"));
$myts->setType('admin');
echo $myts->makeTareaData4Show($disclaimer, 1, 1, 1)."<br /><br />";
OpenTable();
?>

<h3><?php echo _MD_ADDNEWLINK;?></h3>
<form action="submit.php" method="post">
<table width="80%"><tr>
<td align="right" nowrap>*<b><?php echo _MD_SITETITLE;?></b></td>
<td><input type="text" class="text" name="title" size="50" maxlength="100" /></td>
</tr><tr>
<td align="right" nowrap>*<b><?php echo _MD_SITEURL;?></b></td>
<td><input type="text" class="text" name="url" size="50" maxlength="255" value="http://" /></td>
</tr><tr>
<td align="right" nowrap><b><?php echo _MD_CATEGORYC;?></b></td>
<td><?php echo $mytree->makeMySelBox("title", "title");?></td>
</tr><tr>
<td align="right" nowrap><b><?php echo _MD_CONTACTEMAIL;?></b></td>
<td><input type="<?php echo $lock;?>" name="email" value="<?php echo $email;?>" size="50" maxlength="60" /><?php echo $email;?></td>
</tr><tr>
<td align="right" valign="top" nowrap>*<b><?php echo _MD_DESCRIPTIONC;?></b></td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'linkdesc', '', 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'linkdesc', '');
echo $desc->render();
?>
</td>
</tr>
</table>
<div align="center">
<input type="hidden" name="submitter" value="<?php echo $uid;?>" />
<input type="submit" class="button" name="submit" value="<?php echo _SUBMIT;?>" />
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)" />
</div>
</form>

<?php
CloseTable();
CloseTable();
}

include_once("footer.php");
?>