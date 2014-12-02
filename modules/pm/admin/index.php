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

function config() {
include_once("../cache/config.php");
rcx_cp_header();
OpenTable();
$groupid = $pmConfig['allow_group'];
?>
<h4><?php echo _AM_PM_TEXT;?></h4><br />
<?php
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_FUNCTION, "button", _AM_PM_OLD, "button");
         $retur_button->setExtra("onClick=\"location='index.php?op=old_pm'\"");
             $form->addElement($retur_button); 

        $form->display(); 
?>
<form action="index.php" method="post">

<table width="100%" border="0"><tr>
<?php
$chk1 = ''; $chk0 = '';
($pmConfig['allow_upload'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td nowrap><?php echo _AM_PM_UPLOAD;?></td>
<td width="100%">
<input type="radio" class="radio" name="allow_upload" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="allow_upload" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr><tr>
<td nowrap><?php echo _AM_PM_UPLOAD_GROUP;?></td>
<td width="100%">
<?php
$uploadAccess = new groupAccess('uploadGroup');
$uploadAccess->loadGroupsOptions($groupid);
echo $uploadAccess->listGroups();
?>
</td></tr><tr>
<td nowrap><?php echo _AM_PM_DATEIGROESSE;?></td>
<td width="100%">
<input type="text" class="text" size="20" name="upload_limit" value="<?php echo $pmConfig['upload_limit'];?>" />
</td></tr><tr>

<td nowrap><?php echo _AM_PM_DATEIENDUNG;?></td>
<td width="100%">
<input type="text" class="text" size="30" name="accepted_files" value="<?php echo $pmConfig['accepted_files'];?>" />
</td></tr><tr>

<td nowrap><?php echo _AM_PM_PMS;?></td>
<td width="100%">
<input type="text" class="text" size="5" name="max_pms" value="<?php echo $pmConfig['max_pms'];?>" />
</td></tr><tr>

<td nowrap><?php echo _AM_PM_MAX_PMS_SEND;?></td>
<td width="100%">
<select  name="max_pms_send" class='select' >
	<option value='5' <?php if($pmConfig['max_pms_send'] ==5)echo "selected='selected'"; ?> >5</option>
	<option value='10' <?php if($pmConfig['max_pms_send'] ==10)echo "selected='selected'"; ?> >10</option>
	<option value='15' <?php if($pmConfig['max_pms_send'] ==15)echo "selected='selected'"; ?> >15</option>
	<option value='20' <?php if($pmConfig['max_pms_send'] ==20)echo "selected='selected'"; ?> >20</option>
</select>	
</td></tr><tr>

<?php
$chk1 = ''; $chk0 = '';
($pmConfig['sendmail'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td nowrap><?php echo _AM_PM_MAIL;?></td>
<td width="100%">
<input type="radio" class="radio" name="sendmail" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="sendmail" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td></tr>
<tr>
<td colspan="2">
<input type="hidden" name="op" value="save">
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)">
</td></tr></table>
</form>
<?php
CloseTable();
rcx_cp_footer();
}
//*******************************************
function save() {
global $_POST, $myts;

$content  = "<?php\n";
$content .= "\$pmConfig['allow_upload']		   = ".intval($_POST['allow_upload']).";\n";
$content .= "\$pmConfig['allow_group']		   = '".@implode(' ',$_POST['uploadGroup'])."';\n";
$content .= "\$pmConfig['accepted_files']      = '".$_POST['accepted_files']."';\n";
$content .= "\$pmConfig['upload_limit']        = ".intval($_POST['upload_limit']).";\n";
$content .= "\$pmConfig['max_pms']             = ".intval($_POST['max_pms']).";\n";
$content .= "\$pmConfig['max_pms_send']        = ".intval($_POST['max_pms_send']).";\n";
$content .= "\$pmConfig['sendmail']            = ".intval($_POST['sendmail']).";\n";
$content .= "?>";

$filename = "../cache/config.php";
if ( $file = fopen($filename, "w") ) {
	fwrite($file, $content);
	fclose($file);
	} else {
		redirect_header("index.php", 1, _NOTUPDATED);
		exit();
	}
redirect_header("index.php", 1, _UPDATED);
exit();
}
//---------------------------------------------------------------------------------------//
function del_old_pm ()  {
	global $_POST, $db;
			
			$datetime = $_POST['datetime'];
			$time = $datetime." 00:00:00";
			$timestart = strtotime($time);
		
		
			$result = $db->query("SELECT msg_id FROM ".$db->prefix("pm_msgs")." WHERE msg_time < $timestart");
			while ($myrow = $db->fetch_array($result)){
				$result1 = $db->query("SELECT msg_attachment FROM ".$db->prefix("pm_msgs")." WHERE msg_id =".$myrow['msg_id']."");
				list($attachment) = $db->fetch_row($result1);
				
				if ($attachment) {
					$file_csv = explode("|",$attachment);
					@unlink(RCX_ROOT_PATH.'/modules/pm/cache/files/'.$file_csv[1]);
				}

				$result2 = $db->query("DELETE FROM ".$db->prefix("pm_msgs")." WHERE msg_id=".$myrow['msg_id']."");

			}
			rcx_cp_header();
			OpenTable();
			
			echo _AM_PM_DELETED." - $datetime";
			
			closetable();
			rcx_cp_footer();
			//redirect_header("index.php", 1, _UPDATED);
			exit();
			
		}

//---------------------------------------------------------------------------------------//

function old_pm() {
rcx_cp_header();
OpenTable();
global $rcxTheme, $rcxconfig, $_POST, $_GET; 	
include(RCX_ROOT_PATH."/class/rcxformloader.php");

$my_form = new RcxThemeForm(_AM_PM_OLD,"oldpm","index.php",$method="POST");
$dateHeure  =  new RcxFormTextDateSelect(_AM_PM_DATE_TIME,"datetime",15,$value = time());
$my_form->addElement($dateHeure, true);

$hidden = new RcxFormHidden("op","del_old_pm");
$my_form->addElement($hidden, true);

$go = new RcxFormButton("","submit",_SUBMIT,submit,"onclick=\"if (window.confirm('"._AM_PM_ALERT."')) {return true;} else {return false;}\"");
$my_form->addElement($go, true);


$my_form->display();


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_GOBACK, "button",  _AM_PM_TEXT, "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 

closetable();
rcx_cp_footer();

}


//---------------------------------------------------------------------------------------//


$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch ($op) {

case "save":
	save();
	break;

case "del_old_pm":
	del_old_pm();
	break;
	
case "old_pm":
	old_pm();
	break;

default:
	config();
	break;
}
?>
