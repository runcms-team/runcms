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
include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
include_once(RCX_ROOT_PATH."/class/fileupload.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function contact_main()
{
  rcx_cp_header();
 OpenTable();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
  <tr>
    <td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _AM_CONTACT_MAIN;?></div><br />
	
	<br />
	<div class="kpicon"><table id="table1"><tr><td>
		<a href="index.php?op=edit_about"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _AM_EDIT_ABOUT;?>">
	<br /><?php echo _AM_EDIT_ABOUT;?></a>
	<a href="index.php?op=edit_policy"><img src="<?php echo RCX_URL;?>/images/system/moduler.png" alt="<?php echo _AM_EDIT_POLICY;?>"/>	
	<br /><?php echo _AM_EDIT_POLICY;?></a>
	<a href="index.php?op=edit_contact"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _AM_EDIT_CONTACT;?>"/>
	<br /><?php echo _AM_EDIT_CONTACT;?></a>
	<a href="index.php?op=edit_link"><img src="<?php echo RCX_URL;?>/images/system/disclaimer.png" alt="<?php echo _AM_EDIT_LINKS;?>"/>
	<br /><?php echo _AM_EDIT_LINKS;?></a>
		</td></tr></table>

<?php

  CloseTable();
  rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_contact()
{
  global $db, $myts;

  include_once("../cache/config.php");

  $query = $db->query("SELECT contact_text, contact_options, contact_reasons FROM ".$db->prefix("contact"));
  list($contact_text, $contact_options, $contact_reasons) = $db->fetch_row($query);
  $contact_text    = $myts->makeTboxData4Show($contact_text);
  $contact_reasons = $myts->makeTboxData4Show($contact_reasons);

  $contact_options    = explode('|', $contact_options);
  $allow_html         = $contact_options[0];
  $allow_smileys      = $contact_options[1];
  $allow_bbcode       = $contact_options[2];

  $confirmChk = $contactConfig['send_confirmation'] ? " checked='checked'" : "";
  $attachChk  = $contactConfig['allow_attachment']  ? " checked='checked'" : "";
  $anonChk    = $contactConfig['annon_attachment']  ? " checked='checked'" : "";

  rcx_cp_header();
 OpenTable();
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_GOBACK, "button", _AM_CONTACT_MAIN, "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
  ?><br />
    <form action="index.php" method="POST" enctype="multipart/form-data">
    <table width="80%">
    <tr>
      <td nowrap><?php echo _CT_CONFIRMATION;?></td>
      <td><input type="checkbox" class="checkbox" name="send_confirmation" value="1"<?php echo $confirmChk;?> /></td>
    </tr>
    <tr>
      <td nowrap><?php echo _CT_ALLOW_ATTACHMENT;?></td>
      <td><input type="checkbox" class="checkbox" name="allow_attachment" value="1"<?php echo $attachChk;?> /></td>
    </tr>
    <tr>
      <td nowrap><?php echo _CT_ANNON_ATTACHMENT;?></td>
      <td><input type="checkbox" class="checkbox" name="annon_attachment" value="1"<?php echo $anonChk;?> /></td>
    </tr>
    <tr>
      <td nowrap><?php echo _CT_MAX_FILE_SIZE;?>:</td>
      <td><input type="text" class="text" size="5" name="max_file_size" value="<?php echo $contactConfig['max_file_size'];?>" /> <?php echo _BYTES;?></td>
    </tr>
    <tr>
      <td nowrap><?php echo _UPLOADACCEPTED;?></td>
      <td><input type="text" class="text" size="30" name="allowed_extensions" value="<?php echo $myts->makeTboxData4Show($contactConfig['allowed_extensions']);?>" /></td>
    </tr>
    <tr>
      <td nowrap><?php echo _CT_BCC_TO;?>:</td>
      <td><input type="text" class="text" size="50" name="bcc_to" value="<?php echo $myts->makeTboxData4Show($contactConfig['bcc_to']);?>" /></td>
    </tr>
    <tr>
      <td nowrap><?php echo _CT_REASONS;?>:</td>
      <td><input type="text" class="text" size="50" name="contact_reasons" value="<?php echo $contact_reasons;?>" /></td>
    </tr>
    <tr>
      <td valign="top"><?php echo _CT_DISCLAIMER;?>:</td>
      <td>
  <?php
  $desc = new RcxFormDhtmlTextArea('', 'contact_text', $contact_text);
  echo $desc->render();
  ?>
      </td>
    </tr>
    <tr>
      <td colspan="2">
  <?php
  echo 
        _ALLOWEDHTML."<br />".get_allowed_html();

  if ($allow_html == '0')
  {
    $option0 = " selected";
  }
  elseif ($allow_html == '2')
  {
    $option2 = " selected";
  }
  else
  {
    $option1 = " selected";
  }

  echo "
      <br /><br />
      <select class='select' name='allow_html'>
        <option value='0'$option0>"._HTMLOFF."</option>
        <option value='1'$option1>"._HTMLAUTOWRAP."</option>
        <option value='2'$option2>"._HTMLNOAUTOWRAP."</option>
      </select>
      <br />
      <input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
  if ($allow_smileys == 1)
  {
    echo " checked='checked'";
  }
  echo " /> "._ENABLESMILEY."
      <br />
      <input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
  if ($allow_bbcode == 1)
  {
    echo " checked='checked'";
  }
  echo " />&nbsp;"._ENABLEBBCODE."<br />";
  ?>
      </td>
    </tr>

    <tr>
      <td colspan=2><hr /></td>
    </tr>
    <tr>
      <td nowrap><?php echo _ALLOWCAP;?></td>
      <td>
  <?php
    $chk1 = ""; $chk2 = "";
    $chk = ($contactConfig['use_captcha'] == 1) ? $chk1 = "checked='checked'" : $chk2 = "checked='checked'";
  ?>
        <input type="radio" class="radio" name="use_captcha" value="1" <?php echo $chk1;?> /><?php echo _YES;?>
        <input type="radio" class="radio" name="use_captcha" value="0" <?php echo $chk2;?> /><?php echo _NO;?>
      </td>
    </tr>
    <tr>
      <td colspan=2><hr /></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" name="op" value="save_contact" />
        <input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" />
      </td>
    </tr>
    </table>
    </form>
<?php

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_contact()
{
  global $db, $myts;

  $contact_text    = $myts->makeTareaData4Save($_REQUEST['contact_text']);
  $contact_reasons = $myts->makeTareaData4Save($_REQUEST['contact_reasons']);
  $allow_html      = intval($_REQUEST['allow_html']);
  $allow_smileys   = intval($_REQUEST['allow_smileys']);
  $allow_bbcode    = intval($_REQUEST['allow_bbcode']);

  $sql = "UPDATE ".$db->prefix("contact")." SET
      contact_text='$contact_text',
      contact_reasons='$contact_reasons',
      contact_options='$allow_html|$allow_smileys|$allow_bbcode'";

  $result = $db->query($sql);

  if (!$result)
  {
    redirect_header("index.php", 1, _NOTUPDATED);
  }

  $content  = "<?php\n";
  $content .= "\$contactConfig['send_confirmation']  = ".intval($_REQUEST['send_confirmation']).";\n";
  $content .= "\$contactConfig['allow_attachment']   = ".intval($_REQUEST['allow_attachment']).";\n";
  $content .= "\$contactConfig['annon_attachment']   = ".intval($_REQUEST['annon_attachment']).";\n";
  $content .= "\$contactConfig['max_file_size']      = ".intval($_REQUEST['max_file_size']).";\n";
  $content .= "\$contactConfig['allowed_extensions'] = '".$myts->makeTboxData4Save($_REQUEST['allowed_extensions'])."';\n";
  $content .= "\$contactConfig['bcc_to']             = '".$myts->makeTboxData4Save($_REQUEST['bcc_to'])."';\n";
  $content .= "\$contactConfig['use_captcha']        = ".intval($_REQUEST['use_captcha']).";\n";
  $content .= "?>";

  $filename = "../cache/config.php";
  if ($file = fopen($filename, "w"))
  {
    fwrite($file, $content);
    fclose($file);
  }
  else
  {
    redirect_header("index.php?op=edit_contact", 1, _NOTUPDATED);
    exit();
  }

  redirect_header("index.php", 1, _UPDATED);
  exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_about() {
global $db, $myts;

$query = $db->query("SELECT about_text, about_options FROM ".$db->prefix("contact")."");
list($about_text, $about_options) = $db->fetch_row($query);
$about_text    = $myts->oopsStripSlashesRT($about_text);
$about_options = explode('|', $about_options);
$allow_html    = $about_options[0];
$allow_smileys = $about_options[1];
$allow_bbcode  = $about_options[2];

rcx_cp_header();
OpenTable();


            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_GOBACK, "button", _AM_CONTACT_MAIN, "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
		?><br />
<table width="70%"><tr><form action="index.php" method="POST">

<td valign="top" nowrap><?php echo _CT_ABOUT;?>:</td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'about_text', $about_text, 10, 80);
$desc = new RcxFormDhtmlTextArea('', 'about_text', $about_text);
echo $desc->render();
?>
</td>

</tr><tr>

<td colspan="2">
<?php
echo _ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0') {
  $option0 = " selected";
  } elseif ($allow_html == '2') {
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

echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if ($allow_smileys == 1) {
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."<br />";

echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if ($allow_bbcode == 1) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";
?>
</td>

</tr><tr>

<td colspan="2" align="center">
<input type="hidden" name="op" value="save_about" />
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" /></td>
</form></tr></table>

<?php
CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_about() {
global $db, $myts, $_POST;

$about_text    = $myts->makeTareaData4Save($_POST['about_text']);
$allow_html    = intval($_POST['allow_html']);
$allow_smileys = intval($_POST['allow_smileys']);
$allow_bbcode  = intval($_POST['allow_bbcode']);

$result = $db->query("UPDATE ".$db->prefix("contact")." SET about_text='$about_text', about_options='$allow_html|$allow_smileys|$allow_bbcode'");

if ($result) {
  redirect_header("index.php", 1, _UPDATED);
  } else {
    redirect_header("index.php?op=edit_about", 1, _NOTUPDATED);
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_policy() {
global $db, $myts;

$query = $db->query("SELECT policy_text, policy_options FROM ".$db->prefix("contact")."");
list($policy_text, $policy_options) = $db->fetch_row($query);
$policy_text    = $myts->oopsStripSlashesRT($policy_text);
$policy_options = explode('|', $policy_options);
$allow_html     = $policy_options[0];
$allow_smileys  = $policy_options[1];
$allow_bbcode   = $policy_options[2];

rcx_cp_header();

OpenTable();
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_GOBACK, "button", _AM_CONTACT_MAIN, "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
?>
<br />
<table width="70%"><tr><form action="index.php" method="POST">

<td valign="top" nowrap><?php echo _CT_POLICY;?>:</td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'policy_text', $policy_text, 10, 80);
$desc = new RcxFormDhtmlTextArea('', 'policy_text', $policy_text);
echo $desc->render();
?>
</td>

</tr><tr>

<td colspan="2">
<?php
echo _ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0') {
  $option0 = " selected";
  } elseif ($allow_html == '2') {
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

echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if ($allow_smileys == 1) {
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."<br />";

echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if ($allow_bbcode == 1) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";
?>
</td>

</tr><tr>

<td colspan="2" align="center">
<input type="hidden" name="op" value="save_policy" />
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" /></td>
</form></tr></table>

<?php
CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_policy() {
global $db, $myts, $_POST;

$policy_text   = $myts->makeTareaData4Save($_POST['policy_text']);
$allow_html    = intval($_POST['allow_html']);
$allow_smileys = intval($_POST['allow_smileys']);
$allow_bbcode  = intval($_POST['allow_bbcode']);

$result = $db->query("UPDATE ".$db->prefix("contact")." SET policy_text='$policy_text', policy_options='$allow_html|$allow_smileys|$allow_bbcode'");

if ($result) {
  redirect_header("index.php", 1, _UPDATED);
  } else {
    echo $db->error();
    redirect_header("index.php?op=edit_policy", 1, _NOTUPDATED);
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_link() {
global $db, $myts;

$sql = "
  SELECT
  intro_text,
  intro_options,
  text_caption,
  text_alt,
  text_custom,
  button_alt,
  button_img,
  button_custom,
  logo_alt,
  logo_img,
  logo_custom,
  banner_alt,
  banner_img,
  banner_custom
  FROM ".$db->prefix("contact")."";

$result = $db->query($sql);
$res    = $db->fetch_object($result);

$intro_text    = $myts->makeTboxData4Show($res->intro_text);
$text_caption  = $myts->makeTboxData4Show($res->text_caption);
$text_alt      = $myts->makeTboxData4Show($res->text_alt);
$text_link     = $myts->makeTboxData4Show($res->text_link);
$text_custom   = $myts->makeTboxData4Show($res->text_custom);

$button_alt    = $myts->makeTboxData4Show($res->button_alt);
$button_img    = $myts->makeTboxData4Show($res->button_img);
$button_custom = $myts->makeTboxData4Show($res->button_custom);

$logo_alt      = $myts->makeTboxData4Show($res->logo_alt);
$logo_img      = $myts->makeTboxData4Show($res->logo_img);
$logo_custom   = $myts->makeTboxData4Show($res->logo_custom);

$banner_alt    = $myts->makeTboxData4Show($res->banner_alt);
$banner_img    = $myts->makeTboxData4Show($res->banner_img);
$banner_custom = $myts->makeTboxData4Show($res->banner_custom);

$intro_options = explode('|', $res->intro_options);
$allow_html    = $intro_options[0];
$allow_smileys = $intro_options[1];
$allow_bbcode  = $intro_options[2];

rcx_cp_header();
 OpenTable();
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_GOBACK, "button", _AM_CONTACT_MAIN, "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
?><br />
<table width="70%"><tr><form action="index.php" method="POST" enctype="multipart/form-data">

<td valign="top"><?php echo _CT_INTRO;?>:</td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'intro_text', $intro_text, 10, 80);
$desc = new RcxFormDhtmlTextArea('', 'intro_text', $intro_text);
echo $desc->render();
?>
</td>

</tr><tr>

<td colspan="2">
<?php
echo _ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0') {
  $option0 = " selected";
  } elseif ($allow_html == '2') {
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

echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if ($allow_smileys == 1) {
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."<br />";

echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if ($allow_bbcode == 1) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";
?>
<hr />
</td>


</tr><tr>

<td colspan="2"><h6><?php echo _CT_TEXT;?>:</h6></td>

</tr><tr>

<td valign="top"><?php echo _CT_SAMPLE;?>:</td>

<td>
<a name="#text"></a>
<?php
if ($text_custom) {
  echo $text_custom;
  } else {
    echo "<a href='$text_link' title='$text_alt' target='_blank'>$text_caption</a>";
  }
?>
</td>

</tr><tr>

<td><?php echo _CT_ALT;?>:</td><td><input type="text" class="text" name="text_alt" value="<?php echo $text_alt;?>" size="30" maxlength="255" /></td>

</tr><tr>

<td><?php echo _CT_CAPTION;?>:</td><td><input type="text" class="text" name="text_caption" value="<?php echo $text_caption;?>" size="30" maxlength="255" /></td>

</tr><tr>

<td valign="top"><?php echo _CT_CUSTOM;?>:</td><td><textarea class="textarea" name="text_custom" rows="5" cols="50"><?php echo $text_custom;?></textarea></td>

</tr></table>
<hr />

<table><tr>

<td colspan="2"><h6><?php echo _CT_BUTTON;?>:</h6></td>

</tr><tr>

<td valign="top"><?php echo _CT_SAMPLE;?>:</td>

<td>
<a name="#button"></a>
<?php
if ($button_custom) {
  echo $button_custom;
  } else {
    echo "<a href='".RCX_URL."/' target='_blank'><img src='".formatURL(RCX_URL.'/modules/contact/cache/images/', $button_img)."' alt='$button_alt' border='0' /></a>";
  }
?>
</td>

</tr><tr>

<td><?php echo _CT_ALT;?>:</td><td><input type="text" class="text" name="button_alt" value="<?php echo $button_alt;?>" size="30" maxlength="255" /></td>

</tr><tr>

<td><?php echo _CT_IMG;?>:</td><td><input type="text" class="text" name="button_img" value="<?php echo $button_img;?>" size="30" maxlength="255" /> <input type="file" class="file" name="button_file"></td>

</tr><tr>

<td valign="top"><?php echo _CT_CUSTOM;?>:</td><td><textarea class="textarea" name="button_custom" rows="5" cols="50"><?php echo $button_custom;?></textarea></td>

</tr></table>
<hr />

<table><tr>

<td colspan="2"><h6><?php echo _CT_LOGO;?>:</h6></td>

</tr><tr>

<td valign="top"><?php echo _CT_SAMPLE;?>:</td>

<td>
<a name="#logo"></a>
<?php
if ($logo_custom) {
  echo $logo_custom;
  } else {
    echo "<a href='".RCX_URL."/' target='_blank'><img src='".formatURL(RCX_URL.'/modules/contact/cache/images/', $logo_img)."' alt='$logo_alt' border='0' /></a>";
  }
?>
</td>

</tr><tr>

<td><?php echo _CT_ALT;?>:</td><td><input type="text" class="text" name="logo_alt" value="<?php echo $logo_alt;?>" size="30" maxlength="255" /></td>

</tr><tr>

<td><?php echo _CT_IMG;?>:</td><td><input type="text" class="text" name="logo_img" value="<?php echo $logo_img;?>" size="30" maxlength="255" /> <input type="file" class="file" name="logo_file"></td>

</tr><tr>

<td valign="top"><?php echo _CT_CUSTOM;?>:</td><td><textarea class="textarea" name="logo_custom" rows="5" cols="50"><?php echo $logo_custom;?></textarea></td>

</tr></table>
<hr />

<table><tr>

<td colspan="2"><h6><?php echo _CT_BANNER;?>:</h6></td>

</tr><tr>

<td valign="top"><?php echo _CT_SAMPLE;?>:</td>

<td>
<a name="#banner"></a>
<?php
if ($banner_custom) {
  echo $banner_custom;
  } else {
    echo "<a href='".RCX_URL."/' target='_blank'><img src='".formatURL(RCX_URL.'/modules/contact/cache/images/', $banner_img)."' alt='$banner_alt' border='0' /></a>";
  }
?>
</td>

</tr><tr>

<td><?php echo _CT_ALT;?>:</td><td><input type="text" class="text" name="banner_alt" value="<?php echo $banner_alt;?>" size="30" maxlength="255" /></td>

</tr><tr>

<td><?php echo _CT_IMG;?>:</td><td><input type="text" class="text" name="banner_img" value="<?php echo $banner_img;?>" size="30" maxlength="255" /> <input type="file" class="file" name="banner_file"></td>

</tr><tr>

<td valign="top"><?php echo _CT_CUSTOM;?>:</td><td><textarea class="textarea" name="banner_custom" rows="5" cols="50"><?php echo $banner_custom;?></textarea></td>


</tr><tr>
<td colspan="2" align="center">
<hr />
<input type="hidden" name="op" value="save_link" />
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>" />
</td>
</tr></table>

</form>

<?php
CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_link() {
global $db, $myts, $_FILES, $_POST;

$intro_text    = $myts->makeTareaData4Save($_POST['intro_text']);
$text_caption  = $myts->makeTareaData4Save($_POST['text_caption']);
$text_alt      = $myts->makeTareaData4Save($_POST['text_alt']);
$text_link     = $myts->makeTareaData4Save($_POST['text_link']);
$text_custom   = $myts->makeTareaData4Save($_POST['text_custom']);
$button_alt    = $myts->makeTareaData4Save($_POST['button_alt']);
$button_img    = $myts->makeTareaData4Save($_POST['button_img']);
$button_custom = $myts->makeTareaData4Save($_POST['button_custom']);
$logo_alt      = $myts->makeTareaData4Save($_POST['logo_alt']);
$logo_img      = $myts->makeTareaData4Save($_POST['logo_img']);
$logo_custom   = $myts->makeTareaData4Save($_POST['logo_custom']);
$banner_alt    = $myts->makeTareaData4Save($_POST['banner_alt']);
$banner_img    = $myts->makeTareaData4Save($_POST['banner_img']);
$banner_custom = $myts->makeTareaData4Save($_POST['banner_custom']);
$allow_html    = intval($_POST['allow_html']);
$allow_smileys = intval($_POST['allow_smileys']);
$allow_bbcode  = intval($_POST['allow_bbcode']);

if (
    !empty($_FILES['button_file']['name'])
    || !empty($_FILES['logo_file']['name'])
    || !empty($_FILES['banner_file']['name'])
   ) {
  include_once(RCX_ROOT_PATH."/class/fileupload.php");
  $upload = new fileupload();
  $upload->set_upload_dir(RCX_ROOT_PATH . "/modules/contact/cache/images/");
  $upload->set_overwrite(2);
  $result = $upload->upload();
  if ($result['button_file']['filename']) {
    $button_img = $result['button_file']['filename'];
  }
  if ($result['logo_file']['filename']) {
    $logo_img   = $result['logo_file']['filename'];
  }
  if ($result['banner_file']['filename']) {
    $banner_img = $result['banner_file']['filename'];
  }
  if ($upload->errors()) {
    redirect_header("index.php?op=edit_link", 1, $upload->errors());
    exit();
  }
}

$sql = "
  UPDATE ".$db->prefix("contact")." SET
  intro_text='$intro_text',
  intro_options='$allow_html|$allow_smileys|$allow_bbcode',
  text_caption='$text_caption',
  text_alt='$text_alt',
  text_custom='$text_custom',
  button_alt='$button_alt',
  button_img='$button_img',
  button_custom='$button_custom',
  logo_alt='$logo_alt',
  logo_img='$logo_img',
  logo_custom='$logo_custom',
  banner_alt='$banner_alt',
  banner_img='$banner_img',
  banner_custom='$banner_custom'";

$result = $db->query($sql);

if ($result) {
  redirect_header("index.php", 1, _UPDATED);
  } else {
    redirect_header("index.php?op=edit_link", 1, _NOTUPDATED);
  }

exit();
}

// ------- //

switch ($op) {
  case 'edit_contact':
    edit_contact();
    break;

  case 'save_contact':
    save_contact();
    break;

  case 'edit_about':
    edit_about();
    break;

  case 'save_about':
    save_about();
    break;

  case 'edit_policy':
    edit_policy();
    break;

  case 'save_policy':
    save_policy();
    break;

  case 'edit_link':
    edit_link();
    break;

  case 'save_link':
    save_link();
    break;

  default:
    contact_main();
}
?>
