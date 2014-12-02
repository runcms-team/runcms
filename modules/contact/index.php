<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('header.php');
if (@file_exists('./language/'.RC_ULANG.'/main.php'))
  include_once('./language/'.RC_ULANG.'/main.php');
else
  include_once('./language/english/main.php');

if (empty($_REQUEST['submit']))
{
  if ($rcxConfig['startpage'] == 'contact')
  {
    $rcxOption['show_rblock'] = 1;
    include_once(RCX_ROOT_PATH.'/header.php');
    make_cblock();
    echo '<br />';
  }
  else
  {
      $rcxOption['show_rblock'] = 0;
      include_once(RCX_ROOT_PATH.'/header.php');
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function admin_editlink($op, $anchor='')
{
  global $rcxUser, $rcxModule;

  if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid()))
  {
    echo "<a href='admin/index.php?op=$op#$anchor' target='_blank'><img src='images/editicon.gif' border='0' alt='"._EDIT."' valign='top'  /></a> ";
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_contact()
{
  global $db, $myts, $rcxUser, $rcxConfig, $meta, $_REQUEST;
  include_once("./cache/config.php");

  if (empty($_REQUEST['submit']))
  {
    OpenTable();
    $user_comments    = '';
    $bill_firma     = '';
//    $tlf_nummer       = '';
  //               $bill_postnr     = ''; // olsen
	//			 $bill_by     = ''; // olsen
//	$bill_adresse = ''; // olsen

    $user_name        = !empty($rcxUser) ? $rcxUser->getVar("name", "E")     : "";
    $bill_adresse        = !empty($rcxUser) ? $rcxUser->getVar("address", "E")     : "";
    $bill_postnr        = !empty($rcxUser) ? $rcxUser->getVar("zip_code", "E")     : "";
    $bill_by        = !empty($rcxUser) ? $rcxUser->getVar("town", "E")     : "";
    $tlf_nummer        = !empty($rcxUser) ? $rcxUser->getVar("phone", "E")     : "";

    $user_email       = !empty($rcxUser) ? $rcxUser->getVar("email", "E")     : "";
    $user_url         = !empty($rcxUser) ? $rcxUser->getVar("url", "E")       : "";
   	if ($rcxUser) {
		if ($rcxUser->getVar("user_icq")) {
			$user_im         = 'ICQ';
			$user_im_details = $rcxUser->getVar("user_icq", "E");
			} elseif ($rcxUser->getVar("user_aim")) {
				$user_im         = 'AIM';
				$user_im_details = $rcxUser->getVar("user_aim", "E");
				} elseif ($rcxUser->getVar("user_yim")) {
					$user_im         = 'YIM';
					$user_im_details = $rcxUser->getVar("user_yim", "E");
					} elseif ($rcxUser->getVar("user_msnm")) {
						$user_im         = 'MSNM';
						$user_im_details = $rcxUser->getVar("user_msnm", "E");
					}
	}



    $query = $db->query("SELECT contact_text, contact_options, contact_reasons FROM ".$db->prefix("contact")."");
    list($contact_text, $contact_options, $contact_reason,) = $db->fetch_row($query);
    if ($contact_text)
    {
      $contact_options = explode('|', $contact_options);
      $allow_html      = $contact_options[0];
      $allow_smileys   = $contact_options[1];
      $allow_bbcode    = $contact_options[2];
      admin_editlink('edit_contact');
      $myts->setType('admin');
      OpenTable();
      echo $myts->makeTareaData4Show($contact_text, $allow_html, $allow_smileys, $allow_bbcode);
      CloseTable();
    }

    include_once('include/contactform.php');

    CloseTable();
    include_once(RCX_ROOT_PATH.'/footer.php');
  }
  else
  {
    // CAPTCHA hack by SVL
    // begin captcha
    if ((int)$contactConfig['use_captcha'] == 1 && !$rcxUser)
    {
      session_start();
      if(count($_REQUEST)>0)
      {
        if(!isset($_SESSION['captcha_keystring']) || $_SESSION['captcha_keystring'] !== md5($_REQUEST['keystring']))
        {
          redirect_header(_HTTP_REFERER, 3, _WRONGCAPKEY);
          exit;
        }
      }
      unset($_SESSION['captcha_keystring']);
    }
    // end captcha

    $bill_firma     = $myts->oopsStripSlashesGPC($_REQUEST['bill_firma']);
        $bill_postnr     = $myts->oopsStripSlashesGPC($_REQUEST['bill_postnr']); // olsen
        $bill_by    = $myts->oopsStripSlashesGPC($_REQUEST['bill_by']); // olsen

    $tlf_nummer       = $myts->oopsStripSlashesGPC($_REQUEST['tlf_nummer']);
		$bill_adresse = $myts->oopsStripSlashesGPC($_REQUEST['bill_adresse']); // olsen

    $contact_reason   = $myts->oopsStripSlashesGPC($_REQUEST['contact_reason']);
    $user_comments    = $myts->oopsStripSlashesGPC($_REQUEST['user_comments']);
    $user_name        = $myts->oopsStripSlashesGPC($_REQUEST['user_name']);
    $user_email       = $myts->oopsStripSlashesGPC($_REQUEST['user_email']);
    $user_url         = $myts->oopsStripSlashesGPC($_REQUEST['user_url']);
    $user_im          = $myts->oopsStripSlashesGPC($_REQUEST['user_im']);
    $user_im_details  = $myts->oopsStripSlashesGPC($_REQUEST['user_im_details']);

    $rcxMailer =& getMailer();
    $rcxMailer->useMail();
    $rcxMailer->setTemplateDir(RCX_ROOT_PATH.'/modules/contact/');
    $rcxMailer->setTemplate('contact.tpl');
    $rcxMailer->setToEmails($rcxConfig['adminmail']);
    $rcxMailer->setToEmails(explode(',', $contactConfig['bcc_to']));
    $rcxMailer->setFromEmail($user_email);
    $rcxMailer->setFromName($user_name);
    $rcxMailer->setSubject(_CT_CONTACT." - ".$contact_reason);
    $rcxMailer->setPriority($_REQUEST['mail_priority']);

    $rcxMailer->assign("COMPANY", $bill_firma);
        $rcxMailer->assign("POSTNR", $bill_postnr); // olsen
        $rcxMailer->assign("BY", $bill_by); // olsen

    $rcxMailer->assign("TLF", $tlf_nummer);
		$rcxMailer->assign("LOCATION", $bill_adresse); // olsen

    $rcxMailer->assign("URL", $user_url);
    $rcxMailer->assign("IM", $user_im);
    $rcxMailer->assign("IMNO", $user_im_details);
    $rcxMailer->assign("NAME", $user_name);
    $rcxMailer->assign("EMAIL", $user_email);


    $rcxMailer->assign("REASON", $contact_reason);
    $rcxMailer->assign("COMMENTS", $user_comments);
    $rcxMailer->assign("AGENT", _HTTP_USER_AGENT);
    $rcxMailer->assign("IP", _REMOTE_ADDR);
    $rcxMailer->assign("TIME", formatTimestamp(time(), 'm'));

    if (!empty($_['mail_reciept']))
    {
      $rcxMailer->setReciept($user_email);
    }

    if ($contactConfig['allow_attachment'] && !empty($_FILES['mail_attachment']['name']))
    {
      if ($rcxUser || $contactConfig['annon_attachment'])
      {
        include_once(RCX_ROOT_PATH.'/class/fileupload.php');
        $upload = new fileupload();
        $upload->set_upload_dir(RCX_ROOT_PATH.'/cache/', 'mail_attachment');
        $upload->set_overwrite(1, 'mail_attachment');
        $upload->set_accepted($contactConfig['allowed_extensions'], 'mail_attachment');
        $upload->set_max_file_size(intval($contactConfig['max_file_size']), 'mail_attachment');
        $result = $upload->upload();
        if ($result['mail_attachment']['filename'])
        {
          $rcxMailer->attachFile(RCX_ROOT_PATH.'/cache/'.$result['mail_attachment']['filename'], $result['mail_attachment']['type']);
          @unlink(RCX_ROOT_PATH.'/cache/'.$result['mail_attachment']['filename']);
        }
        else
        {
          $message_errors = $upload->errors(0);
        }
      }
    }

    $rcxMailer->send();
    $message_errors .= $rcxMailer->getErrors();

    if ($contactConfig['send_confirmation'] == 1)
    {
      $rcxMailer =& getMailer();
      $rcxMailer->useMail();
      $rcxMailer->setTemplateDir(RCX_ROOT_PATH.'/modules/contact/');
      $rcxMailer->setTemplate('confirmation.tpl');
      $rcxMailer->setToEmails($user_email);
      $rcxMailer->setFromEmail($rcxConfig['adminmail']);
      $rcxMailer->setFromName($meta['title']);
      $rcxMailer->setSubject(_CT_RECIEVED);
      $rcxMailer->assign("NAME", $user_name);
      $rcxMailer->assign("SIGNATURE", $rcxConfig['adminmail']);
      $rcxMailer->assign("SITENAME", $meta['title']);
      $rcxMailer->send();
      $message_errors .= $rcxMailer->getErrors();
    }

    $messagesent = _CT_MESSAGESENT."<br /><br />".$message_errors;
    redirect_header(RCX_URL.'/index.php', 2, $messagesent);
  }

  exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_link()
{
  global $db, $myts;

  $sql = "SELECT intro_text, intro_options, text_caption, text_alt, text_custom, logo_img, logo_alt, logo_custom, button_img, button_alt, button_custom, banner_img, banner_alt, banner_custom FROM ".$db->prefix("contact");

  $query = $db->query($sql);
  list($intro_text, $intro_options, $text_caption, $text_alt, $text_custom, $logo_img, $logo_alt, $logo_custom, $button_img, $button_alt, $button_custom, $banner_img, $banner_alt, $banner_custom) = $db->fetch_row($query);

  if ($text_caption || $text_custom || $logo_img || $logo_custom || $button_img || $button_custom || $banner_img || $banner_custom)
  {
    OpenTable();
    if ($intro_text)
    {
      $intro_options = explode('|', $intro_options);
      $allow_html      = $intro_options[0];
      $allow_smileys   = $intro_options[1];
      $allow_bbcode    = $intro_options[2];
      $myts->setType('admin');
      admin_editlink('edit_link');
      OpenTable();
      echo $myts->makeTareaData4Show($intro_text, $allow_html, $allow_smileys, $allow_bbcode);
      CloseTable();
    }
    if ($text_custom)
    {
    ?>
    <h6><?php admin_editlink('edit_link', 'text');?><?php echo _CT_TEXT;?>:</h6>
    <?php echo $text_custom;?><br /><br />
    <textarea class="textarea" rows="5" cols="60"><?php echo $text_custom;?></textarea>
    <?php
    }
    elseif ($text_caption)
    {
      $text_caption = $myts->makeTboxData4Show($text_caption);
      $text_alt     = $myts->makeTboxData4Show($text_alt);
      ?>
      <h6><?php admin_editlink('edit_link', 'text');?><?php echo _CT_TEXT;?>:</h6>
      <a href="<?php echo RCX_URL;?>/" title="<?php echo $text_alt;?>" target="_blank"><?php echo $text_caption;?></a><br /><br />
      <textarea class="textarea" rows="5" cols="60"><a href="<?php echo RCX_URL;?>/" title="<?php echo $text_alt;?>" target="_blank"><?php echo $text_caption;?></a></textarea>
      <?php
    }

    if ($button_custom)
    {
    ?>
    <h6><?php admin_editlink('edit_link', 'button');?><?php echo _CT_BUTTON;?>:</h6>
    <?php echo $button_custom;?><br /><br />
    <textarea class="textarea" rows="5" cols="60"><?php echo $button_custom;?></textarea>
    <?php
    }
    elseif ($button_img)
    {
      $button_alt = $myts->makeTboxData4Show($button_alt);
      ?>
      <h6><?php admin_editlink('edit_link', 'button');?><?php echo _CT_BUTTON;?>:</h6>
      <a href="<?php echo RCX_URL;?>/" target="_blank"><img src="<?php echo formatURL(RCX_URL.'/modules/contact/cache/images/', $button_img);?>" alt="<?php echo $button_alt;?>" border="0" /></a><br /><br />
      <textarea class="textarea" rows="5" cols="60"><a href="<?php echo RCX_URL;?>/" target="_blank"><img src="<?php echo formatURL(RCX_URL.'/modules/contact/cache/images/', $button_img);?>" alt="<?php echo $button_alt;?>" border="0" /></a></textarea>
      <?php
    }

    if ($logo_custom)
    {
    ?>
    <h6><?php admin_editlink('edit_link', 'logo');?><?php echo _CT_LOGO;?>:</h6>
    <?php echo $logo_custom;?><br /><br />
    <textarea class="textarea" rows="5" cols="60"><?php echo $logo_custom;?></textarea>
    <?php
    }
    elseif ($logo_img)
    {
      $logo_alt = $myts->makeTboxData4Show($logo_alt);
      ?>
      <h6><?php admin_editlink('edit_link', 'logo');?><?php echo _CT_LOGO;?>:</h6>
      <a href="<?php echo RCX_URL;?>/" target="_blank"><img src="<?php echo formatURL(RCX_URL.'/modules/contact/cache/images/', $logo_img);?>" alt="<?php echo $logo_alt;?>" border="0" /></a><br /><br />
      <textarea class="textarea" rows="5" cols="60"><a href="<?php echo RCX_URL;?>/" target="_blank"><img src="<?php echo formatURL(RCX_URL.'/modules/contact/cache/images/', $logo_img);?>" alt="<?php echo $logo_alt;?>" border="0" /></a></textarea>
      <?php
    }

    if ($banner_custom)
    {
    ?>
    <h6><?php admin_editlink('edit_link', 'banner');?><?php echo _CT_BANNER;?>:</h6>
    <?php echo $banner_custom;?><br /><br />
    <textarea class="textarea" rows="5" cols="60"><?php echo $banner_custom;?></textarea>
    <?php
    }
    elseif ($banner_img)
    {
      $banner_alt = $myts->makeTboxData4Show($banner_alt);
      ?>
      <h6><?php admin_editlink('edit_link', 'banner');?><?php echo _CT_BANNER;?>:</h6>
      <a href="<?php echo RCX_URL;?>/" target="_blank"><img src="<?php echo formatURL(RCX_URL.'/modules/contact/cache/images/', $banner_img);?>" alt="<?php echo $banner_alt;?>" border="0" /></a><br /><br />
      <textarea class="textarea" rows="5" cols="60"><a href="<?php echo RCX_URL;?>/" target="_blank"><img src="<?php echo formatURL(RCX_URL.'/modules/contact/cache/images/', $banner_img);?>" alt="<?php echo $banner_alt;?>" border="0" /></a></textarea>
      <?php
    }

    CloseTable();
    include_once(RCX_ROOT_PATH.'/footer.php');
  }
  else
  {
    show_contact();
  }

  exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_about()
{
  global $db, $myts;

  $query = $db->query("SELECT about_text, about_options FROM ".$db->prefix("contact"));
  list($about_text, $about_options) = $db->fetch_row($query);

  if ($about_text)
  {
    $about_options = explode('|', $about_options);
    $allow_html    = $about_options[0];
    $allow_smileys = $about_options[1];
    $allow_bbcode  = $about_options[2];
    $myts->setType('admin');
    admin_editlink('edit_about');
    
    OpenTable();
    echo $myts->makeTareaData4Show($about_text, $allow_html, $allow_smileys, $allow_bbcode);
    CloseTable();
    include_once(RCX_ROOT_PATH.'/footer.php');
  }
  else
  {
    show_contact();
  }

  exit();
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function show_policy()
{
  global $db, $myts;

  $query = $db->query("SELECT policy_text, policy_options FROM ".$db->prefix("contact"));
  list($policy_text, $policy_options) = $db->fetch_row($query);

  if ($policy_text)
  {
    $policy_options = explode('|', $policy_options);
    $allow_html     = $policy_options[0];
    $allow_smileys  = $policy_options[1];
    $allow_bbcode   = $policy_options[2];
    $myts->setType('admin');
    admin_editlink('edit_policy');
    
    OpenTable();
    echo $myts->makeTareaData4Show($policy_text, $allow_html, $allow_smileys, $allow_bbcode);
    CloseTable();
    include_once(RCX_ROOT_PATH.'/footer.php');
  }
  else
  {
    show_contact();
  }

  exit();
}
//$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];
$op = $_REQUEST['op'];
switch($op)
{
  case 'about':
    show_about();
    break;

  case 'contact':
    show_contact();
    break;

  case 'policy':
    show_policy();
    break;

  case 'link':
    show_link();
    break;

  default:
    show_about();
}
?>