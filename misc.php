<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("./mainfile.php");

global $_POST, $_GET;

$type = $_GET['type'];
$action = $_GET['action'];
$target = $_GET['target'];
$subdir = $_GET['subdir'];
$start = $_GET['start'];

if ( $action == "showpopups" ) {
	rcx_header(false);
	$closebutton = 1;

switch ( $type ) {

case "images":
	include_once("./include/image_manager.php");
	break;

case "smilies":
	echo "
	<script type='text/javascript'>
	<!--
	function doSmilie(addSmilie) {
	var currentMessage = window.opener.rcxGetElementById(\"".$target."\").value;
	window.opener.rcxGetElementById(\"".$target."\").value=currentMessage+addSmilie;
	return;
	}
	//-->
	</script>
	</head><body class='sysbody'>
	<table width='100%'><tr>
	<td colspan='3'><big><b>"._SMILIES."</b></big><br />"._CLICKASMILIE."</td>
	</tr><tr class='bg2'>
	<td><b>"._CODE."</b></td>
	<td><b>"._EMOTION."</b></td>
	<td><b>"._IMAGE."</b></td>
	</tr>";

	if ( $getsmiles = $db->query("SELECT code, emotion, smile_url FROM ".$db->prefix("smiles")) ) {
		$rcolor = 'bg1';
		while ( $smile = $db->fetch_array($getsmiles) ) {
			echo "<tr class='$rcolor'><td>".$smile['code']."</td><td>".$smile['emotion']."</td><td><a href='javascript: justReturn()' onclick='doSmilie(\" ".$smile['code']." \");'><img src='".formatURL(RCX_URL."/images/smilies/", $smile['smile_url'])."' alt='' /></a></td></tr>";
			if ( $rcolor == 'bg1' ) {
				$rcolor = 'bg2';
				} else {
					$rcolor = 'bg1';
				}
			}
			} else {
				echo "Could not retrieve data from the database.";
			}
			echo "</table>";
	break;

case "avatars":
	if ( $rcxUser && $rcxUser->isAdmin() && !empty($_FILES['image']['name']) ) {
		include_once(RCX_ROOT_PATH."/class/fileupload.php");
		$upload = new fileupload();
		$upload->set_upload_dir(RCX_ROOT_PATH . "/images/avatar/$subdir", 'image');
		$upload->set_accepted("gif|jpg|png", 'image');
		$upload->set_max_image_height($rcxConfig['avatar_height'], 'image');
		$upload->set_max_image_width($rcxConfig['avatar_width']  , 'image');
		$upload->set_overwrite(1, 'image');
		$result = $upload->upload();
		if (!$result) {
			$upload->errors(1);
			} else {
				?>
				<script type='text/javascript'>
				window.opener.location.reload();
				</script>
				<?php
			}
		} elseif ( $_GET["delete"] && $rcxUser && $rcxUser->isAdmin() && preg_match("'[a-z0-9_/-]+\.(gif|jpg|png)$'i", $_GET["delete"]) ) {
			if ( @file_exists(RCX_ROOT_PATH . "/images/avatar/" . $_GET["delete"]) ) {
				unlink(RCX_ROOT_PATH . "/images/avatar/" . $_GET["delete"]);
				?>
				<script type='text/javascript'>
					window.opener.location.reload();
				</script>
				<?php
			}
		}
	?>
	<script type='text/javascript'>
	<!--
	function myimage_onclick(counter) {
	xselect = window.opener.rcxGetElementById("user_avatar");
	ximage  = window.opener.rcxGetElementById("avatar");

	xselect.options[counter].selected = true;
	ximage.src='<?php echo RCX_URL;?>/images/avatar/' + xselect.options[counter].value;
	window.close();
	}
	//-->
	</script>
	</head><body>
	<h4><?php echo _AVAVATARS;?></h4>
	<?php
	include_once(RCX_ROOT_PATH."/class/rcxlists.php");
	if ( !isset($subdir) ) {
		$subdir = "";
	}
	$lists       = new RcxLists;
	$avatarslist = $lists->getAvatarsList($subdir);
	$counter     = isset($start) ? intval($start) : 0;
	foreach ($avatarslist as $avatar) {
		echo "<span><a href='javascript:void();'><img src='images/avatar/".$avatar."' alt='"._SELECT.": ".$avatar."' onclick='myimage_onclick($counter)' hspace='5' vspace='5' border='0' /></a>";
		if ($rcxUser && $rcxUser->isAdmin() && ($avatar != "blank.gif")) {
			echo "<a href='"._REQUEST_URI."&delete=$avatar'><img src='".RCX_URL."/images/x.gif' border='0' alt='"._DELETE.": ".$avatar."' /></a>";
		}
		echo "</span>";
		$counter++;
	}
	if ($rcxUser && $rcxUser->isAdmin()) {
		?>
		<div align="center">
		<form name="upload" enctype="multipart/form-data" method="post" action="<?php echo _REQUEST_URI;?>">
		<input type="file" name="image" id="image" />
		<input type="submit" class="button" name="submit" value="<?php echo _UPLOADAVATAR;?>">
		</td></form></div>
		<?php
	}
	break;

case "friend":
	if ( !isset($op) || $op == "sendform" ) {
		if ( $rcxUser ) {
			$yname = $rcxUser->getVar("uname");
			$ymail = $rcxUser->getVar("email");
			$fname = "";
			$fmail = "";
			} else {
				break;
			}
		printCheckForm();

		echo "
		</head><body>
		<table width='100%' border='0' cellspacing='1' cellpadding='0'><tr class='bg2'><td valign='top'>
		<table width='100%' border='0' cellspacing='1' cellpadding='8'><tr class='bg3'><td valign='top'>
		<h4>"._RECOMMENDSITE."</h4>
		<form action='".RCX_URL."/misc.php' method='post' id='friend' onsubmit='return checkForm();'>
		<table width='100%'><tr><td>
		<input type='hidden' name='op' value='sendsite' />
		<input type='hidden' name='action' value='showpopups' />
		<input type='hidden' name='type' value='friend' />
		"._YOURNAMEC."</td><td><input type='text' class='text' name='yname' value='$yname' id='yname' /></td></tr>
		<tr><td>"._YOUREMAILC."</td><td>".$ymail."</td></tr>
		<tr><td>"._FRIENDNAMEC."</td><td><input type='text' class='text' name='fname' value='$fname' id='fname' /></td></tr>
		<tr><td>"._FRIENDEMAILC."</td><td><input type='text' class='text' name='fmail' value='$fmail' id='fmail' /></td></tr>
		<tr><td align='center' colspan='2'><br /><br /><input type='submit' class='button' value='"._SEND."' />&nbsp;<input value='"._CLOSE."' type='button' class='button' onclick='javascript:window.close();' /></td></tr>
		</table></form>";

		$closebutton = 0;
		echo "</td></tr></table></td></tr></table>";
		} elseif ( $op == "sendsite" ) {
			if ( $rcxUser ) {
				$ymail = $rcxUser->getVar("email");
				} else {
					break;
				}
			if ( !isset($yname) || $yname == "" || !isset($fname) || $fname == ""  || !$fmail ) {
				redirect_header(RCX_URL."/misc.php?action=showpopups&amp;type=friend&amp;op=sendform",2,_NEEDINFO);
				exit();
				}
			if ( !checkEmail($fmail) ) {
				$errormessage = _INVALIDEMAIL1."<br />"._INVALIDEMAIL2."";
				redirect_header(RCX_URL."/misc.php?action=showpopups&amp;type=friend&amp;op=sendform",2,$errormessage);
				exit();
				}
			$rcxMailer =& getMailer();
			$rcxMailer->setTemplate("tellfriend.tpl");
			$rcxMailer->assign("SITENAME", $meta['title']);
			$rcxMailer->assign("ADMINMAIL", $rcxConfig['adminmail']);
			$rcxMailer->assign("SITEURL", RCX_URL."/");
			$rcxMailer->assign("YOUR_NAME", $yname);
			$rcxMailer->assign("FRIEND_NAME", $fname);
			$rcxMailer->setToEmails($fmail);
			$rcxMailer->setFromEmail($rcxUser->getVar("email"));
			$rcxMailer->setFromName($yname);
			$rcxMailer->setSubject(sprintf(_INTSITE, $meta['title']));
			echo "
			<table width='100%' border='0' cellspacing='1' cellpadding='0'><tr class='bg2'><td valign='top'>
			<table width='100%' border='0' cellspacing='1' cellpadding='8'><tr class='bg3'><td valign='top'>";
			if ( !$rcxMailer->send() ) {
				echo $rcxMailer->getErrors();
				} else {
					echo "<h5>"._REFERENCESENT."</h5>";
				}
			echo "</td></tr></table></td></tr></table>";
			}
	break;
}

if ($closebutton) {
	echo "<div align='center'><input value='"._CLOSE."' type='button' class='button' onclick='javascript:window.close();' /></div><br />";
}

rcx_footer(0);
}


function printCheckForm() {
?>
<script type='text/javascript'>
<!--
function checkForm() {
if ( rcxGetElementById("yname").value == "" ) {
	alert( "<?php echo _ENTERYNAME;?>" );
	rcxGetElementById("yname").focus();
	return false;
	} else if ( rcxGetElementById("fname").value == "" ) {
		alert( "<?php echo _ENTERFNAME;?>" );
		rcxGetElementById("fname").focus();
		return false;
	} else if ( rcxGetElementById("fmail").value =="") {
		alert( "<?php echo _ENTERFMAIL;?>" );
		rcxGetElementById("fmail").focus();
		return false;
	} else {
		return true;
	}
}
//--->
</script>
<?php
}
?>
