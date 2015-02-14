<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');
include_once(RCX_ROOT_PATH.'/class/eseditor/eseditor.php'); //integration af ESEditor
?>
<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>
<td>
<form action="./submit.php" method="post" id="storyform" onsubmit="return rcxValidate('subject', 'hometext', 'news_submit');">
<br /><br /><b><?php echo _NW_YOURNAME;?>:</b>
<?php
if ($rcxUser) {
  echo "<a href='".RCX_URL."/userinfo.php?uid=".$rcxUser->getVar("uid")."'>".$rcxUser->getVar("uname")."</a>&nbsp;[&nbsp;<a href='".RCX_URL."/user.php?op=logout'>"._NW_LOGOUT."</a>&nbsp;]";
  } else {
    echo "<b>".$rcxConfig['anonymous']."</b> [ <a href='".RCX_URL."/register.php'>"._NW_REGISTER."</a> ]";
  }
?>
<br /><br />
<b><?php echo _NW_TITLE;?></b>&nbsp;(<?php echo _NW_BECLEAR;?>)<br />
<input type="text" class="text" name="subject" id="subject" value="<?php echo $_POST['subject'];?>" size="50" maxlength="255" />
&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo _NW_TOPIC;?></b>&nbsp;<?php $xt->makeTopicSelBox(0); ?>
<br />(<?php echo _NW_BADTITLES;?>)<br />
<?php
//integration ESeditor
$admin = 0;
if ($rcxUser && $rcxUser->isAdmin()) {
  $admin = 1;
}
echo "<br /><br /><b>"._NW_THESCOOP."</b><br /><br />";
//ESeditor integration
$runESeditor = new ESeditor('hometext');
$runESeditor->BasePath = RCX_URL."/class/eseditor/";
if ($runESeditor->IsCompatible() && $editorConfig["displayeditor"] == 1 && $editorConfig["displayforuser"] == 1 && $rcxUser)
{
  $runESeditor->Value = $hometext ;
  if($admin == 1 ){
  $runESeditor->ToolbarSet = 'rcx_lib' ;
  }else{
  $runESeditor->ToolbarSet = 'UserToolbar';
  }
  echo $runESeditor->Create('hometext') ;
  echo "<br /><br /><br /><b>"._NW_MORE."</b><br /><br />";
  echo _NW_PAGEBREAK."<br /><br />";
  $run2ESeditor = new ESeditor('moretext');
  $run2ESeditor->BasePath = RCX_URL."/class/eseditor/";
  $run2ESeditor->Value = $moretext;
  if($admin == 1 ){
  $run2ESeditor->ToolbarSet = 'rcx_lib' ;
  }else{
  $run2ESeditor->ToolbarSet = 'UserToolbar';
  }
  echo $run2ESeditor->Create('moretext');
  echo "<input type='hidden' name='allow_html' value='2' />";
}
else
{
$desc = new RcxFormDhtmlTextArea('', 'hometext', $hometext);
echo $desc->render();
echo "<br /><br /><br /><b>"._NW_MORE."</b><br /><br />";
echo _NW_PAGEBREAK;
echo "<br /><br />";
$desc = new RcxFormDhtmlTextArea('', 'moretext', $moretext);
echo $desc->render();
echo "<br /><br />";
echo _ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0' || $_POST['allow_html'] == '0') {
  $option0 = " selected";
  } elseif ($allow_html == '2' || $_POST['allow_html'] == '2') {
    $option2 = " selected";
    } else {
      $option1 = " selected";
    }
echo "<br /><br />
<select class='select' name='allow_html'>
<option value='0'$option0>"._HTMLOFF."</option>
<option value='1'$option1>"._HTMLAUTOWRAP."</option>
<option value='2'$option2>"._HTMLNOAUTOWRAP."</option>
</select><br><br>";
}
//slut på integration ESeditor
echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if (!isPost() || $_POST['allow_smileys'] == 1) {
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."<br />";
// aktiver bbcode?
echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if (!isPost() || $_POST['allow_bbcode'] == 1) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";
if ( $rcxUser && $rcxConfig['anonpost'] ) {
  echo "<input type='checkbox' class='checkbox' value='1' name='noname'";
  if ( !empty($noname) ) {
    echo " checked='checked'";
  }
  echo " /> "._NW_POSTANON."<br />";
}
if ($rcxUser) {
  echo "<input type='checkbox' class='checkbox' name='notifypub' value='1'";
  if ( !empty($notifypub) ) {
    echo " checked='checked'";
  }
  echo " /> "._NW_NOTIFYPUBLISH."<br />";
  } else {
    echo "<input type='hidden' name='notifypub' value='0' /><br />";
  }
?>
<br />
<select class="select" name="op">
<option value="preview" selected="selected"><?php echo _NW_PREVIEW;?></option>
<option value="post"><?php echo _NW_POST;?></option>
</select>
<?php 

$rcx_token = & RcxToken::getInstance();

echo $rcx_token->getTokenHTML();

?>
<input type="submit" class="button" value="<?php echo _GO;?>" name="news_submit" id="news_submit" />
</form>
</td></tr></table>
