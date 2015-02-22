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
function partners_manage() {
global $db, $myts;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_PARTNERADMIN.'</div>
            <br />
            <br />';

OpenTable();

		           include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_AM_CONFIG, "button", _MODIFY, "button");
         $retur_button->setExtra("onClick=\"location='index.php?op=configure_partners'\"");
             $form->addElement($retur_button); 



echo "
<form action='./index.php' method='post'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>

<td width='1%' align='left' nowrap><b>" ._AM_TITLE."</b></td>
<td><b>" ._AM_DESCRIPTION."</b></td>
<td width='5' align='left' nowrap><b>" ._AM_IMAGE."</b></td>
<td width='5' align='left' nowrap><b>" ._AM_HITS."</b></td>
<td width='5' align='left' nowrap><b>" ._AM_WEIGHT."</b></td>
<td>&nbsp;</td></tr>";

$result = $db->query("SELECT id, hits, url, weight, image, title, description, status FROM ".$db->prefix("partners")." ORDER BY status DESC, weight ASC, title DESC");
while ( list($id, $hits, $url, $weight, $image, $title, $description, $status) = $db->fetch_row($result) ) {
$title        = $myts->makeTboxData4Show($title);
$description  = $myts->makeTboxData4Show($description);

echo "
<tr class='bg1'>
<td width='1%' align='left' valign='top' nowrap><a href='$url' target='_blank'>$title</a></td>
<td align='left' valign='top'>$description</td>
<td width='5' align='center' valign='top' nowrap>";

if ( !empty($image) ) {
	echo "<a href='$url' target='_blank'><img src='".formatURL(RCX_URL . "/modules/partners/cache/images/", $image)."' alt='$title' border='0'></a>";
}

echo "
</td>
<td width='5' align='left' valign='top' nowrap>$hits</td>
<td width='5' align='left' valign='top' nowrap>";
if ( !empty($status) ) {
	echo "<input type='text' class='text' name='weight[$id]' value='$weight' size='3' maxlength='3'>";
	}
echo "
</td><td width='1%' align='right' valign='top' nowrap>
<a href='index.php?op=edit_partner&amp;id=".$id."'>"._EDIT."</a>|<a href='index.php?op=delete_partner&amp;id=".$id."&amp;del=0'>"._DELETE."</a>
</td></tr>";
}

echo "
<tr class='sysbg1'><td colspan='6' align='right'>
<input type='hidden' name='op' value='reorder_partners' />
<input type='submit' class='button' name='submit' value='"._AM_REORDER."'>
</td>    </tr></table></td>
    </tr></table></form>";

CloseTable();
OpenTable();

echo '<div class="KPstor" >'._ADD.'</div>
            <br />
            <br />';

echo "
<form action='index.php' method='post' enctype='multipart/form-data'>


<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>



<td>"._AM_WEIGHT."</td>
<td><input type='text' class='text' name='weight' size='3' maxlength='3' /></td>

</tr><tr class='sysbg1'>

<td>"._AM_IMAGE."</td>
<td><input type='text' class='text' name='image' size='35' maxlength='255' /> :: <input type='file' class='file' name='image1' /></td>

</tr><tr class='sysbg1'>

<td>"._AM_URL."</td>
<td><input type='text' class='text' name='url' size='35' maxlength='255' /></td>

</tr><tr class='sysbg1'>

<td valign='top'>"._AM_TITLE."</td>
<td><input type='text' class='text' name='title' size='35' maxlength='60' /></td>

</tr><tr class='sysbg1'>

<td valign='top'>"._AM_DESCRIPTION."</td>
<td><textarea class='textarea' name='description' cols='60' rows='10'></textarea></td>

</tr><tr class='sysbg1'>

<td valign='top'>"._STATUS."</td>
<td>
<select class='select' name='status'>
<option value='1'>"._ACTIVE."</option>
<option value='0'>"._INACTIVE."</option>
</select>
</td>

</tr><tr class='sysbg1'>

<td colspan='2' align='right'>
<input type='hidden' name='op' value='add_partner' />
<input type='submit' class='button' value='"._ADD."' />


    </tr></table></td>
    </tr></table>
</form>";


echo "<br />";
        $form->display(); 

CloseTable();

echo "                        
        </td>
    </tr>
</table>";

}

/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_partner($id) {
global $db, $myts;

rcx_cp_header();
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._EDIT.'</div>
            <br />
            <br />';
OpenTable();

$result = $db->query("SELECT weight, hits, url, image, title, description, status FROM ".$db->prefix("partners")." WHERE id=$id");
list($weight, $hits, $url, $image, $title, $description, $status) = $db->fetch_row($result);
$title        = $myts->makeTboxData4Edit($title);
$description  = $myts->makeTboxData4Edit($description);

if ( empty($status) ) {
	$chk = " selected='selected'";
	}


if ( !empty($image) ) {
	echo "<img src='".formatURL(RCX_URL . "/modules/partners/cache/images/", $image)."' border='0' /><br /><br />";
	}

echo "
<form action='./index.php' method='post' enctype='multipart/form-data'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg1'>




<td>"._AM_HITS."</td>
<td><input type='text' class='text' name='hits' size='3' maxlength='8' value='$hits' /></td>

</tr><tr class='sysbg1'>

<td>"._AM_WEIGHT."</td>
<td><input type='text' class='text' name='weight' size='3' maxlength='3' value='$weight' /></td>

</tr><tr class='sysbg1'>

<td>"._AM_URL."</td>
<td><input type='text' class='text' name='url' size='35' maxlength='255' value='$url' /> <a href='$url' target='_blank'>"._VISIT."</a></td>

</tr><tr class='sysbg1'>

<td>"._AM_IMAGE."</td>
<td><input type='text' class='text' name='image' size='35' maxlength='255' value='$image' /> :: <input type='file' class='file' name='image1' /></td>

</tr><tr class='sysbg1'>

<td>"._AM_TITLE."</td>
<td><input type='text' class='text' name='title' size='35' maxlength='60' value='$title' /></td>

</tr><tr class='sysbg1'>

<td>"._AM_DESCRIPTION."</td>
<td><textarea class='textarea' name='description' cols='50' rows='10' />$description</textarea></td>

</tr><tr class='sysbg1'>

<td>"._STATUS.":</td>
<td>
<select class='select' name='status'>
<option value='1'>"._ACTIVE."</option>
<option value='0'$chk>"._INACTIVE."</option>
</select>
</td>

</tr><tr class='sysbg1'>

<td colspan='2' align='left'>
<input type='hidden' name='id' value='$id' />
<input type='hidden' name='op' value='change_partner' />
<input type='submit' class='button' value='"._EDIT."' />
</td>

    </tr></table></td>
    </tr></table>
</form>";

CloseTable();

echo "                        
        </td>
    </tr>
</table>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function change_partner($id, $weight, $hits, $url, $image, $title, $description, $status) {
global $db, $myts, $_FILES;

if ( empty($title) || empty($url) ) {
	redirect_header("index.php", 1, _AM_BESURE);
	exit();
}

$url          = formatURL($url);
$title        = $myts->makeTboxData4Save($title);
$description  = $myts->makeTboxData4Save($description);

if ( !is_numeric($weight) ) {
	$weight = 0;
	}

if ( !is_numeric($hits) ) {
	$hits = 0;
	}

if ( !empty($_FILES['image1']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH . "/modules/partners/cache/images/", 'image1');
	$upload->set_accepted("gif|jpg|png", 'image1');
	$upload->set_overwrite(1, 'image1');
	$result = $upload->upload();
	if ($result['image1']['filename']) {
		$old = $db->query("SELECT image FROM ".$db->prefix("partners")." WHERE id=$id");
		list($oldimage) = $db->fetch_row($old);
		@unlink(RCX_ROOT_PATH."/modules/partners/cache/images/".basename($oldimage));
		$image = $result['image1']['filename'];
		} else {
			redirect_header("index.php", 3, $upload->errors());
			exit();
		}
}

$sql = "
	UPDATE ".$db->prefix("partners")." SET
	hits=$hits,
	weight=$weight,
	url='$url',
	image='$image',
	title='$title',
	description='$description',
	status=$status
	WHERE id=$id";

if ($db->query($sql)) {
	redirect_header("index.php", 1, _UPDATED);
	} else {
		redirect_header("index.php", 1, _NOTUPDATED);
	}
	exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function add_partner($weight, $url, $image, $title, $description, $status) {
global $db, $myts, $_FILES;

if ( empty($title) || empty($url) ) {
	redirect_header("index.php", 1, _AM_BESURE);
	exit();
}

$url          = formatURL($url);
$title        = $myts->makeTboxData4Save($title);
$description  = $myts->makeTboxData4Save($description);

if ( !is_numeric($weight) ) {
	$weight = 0;
}

if ( !empty($_FILES['image1']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH."/modules/partners/cache/images/", 'image1');
	$upload->set_accepted("gif|jpg|png", 'image1');
	$upload->set_overwrite(1, 'image1');
	$result = $upload->upload();
	if ($result['image1']['filename']) {
		$image = $result['image1']['filename'];
		} else {
			redirect_header("index.php", 3, $upload->errors());
			exit();
		}
}

$newid = $db->genId($db->prefix("partners")."_num_seq");

$sql = "
	INSERT INTO ".$db->prefix("partners")." SET
	id=$newid,
	hits=0,
	weight=$weight,
	url='$url',
	image='$image',
	title='$title',
	description='$description',
	status=$status";

if ($db->query($sql)) {
	redirect_header("index.php", 1, _UPDATED);
	} else {
		redirect_header("index.php", 1, _NOTUPDATED);
	}
	exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete_partner($id, $del=0) {
global $db;

if ($del == 1) {
	$old = $db->query("SELECT image FROM ".$db->prefix("partners")." WHERE id=$id");
	list($oldimage) = $db->fetch_row($old);
	@unlink(RCX_ROOT_PATH."/modules/partners/cache/images/".basename($oldimage));

	$sql = "DELETE FROM ".$db->prefix("partners")." WHERE id=$id";
	if ($db->query($sql)) {
		redirect_header("index.php", 1, _UPDATED);
		} else {
			redirect_header("index.php", 1, _NOTUPDATED);
		}
		exit();

} else {
	rcx_cp_header();
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPattention" >'._AM_SURETODELETE.'</div>
            <br />
            <br />';
	OpenTable();
	echo "<table><tr><td>";
	echo myTextForm("index.php?op=delete_partner&amp;id=".$id."&amp;del=1", _YES);
	echo "</td><td>";
	echo myTextForm("index.php" , _NO);
	echo "</td></tr></table>";
	CloseTable();
        
        echo "                        
        </td>
    </tr>
</table>";
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function reorder_partners($weight) {
global $db;

foreach ($weight as $id=>$order) {
	if ( isset($id) && is_numeric($id) && isset($order) ) {
		if ( !is_numeric($order) ) { $order = 0; }
		$db->query("UPDATE ".$db->prefix("partners")." SET weight='$order' WHERE id=$id");
	}
}

redirect_header("./index.php", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function configure_partners() {

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_CONFIG.'</div>
            <br />
            <br />';

OpenTable();

include_once('../cache/config.php');
include_once('./settings.inc.php');

CloseTable();

echo "                        
        </td>
    </tr>
</table>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_partners() {
global $_POST;

if ( !empty($_POST) ) {

if ( is_numeric($_POST["partners_cookietime"]) ) {
	$partners_cookietime = $_POST["partners_cookietime"];
	} else {
		$partners_cookietime = 86400;
	}

if ( is_numeric($_POST["partners_limit"]) ) {
	$partners_limit = $_POST["partners_limit"];
	} else {
		$partners_limit = 0;
	}

if ( is_numeric($_POST["partners_blimit"]) ) {
	$partners_blimit = $_POST["partners_blimit"];
	} else {
		$partners_blimit = 0;
	}

$content = '<?php
// '._AM_CCOMMON.'
$partners_cookietime = '.$partners_cookietime.';

// '._AM_CMAIN.'
$partners_randomize = '.$_POST["partners_randomize"].';
$partners_limit     = '.$partners_limit.';
$partners_show      = '.$_POST["partners_show"].';
$partners_order     = "'.$_POST["partners_order"].'";
$partners_orderd    = "'.$_POST["partners_orderd"].'";

// '._AM_CBLOCK.'
$partners_brandomize = '.$_POST["partners_brandomize"].';
$partners_blimit     = '.$partners_blimit.';
$partners_bshow      = '.$_POST["partners_bshow"].';
$partners_border     = "'.$_POST["partners_border"].'";
$partners_borderd    = "'.$_POST["partners_borderd"].'";
?>';

if ( $fp = fopen('../cache/config.php', "w") ) {
	fwrite($fp, $content);
	fclose($fp);
	redirect_header("./index.php", 1, _UPDATED);
	} else {
		redirect_header("./index.php", 1, _NOTUPDATED);
	}

	} else {
		redirect_header("./index.php", 1, _AM_NOTHING);
	}

exit();
}

$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch ($op) {

	case "change_partner":
		change_partner((int)$_POST["id"], $_POST["weight"], $_POST["hits"], $_POST["url"], $_POST["image"], $_POST["title"], $_POST["description"], $_POST["status"]);
		break;

	case "add_partner":
		add_partner($_POST["weight"], $_POST["url"], $_POST["image"], $_POST["title"], $_POST["description"], $_POST["status"]);
		break;

	case "delete_partner":
		delete_partner((int)$_GET['id'], $_GET['del']);
		break;

	case "edit_partner":
		edit_partner((int)$_GET['id']);
		break;

	case "reorder_partners":
		reorder_partners($_POST["weight"]);
		break;

	case "configure_partners":
		configure_partners();
		break;

	case "save_partners":
		save_partners();
		break;

	default:
		partners_manage();
		break;
}

rcx_cp_footer();
?>
