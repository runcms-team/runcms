<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: proprietary
*
*/
global $_SERVER;
if ( preg_match("/image_manager\.php/i", $_SERVER['PHP_SELF']) ) {
	exit();
}
$admin = 0;
if ($rcxUser && $rcxUser->isAdmin()) {
	$admin = 1;
}
if (!$admin && $rcxConfig['allow_library'] == 0) {
	exit();
}
$path = $_GET['path'];
if ( empty($path) || preg_match("'\.'", $path) || !preg_match("'^library/'", $path) ) {
	$path = "library/";
	} elseif ( (substr($path, -1) != '/') ) {
		$path .= "/";
	}
/**
*
* @param type $var description
* @return type description
*/
function getImages($path="library/") {
global $_GET, $admin;
$dir = RCX_ROOT_PATH . "/images/" . $path;
$url = RCX_URL . "/images/" . $path;
$values = array();
$handle = opendir($dir);
while (false !== ($file = readdir($handle))) {
	if ( ($file != ".") && ($file != "..") && (preg_match("/\.(gif|jpg|png)$/i", $file) || @is_dir($dir.$file)) ) {
		if ( @is_dir($dir.$file) ) {
			array_push($values, $file);
			} else {
				array_unshift($values, $file);
			}
			}
			}
closedir($handle);
while (list($key, $filename) = @each($values)) {
	if ( @is_dir($dir.$filename) ) {
		if ($_GET['showall'] == 1) {
			echo "<tr><td colspan='3'><img src='".RCX_URL."/images/menu/tree_open.gif' alt=''> <a href='"._REQUEST_URI."&path=".$path.$filename."'>".$path.$filename."/</a></td></tr>";
			getImages($path.$filename."/");
			} else {
				echo "<tr><td colspan='3'><img src='".RCX_URL."/images/menu/tree_close.gif' alt=''> <a href='"._REQUEST_URI."&path=".$path.$filename."'>".$path.$filename."/</a></td></tr>";
			}
		} else {
			$img = str_replace('library/', '', $path);
			echo "
			<tr>
			<td> &nbsp; &nbsp; <img src='".$url.$filename."' alt='"._PREVIEW."' style='cursor:hand;' height='15' onclick='javascript:rcxGetElementById(\"preview\").src=this.src;'></td>
			<td>&raquo;<a title='"._ADD."' href='javascript:addImage(\"".$img.$filename."\"); self.close();'>$filename</a>&laquo;</td>
			<td>";
			if ($admin) {
				echo "<a href='"._REQUEST_URI."&delete=$path$filename'><img src='".RCX_URL."/images/x.gif' border='0' alt='"._DELETE."'></a>";
				} else {
					echo "&nbsp;";
				}
			echo "</td></tr>";
		}
	}
}
?>
<script type="text/javascript">
<!--
function addImage(imgurl) {
var txtbox  = window.opener.rcxGetElementById("<?php echo $target;?>");
var align   = prompt("<?php echo _ENTERIMGPOS;?>\n<?php echo _IMGPOSRORL;?>", "");
while ( ( align != "" ) && ( align != "r" ) && ( align != "R" ) && ( align != "l" ) && ( align != "L" ) && ( align != null ) ) {
	align = prompt("<?php echo _ERRORIMGPOS;?>\n<?php echo _IMGPOSRORL;?>", "");
}
if ( align == "l" || align == "L" ) {
	align = " align=left";
	} else if ( align == "r" || align == "R" ) {
		align = " align=right";
		} else {
			align = "";
		}
txtbox.value += "[lib" + align + "]" + imgurl + "[/lib]";
return;
}
//-->
</script>
<br />
<h4 align="center"><?php echo _IMG_PICKER;?></h4>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0"><tr>
<?php
if ($admin || ($rcxUser && $rcxConfig['lib_allow_upload'] == 1)) {
?>
<td>
<?php
if ( !empty($_FILES['image']['name']) ) {
	include_once(RCX_ROOT_PATH."/class/fileupload.php");
	$upload = new fileupload();
	$upload->set_upload_dir(RCX_ROOT_PATH . "/images/$path", 'image');
	$upload->set_accepted("gif|jpg|png", 'image');
	if (!$admin) {
		$upload->set_max_image_height($rcxConfig['lib_height'], 'image');
		$upload->set_max_image_width($rcxConfig['lib_width'], 'image');
		$upload->set_max_file_size($rcxConfig['lib_maxsize'], 'image');
	}
	$upload->set_overwrite(1, 'image');
	$result = $upload->upload();
	if (!$result) {
		$upload->errors(1);
	}
	} elseif ($admin && preg_match("'^library/[a-z0-9_/-]+\.(gif|jpg|png)$'i", $_GET["delete"])) {
		if ( @file_exists(RCX_ROOT_PATH . "/images/" . $_GET["delete"]) ) {
			unlink(RCX_ROOT_PATH . "/images/" . $_GET["delete"]);
		}
	}
?>
<form name="upload" enctype="multipart/form-data" method="post" action="<?php echo _REQUEST_URI;?>">
<input type="file" class="file" name="image" id="image" onchange="rcxGetElementById('preview').src=this.value;" />
<br /><input type="submit" class="button" name="submit" value="<?php echo _SUBMIT;?>"/>
</td></form></tr><tr>
<?php } ?>
<td align="center"><hr size="1" noshade="noshade" /></td>
</tr><tr>
<td align="center" height="70"><img src="<?php echo RCX_URL;?>/images/pixel.gif" id="preview" name="preview" width="50" /></td>
</tr><tr>
<td align="center"><hr size="1" noshade="noshade" /></td>
</tr><tr>
<td>
<a href="<?php echo _REQUEST_URI;?>&path=images/"><b>...</b></a><br /><br />
 <img src="<?php echo RCX_URL;?>/images/menu/tree_open.gif" alt=""/> <?php echo $path;?>
<table><?php getImages($path);?></table>
<br />
<div align="center">
<a href="<?php echo _REQUEST_URI;?>&showall=1"><b>:: <?php echo _IMG_EXPAND;?> ::</b></a> &nbsp; &nbsp;
<a href="<?php echo _REQUEST_URI;?>&showall=0"><b>:: <?php echo _IMG_COLLAPSE;?> ::</b></a>
</div>
<br />
</td>
</tr></table>
