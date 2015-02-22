<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("./admin_header.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function banner_admin() {
global $db, $myts;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_AM_BANS.'</div>
            <br />
            <br />';

// Show Active Banners


OpenTable();

?>

<div style="text-align:left"><b><?php echo _AM_CURACTBNR;?></b></div><br />

<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>


<td><?php echo _AM_BANNERID;?></td>
<td><?php echo _AM_SHOW;?></td>
<td><?php echo _AM_IMPRESION;?></td>
<td><?php echo _AM_IMPLEFT;?></td>
<td><?php echo _AM_CLICKS;?></td>
<td><?php echo _AM_NCLICKS;?></td>
<td><?php echo _AM_CLINAME;?></td>
<td><?php echo _AM_FUNCTION;?></td></tr>
<?php

$result = $db->query("SELECT bid, cid, imptotal, impmade, clicks, datestart, display FROM ".$db->prefix("banner_items")." WHERE dateend < 1 ORDER BY bid");

while (list($bid, $cid, $imptotal, $impmade, $clicks, $datestart, $display) = $db->fetch_row($result)) {
	$result2 = $db->query("SELECT cid, name FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
	list($cid, $name) = $db->fetch_row($result2);
	$name = $myts->makeTboxData4Show($name);
	if ( ($impmade == 0) || ($clicks == 0) ) {
		$percent = 0;
		} else {
			$percent = round(100 * ($clicks/$impmade), 2);
		}

if ( $imptotal == 0 ) {
	$left = _AM_UNLIMIT;
	} else {
		$left = ($imptotal-$impmade);
	}
?>
<tr class='sysbg1'>
<td><?php echo $bid;?></td>
<td><?php echo $display;?></td>
<td><?php echo $impmade;?></td>
<td><?php echo $left;?></td>
<td><?php echo $clicks;?></td>
<td><?php echo $percent;?>%</td>
<td><?php echo $name;?></td>
<td><a href="index.php?op=banner_edit&amp;bid=<?php echo $bid;?>"><?php echo _EDIT;?></a> | <a href="index.php?op=banner_delete&amp;bid=<?php echo $bid;?>&amp;ok=0"><?php echo _DELETE;?></a></td>
</tr>
<?php
}
echo "   </table></td>
    </tr></table>";
CloseTable();

// Show Finished Banners
echo "<br />";
OpenTable();

?>
<div style="text-align:left"><b><?php echo _AM_FINISHBNR;?></b></div><br />
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>

<td><?php echo _AM_BANNERID;?></td>
<td><?php echo _AM_SHOW;?></td>
<td><?php echo _AM_IMPD;?></td>
<td><?php echo _AM_CLICKS;?></td>
<td><?php echo _AM_NCLICKS;?></td>
<td><?php echo _AM_STARTDATE;?></td>
<td><?php echo _AM_ENDDATE;?></td>
<td><?php echo _AM_CLINAME;?></td>
<td><?php echo _AM_FUNCTION;?></td></tr>
<?php

$result = $db->query("SELECT bid, cid, impmade, clicks, datestart, dateend, display FROM ".$db->prefix("banner_items  ")." WHERE dateend > 1 ORDER BY bid");
while (list($bid, $cid, $impmade, $clicks, $datestart, $dateend, $display) = $db->fetch_row($result)) {
	$result2 = $db->query("SELECT cid, name FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
	list($cid, $name) = $db->fetch_row($result2);
	$name = $myts->makeTboxData4Show($name);
	if ( ($impmade == 0) || ($clicks == 0) ) {
		$percent = 0;
		} else {
			$percent = round(100 * ($clicks/$impmade), 2);
		}
	echo "
	<tr class='sysbg1'>
	<td>$bid</td>
	<td>$display</td>
	<td>$impmade</td>
	<td>$clicks</td>
	<td>$percent%</td>
	<td>".formatTimestamp($datestart, "m")."</td>
	<td>".formatTimestamp($dateend, "m")."</td>
	<td>$name</td>
	<td><a href='index.php?op=banner_edit&amp;bid=$bid'>"._EDIT."</a> | <a href='index.php?op=banner_delete&amp;bid=$bid&amp;ok=0'>"._DELETE."</a></td>
	</tr>";
	}

echo "    </table></td>
    </tr></table>";

CloseTable();
echo "<br />";
OpenTable();

?>
<div style="text-align:left"><b><?php echo _AM_ADVCLI;?></b></div><br />
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>


<td><?php echo _AM_BANNERID;?></td>
<td><?php echo _AM_CLINAME;?></td>
<td><?php echo _AM_ACTIVEBNR;?></td>
<td><?php echo _AM_CONTNAME;?></td>
<td><?php echo _AM_CONTMAIL;?></td>
<td><?php echo _AM_FUNCTION;?></td></tr>
<?php

$result = $db->query("SELECT cid, name, contact, email FROM ".$db->prefix("banner_clients")." ORDER BY cid");
while (list($cid, $name, $contact, $email) = $db->fetch_row($result)) {
	$name    = $myts->makeTboxData4Show($name);
	$contact = $myts->makeTboxData4Show($contact);
	$result2 = $db->query("SELECT COUNT(*) FROM ".$db->prefix("banner_items")." WHERE cid=$cid AND dateend < 1");
	list($numrows) = $db->fetch_row($result2);
	echo "
	<tr class='sysbg1'>
	<td>$cid</td>
	<td>$name</td>
	<td>$numrows</td>
	<td>$contact</td>
	<td>$email</td>
	<td><a href='index.php?op=banner_clientedit&cid=$cid'>"._EDIT."</a> | <a href='index.php?op=banner_clientdelete&cid=$cid'>"._DELETE."</a></td>
	</tr>";
}

echo "    </table></td>
    </tr></table>";
CloseTable();
echo "<br />";

// Add Banner
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("banner_clients"));
list($numrows) = $db->fetch_row($result);

if ( $numrows > 0 ) {
	OpenTable();
	echo"

            <div class='KPstor' >"._AM_ADDNWBNR."</div>
                <br />
            <br />
	<form action='index.php' method='post' enctype='multipart/form-data'>
	<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>


	<td >"._AM_CLINAMET."</td>
	<td><select class='select' name='cid'>";
	$result = $db->query("SELECT cid, name FROM ".$db->prefix("banner_clients"));
	while (list($cid, $name) = $db->fetch_row($result)) {
		$name = $myts->makeTboxData4Show($name);
		echo "<option value='$cid'>$name</option>";
}

?>
</select></td>

</tr><tr class='sysbg1'>
<td><?php echo _AM_IMPPURCHT;?></td>
<td><input type="text" class="text" name="imptotal" size="12" maxlength="11" /> 0 = <?php echo _AM_UNLIMIT;?></td>
</tr><tr class='sysbg1'>

<td><?php echo _AM_SHOW;?></td>
<td>
<select class="select" name="display">
<optgroup label="<?php echo _AM_SGLOBAL;?>">
<option value=""><?php echo _AM_CCODE;?></option>
<option value="N"><?php echo _AM_N;?></option>
<option value="A"><?php echo _AM_A;?></option>
<option value="BA"><?php echo _AM_BA;?></option>
</optgroup>

<optgroup label="<?php echo _AM_SSIDE;?>">
<option value="SL"><?php echo _AM_SL;?></option>
<option value="SR"><?php echo _AM_SR;?></option>
<option value="SLR"><?php echo _AM_SLR;?></option>
</optgroup>

<optgroup label="<?php echo _AM_SCENTER;?>">
<option value="CL"><?php echo _AM_CL;?></option>
<option value="CR"><?php echo _AM_CR;?></option>
<option value="CLR"><?php echo _AM_CLR;?></option>
<option value="CC"><?php echo _AM_CC;?></option>
<option value="CA"><?php echo _AM_CA;?></option>
</optgroup>
</select>
 <?php echo _AM_CCODE;?>: <input type="text" class="text" name="ccode" size="11" maxlength="10">
</td>
</tr><tr class='sysbg1'>
<td valign="top"><?php echo _AM_IMGURLT;?></td>
<td>
<input type="text" class="text" name="imageurl" size="35" maxlength="255" value="<?php echo $imageurl;?>" /> :: <input type="file" class="file" name="image" />
<br /><?php printf(_AM_IMGLOCATION, "/modules/banners/cache/banners/");?>
</td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_IMGALT;?></td>
<td><input type="text" class="text" name="imagealt" size="35" maxlength="255" value="<?php echo $imagealt;?>" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CLICKURLT;?></td>
<td><input type="text" class="text" name="clickurl" size="35" maxlength="255" value="<?php echo $clickurl;?>" /></td>
</tr><tr class='sysbg1'>
<td valign="top"><br /><?php echo _AM_CUSTOM;?> *</td>
<td><br /><textarea class="textarea" cols="55" rows="7" name="custom"><?php echo $custom;?></textarea></td>
</tr><tr class='sysbg1'>
<td colspan="2">
<br /><?php echo _AM_NCUSTOM;?><br /><br />
<input type="hidden" name="op" value="banner_add" />
<input type="submit" class="button" value="<?php echo _AM_ADDBNR;?>" />
</td>
    </tr></table></td>
    </tr></table></form>
<?php

CloseTable();
}

// Add Client
echo "<br />";

OpenTable();

?>
            <div class='KPstor' ><?php echo _AM_ADDNWCLI;?></div>
                <br />
            <br />
<form action="index.php" method="post">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>


<td><?php echo _AM_CLINAMET;?></td>
<td><input type="text" class="text" name="name" size="30" maxlength="30" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CONTNAMET;?></td>
<td><input type="text" class="text" name="contact" size="30" maxlength="30" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CONTMAILT;?></td>
<td><input type="text" class="text" name="email" size="30" maxlength="60" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CLILOGINT;?></td>
<td><input type="text" class="text" name="login" size="11" maxlength="10" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CLIPASST;?></td>
<td><input type="password" class="text" name="passwd" size="11" maxlength="10" /></td>
</tr><tr class='sysbg1'>
<td valign="top"><?php echo _AM_EXTINFO;?></td>
<td><textarea class="textarea" name="extrainfo" cols="50" rows="10" /></textarea></td>
</tr><tr class='sysbg1'>
<td colspan="2">
<input type="hidden" name="op" value="banner_addclient" />
<input type="submit" class="button" value="<?php echo _AM_ADDCLI;?>" />
</td>
    </tr></table></td>
    </tr></table></form>
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
function banner_add($cid, $imageurl, $imagealt, $clickurl, $imptotal, $display, $ccode, $custom) {
global $db, $myts, $_FILES;

$nowtime  = time();
$newid    = $db->genId($db->prefix("banner_items")."_bid_seq");
$imagealt = $myts->makeTboxData4Save($imagealt);
$custom   = $myts->makeTboxData4Save($custom);

if ( !empty($display) || !empty($ccode) ) {
	$display  = !empty($display) ? $myts->makeTboxData4Save($display) : $myts->makeTboxData4Save($ccode);
	} else {
		$display = "N";
	}

if ( !is_numeric($imptotal) ) {
	$imptotal = 0;
}

if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/modules/banners/cache/banners/", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if ($result['image']['filename']) {
		$imageurl = $result['image']['filename'];
		} else {
			redirect_header("index.php?op=banner_admin#top", 3, $upload->errors());
			exit();
		}
}

if ($result = $db->query("INSERT INTO ".$db->prefix("banner_items")." SET bid=$newid, cid=$cid, imptotal=$imptotal, impmade=0, clicks=0, imageurl='$imageurl', imagealt='$imagealt', clickurl='$clickurl', datestart=$nowtime, dateend=0, display='$display', custom='$custom'")) {
	redirect_header("index.php?op=banner_admin#top", 1, _UPDATED);
	} else {
		redirect_header("index.php?op=banner_admin#top", 1, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function banner_addclient($name, $contact, $email, $login, $passwd, $extrainfo) {
global $db, $myts;

if ( (empty($name) && empty($contact)) ) {
	redirect_header("index.php?op=banner_admin#top", 1, _NOTUPDATED);
	exit();
}

$name      = $name    ? $myts->makeTboxData4Save($name)    : $myts->makeTboxData4Save($contact);
$contact   = $contact ? $myts->makeTboxData4Save($contact) : $name;
$login     = $login   ? $myts->makeTboxData4Save($login)   : $name;
$passwd    = $passwd  ? md5($passwd) : md5($name);
$extrainfo = $myts->makeTboxData4Save($extrainfo);
$newid     = $db->genId($db->prefix("banner_clients")."_cid_seq");

if ($result = $db->query("INSERT INTO ".$db->prefix("banner_clients")." SET cid=$newid, name='$name', contact='$contact', email='$email', login='$login', passwd='$passwd', extrainfo='$extrainfo'")) {
	redirect_header("index.php?op=banner_admin#top", 1, _UPDATED);
	} else {
		redirect_header("index.php?op=banner_admin#top", 1, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function banner_delete($bid, $ok=0) {
global $db, $myts;

if ($ok == 1) {
	$result = $db->query("SELECT imageurl FROM ".$db->prefix("banner_items")." where bid=$bid");
	list($oldimage) = $db->fetch_row($result);
	@unlink(RCX_ROOT_PATH . "/modules/banners/cache/banners/".basename($oldimage));

	$db->query("DELETE FROM ".$db->prefix("banner_items")." WHERE bid=$bid");
	redirect_header("index.php?op=banner_admin#top", 1, _UPDATED);
	exit();
	} else {
		rcx_cp_header();
                
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPattention" >'._AM_DELEBNR.'</div>
            <br />
            <br />';
                
		$result = $db->query("SELECT cid, imptotal, impmade, clicks, imageurl, imagealt, clickurl, custom FROM ".$db->prefix("banner_items")." where bid=$bid");
		list($cid, $imptotal, $impmade, $clicks, $imageurl, $imagealt, $clickurl, $custom) = $db->fetch_row($result);
		$imagealt = $myts->makeTboxData4Show($imagealt);
		$custom   = $myts->makeTboxData4Show($custom);
		OpenTable();
		
		if ($custom) {
			echo $custom;
			} else {
				echo "<a href='$clickurl' target='_blank'><img src='".formatURL(RCX_URL . "/modules/banners/cache/banners/", $imageurl)."' alt='$imagealt' border='1' /></a><br /><a href='$clickurl' target='_blank'>$clickurl</a>";
			}
		echo "
		<br /><br />
		<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>



		<td>"._AM_BANNERID."</td>
		<td>"._AM_IMPRESION."</td>
		<td>"._AM_IMPLEFT."</td>
		<td>"._AM_CLICKS."</td>
		<td>"._AM_NCLICKS."</td>
		<td>"._AM_CLINAME."</td></tr><tr class='sysbg1'>";
		$result2 = $db->query("SELECT cid, name FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
		list($cid, $name) = $db->fetch_row($result2);
		$name = $myts->makeTboxData4Show($name);
		if ( ($impmade == 0) || ($clicks == 0) ) {
			$percent = 0;
			} else {
				$percent = round(100 * ($clicks/$impmade), 2);
			}
		if ($imptotal == 0) {
			$left = _AM_UNLIMIT;
			} else {
				$left = ($imptotal-$impmade);
			}
		echo "
		<td>$bid</td>
		<td>$impmade</td>
		<td>$left</td>
		<td>$clicks</td>
		<td>$percent%</td>
		<td>$name</td>
		</tr></table></td>
    </tr></table><br />
		"._AM_SUREDELE."<br /><br />
		<table><tr><td>";
		echo myTextForm("index.php?op=banner_admin#top", _NO);
		echo "</td><td>";
		echo myTextForm("index.php?op=banner_delete&bid=$bid&ok=1", _YES);
		echo "</td>
    </table><br /><br />";
		CloseTable();
                
                echo "                        
        </td>
    </tr>
</table>";
                
		rcx_cp_footer();
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function banner_edit($bid) {
global $db, $myts;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_EDITBNR.'</div>
            <br />
            <br />';

$result = $db->query("SELECT cid, imptotal, impmade, clicks, imageurl, imagealt, clickurl, display, custom FROM ".$db->prefix("banner_items")." WHERE bid=$bid");
list($cid, $imptotal, $impmade, $clicks, $imageurl, $imagealt, $clickurl, $display, $custom) = $db->fetch_row($result);
$imagealt = $myts->makeTboxData4Show($imagealt);

OpenTable();

?>

<?php
if ( !empty($custom) ) {
	echo $custom;
	} else {
		echo "<a href='$clickurl' target='_blank'><img src='".formatURL(RCX_URL . "/modules/banners/cache/banners/", $imageurl)."' alt='$imagealt' border='1' /></a><br /><a href='$clickurl' target='_blank'>$clickurl</a>";
	}
?>
<br /><br />
<form name="edit" action="index.php" method="post" enctype="multipart/form-data">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>

<td><?php echo _AM_CLINAMET;?></td>
<td><select class="select" name="cid">
<?php

$result = $db->query("SELECT cid, name FROM ".$db->prefix("banner_clients"));
while (list($cid2, $name) = $db->fetch_row($result)) {
	$name = $myts->makeTboxData4Show($name);
	$chk  = ($cid == $cid2) ? " selected='selected'" : "";
	echo "<option value='$cid2'$chk>$name</option>";
}
echo "</select></td>";

if ( $imptotal == 0 ) {
	$impressions = _AM_UNLIMIT;
	} else {
		$impressions = $imptotal;
	}

?>
</tr><tr class='sysbg1'>
<td><?php echo _AM_ADDIMPT;?></td>
<td><input type="text" class="text" name="impadded" size="12" maxlength="11" /> <?php echo _AM_PURCHT;?><b><?php echo $impressions;?></b> <?php echo _AM_MADET;?><b><?php echo $impmade;?></b></td>
</tr><tr class='sysbg1'>

<td><?php echo _AM_SHOW;?></td>
<td>
<select class="select" name="display">
<optgroup label="<?php echo _AM_SGLOBAL;?>">
<option value=""<?php if ( !preg_match("/\b(N|A|BA|SL|SR|SLR|CL|CR|CLR|CC|CA)\b/i", $display) ) { echo " selected='selected'"; }?>><?php echo _AM_CCODE;?></option>
<option value="N"<?php if ($display == "N") { echo " selected='selected'"; }?>><?php echo _AM_N;?></option>
<option value="A"<?php if ($display == "A") { echo " selected='selected'"; }?>><?php echo _AM_A;?></option>
<option value="BA"<?php if ($display == "BA") { echo " selected='selected'"; }?>><?php echo _AM_BA;?></option>
</optgroup>

<optgroup label="<?php echo _AM_SSIDE;?>">
<option value="SL"<?php if ($display == "SL") { echo " selected='selected'"; }?>><?php echo _AM_SL;?></option>
<option value="SR"<?php if ($display == "SR") { echo " selected='selected'"; }?>><?php echo _AM_SR;?></option>
<option value="SLR"<?php if ($display == "SLR") { echo " selected='selected'"; }?>><?php echo _AM_SLR;?></option>
</optgroup>

<optgroup label="<?php echo _AM_SCENTER;?>">
<option value="CL"<?php if ($display == "CL") { echo " selected='selected'"; }?>><?php echo _AM_CL;?></option>
<option value="CR"<?php if ($display == "CR") { echo " selected='selected'"; }?>><?php echo _AM_CR;?></option>
<option value="CLR"<?php if ($display == "CLR") { echo " selected='selected'"; }?>><?php echo _AM_CLR;?></option>
<option value="CC"<?php if ($display == "CC") { echo " selected='selected'"; }?>><?php echo _AM_CC;?></option>
<option value="CA"<?php if ($display == "CA") { echo " selected='selected'"; }?>><?php echo _AM_CA;?></option>
</optgroup>
</select>
 <?php echo _AM_CCODE;?>: <input name="ccode" type="text" size="11" maxlength="10" value="<?php if ( !preg_match("/\b(N|A|BA|SL|SR|SLR|CL|CR|CLR|CC|CA)\b/i", $display) ) { echo $display; } ?>">
</td>
</tr><tr class='sysbg1'>
<td valign="top"><?php echo _AM_IMGURLT;?></td>
<td>
<input type="text" class="text" name="imageurl" size="35" maxlength="255" value="<?php echo $imageurl;?>" /> :: <input type="file" class="file" name="image" />
<br /><?php printf(_AM_IMGLOCATION, "/modules/banners/cache/banners/");?>
</td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_IMGALT;?></td>
<td><input type="text" class="text" name="imagealt" size="35" maxlength="255" value="<?php echo $imagealt;?>" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CLICKURLT;?></td>
<td><input type="text" class="text" name="clickurl" size="35" maxlength="255" value="<?php echo $clickurl;?>" /></td>
</tr><tr class='sysbg1'>
<td valign="top"><br /><?php echo _AM_CUSTOM;?> *</td>
<td><br /><textarea class="textarea" cols="55" rows="7" name="custom"><?php echo $myts->makeTboxData4Edit($custom);?></textarea></td>
</tr><tr class='sysbg1'>
<td colspan="2">
<br /><?php echo _AM_NCUSTOM;?><br /><br />
</td>
</tr><tr class='sysbg1'>
<td colspan="2">
<input type="hidden" name="bid" value="<?php echo $bid;?>" />
<input type="hidden" name="imptotal" value="<?php echo $imptotal;?>" />
<input type="hidden" name="impmade" value="<?php echo $impmade;?>" />
<input type="hidden" name="op" value="banner_change" />
<input type="submit" class="button" value="<?php echo _AM_CHGBNR;?>" />
</td>
</tr>    </tr></table></td>
    </tr></table>
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
function banner_change($bid, $cid, $impmade, $imptotal, $impadded, $imageurl, $imagealt, $clickurl, $display, $ccode, $custom) {
global $db, $myts, $_FILES;

if ( is_numeric($impadded) ) {
	if ($impadded == 0) {
		$extra = ", imptotal=0, dateend=0";
		} else {
			if ($imptotal == 0) {
				$imptotal = $impmade;
			}
			$imptotal = ($imptotal + $impadded);
			$extra    = ", imptotal=$imptotal, dateend=0";
		}
}
$imagealt = $myts->makeTboxData4Save($imagealt);
$custom   = $myts->makeTboxData4Save($custom);

if ( !empty($display) || !empty($ccode) ) {
	$display  = !empty($display) ? $myts->makeTboxData4Save($display) : $myts->makeTboxData4Save($ccode);
	} else {
		$display = "N";
	}

if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/modules/banners/cache/banners/", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if ($result['image']['filename']) {
		$old = $db->query("SELECT imageurl FROM ".$db->prefix("banner_items")." where bid=$bid");
		list($oldimage) = $db->fetch_row($old);
		@unlink(RCX_ROOT_PATH . "/modules/banners/cache/banners/".basename($oldimage));
		$imageurl = $result['image']['filename'];
		} else {
			redirect_header("index.php?op=banner_admin#top", 3, $upload->errors());
			exit();
		}
}

if ($result = $db->query("UPDATE ".$db->prefix("banner_items")." SET cid=$cid, imageurl='$imageurl', imagealt='$imagealt', clickurl='$clickurl', display='$display', custom='$custom' $extra WHERE bid=$bid")) {
	redirect_header("index.php?op=banner_admin#top", 1, _UPDATED);
	} else {
		redirect_header("index.php?op=banner_admin#top", 1, _NOTUPDATED);
	}

exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function banner_clientdelete($cid, $ok=0) {
global $db, $myts;

if ( $ok == 1 ) {
	$db->query("DELETE FROM ".$db->prefix("banner_items")." WHERE cid=$cid");
	$db->query("DELETE FROM ".$db->prefix("banner_clients")." where cid=$cid");
	redirect_header("index.php?op=banner_admin#top", 1, _UPDATED);
	exit();
	} else {
		rcx_cp_header();
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPattention" >'._AM_DELEADC.'</div>
            <br />
            <br />';
		$result = $db->query("SELECT cid, name FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
		list($cid, $name) = $db->fetch_row($result);
		$name = $myts->makeTboxData4Show($name);
		OpenTable();
		echo "
		".sprintf(_AM_SUREDELCLI, $name)."<br /><br />";
		$result2 = $db->query("SELECT imageurl, clickurl FROM ".$db->prefix("banner_items")." WHERE cid=$cid");
		$numrows = $db->num_rows($result2);
		if ($numrows == 0) {
			echo _AM_NOBNRRUN."<br /><br />";
			} else {
				echo "
				<font color='#ff0000'><b>"._AM_WARNING."</b></font>
				<br />"._AM_ACTBNRRUN."<br /><br />";
			}
		while (list($imageurl, $clickurl) = $db->fetch_row($result2)) {
			echo "
			<a href='$clickurl'><img src='".formatURL(RCX_URL . "/modules/banners/cache/banners/", $imageurl)."' border='1' /></a><br />
			<a href='$clickurl'>$clickurl</a><br /><br />";
		}
	}
	echo _AM_SUREDELBNR."<br /><br /><table><tr><td>";
	echo myTextForm("index.php?op=banner_admin#top", _NO);
	echo "</td><td>";
	echo myTextForm("index.php?op=banner_clientdelete&cid=$cid&ok=1", _YES);
	echo "</td></tr></table>";
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
function banner_clientedit($cid) {
global $db, $myts;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_EDITADVCLI.'</div>
            <br />
            <br />';

$result = $db->query("SELECT name, contact, email, login, passwd, extrainfo FROM ".$db->prefix("banner_clients")." WHERE cid=$cid");
list($name, $contact, $email, $login, $passwd, $extrainfo) = $db->fetch_row($result);
$name      = $myts->makeTboxData4Edit($name);
$contact   = $myts->makeTboxData4Edit($contact);
$extrainfo = $myts->makeTboxData4Edit($extrainfo);

OpenTable();

?>
<form action="index.php" method="post">
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>


<td><?php echo _AM_CLINAMET;?></td>
<td><input type="text" class="text" name="name" value="<?php echo $name;?>" size="30" maxlength="60" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CONTNAMET;?></td>
<td><input type="text" class="text" name="contact" value="<?php echo $contact;?>" size="30" maxlength="60" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CONTMAILT;?></td>
<td><input type="text" class="text" name="email" size="30" maxlength="60" value="<?php echo $email;?>" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_CLILOGINT;?></td>
<td><input type="text" class="text" name="login" size="11" maxlength="10" value="<?php echo $login;?>" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_NEWPASS;?></td>
<td><input type="password" class="text" name="passwd" size="11" maxlength="10" /></td>
</tr><tr class='sysbg1'>
<td><?php echo _AM_EXTINFO;?></td>
<td><textarea class="textarea" name="extrainfo" cols="60" rows="10" /><?php echo $extrainfo;?></textarea></td>
</tr><tr class='sysbg1'>
<td colspan="2">
<input type="hidden" name="cid" value="<?php echo $cid;?>" />
<input type="hidden" name="op" value="banner_clientchange" />
<input type="submit" class="button" value="<?php echo _AM_CHGCLI;?>" />
</td>
    </tr></table></td>
    </tr></table></form>
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
function banner_clientchange($cid, $name, $contact, $email, $extrainfo, $login, $passwd) {
global $db, $myts;

$name      = $myts->makeTboxData4Save($name);
$contact   = $myts->makeTboxData4Save($contact);
$extrainfo = $myts->makeTboxData4Save($extrainfo);

if ( !empty($passwd) ) {
	$passwd = md5($passwd);
	$sql = "UPDATE ".$db->prefix("banner_clients")." SET name='$name', contact='$contact', email='$email', login='$login', passwd='$passwd', extrainfo='$extrainfo' WHERE cid=$cid";
	} else {
		$sql = "UPDATE ".$db->prefix("banner_clients")." SET name='$name', contact='$contact', email='$email', login='$login', extrainfo='$extrainfo' WHERE cid=$cid";
	}

if ($result = $db->query($sql)) {
	redirect_header("index.php?op=banner_admin#top", 1, _UPDATED);
	} else {
		redirect_header("index.php?op=banner_admin#top", 1, _NOTUPDATED);
	}

exit();
}

$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch($op) {
	case "banner_admin":
		banner_admin();
		break;

	case "banner_add":
		banner_add($_POST['cid'], $_POST['imageurl'], $_POST['imagealt'], $_POST['clickurl'], $_POST['imptotal'], $_POST['display'], $_POST['ccode'], $_POST['custom']);
		break;

	case "banner_addclient":
		banner_addclient($_POST['name'], $_POST['contact'], $_POST['email'], $_POST['login'], $_POST['passwd'], $_POST['extrainfo']);
		break;

	case "banner_delete":
		banner_delete($_GET['bid'], $_GET['ok']);
		break;

	case "banner_edit":
		banner_edit($_GET['bid']);
		break;

	case "banner_change":
		banner_change($_POST['bid'], $_POST['cid'], $_POST['impmade'], $_POST['imptotal'], $_POST['impadded'], $_POST['imageurl'], $_POST['imagealt'], $_POST['clickurl'], $_POST['display'], $_POST['ccode'], $_POST['custom']);
		break;

	case "banner_clientdelete":
		banner_clientdelete($_GET['cid'], $_GET['ok']);
		break;

	case "banner_clientedit":
		banner_clientedit($_GET['cid']);
		break;

	case "banner_clientchange":
		banner_clientchange($_POST['cid'], $_POST['name'], $_POST['contact'], $_POST['email'], $_POST['extrainfo'], $_POST['login'], $_POST['passwd']);
		break;

	default:
		banner_admin();
		break;
}
?>
