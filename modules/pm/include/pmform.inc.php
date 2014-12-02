<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined('RCX_URL')) die('Empty PM');

include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');
include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH.'/class/fileupload.php');
include_once(RCX_ROOT_PATH.'/class/groupaccess.php');
include_once('cache/config.php');
global $rcxConfig, $rcxUser, $db, $myts;

$sql = "SELECT msg_disclaimer, msg_showdisc FROM ".$db->prefix("pm_msgs_config")." WHERE msg_uid=".$to_userid."";
$result = $db->query($sql);
while ( $myrow = $db->fetch_array($result) ) {
    $ret[0] = $myrow['msg_disclaimer'];
    $ret[1] = $myrow['msg_showdisc'];
    }
$disclaimer = $myts->makeTareaData4Show($ret[0],1,1,1);
//added by EsseBe for integration of pm module
$thisUser= new RcxUser($to_userid);
$module = RcxModule::getByDirname('pm');
if ( !RcxGroup::checkRight('module', $module->mid(), $thisUser->groups()) ) {
  echo _PM_US_NOT_AUTORIZED;
}else{
//end added
if ($ret[1] == 1) {
?>
<table width="60%" align="center"><tr><td class="bg3" ><?php echo $disclaimer;?></td></tr></table>
<?php
}
?>
<form action="pmlite.php" method="POST" onsubmit='return setRequired("subject", "message" );' enctype='multipart/form-data'><br />
<table width="100%" align="center"><tr>
<td class="bg3" nowrap><b><?php echo _PM_TO;?><b></td>

<?php

//|| ($reply == 1) || ($_POST['op'] == 'preview')
if ( ($to_userid)  ) {
  echo "<td class='bg1'><input type='hidden' name='to_userid' value='".$pm->getVar("to_userid")."' />".$pm_uname."</td>";
  } //else {
    //echo "<td class='bg1'><select class='select' name='to_userid'>";
    //$result = $db->query("SELECT uid, uname FROM ".$db->prefix("users")." WHERE level > 0 ORDER BY uname");
    //while ( list($ftouid, $ftouname) = $db->fetch_row($result) ) {
      //echo "<option value='".$ftouid."'>".$myts->makeTboxData4Show($ftouname)."</option>";
    //}
    //echo '</select></td>';
  //}

  ?>
  </tr><tr align="left">
  <td class="bg3" nowrap><b><?php echo _PM_SUBJECTC;?><b></td>
  <td class="bg1"><input type="text" class="text" name="subject" value="<?php echo $subject;?>" size="30" maxlength="60" /></td>
  </tr>
  <tr>
  <td class="bg3" nowrap><b><?php echo _PM_SUBJECTICON;?><b></td>
  <td>
  <table><tr align='left'>
  <td>
<?php
$lists    = new RcxLists;
$filelist = $lists->getSubjectsList();
$count    = 1;
while ( list($key, $file) = each($filelist) ) {
  $checked = "";
  if ( isset($msg_image) && $file == $msg_image ) {
    $checked = " checked='checked'";
  }
  echo "
  <input type='radio' class='radio' value='$file' name='msg_image'$checked />
  <img src='".RCX_URL."/images/subject/$file' alt='' />";
  if ($count == 8) {
    echo "<br />";
    $count = 0;
  }
  $count++;
}
?>

  </td></tr></table></td></tr>
    
  <tr align="left" valign="top">
  <td class="bg3" nowrap><b><?php echo _PM_MESSAGEC;?></b></td>
  <td class="bg1">
  <?php

//  $desc  = new RcxFormDhtmlTextArea('', 'message', $message, 15, 58);
  $desc  = new RcxFormDhtmlTextArea('', 'message', $message);
  echo $desc->render();

  echo "
  &nbsp; &nbsp; <input type='reset' class='button' value='"._RESET."' /></td>
  </tr>";
// if allow upload is tru
  if ($pmConfig['allow_upload'] == 1) {

// if allow upload by group 
  $groupid = $pmConfig['allow_group'];
  $groupid = explode(" ",$groupid);
  
  $usergroup = RcxGroup::getByUser($rcxUser);
  $ret = 0;
  foreach($usergroup as $value) {
    if (in_array($value,$groupid)){
      $ret = 1;       
      }
    }
  
  if ($ret == 1){ 
  echo "<tr align='left' valign='top'>
  <td class='bg3' nowrap><b>". _PM_UPLOAD."</b></td>
  <td calss='bg1'>";
  $upload = new fileupload();
  $upload->set_max_file_size($pmConfig['upload_limit'], 'k' , 'msg_attachment');
  $upload->set_accepted($pmConfig['accepted_files'],'msg_attachment');
  $upload->render(1, 'msg_attachment');
  echo " <br>"._UPLOADLIMIT."<b> " . $pmConfig['upload_limit'] . "</b> " . _BYTES." "._MAX ;
  echo "<br>"._UPLOADACCEPTED."<b> ".$pmConfig['accepted_files']."</b>";
  echo "</td></tr>";
    }
  }
  
echo "<tr><td colspan='2'><br />";
  if ( !empty($rcxConfig['allow_html']) ) {
    echo _ALLOWEDHTML.'<br />';
    echo get_allowed_html();
    if ($_POST['allow_html'] == '0') {
      $option0 = ' selected';
      } elseif ($_POST['allow_html'] == '2') {
        $option2 = ' selected';
        } else {
          $option1 = ' selected';
        }
    echo "
    <br /><br />
    <select class='select' name='allow_html'>
    <option value='0'$option0>"._HTMLOFF."</option>
    <option value='1'$option1>"._HTMLAUTOWRAP."</option>
    <option value='2'$option2>"._HTMLNOAUTOWRAP."</option>
    </select><br />";
    } else {
      echo "<input type='hidden' name='allow_html' value='0'>";
    }

  echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
  if (!isPost() || $_POST['allow_smileys'] == 1) {
    echo " checked='checked'";
    }
  echo ' /> '._ENABLESMILEY.'<br />';

  // Enable bbcode?
  echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
  if (!isPost() || $_POST['allow_bbcode'] == 1) {
    echo " checked='checked'";
  }
  echo ' />&nbsp;'._ENABLEBBCODE.'<br />';
    
?>

</td></tr><tr>
<td class="bg1" colspan="2" align="center">
<?php
if ($reply == 1) {
echo "<input type='hidden' name='msg_replay' value='1'>";
echo "<input type='hidden' name='msg_id1' value='".$msg_id."'>";    
}
?>
<input type="submit" class="button" name="submit" value="<?php echo _SEND;?>">
<input type="submit" class="button" name="preview" value="<?php echo _PREVIEW;?>">
<input type="button" class="button" name="cancel" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1);" />
</td></tr></table></form>
<?php
//added by EsseBe for integration of pm module
}