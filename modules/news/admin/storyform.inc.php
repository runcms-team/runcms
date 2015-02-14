<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if ( !preg_match("/index\.php/i", _PHP_SELF) ) {
  exit();
  }
include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');
include_once(RCX_ROOT_PATH.'/class/eseditor/eseditor.php'); //integration ESeditor
global $rcxConfig;
if ( is_object($story) && is_numeric($story->uid) ) {
  $uid    = $story->uid();
  $author = new RcxUser($uid);
  $author = $author->uname();
  } else {
    $uid    = $rcxUser->uid();
    $author = $rcxUser->uname();
  }
?>
<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td>
<?php echo _AM_POSTER;?>: <a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $uid;?>" target="_blank"><?php echo $author;?></a>
<form action="./index.php" method="post">
<b><?php echo _AM_TITLE;?></b><br />
<input type="text" class="text" name="title" id="title" value="<?php echo $title;?>" size="70" maxlength="255" />
&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo _AM_TOPIC;?></b>&nbsp;
<?php
$xt = new RcxTopic($db->prefix("topics"));
if (isset($topicid)) {
  $xt->makeTopicSelBox(0, $topicid, "topicid");
  } else {
    $xt->makeTopicSelBox(0, 0, "topicid");
  }
echo "<p><br /><b>"._AM_TOPICDISPLAY."</b>&nbsp;&nbsp;<input type='radio' class='radio' name='topicdisplay' value='1'";
if ( !isset($topicdisplay) || $topicdisplay == 1 ) {
  echo " checked='checked'";
}
echo " />"._YES."&nbsp;<input type='radio' class='radio' name='topicdisplay' value='0'";
if ($topicdisplay == 0) {
  echo " checked='checked'";
}
echo " />"._NO."&nbsp;&nbsp;&nbsp;";
echo "<b>"._AM_TOPICALIGN."</b>&nbsp;<select class='select' name='topicalign'>";
if ($topicalign == "L") {
  $selL = " selected='selected'";
  } elseif ($topicalign == "R") {
    $selR = " selected='selected'";
  }
echo "<option value='R'".$selR.">"._RIGHT."</option>";
echo "<option value='L'".$selL.">"._LEFT."</option>";
echo "</select>";
echo "<br />";
if (isset($ihome)) {
  puthome($ihome);
  } else {
    puthome();
  }
//integration af ESeditor
$admin = 0;
if ($rcxUser && $rcxUser->isAdmin()) {
  $admin = 1;
}
if($admin == 0 && $rcxConfig['allow_library'] == 0){
  $toolbar = 'rcx' ;
  }else{
  $toolbar = 'rcx_lib' ;
  }
echo "<br /><br /><b>"._AM_INTROTEXT."</b><br /><br />";
$runESeditor = new ESeditor('hometext');
$runESeditor->BasePath = RCX_URL."/class/eseditor/";
if ($runESeditor->IsCompatible() && $editorConfig["displayeditor"] == 1)
{
  $runESeditor->Width = "100%" ;
  $runESeditor->Value = $hometext ;
  $runESeditor->ToolbarSet = $toolbar ;
    echo $runESeditor->Create('hometext') ;
  echo "<br /><br /><br /><b>"._AM_EXTEXT."</b><br /><br />";
    echo _AM_PAGEBREAK."<br /><br />";
  $run2ESeditor = new ESeditor('bodytext');
  $run2ESeditor->BasePath = RCX_URL."/class/eseditor/";
  $run2ESeditor->Width = "100%" ;
  $run2ESeditor->Value = $bodytext;
  $run2ESeditor->ToolbarSet = $toolbar;
  echo $run2ESeditor->Create('bodytext');
  echo "<input type='hidden' name='allow_html' value='2' />";
}
else
{
$desc = new RcxFormDhtmlTextArea('', 'hometext', $hometext);
echo $desc->render();
echo "<br /><br /><br /><b>"._AM_EXTEXT."</b><br /><br />";
echo _AM_PAGEBREAK;
echo "<br /><br />";
$desc = new RcxFormDhtmlTextArea('', 'bodytext', $bodytext);
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
</select>";
}
//slut på integration af ESeditor
echo "<br />";
// Aktiver smileys?
echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if ( (!isset($allow_smileys) && !isPost()) || $allow_smileys == '1' || $_POST['allow_smileys'] == '1' ) {
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."<br />";
// Aktiver bbcode?
echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if ( (!isset($allow_bbcode) && !isPost()) || $allow_bbcode == '1' || $_POST['allow_bbcode'] == '1' ) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";
echo "<input type='checkbox' class='checkbox' name='autodate' value='1'";
if ($autodate == '1') {
  echo " checked='checked'";
}
echo "> ";
if ($isedit == '1') {
  echo "<input type='hidden' name='isedit' value='1' />";
  echo _AM_CHANGEDATETIME . "? ";
  } else {
    echo _AM_SETDATETIME . "? ";
  }
if ($autodate == 1) {
  $pubdate = mktime($autohour, $automin, 0, $automonth, $autoday, $autoyear);
  } elseif (!isset($published)) {
    $pubdate = time();
    } else {
      $pubdate = $published;
    }
printf(_AM_NOWSETTIME, formatTimestamp($pubdate, 'm'));
echo "<br /> &nbsp; "._AM_MONTHC." <select class='select' name='automonth'>";
if (isset($automonth)) {
  $automonth = intval($automonth);
  } elseif (isset($published)) {
    $automonth = date('m', intval($published));
    } else {
      $automonth = date('m');
    }for ($xmonth=1; $xmonth<13; $xmonth++) {
  if ($xmonth == $automonth) {
    $sel = "selected";
    } else {
      $sel = "";
    }
  echo "<option value='$xmonth' $sel>$xmonth</option>";
}
echo "</select>&nbsp;";
echo _AM_DAYC." <select class='select' name='autoday'>";
if (isset($autoday)) {
  $autoday = intval($autoday);
  } elseif (isset($published)) {
    $autoday = date('d', intval($published));
    } else {
      $autoday = date('d');
    }
for ($xday=1; $xday<32; $xday++) {
  if ($xday == $autoday) {
    $sel = "selected";
    } else {
      $sel = "";
    }
  echo "<option value='$xday' $sel>$xday</option>";
}echo "</select>&nbsp;";
echo _AM_YEARC." <select class='select' name='autoyear'>";
if (isset($autoyear)) {
  $autoyear = intval($autoyear);
  } elseif (isset($published)) {
    $autoyear = date('Y', intval($published));
    } else {
      $autoyear = date('Y');
    }
$cyear    = date('Y');
for ($xyear=($autoyear-8); $xyear < ($cyear+2); $xyear++) {
  if ($xyear == $autoyear) {
    $sel = "selected";
    } else {
      $sel = "";
    }
  echo "<option value='$xyear' $sel>$xyear</option>";
}
echo "</select>";
echo "&nbsp;"._AM_TIMEC." <select class='select' name='autohour'>";
if (isset($autohour)) {
  $autohour = intval($autohour);
  } elseif (isset($published)) {
    $autohour = date('H', intval($published));
    } else {
      $autohour = date('H');
    }
for ($xhour=0; $xhour<24; $xhour++) {
  if ($xhour == $autohour) {
    $sel = "selected";
    } else {
      $sel = "";
    }
  echo "<option value='$xhour' $sel>$xhour</option>";
}
echo "</select>";
echo "&nbsp;"._AM_MINC." <select class='select' name='automin'>";
if (isset($automin)) {
  $automin = intval($automin);
  } elseif (isset($published)) {
    $automin = date('i', intval($published));
    } else {
      $automin = date('i');
    }
for ($xmin=0; $xmin<61; $xmin++) {
  if ($xmin == $automin) {
    $sel = "selected";
    } else {
      $sel = "";
    }
  $xxmin = $xmin;
  if ($xxmin < 10) {
    $xxmin = "0$xmin";
  }
  echo "<option value='$xmin' $sel>$xxmin</option>";
}
echo "</select>";
echo "<br /><br />";
if ( empty($published) ) {
  echo "<input type='checkbox' class='checkbox' name='approve' value='1'";
  if ($approve == 1) {
    echo " checked='checked'";
  }
  echo " />&nbsp;<b>"._AM_APPROVE."</b><br />";
  } else {
    if ($isedit == 1) {
      echo "<input type='checkbox' class='checkbox' name='movetotop' value='1'";
      if (isset($movetotop) && $movetotop == 1) {
        echo " checked='checked'";
      }
      echo " />&nbsp;<b>"._AM_MOVETOTOP."</b><br />";
      echo "<input type='hidden' name='isedit' value='1' />";
    }
    echo "<input type='hidden' name='approve' value='1' />";
  }
echo "<select class='select' name='op'>";
echo "<option value='preview' selected='selected'>"._PREVIEW."</option>";
echo "<option value='save'>"._SAVE."</option>";
echo "<option value='delete'>"._DELETE."</option>";
echo "</select>";
if (isset($storyid)) {
  echo "<input type='hidden' name='storyid' value='".$storyid."' />";
}
echo "<input type='hidden' name='type' value='".$type."' />";
echo "<input type='hidden' name='fct' value='articles' />";
echo " <input type='submit' class='button' value='"._GO."' />";
echo "</p></form>";
echo "</td></tr></table>";
/**
* Description
*
* @param type $var description
* @return type description
*/
function puthome($ihome="") {
echo "<br /><b>"._AM_PUBINHOME."</b>&nbsp;&nbsp;";
if (($ihome == 0) OR ($ihome == "")) {
  $sel1 = "checked='checked'";
  $sel2 = "";
}
if ($ihome == 1) {
  $sel1 = "";
  $sel2 = "checked='checked'";
}
echo "<input type='radio' class='radio' name='ihome' value='0' $sel1 />"._YES."&nbsp;";
echo "<input type='radio' class='radio' name='ihome' value='1' $sel2 />"._NO."<br />";
}
?>
