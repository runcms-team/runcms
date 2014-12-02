<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( $rcxUser->isAdmin($rcxModule->mid()) ) {

/**
* Description
*
* @param type $var description
* @return type description
*/
function RankForumAdmin() {
global $db, $rcxModule;

$rcx_token = & RcxToken::getInstance();

rcx_cp_header();
OpenTable();

?>
<h4 style="text-align:left;"><?php echo _AM_RANKSSETTINGS;?></h4>
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
<td class="sysbg2">

<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="sysbg3" align="center">

<td align="left"><b><?php echo _AM_TITLE;?></b></td>
<td><b><?php echo _AM_MINPOST;?></b></td>
<td><b><?php echo _AM_MAXPOST;?></b></td>
<td><b><?php echo _AM_IMAGE;?></b></td>
<td><b><?php echo _AM_SPERANK;?></b></td>
<td><b><?php echo _ACTION;?></b></td>
</tr>
<?php

$result = $db->query("SELECT * FROM ".$db->prefix("ranks")." ORDER BY rank_id");
while ($rank = $db->fetch_array($result)) {
	echo "
		<tr class='sysbg1' align='center'>
		<td align='left'>".$rank['rank_title']."</td>
		<td>".$rank['rank_min']."</td>
		<td>".$rank['rank_max']."</td>
		<td>";

	if ($rank['rank_image']) {
		echo "<img src='".formatURL(RCX_URL."/images/ranks/", $rank['rank_image'])."'></td>";
		} else {
			echo "&nbsp;";
		}

	if ($rank['rank_special'] == 1) {
		echo"<td>"._ON."</td>";
		} else {
			echo"<td>"._OFF."</td>";
		}

echo"<td><a href='admin.php?fct=userrank&amp;op=RankForumEdit&amp;rank_id=".$rank['rank_id']."'>"._EDIT."</a> | <a href='admin.php?fct=userrank&amp;op=RankForumDel&amp;rank_id=".$rank['rank_id']."&amp;ok=0'>"._DELETE."</a></td></tr>";
}

?>
</table></td>
</tr></table>

<br /><br />
<h4 style="text-align:left;"><?php echo _AM_ADDNEWRANK;?></h4>
<form action="admin.php" method="post" enctype="multipart/form-data">

<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
<td class="sysbg2">

<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr valign="top">
<td class="sysbg3"><b><?php echo _AM_RANKTITLE;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_title" size="30" maxlength="50" /></td>

</tr><tr valign="top">

<td class="sysbg3"><b><?php echo _AM_MINPOST;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_min" size="4" maxlength="5" /></td>

</tr><tr valign="top">

<td class="sysbg3"><b><?php echo _AM_MAXPOST;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_max" size="4" maxlength="5" /></td>

</tr><tr valign="top">

<td class="sysbg3"><b><?php echo _AM_IMAGE;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_image" size="30" maxlength="255" /> :: <input type="file" class="file" name="image" /><br />
<?php printf(_AM_VALIDUNDER, "images/ranks/");?>
</td>

</tr><tr valign="top">

<td class="sysbg3"><b><?php echo _AM_SPECIAL;?></b></td>
<td class="sysbg1"><input type="checkbox" class="checkbox" name="rank_special" value="1" /> <?php echo _AM_SPECIALCAN;?></td>

</tr><tr valign="top">

<td class="sysbg3">&nbsp;</td>
<td class="sysbg1"><input type="submit" class="button" value="<?php echo _ADD;?>" /></td>

</tr></table></td>
</tr></table>

<?php echo $rcx_token->getTokenHTML();?>

<input type="hidden" name="op" value="RankForumAdd" />
<input type="hidden" name="fct" value="userrank" />
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
function RankForumAdd($rank_title, $rank_min, $rank_max, $rank_image, $rank_special) {
global $db, $myts;

$rank_title = $myts->makeTboxData4Save($rank_title);
$rank_image = $myts->makeTboxData4Save($rank_image);

if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/images/ranks/", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if ($result['image']['filename']) {
		$rank_image = $result['image']['filename'];
	}
}

$newid = $db->genId($db->prefix("ranks")."_rank_id_seq");
if ($rank_special == 1) {
	$sql = "INSERT INTO ".$db->prefix("ranks")." SET rank_id=$newid, rank_title='$rank_title', rank_min=-1, rank_max=-1, rank_special=1, rank_image='$rank_image'";
	} else {
		$sql = "INSERT INTO ".$db->prefix("ranks")." SET rank_id=$newid, rank_title='$rank_title', rank_min='$rank_min', rank_max='$rank_max', rank_special=0, rank_image='$rank_image'";
	}

if ( !empty($rank_title) && $db->query($sql) ) {
	redirect_header("admin.php?fct=userrank&op=RankForumAdmin", 1, _UPDATED);
	} else {
		redirect_header("admin.php?fct=userrank&op=RankForumAdmin", 1, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function RankForumEdit($rank_id) {
global $db, $myts, $rcxModule;

$rcx_token = & RcxToken::getInstance();

rcx_cp_header();

$result = $db->query("SELECT * FROM ".$db->prefix("ranks")." WHERE rank_id=".$rank_id."");
$rank   = $db->fetch_array($result);
OpenTable();

?>
<h4 style="text-align:left;"><?php echo _AM_EDITRANK;?></h4>
<form action="admin.php" method="post" enctype="multipart/form-data">

<table border="0" cellpadding="0" cellspacing="0" align="center"  width="100%"><tr>

<td class="sysbg2">
<input type="hidden" name="rank_id" value="<?php echo $rank['rank_id'];?>" />

<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr valign="top" align="left">

<td class="sysbg3"><b><?php echo _AM_RANKTITLE;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_title" size="30" value="<?php echo $myts->makeTboxData4Edit($rank['rank_title']);?>" maxlength="50" /></td>

</tr><tr valign="top" align="left">

<td class="sysbg3"><b><?php echo _AM_IMAGE;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_image" size="30" maxlength="255" value="<?php echo $myts->makeTboxData4Edit($rank['rank_image']);?>" /> :: <input type="file" class="file" name="image" /><br />
<?php printf(_AM_VALIDUNDER, "images/ranks/");?>
</td>

</tr><tr valign="top" align="left">

<td class="sysbg3"><b><?php echo _AM_MINPOST;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_min" size="4" value="<?php echo $rank['rank_min'];?>" /></td>

</tr><tr valign="top" align="left">

<td class="sysbg3"><b><?php echo _AM_MAXPOST;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="rank_max" size="4" value="<?php echo $rank['rank_max'];?>" /></td>

</tr><tr valign="top" align="left">

<td class="sysbg3"><b><?php echo _AM_SPECIAL;?></b></td>
<td class="sysbg1">
<?php if ($rank['rank_special'] == 1) { $chk = " checked='checked'"; };?>
<input type="checkbox" class="checkbox" name="rank_special" value="1"<?php echo $chk;?> />
</td>

</tr><tr valign="top" align="left">

<td class="sysbg3">&nbsp;</td>
<td class="sysbg1"><input type="submit" class="button" value="<?php echo _SAVE;?>" /></td>

</tr></table></td>
</tr></table>

<?php echo $rcx_token->getTokenHTML();?>

<input type="hidden" name="op" value="RankForumSave" />
<input type="hidden" name="fct" value="userrank" />
</form><br /><br />
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
function RankForumSave($rank_id, $rank_title, $rank_min, $rank_max, $rank_image, $rank_special) {
global $db, $myts, $_FILES;

$rank_title = $myts->makeTboxData4Save($rank_title);
$rank_image = $myts->makeTboxData4Save($rank_image);

if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/images/ranks/", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if ($result['image']['filename']) {
		$rank_image = $result['image']['filename'];
	}
}

if ($rank_special != 1) {
	$sql = "UPDATE ".$db->prefix("ranks")." SET rank_title='$rank_title', rank_min='$rank_min', rank_max='$rank_max', rank_special=0, rank_image='$rank_image' WHERE rank_id=".$rank_id."";
	} else {
		$sql = "UPDATE ".$db->prefix("ranks")." SET rank_title='$rank_title', rank_min=-1, rank_max=-1, rank_special=1, rank_image='$rank_image' WHERE rank_id=".$rank_id."";
	}

if ( !empty($rank_title) && $db->query($sql) ) {
	redirect_header("admin.php?fct=userrank&op=RankForumAdmin", 1, _UPDATED);
	} else {
		redirect_header("admin.php?fct=userrank&op=RankForumAdmin", 1, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function RankForumDel($rank_id, $ok=0) {
global $db, $rcxModule;

if ($ok == 1) {
    
    $rcx_token = & RcxToken::getInstance();
  
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=userrank', 3, $rcx_token->getErrors(true));
        exit();
    }
    
	if ($result = $db->query("SELECT rank_image FROM ".$db->prefix("ranks")." where rank_id=$rank_id")) {
		list($rank_image) = $db->fetch_row($result);
		@unlink(RCX_ROOT_PATH."/images/ranks/".basename($rank_image));
	}
	$db->query("DELETE FROM ".$db->prefix("ranks")." WHERE rank_id=".$rank_id."");
	redirect_header("admin.php?fct=userrank&op=ForumAdmin", 1, _UPDATED);
	exit();
	} else {
		rcx_cp_header();
		OpenTable();
		echo "<br /><h4 style='color:#ff0000'>"._AM_WAYSYWTDTR."</h4><br /><table><tr><td>";
		echo myTextForm("admin.php?fct=userrank&amp;op=RankForumDel&amp;rank_id=$rank_id&amp;ok=1", _YES, true);
		echo "</td><td>";
		echo myTextForm("admin.php?fct=userrank&amp;op=RankForumAdmin", _NO);
		echo "</td></tr></table>";
		CloseTable();
	}

rcx_cp_footer();
}
} else {
	echo "Access Denied";
}
?>
