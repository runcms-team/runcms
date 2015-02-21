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
function admin_headlines() {
global $db, $myts;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MI_HEADLINES_NAME.'</div>
            <br />
            <br />';

OpenTable();
?>
<form name="order" action="./index.php" method="post">
<table border="0" cellpadding="0" cellspacing="0" valign="top" width="100%"><tr>
<td class="bg2">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr class="bg3" align="center">
<td><b><?php echo _AM_SITENAME;?></b></td>
<td><b><?php echo _TYPE;?></b></td>
<td><b><?php echo _AM_ITEMS;?></b></td>
<td><b><?php echo _AM_CACHE;?></b></td>
<td><b><?php echo _AM_TEMPLATE;?></b></td>
<td><b><?php echo _STATUS;?></b></td>
<td><b><?php echo _AM_WEIGHT;?></b></td>
<td><b><?php echo _AM_FUNCTION;?></b></td>
<?php

$result = $db->query("SELECT id, name, url, status, template, cache, items, type, weight FROM ".$db->prefix("headlines")." ORDER BY status DESC, weight ASC, name ASC");

while ( list($id, $name, $url, $status, $template, $cache, $items, $type, $weight) = $db->fetch_row($result) ) {
	$name     = $myts->makeTboxData4Show($name);
	$url      = $myts->makeTboxData4Show($url);
	$template = str_replace('.txt', '', $template);
	echo "
	<tr class='bg1'>
	<td><a href='$url' target='new'>$name</a></td>
	<td>$type</td>
	<td>$items</td>
	<td>$cache</td>
	<td>$template</td>";
	if ($status > 0) {
		$stat = "<b><u><i>"._ACTIVE."<i></u></b>";
		} else {
			$stat = _INACTIVE;
		}
	echo "<td>$stat</td><td>";
	if ($status == 1) {
		echo "<input type='text' class='text' name='weight[$id]' value='$weight' size='3' />";
		} else {
			echo "&nbsp;";
		}
	echo "</td><td><a href='./index.php?op=edit_headlines&amp;id=$id'>"._EDIT."</a> | <a href='./index.php?op=delete_headlines&amp;id=$id&amp;ok=0'>"._DELETE."</a></td></tr>";
}

?>
<tr>
<td colspan="8" align="center" class="bg3">
<input type="hidden" name="op" value="reorder_headlines" />
<input type="submit" class="button" value="<?php echo _AM_REORDER;?>" />
</td>
</tr></table></td>
</tr></table>
</form>
<br /><br />
            <div class="KPstor" ><?php echo _AM_ADDHEADL;?></div>
            <br />
            <br />
<form name="new" action="./index.php" method="post">
<table border="0" cellpadding="0" cellspacing="0" valign="top" width="100%"><tr>
<td class="bg2">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr>
<td class="bg3"><b><?php echo _AM_SITENAMET;?></b></td>
<td class="bg1"><input type="text" class="text" name="name" size="31" maxlength="30" /></td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_URLT;?></b></td>
<td class="bg1"><input type="text" class="text" name="url" size="50" maxlength="100" /></td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_URLEDFXMLT;?></b></td>
<td class="bg1"><input type="text" class="text" name="headlineurl" size="50" maxlength="200" /></td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_TEMPLATE;?></b></td>
<td class="bg1"><select class="select" name="template">
<?php

$path = "../templates/";
if ( $handle = opendir($path) ) {
	while (false !== ($file = readdir($handle))) {
		if ( @!is_dir($path.$file) && $file != 'index.html' ) {
			$text = basename($file,".php");
			echo $text."<br>";
			if ($text == $template) { $sel = "selected";
				} else {
					$sel = '';
				}
				echo "<option value='$text'$sel>$text</option>";
		}
	}
	closedir($handle);
}
?>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _TYPE;?></b></td>
<td class="bg1">
<select class="select" name="type">
<option value="block"><?php echo _AM_HLBLOCK;?></option>
<option value="main"><?php echo _AM_HLMAIN;?></option>
<option value="both"><?php echo _AM_HLBOTH;?></option>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_CACHE;?></b></td>
<td class="bg1">
<select class="select" name="cache">
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="30">30</option>
<option value="60">60</option>
<option value="90">90</option>
<option value="120">120</option>
<option value="180">180</option>
<option value="240">240</option>
<option value="520">520</option>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_ITEMS;?></b></td>
<td class="bg1">
<select class="select" name="items">
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _STATUS;?>:</b></td>
<td class="bg1">
<select class="select" name="status">
<option value="1"><?php echo _ACTIVE;?></option>
<option value="0" selected="selected"><?php echo _INACTIVE;?></option>
</select></td>
</tr><tr>
<td class="bg3">&nbsp;</td>
<td class="bg1">
<input type="hidden" name="op" value="add_headlines" />
<input type="submit" class="button" value="<?php echo _ADD;?>" />
</td>
</tr></table>
</td>
</tr></table>
</form>
<?php

CloseTable();


echo "                        
        </td>
    </tr>
</table>";
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_headlines($id) {
global $db, $myts;

rcx_cp_header();

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_EDITHEADL.'</div>
            <br />
            <br />';

$result = $db->query("SELECT name, url, headlineurl, template, cache, items, type, status FROM ".$db->prefix("headlines")." WHERE id=$id");
list($name, $url, $headlineurl, $template, $cache, $items, $type, $status) = $db->fetch_row($result);
$name        = $myts->makeTboxData4Edit($name);
$url         = $myts->makeTboxData4Edit($url);
$template    = $myts->makeTboxData4Edit($template);
$headlineurl = $myts->makeTboxData4Edit($headlineurl);

OpenTable();
?>

<form action="./index.php" method="post">
<input type="hidden" name="id" value="<?php echo $id;?>" />
<table border="0" cellpadding="0" cellspacing="0" valign="top" width="100%"><tr>
<td class="bg2">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr>
<td class="bg3"><b><?php echo _AM_SITENAMET;?></b></td>
<td class="bg1"><input type="text" class="text" name="name" size="31" maxlength="30" value="<?php echo $name;?>" /></td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_URLT;?></b></td>
<td class="bg1"><input type="text" class="text" name="url" size="50" maxlength="100" value="<?php echo $url;?>" /></td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_URLEDFXMLT;?></b></td>
<td class="bg1"><input type="text" class="text" name="headlineurl" size="50" maxlength="200" value="<?php echo $headlineurl;?>" /></td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_TEMPLATE;?></b></td>
<td class="bg1">
<select class="select" name="template">
<?php

$path = "../templates/";
if ( $handle = opendir($path) ) {
	while (false !== ($file = readdir($handle))) {
		if ( @!is_dir($path.$file) && $file != 'index.html') {
			$text = basename($file,'.php');
			if ($text == $template) { $sel = "selected";
				} else {
					$sel = '';
				}
				echo "<option value='$text'$sel>$text</option>";
		}
	}
	closedir($handle);
}

?>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _TYPE;?></b></td>
<td class="bg1">
<select class="select" name="type">
<option value="<?php echo $type;?>" selected><?php echo $type;?></option>
<option value="block"><?php echo _AM_HLBLOCK;?></option>
<option value="main"><?php echo _AM_HLMAIN;?></option>
<option value="both"><?php echo _AM_HLBOTH;?></option>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_CACHE;?></b></td>
<td class="bg1">
<select class="select" name="cache">
<option value="<?php echo $cache;?>" selected><?php echo $cache;?></option>
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="30">30</option>
<option value="60">60</option>
<option value="90">90</option>
<option value="120">120</option>
<option value="180">180</option>
<option value="240">240</option>
<option value="520">520</option>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _AM_ITEMS;?></b></td>
<td class="bg1">
<select class="select" name="items">
<option value="<?php echo $items;?>" selected><?php echo $items;?></option>
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
</select>
</td>
</tr><tr>
<td class="bg3"><b><?php echo _STATUS;?>:</b></td>
<td class="bg1">
<select class="select" name="status">
<?php

if ($status > 0) {
	$sel_a = "selected='selected'";
	} else {
		$sel_i = "selected='selected'";
	}

?>
<option value="1" <?php echo $sel_a;?>><?php echo _ACTIVE;?></option>
<option value="0" <?php echo $sel_i;?>><?php echo _INACTIVE;?></option>
</select></td>
</tr><tr>
<td class="bg3">&nbsp;</td>
<td class="bg1">
<input type="hidden" name="op" value="save_headlines" />
<input type="submit" class="button" value="<?php echo _SAVE;?>" />
</td>
</tr></table>
</td></tr></table>
</form>
<?php

CloseTable();

echo "                        
        </td>
    </tr>
</table>";
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function save_headlines($id) {
global $db, $myts, $_POST;

$name        = $myts->makeTboxData4Save(trim($_POST['name']));
$headlineurl = $myts->makeTboxData4Save(trim($_POST['headlineurl']));
$url         = $myts->makeTboxData4Save(trim($_POST['url']));
$template    = $_POST['template'];
$status      = $_POST['status'];
$cache       = $_POST['cache'];
$items       = $_POST['items'];
$type        = $_POST['type'];

$db->query("UPDATE ".$db->prefix("headlines")." SET name='$name', url='$url', headlineurl='$headlineurl', status=$status, template='$template', cache='$cache', items='$items', type='$type' WHERE id=$id");
redirect_header("./index.php", 1, _UPDATED);
exit();
}


//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function add_headlines() {
global $db, $myts, $_POST;

$name        = $myts->makeTboxData4Save(trim($_POST['name']));
$headlineurl = $myts->makeTboxData4Save(trim($_POST['headlineurl']));
$url         = $myts->makeTboxData4Save(trim($_POST['url']));
$template    = $_POST['template'];
$status      = $_POST['status'];
$cache       = $_POST['cache'];
$items       = $_POST['items'];
$type        = $_POST['type'];

$newid = $db->genId($db->prefix("headlines")."_id_seq");
$db->query("INSERT INTO ".$db->prefix("headlines")." SET id=$newid, name='$name', url='$url', headlineurl='$headlineurl', status=$status, template='$template', cache='$cache', items='$items', type='$type'");
redirect_header("./index.php", 1, _UPDATED);
exit();
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function delete_headlines($id, $ok=0) {
global $db;

if ( $ok == 1 ) {
	$db->query("DELETE FROM ".$db->prefix("headlines")." WHERE id=$id");
	redirect_header("./index.php", 1, _UPDATED);
	exit();
	} else {
		rcx_cp_header();
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPattention" >'._AM_WANTDEL.'</div>
            <br />
            <br />';
		OpenTable();
		echo "<table><tr><td>";
		echo myTextForm("./index.php?op=delete_headlines&id=$id&ok=1", _YES);
		echo "</td><td>";
		echo myTextForm("./index.php", _NO);
		echo "</td></tr></table>";
		CloseTable();
                
                echo "                        
        </td>
    </tr>
</table>";

	}
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function reorder_headlines($weight) {
global $db;

foreach ($weight as $id=>$order) {
	if ( isset($id) && is_numeric($id) && isset($order) ) {
		if ( !is_numeric($order) ) {
			$order = 0;
			}
		$db->query("UPDATE ".$db->prefix("headlines")." SET weight='$order' WHERE id=$id");
	}
}
redirect_header("./index.php", 1, _UPDATED);
}

//---------------------------------------------------------------------------------------//
$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch($op) {

	case "delete_headlines":
		delete_headlines($_GET['id'], $_GET['ok']);
		break;

	case "add_headlines":
		add_headlines();
		break;

	case "save_headlines":
		save_headlines($_POST['id']);
		break;

	case "edit_headlines":
		edit_headlines($_GET['id']);
		break;

	case "reorder_headlines":
		reorder_headlines($_POST['weight']);
		break;

	default:
		admin_headlines();
		break;
}
rcx_cp_footer();
?>
