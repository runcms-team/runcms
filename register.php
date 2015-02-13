<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$rcxOption['pagetype']   = 'user';
$rcxOption['page_style'] = 8;
$rcxOption['nocache']    = 1;

include_once("./mainfile.php");

// start tcaptcha hack by LARK (http://www.runcms.ru)

include_once(RCX_ROOT_PATH."/modules/system/cache/tcaptcha.php");

// end tcaptcha hack

if ( empty($rcxConfig['allow_register']) ) {
  redirect_header('index.php', 1, _US_NOREG);
  exit();
}

if($rcxUser){
    header("Location: userinfo.php?uid=".$rcxUser->getVar("uid")."");
    exit();;
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function userCheck($uname, $email, $passw, $vpassw) {
global $rcxConfig, $db, $myts, $rcxBadEmails, $rcxBadUnames;

$stop = "";

if ( !checkEmail($email) ) {
  $stop .= _US_INVALIDMAIL."<br />";
}

if ( strrpos($uname,' ') > 0 ) {
  $stop .= _US_EMAILNOSPACES."<br />";
}

$uname  = $myts->oopsStripSlashesGPC($uname);
$strict = "^a-zA-Z0-9_";
$medium = $strict."<>,.$%#@!\'\"";
$loose  = $medium."?{}\[\]\(\)\^&*`~;:\\+=";

switch ( $rcxConfig['uname_test_level'] ) {
  case 0:
    $restriction = $strict;
    break;

  case 1:
    $restriction = $medium;
    break;

  case 2:
    $restriction = $loose;
    break;
  }

if ( empty($uname) || preg_match('#['.$restriction.'-]#', $uname) ) {
  $stop .= _US_INVALIDNICKNAME."<br />";
}

if ( strlen($uname) > 25 ) {
  $stop .= _US_NICKNAMETOOLONG."<br />";
}

if ( !empty($rcxBadUnames) && hasMatch($rcxBadUnames, $uname) ) {
  $stop .= _US_NAMERESERVED."<br />";
//  break;
}

if ( strrpos($uname, ' ') > 0 ) {
  $stop .= _US_NICKNAMENOSPACES."<br />";
}

$sql    = "SELECT COUNT(*) FROM ".RC_USERS_TBL." WHERE uname='".addslashes($uname)."'";
$result = $db->query($sql);
list($count) = $db->fetch_row($result);

if ($count > 0) {
  $stop .= _US_NICKNAMETAKEN."<br />";
}

$count = 0;

if ($email) {
  if ( !empty($rcxBadEmails) && hasMatch($rcxBadEmails, $email) ) {
    $stop .= _US_EMAILRESERVED."<br />";
//    break;
  }
  $sql    = "SELECT COUNT(*) FROM ".RC_USERS_TBL." WHERE email='".$myts->makeTboxData4Save($email)."'";
  $result = $db->query($sql);
  list($count) = $db->fetch_row($result);
    if ( $count > 0 ) {
      $stop .= _US_EMAILTAKEN."<br />";
    }
}

if ( empty($passw) || empty($vpassw) ) {
  $stop .= _US_ENTERPWD."<br />";
}

if ( (isset($passw)) && ($passw != $vpassw) ) {
  $stop .= _US_PASSNOTSAME."<br />";
  } elseif ( ($passw != "") && (strlen($passw) < $rcxConfig['minpass']) ) {
    $stop .= sprintf(_US_PWDTOOSHORT, $rcxConfig['minpass'])."<br />";
  }

return $stop;
}

// start tcaptcha hack by LARK (http://www.runcms.ru)

function checkTCaptcha($tcaptcha)
{
	$stop = '';
	
	if ($tcaptcha['use_tc'] == 1) {

        $qq_arr = preg_split('/[\n\r]+/', trim(stripslashes($tcaptcha['tc_qq'])));
        $ans_arr = explode("|", strtolower($qq_arr[intval($_POST['q_id'])]));
        array_shift($ans_arr);

        array_walk($ans_arr, create_function('&$val', '$val = trim($val);'));

        if (!in_array(strtolower(trim($_POST['tc_ans'])), $ans_arr)) {
            $stop .= _US_WRONGTCANSWER . '<br />';
        }
    }
    
    return $stop;
}

// end tcaptcha hack

//---//
$op = "register";
foreach ($_POST as $k => $v) {
  $$k = $v;
}

switch ($op) {

case "register":
  include_once("header.php");
  OpenTable();
  include_once("include/registerform.php");
  $reg_form->display();
  CloseTable();
  include_once("footer.php");
  break;

case "newuser":
    
  $stop = '';
    
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      $stop .= $rcx_token->getErrors(true);
  }     
  
  $uname       = trim($uname);
  $email       = trim($email);
  
  $name        = trim($name);
  $address     = trim($address);
  $zip_code    = trim($zip_code);
  $town        = trim($town);
  $user_from   = trim($user_from);
  $phone       = trim($phone);

  $passw       = trim($passw);
  $vpassw      = trim($vpassw);

  $language    = trim($language);
  $verify_text = trim($verify_text);
  $verify_crc  = trim($verify_crc);
  
  $stop        .= userCheck($uname, $email, $passw, $vpassw);
  
  
  
  // start tcaptcha hack by LARK (http://www.runcms.ru)

  $stop        .= checkTCaptcha($tcaptcha);

  // end tcaptcha hack
  
  
    // begin captcha
    if ((int)$rcxConfig['img_verify'] == 1)
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
      // unset($_SESSION['captcha_keystring']);
    }
    // end captcha
    
  include_once("header.php"); 
    
  if ( empty($stop) ) {
    OpenTable();
  $f_timezone = ($timezone_offset < 0) ? "GMT ".$timezone_offset : "GMT +".$timezone_offset;
  echo "
    <center><table width='60%'  border='0' cellspacing='2' cellpadding='2'>
    <tr align='center' class='bg4'>
      <td colspan='2'><strong>"._US_USERREG."</strong></td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_USERNAME."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($uname)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_EMAIL."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($email)."</td>
    </tr>
    <tr class='bg3'>
    <td nowrap>&nbsp;"._US_REALNAME."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($name)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_ADDRESS."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($address)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_ZIP_CODE."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($zip_code)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_TOWN."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($town)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_LOCATION."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($user_from)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_TELEPHONE."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($phone)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_LNG."</td>
      <td>&nbsp;".$myts->makeTboxData4Preview($language)."</td>
    </tr>
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_TIMEZONE."</td>
      <td>&nbsp;".$f_timezone."</td>
    </tr>";
    if ( isset($url) && $url != "" ) {
      $url = formatURL($myts->makeTboxData4Preview($url));
    echo "
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_WEBSITE."</td>
      <td>&nbsp;".$url."</td>
    </tr>";
    }
    if ( $user_avatar != "" ) {
    echo "
    <tr class='bg3'>
      <td nowrap>&nbsp;"._US_AVATAR."</td>
      <td>&nbsp;<img src='images/avatar/".$user_avatar."' alt='".$uname."' /></td>
    </tr>";
    }
    echo "
    </table></center>
    <form action='register.php' method='post'>
    <input type='hidden' name='uname' value='".$myts->makeTboxData4PreviewInForm($uname)."' />
    <input type='hidden' name='email' value='".$myts->makeTboxData4PreviewInForm($email)."' />
    <input type='hidden' name='user_viewemail' value='".intval($user_viewemail)."' />
    <input type='hidden' name='name' value='".$myts->makeTboxData4PreviewInForm($name)."' />
    <input type='hidden' name='address' value='".$myts->makeTboxData4PreviewInForm($address)."' />
    <input type='hidden' name='zip_code' value='".$myts->makeTboxData4PreviewInForm($zip_code)."' />
    <input type='hidden' name='town' value='".$myts->makeTboxData4PreviewInForm($town)."' />
    <input type='hidden' name='user_from' value='".$myts->makeTboxData4PreviewInForm($user_from)."' />
    <input type='hidden' name='phone' value='".$myts->makeTboxData4PreviewInForm($phone)."' />
     <input type='hidden' name='user_avatar' value='".$myts->makeTboxData4PreviewInForm($user_avatar)."' />
    <input type='hidden' name='timezone_offset' value='".(float)$timezone_offset."' />
    <input type='hidden' name='url' value='".$myts->makeTboxData4PreviewInForm($url)."' />
    <input type='hidden' name='language' value='".$myts->makeTboxData4PreviewInForm($language)."' />
    <input type='hidden' name='passw' value='".$myts->makeTboxData4PreviewInForm($passw)."' />
    <input type='hidden' name='vpassw' value='".$myts->makeTboxData4PreviewInForm($vpassw)."' />
    <input type='hidden' name='user_mailok' value='".intval($user_mailok)."' />
    <input type='hidden' name='verify_text' value='".$myts->makeTboxData4PreviewInForm($verify_text)."' />
    <input type='hidden' name='verify_crc' value='".$myts->makeTboxData4PreviewInForm($verify_crc)."' />
    <input type='hidden' name='keystring' value='".$myts->makeTboxData4PreviewInForm($_REQUEST['keystring'])."' />
    " . $rcx_token->getTokenHTML() . "
    <input type='hidden' name='tc_ans' value='".$myts->makeTboxData4PreviewInForm($tc_ans)."' />
    <input type='hidden' name='q_id' value='" . intval($q_id) . "' />
    
    <br /><br /><center><input type='hidden' name='op' value='finish' /><input type='submit' class='button' value='". _US_FINISH ."' />
    </center></form>";
    CloseTable();
    } else {
      echo "<span style='color:#ff0000;'>$stop</span>";
      include_once("include/registerform.php");
      $reg_form->display();
    }

  include_once("footer.php");
  break;

case "finish":
    
  $stop = '';
    
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      $stop .= $rcx_token->getErrors(true);
  }     
  
  // Fix by HDMan /http://MoscowVolvoClub.ru/)
  
  if ((int)$rcxConfig['img_verify'] == 1 )
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
  
  // Fix by HDMan /http://MoscowVolvoClub.ru/)
  
  include_once("header.php");

  $uname       = trim($uname);
  $email       = trim($email);
  $name        = trim($name);
  
  $address     = trim($address);
  $zip_code    = trim($zip_code);
  $town        = trim($town);
  $user_from   = trim($user_from);
  $phone       = trim($phone);
  $passw       = trim($passw);
  $vpassw      = trim($vpassw);
 
  $language    = trim($language);
  $stop        .= userCheck($uname, $email, $passw, $vpassw);
  
  // start tcaptcha hack by LARK (http://www.runcms.ru)

  $stop        .= checkTCaptcha($tcaptcha);

  // end tcaptcha hack  
  
/* other options which can be add are - > $name, $adress, $zip_code, $town, $user_form, $phone */
  if ( empty($stop) ) {
    $newuser = new RcxUser();

    if ( isset($user_viewemail) ) {
      $newuser->setVar("user_viewemail", $user_viewemail);
    }

    if (isset($attachsig)) {
      $newuser->setVar("attachsig",$attachsig);
    }

    $newuser->setVar("name" , $name);
    $newuser->setVar("uname", $uname);
    $newuser->setVar("email", $email);

    if (!empty($url)) {
      $newuser->setVar("url", formatURL($url));
    }
    $newuser->setVar("address", $address);
    $newuser->setVar("zip_code", $zip_code);
    $newuser->setVar("town", $town);
    $newuser->setVar("user_from", $user_from);
    $newuser->setVar("phone", $phone);
    $newuser->setVar("user_avatar", $user_avatar);
    $newuser->setVar("actkey", substr(md5(makepass()), 0, 8));
    $newuser->setVar("pass", md5($passw));
    $newuser->setVar("timezone_offset", (float)$timezone_offset);
    $newuser->setVar("user_regdate", time());
    $newuser->setVar("uorder", $rcxConfig['com_order']);
    $newuser->setVar("umode", $rcxConfig['com_mode']);
    $newuser->setVar("user_mailok", $user_mailok);
    $newuser->setVar("language", $language);
    $newuser->setVar("regip", _REMOTE_ADDR);
    $newid = $newuser->store();

    if (!$newid) {
      OpenTable();
      echo _US_REGISTERNG;
      foreach($newuser->errors as $value) {
        echo "<br />-->".$value;
      }
      CloseTable();
      include_once("footer.php");
      exit();
    }

    if (!empty($rcxConfig['auto_register'])) {
      $newuser->setVar("uid", $newid);
      if ($newuser->activate()) {
        OpenTable();
        printf(_US_AUTOREGISTERED, $uname);
        CloseTable();
        include_once("footer.php");
        exit();
      }
    }

    $rcxMailer =& getMailer();
    $rcxMailer->useMail();
    if ($rcxConfig['coppa']) {
      $rcxMailer->setTemplate("coppa.tpl");
      $rcxMailer->assign("UEMAIL"  , $email);
      $rcxMailer->assign("UWEBSITE", $url);
      $rcxMailer->assign("UNAME"   , $uname);
      $rcxMailer->assign("UPASS"   , $passw);
      } else {
        $rcxMailer->setTemplate("register.tpl");
      }

    $rcxMailer->setSubject(sprintf(_US_USERKEYFOR, $uname));
    $rcxMailer->assign("SITENAME", $meta['title']);
    $rcxMailer->assign("ADMINMAIL", $rcxConfig['adminmail']);
    $rcxMailer->assign("SITEURL", RCX_URL."/");
    $rcxMailer->assign("IP", _REMOTE_ADDR);
    $rcxMailer->setToUsers($newid);
    $rcxMailer->setFromEmail($rcxConfig['adminmail']);
    $rcxMailer->setFromName($meta['title']);
    $rcxMailer->setPriority(2);
    OpenTable();

    if ( !$rcxMailer->send() ) {
      echo _US_YOURREGMAILNG;
      foreach($rcxMailer->errors as $value) {
        echo "<br />-->".$value;
      }
      } else {
        echo _US_YOURREGISTERED;
      }

    CloseTable();
    if ( $rcxConfig['new_user_notify'] == 1 && !empty($rcxConfig['new_user_notify_group']))
    {
			$rcxMailer =& getMailer();
			$rcxMailer->useMail();
			$rcxMailer->setTemplate("justreg.tpl");
			$rcxMailer->assign("SITENAME", $meta['title']);
			$rcxMailer->assign("IP", _REMOTE_ADDR);
			$rcxMailer->assign("UEMAIL", $email);
			$rcxMailer->assign("UNAME", $uname);
			$rcxMailer->assign("SITEURL", RCX_URL."/");
			$rcxMailer->setToGroups($rcxConfig['new_user_notify_group']);
			$rcxMailer->setFromEmail($rcxConfig['adminmail']);
			$rcxMailer->setFromName($meta['title']);
			$rcxMailer->setSubject(sprintf(_US_NEWUSERREGAT, $meta['title']));
			$rcxMailer->send();
    }

    } else {
      echo "<span style='font-weight:bold;'>$stop</span>";
      include_once("include/registerform.php");
      $reg_form->display();
    }

  include_once("footer.php");
  break;
}
?>