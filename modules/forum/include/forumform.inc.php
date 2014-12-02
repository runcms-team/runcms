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

include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');
// alphalogic's attachment hack --->
include_once(RCX_ROOT_PATH.'/class/fileupload.php');
// <---

include_once('./cache/config.php');

if ( $forumConfig['disc_show'] == 3 || ($isreply && $forumConfig['disc_show'] == 2) || (empty($editpost) && $forumConfig['disc_show'] == 1) ) {
  $disclaimer = join('', file("./cache/disclaimer.php"));
  if ($disclaimer != "") {
    OpenTable();
    $myts->setType('admin');
    echo $myts->makeTareaData4Show($disclaimer, 1, 1, 1);
    CloseTable();
    echo "<br /><br />";
  }
}

// Bit of a hack to retieve data for certain fields when the form is
// submitted by pressing the 'Add Option' button for polls.
if ($subject == '') $subject = $_REQUEST['subject'];
if ($message == '') $message = $_REQUEST['message'];
if ($addpoll == '') $addpoll = $_REQUEST['addpoll'];

$nextcolor = 'bg1';
echo "
<table border='0' cellpadding='1' cellspacing='1' width='100%' class='bg2'>
<tr class='$nextcolor' align='left'>
<form action='post.php' method='post' name='forumform' id='forumform' onsubmit='return rcxValidate(\"subject\", \"message\", \"contents_submit\");' enctype='multipart/form-data'>
<td width='30%' valign='top' style='white-space: nowrap;'><b>". _MD_YOURNAME ."</b></td><td>";

if ($rcxUser) {
  echo "
  <a href='".RCX_URL."/userinfo.php?uid=".$rcxUser->getVar("uid")."'>".$rcxUser->getVar("uname")."</a>
  [ <a href='".RCX_URL."/user.php?op=logout'>"._MD_LOGOUT."</a> ]";
  } else {
    $anon_uname = (!empty($anon_uname)) ? $anon_uname : $rcxConfig['anonymous'];
    echo "<input type='text' class='text' name='anon_uname' value='$anon_uname'> &nbsp;&nbsp;
    [ <a href='".RCX_URL."/register.php'>"._MD_REGISTER."</a> ]";
  }
  
$nextcolor = ($nextcolor=='bg1') ? 'bg3' : 'bg1';
echo "
</td></tr>
<tr class='$nextcolor' align='left'>
<td valign='top' style='white-space: nowrap;'><b>". _MD_SUBJECTC ."</b></td>
<td>";

if ( !$istopic ) {
  if ( !preg_match("/^re:/i", $subject) ) {
    $subject = "Re: ".substr($subject, 0, 81);
  }
}

$nextcolor = ($nextcolor=='bg1') ? 'bg3' : 'bg1';
echo "
<input type='text' class='text' id='subject' name='subject' size='60' maxlength='100' value='".$subject."' /></td></tr>";
//show the options for create a polls here
if ($addpoll==1 && ($forumdata['allow_polls']==1) && ( $istopic )&&($pagetype != "edit"))
{
  echo "<input type='hidden' name='addpoll' value='1'>";
  echo "<tr class='$nextcolor' align='left'>";
  echo "<td valign='top' style='white-space: nowrap;'><b>"._MD_POLL."</b></td>\n";
  echo "<td>";
  
  echo "<table>";
  echo "<tr>";
  echo "<td>"._MD_POLLQUESTION.":</td><td><input type='text' name='poll_question' value='".$poll_question."' size='54' class='text'/></td>\n"; 
  echo "</tr>";
  $cpt=0;

  for($i=0;$i<count($option);$i++)
    { 
    $optiontxt=$option[$i];
    if(($option[$i]!=""))
      {
      echo "<tr>";
      echo "<td>"._MD_POLLOPTIONS.":</td><td><input type='text' class='text' id='option".$cpt."' name='option[".$cpt."]' value=\"$optiontxt\" size='25' />&nbsp;<input type='hidden' value='' name='del_poll_option".$cpt."' />&nbsp;".print_colorbar_combo('bar_color['.$cpt.']', $bar_color[$cpt])."&nbsp;<input type='button' onclick=\"annule('".$cpt."');document.forumform.action='newtopic.php';document.forumform.submit();\" name='delbutton' value=\""._DELETE."\" class=\"button\" /></td>\n"; 
      echo "</tr>";
      $cpt++;
      }
    }
  echo "<tr>";
  echo "<td>"._MD_POLLOPTIONS.":</td><td><input type='text' class='text' name='option[".$cpt."]' size='25' />&nbsp;&nbsp;".print_colorbar_combo('bar_color['.$cpt.']')."&nbsp;<input type='button' onclick=\"document.forumform.action='newtopic.php';document.forumform.submit();\" name='add_poll_option' value=\""._MD_ADDPOLLOPTION."\" class=\"button\"/></td>\n";
  echo "</tr>";
  echo "<tr>";
  if (intval($poll_expire) == 0) $poll_expire = 7;
  echo "<td>"._MD_POLLEXPIRETIME.":</td><td><input type='text' class='text' name='poll_expire' size='10' value='".$poll_expire."'/>&nbsp;"._MD_DAYS."</td>\n";
  echo "</tr>";
  echo "</table>";
  echo "</td></tr>";
  $nextcolor = ($nextcolor=='bg1') ? 'bg3' : 'bg1';
} 
  // End show

echo "<tr class='$nextcolor' align='left'>
<td valign='top' style='white-space: nowrap;'><b>"._MD_MESSAGEC."</b><br /><br />"._MD_MESSAGEICON."<br />";
echo "<table ='100%' align=left><tr align='left'>
<td>";
$lists    = new RcxLists;
$filelist = $lists->getSubjectsList();
$count    = 1;
while ( list($key, $file) = each($filelist) ) {
  $checked = "";
  if ( isset($icon) && $file == $icon ) {
    $checked = " checked='checked'";
  }
  echo "
  <input type='radio' class='radio' value='$file' name='icon'$checked />
  <img src='".RCX_URL."/images/subject/$file' alt='#' />";
  if ($count == 4) {
    echo "<br />";
    $count = 0;
  }
  $count++;
}
echo "</td></tr></table>";
echo "</td>
<td><br />";

//$desc = new RcxFormDhtmlTextArea('', 'message', $message, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'message', $message);
echo $desc->render();

if ( !empty($isreply) && isset($hidden) && $hidden != "" ) {
  echo "
  <input type='hidden' name='isreply' value='1' />
  <input type='hidden' name='hidden' id='hidden' value='$hidden' />
  <input type='button' class='button' name='quote' value='"._MD_QUOTE."' onclick='rcxGetElementById(\"message\").value=rcxGetElementById(\"message\").value + rcxGetElementById(\"hidden\").value; rcxGetElementById(\"hidden\").value=\"\";' />
  <br />";
}

echo "<br /><br />";

$nextcolor = ($nextcolor=='bg1') ? 'bg3' : 'bg1';
echo "
</td></tr>
<tr class='$nextcolor' align='left'>
<td valign='top' style='white-space: nowrap;'><b>"._MD_OPTIONS."</b></td>
<td>";

// Allow html?
if ( $rcxUser && !empty($forumdata['allow_html']) ) {
  echo _MD_ALLOWEDHTML."<br />";
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
  </select><br />";
  } else {
    echo "<input type='hidden' name='allow_html' value='0'>";
  }

// Enable Smileys?
echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if (!isPost() || $_POST['allow_smileys'] == 1) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLESMILEY."<br />";

// Enable bbcode?
echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if (!isPost() || $_POST['allow_bbcode'] == 1) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";


if ($rcxUser && !empty($editpost) ) {

// Add edited? <---
echo "<input type='checkbox' name='add_edited' value='1'";
echo " checked='checked'";
echo " />&nbsp;"._MD_ADDEDITED."<br />";
// --->

  echo "<input type='hidden' name='editpost' value='1' />";
}

if ($rcxUser && isset($istopic) && $istopic) {
  echo "<input type='hidden' name='istopic' value='1' />";
  echo "<input type='checkbox' class='checkbox' name='notify' value='1'";
  if ( isset($notify) && $notify ) {
    echo " checked='checked'";
  }
  echo " />&nbsp;"._MD_EMAILNOTIFY."<br />";
}

if ( $rcxUser && !$post_id && $forumConfig['post_anon']) {
  echo "<input type='checkbox' class='checkbox' name='noname' value='1'";
  if ( isset($noname) && $noname ) {
    echo " checked='checked'";
  }
  echo " />&nbsp;"._MD_POSTANONLY."<br />";
}

if ( $forumdata['allow_sig'] && $rcxUser ) {
  echo "<input type='checkbox' class='checkbox' name='attachsig' value='1'";
  if ( isset($_POST['contents_preview'] ) ) {
    if ( $attachsig ) {
      echo " checked='checked' />&nbsp;";
      } else {
        echo " />&nbsp;";
      }
    } elseif ( isset($attachsig) && $attachsig == 1 ) {
      echo " checked='checked' />&nbsp;";
      } elseif ( isset($attachsig) && $attachsig == 0 ) {
        echo "/>&nbsp;";
        } else {
          if ( $rcxUser->getVar("attachsig") ) {
            echo " checked='checked' />&nbsp;";
            } else {
              echo "/>&nbsp;";
            }
        }

  echo _MD_ATTACHSIG."<br />";
}

$nextcolor = ($nextcolor=='bg1') ? 'bg3' : 'bg1';
echo "</td></tr>";
//  alphalogic's attachment hack
if (empty($editpost) && ($forumdata['allow_attachments']==1) && $permissions->can_attach)
{
  echo "<tr class='$nextcolor' align='left'><td valign='top' style='white-space: nowrap;'><b>"._MD_ATTACHMENT."</b></td><td>";
  $upload = new fileupload();

  for($i = 0; $i<5; $i++)
  {
    $upload->set_max_file_size($forumdata['attach_maxkb'], 'k', "attachment_$i");
      $upload->set_accepted($forumdata['attach_ext'],"attachment_$i");
    $upload->render(1, "attachment_$i");
    echo "<br />";
  }
  echo '<b>'._MD_ALLOWED_EXTENSIONS.':</b><br>';
  echo '<i>'.str_replace('|',' ',$forumdata['attach_ext']).'</i>';
  echo "</td></tr>";
  $nextcolor = ($nextcolor=='bg1') ? 'bg3' : 'bg1';
}

// 
echo "
</td></tr>
<tr class='$nextcolor' align='left'><td colspan='2' align='center'><br />
<input type='hidden' name='pid' value='".intval($pid)."' />
<input type='hidden' name='post_id' value='".intval($post_id)."' />
<input type='hidden' name='topic_id' value='".intval($topic_id)."' />
<input type='hidden' name='forum' value='".intval($forum)."' />
<input type='hidden' name='viewmode' value='$viewmode' />
<input type='hidden' name='order' value='".intval($order)."' />";
if(!$addpoll)
{
  echo "<input type='submit' class='button' name='contents_preview' value='"._PREVIEW."' />&nbsp;";
}
echo "<input type='submit' class='button' name='contents_submit' id='contents_submit' value='"._SUBMIT."' />
<input type='button' class='button' onclick='location=\"";

if ( isset($topic_id) && $topic_id != "" ) {
  echo "viewtopic.php?topic_id=".intval($topic_id)."&amp;forum=".intval($forum)."\"'";
  } else {
    echo "viewforum.php?forum=".intval($forum)."\"'";
  }

echo " value='"._CANCEL."' /></form></td></tr></table>";
?>
