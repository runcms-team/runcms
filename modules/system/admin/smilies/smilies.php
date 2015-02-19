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
function SmilesAdmin() {
global $db, $myts, $rcxModule;

$rcx_token = & RcxToken::getInstance();

$url_smiles = RCX_URL."/images/smilies";

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_CURRENTSMILE.'</div>
            <br />
            <br />';

OpenTable();
//echo "<h4 style='text-align:left;'>"._AM_CURRENTSMILE."</h4>";

if ($getsmiles = $db->query("SELECT * FROM ".$db->prefix("smiles"))) {
	if ($db->num_rows($getsmiles) > 0) {
		?>
		<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%"><tr>
		<td class="sysbg2">
		<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="sysbg3">
		<td><b><?php echo _AM_CODE;?></b></td>
		<td align="center"><b><?php echo _AM_SMILIE;?></b></td>
		<td align="center"><b><?php echo _AM_EMOTION;?></b></td>
		<td align="right"><b><?php echo _ACTION;?></b></td>
		</tr>
		<?php
		while ($smiles = $db->fetch_array($getsmiles)) {
			?>
			<tr class="sysbg1">
			<td><?php echo $myts->makeTboxData4Show($smiles['code']);?></td>
			<td align="center"><img src="<?php echo formatURL($url_smiles, $smiles['smile_url']);?>"></td>
			<td align="center"><?php echo $myts->makeTboxData4Show($smiles['emotion']);?></td>
			<td align="right"><a href="admin.php?fct=smilies&op=SmilesEdit&id=<?php echo $smiles['id'];?>"><?php echo _EDIT;?></a> | <a href="admin.php?fct=smilies&op=SmilesDel&id=<?php echo $smiles['id'];?>"><?php echo _DELETE;?></a></td>
			</tr>
			<?php
		}
		echo "</table></td></tr></table>";
	}
	} else {
		echo _AM_CNRFTSD;
	}
        
        
echo '<br /><br /><div class="KPstor" >'._AM_ADDSMILE.'</div>
            <br />
            <br />';

?>

<form action="admin.php" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" align="center"  width="100%"><tr>
<td class="sysbg2">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr>
<td class="sysbg3"><b><?php echo _AM_SMILECODE;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="code" /></td>
</tr><tr>
<td class="sysbg3" valign="top"><b><?php echo _AM_SMILEURL;?></b></td>
<td class="sysbg1">
<input type="text" class="text" name="smile_url" /> :: <input type="file" class="file" name="image" />
<br /><?php printf(_AM_VALIDUNDER, "images/smilies/");?>
</td>
</tr><tr>
<td class="sysbg3"><b><?php echo _AM_SMILEEMOTION;?></b></td>
<td class="sysbg1"><input type="text" class="text" name="emotion" /></td>
</tr><tr>
<td class="sysbg3">&nbsp;</td>
<td class="sysbg1">
<input type="hidden" name="fct" value="smilies" />
<input type="hidden" name="op" value="SmilesAdd" />
<?php echo $rcx_token->getTokenHTML();?>
<input type="submit" class="button" value="<?php echo _ADD;?>" />
</td></tr></table>
</td></tr></table>
</form><br /><br />
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
function SmilesEdit($id) {
global $db, $myts, $rcxModule;

$rcx_token = & RcxToken::getInstance();

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_EDITSMILE.'</div>
            <br />
            <br />';

OpenTable();
//echo "<h4 style='text-align:left;'>"._AM_EDITSMILE."</h4>";

if ($getsmiles = $db->query("SELECT * FROM ".$db->prefix("smiles")." WHERE id = $id")) {
	if ($smiles = $db->fetch_array($getsmiles)) {
		?>
		<form action="admin.php" method="post" enctype="multipart/form-data">
		<table border="0" cellpadding="0" cellspacing="0"  width="100%"><tr>
		<td class="sysbg2">
		<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr>
		<td class="sysbg3"><b><?php echo _AM_SMILECODE;?></b></td>
		<td class="sysbg1"><input type="text" class="text" name="code" value="<?php echo $myts->makeTboxData4Edit($smiles['code']);?>" /></td>
		</tr><tr>
		<td class="sysbg3"><b><?php echo _AM_SMILEURL;?></b></td>
		<td class="sysbg1">
		<input type="text" class="text" name="smile_url" value="<?php echo $myts->makeTboxData4Edit($smiles['smile_url']);?>" /> :: <input type="file" class="file" name="image" />
		<br /><?php printf(_AM_VALIDUNDER, "images/smilies/");?>
		</td>
		</tr><tr>
		<td class="sysbg3"><b><?php echo _AM_SMILEEMOTION;?></b></td>
		<td class="sysbg1"><input type="text" class="text" name="emotion" value="<?php echo $myts->makeTboxData4Edit($smiles['emotion']);?>" /></td>
		</tr><tr>
		<td class="sysbg3">
		<input type="hidden" name="id" value="<?php echo $smiles['id'];?>" />
		<input type="hidden" name="op" value="SmilesSave" />
		<input type="hidden" name="fct" value="smilies" />
		<?php echo $rcx_token->getTokenHTML();?>
		</td>
		<td class="sysbg1"><input type="submit" class="button" value="<?php echo _SAVE;?>" /></td>
		</tr></table>
		</td></tr></table>
		</form>
		<?php
	}
	} else {
		echo _AM_CNRFTSD;
	}

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
function SmilesAdd($code, $smile_url, $emotion) {
global $db, $myts, $_FILES;

$code      = $myts->makeTboxData4Save($code);
$smile_url = $myts->makeTboxData4Save($smile_url);
$emotion   = $myts->makeTboxData4Save($emotion);
$newid     = $db->genId($db->prefix("smilies")."_id_seq");

if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/images/smilies/", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if ($result['image']['filename']) {
		$smile_url = $result['image']['filename'];
	}
}

if ( !empty($code) && !empty($smile_url) ) {
	$db->query("INSERT INTO ".$db->prefix("smiles")." SET id=$newid, code='$code', smile_url='$smile_url', emotion='$emotion'");
	redirect_header("admin.php?fct=smilies&op=SmilesAdmin", 2, _UPDATED);
	} else {
		redirect_header("admin.php?fct=smilies&op=SmilesAdmin", 2, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function SmilesSave($id, $code, $smile_url, $emotion) {
global $db, $myts, $_FILES;

$code      = $myts->makeTboxData4Save($code);
$smile_url = $myts->makeTboxData4Save($smile_url);
$emotion   = $myts->makeTboxData4Save($emotion);

if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/images/smilies/", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if ($result['image']['filename']) {
		$smile_url = $result['image']['filename'];
	}
}

if ( !empty($code) && !empty($smile_url) ) {
	$db->query("UPDATE ".$db->prefix("smiles")." SET code='$code', smile_url='$smile_url', emotion = '$emotion' WHERE id = $id");
	redirect_header("admin.php?fct=smilies&op=SmilesAdmin", 2, _UPDATED);
	} else {
		redirect_header("admin.php?fct=smilies&op=SmilesAdmin", 2, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function SmilesDel($id, $ok=0) {
global $db, $rcxModule;

if ($ok==1) {
    
    $rcx_token = & RcxToken::getInstance();
  
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=smilies', 3, $rcx_token->getErrors(true));
        exit();
    }
    
	if ($result = $db->query("SELECT smile_url FROM ".$db->prefix("smiles")." where id=$id")) {
		list($smile) = $db->fetch_row($result);
		@unlink(RCX_ROOT_PATH."/images/smilies/".basename($smile));
	}
	$db->query("DELETE FROM ".$db->prefix("smiles")." where id=$id");
	redirect_header("admin.php?fct=smilies&op=SmilesAdmin", 2, _UPDATED);
	exit();
	} else {
		rcx_cp_header();
                
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPattention" >'._AM_WAYSYWTDTS.'</div>
            <br />
            <br />';
                
		OpenTable();
		echo "
		<table><tr><td>";
		echo myTextForm("admin.php?fct=smilies&op=SmilesDel&id=$id&ok=1", _YES, true);
		echo "</td><td>";
		echo myTextForm("admin.php?fct=smilies&op=SmileAdmin", _NO);
		echo "</td></tr></table><br /><br />";
		CloseTable();
                
                echo "                        
        </td>
    </tr>
</table>";
                
		rcx_cp_footer();
	}
}
} else {
	echo "Access Denied";
}
?>
