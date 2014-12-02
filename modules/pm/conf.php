<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

//include_once('../../mainfile.php');
include_once('header.php');
function config(){
include_once("cache/config.php");
include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
global $db, $rcxUser, $myts;


$sql = "SELECT * FROM ".$db->prefix("pm_msgs_config")." WHERE msg_uid=".$rcxUser->getVar("uid")."";
$result = $db->query($sql);

while ( $myrow = $db->fetch_array($result) ) {
    $ret[0] = $myrow['msg_uid'];
    $ret[1] = $myrow['msg_mail'];
    $ret[2] = $myrow['msg_disclaimer'];
    $ret[3] = $myrow['msg_showdisc'];
    $ret[4] = $myrow['msg_showsend'];
    }

include_once('../../header.php');
OpenTable();
?>
<h4><?php echo _PM_CONFIG;?></h4><br />
<form action="conf.php" method="post">
<table width="100%" border="0">

<?php
if ($ret[0] != "") {
    $update = 1;
} else {
  $update = 0;
}

if ($pmConfig['sendmail']  == 1) {
      $chk1 = ''; $chk0 = '';
  ($ret[1] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
  ?>
  <tr><td nowrap><?php echo _PM_MAIL;?></td>
  <td width="100%">
  <input type="radio" class="radio" name="msg_mail" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
  <input type="radio" class="radio" name="msg_mail" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
  </td></tr>
<?php
}
$chk1 = ''; $chk0 = '';
  ($ret[3] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
  ?>
  <tr><td nowrap><?php echo _PM_SHOWDISC;?></td>
  <td width="100%">
  <input type="radio" class="radio" name="msg_showdisc" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
  <input type="radio" class="radio" name="msg_showdisc" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
  </td></tr>
<tr><td><?php echo _PM_DISCLAIMER;?></td><td>
<?php
$disclaimer = $myts->makeTareaData4PreviewInForm($ret[2]);
//$desc       = new RcxFormDhtmlTextArea('', 'disclaimer', $disclaimer, 10, 58);
$desc       = new RcxFormDhtmlTextArea('', 'disclaimer', $disclaimer);
echo $desc->render();
?>
</td></tr>
<?php
$chk1 = ''; $chk0 = '';
  ($ret[4] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
  ?>
  <tr><td nowrap><?php echo _PM_SHOWSEND;?></td>
  <td width="100%">
  <input type="radio" class="radio" name="msg_showsend" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
  <input type="radio" class="radio" name="msg_showsend" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
  </td></tr>

<tr><td colspan="2">
<input type="hidden" name="update" value=<?php echo $update;?>>
<input type="hidden" name="op" value="save">
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)">
</td></tr></table>
</form>
<?php
CloseTable();
include_once('../../footer.php');
}
//****************************
function save(){
global $_POST, $myts, $db, $rcxUser;

$msg_mail = intval($_POST['msg_mail']);
$update = intval($_POST['update']);
$msg_showdisc = intval($_POST['msg_showdisc']);
$disclaimer = $myts->makeTareaData4Save($_POST['disclaimer']);
$msg_showsend = intval($_POST['msg_showsend']);

if ($update == 0) {
    $sql = "INSERT INTO ".$db->prefix("pm_msgs_config")." SET 
    msg_uid=".$rcxUser->getVar('uid').",
    msg_mail=$msg_mail,
    msg_disclaimer='$disclaimer',
    msg_showdisc=$msg_showdisc,
    msg_showsend=$msg_showsend";
    
  if ( !$result = $db->query($sql) ) {
      $this->errors[] = _NOTUPDATED;
      return false;
  }
} else {
  $sql = "UPDATE ".$db->prefix("pm_msgs_config")." SET msg_uid=".$rcxUser->getVar('uid')." ,msg_mail=".$msg_mail.
  " ,msg_disclaimer='$disclaimer', msg_showdisc=$msg_showdisc, msg_showsend=$msg_showsend  WHERE msg_uid=".$rcxUser->getVar('uid')."";

  if ( !$result = $db->query($sql) ) {
    redirect_header("conf.php", 1, _NOTUPDATED);
    exit();
  }
}
redirect_header("index.php", 1, _UPDATED);
exit();
}
//******************************************
$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch ($op) {

case "save":
  save();
  break;

default:
  config();
  break;
}
?>
