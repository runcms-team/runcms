<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
$rcxOption['pagetype'] = "admin";

include_once("mainfile.php");
include_once(RCX_ROOT_PATH."/include/cp_functions.php");

$admintest = 0;

if ($rcxUser) {
    if ( !$rcxUser->isAdmin() ) {
        redirect_header("index.php", 2, _NOPERM);
        exit();
    } else {
        $admintest = 1;
        $op = "list";
    }

} else {

    if ($rcxConfig['use_auth_admin']) {
        $op = "login_form";
    } else {
        redirect_header("index.php", 2, _NOPERM);
        exit();
    }
}


if ( !empty($_GET['op']) ) {
  $op = $_GET['op'];
}

if ( !empty($_POST['op']) ) {
  $op = $_POST['op'];
}


switch ($op) {

    case "list":
        if ($admintest == 1) {
            
            if ( @is_dir(RCX_ROOT_PATH."/_install" ) ) {
                redirect_header(RCX_URL."/include/noinstall.php", 0);
                die;
            }

            if ( @is_writable(RCX_ROOT_PATH."/mainfile.php" ) ) {
                redirect_header(RCX_URL."/include/nomain.php", 0);
                die;
            }            

            header('Status: 302 Found');
            header("Location: modules/system/admin.php");
            exit();

            rcx_cp_header();
            OpenTable();
   ?>
  <table width="100%"><tr>
<td width="100%"> 	<div class="KPstor"></div>
  <table border="0" cellpadding="0" cellspacing="0" align="top" width="100%"><tr><td class="sysbg2"><div class="KPstor">RunCms2 Goals:</div>
        <table width="100%" border="0" cellpadding="4" cellspacing="1"><tr><td class="sysbg1">
<div class="ftop">
- Simple and easy to use -<br />
- Optimize Code and Cosmetic look -<br />
- Compatible with latest server software -<br /><br />
</div></td></tr><tr><td> 

<div class="sysinf1"><b><br />
RunCms2 is based on ScarPox. (ScarPox is Only Published in Danish.)<br />
Which in turn is based on RunCms (1.4 build 20062006).<br /><br />
There is no guarantee that I will deal with RunCms out in perpetuity.</b><br /><br /> </div>
<div class="KPmellem">
RunCms2 used at your own risk.! <br />
Without warranty of any kind. <br />
All code is released under GPL <br />
<br /><div style="color: black; font-style: italic;"><small> - Sincerely, <br />
    Farsus aka Jan Cordsen <br />
Farsus Design & Hosting <br />
www.farsus.dk</small><br/><br/></div></div>
  </td></tr></table>
  <?php
  CloseTable();
  rcx_cp_footer();

        }
        break;

    case "login_form":
        login_form();
        break;

    case "login":

        sleep(1);

        $uname = !isset($_POST['uname']) ? '' : trim($_POST['uname']);
        $pass = !isset($_POST['pass']) ? '' : trim($_POST['pass']);
        $count = 0;

        if ($uname == '' || $pass == '')
        {
            //redirect_header("admin.php", 1, _AD_INCORRECTLOGIN);
            login_form(array('type' => 'error', 'title' => _NOTIFY_ERROR, 'description' => _AD_INCORRECTLOGIN));
            exit();
        }

        $rcx_token = & RcxToken::getInstance();

        if ( !$rcx_token->check() ) {
            rcx_set_login_log($rcx_token->getErrors(true), $uname);
            login_form(array('type' => 'error', 'title' => _NOTIFY_ERROR, 'description' => $rcx_token->getErrors(true)));
            //redirect_header('admin.php', 3, $rcx_token->getErrors(true));
            exit();
        }

        if ($rcxConfig['check_bruteforce_login'] == 1) {

            $count = rcx_check_bruteforce_login();

            if ($count >= $rcxConfig['count_failed_auth']) {
                unset($_SESSION['captcha_keystring']);
                login_form(array('type' => 'error', 'title' => _NOTIFY_ERROR, 'description' => _AD_DETECT_BRUTEFORCE));
                //redirect_header("admin.php", 4, _AD_DETECT_BRUTEFORCE);
                exit();
            }

        }

        if ($rcxConfig['use_captcha_for_admin'] == 1) {

            if(!isset($_SESSION['captcha_keystring']) || $_SESSION['captcha_keystring'] !== md5($_POST['keystring'])) {
                rcx_set_login_log(_WRONGCAPKEY, $uname);
                login_form(array('type' => 'error', 'title' => _NOTIFY_ERROR, 'description' => _WRONGCAPKEY));
                //redirect_header('admin.php', 3, _WRONGCAPKEY);
                exit();
            }

            unset($_SESSION['captcha_keystring']);

        }

        if (!headers_sent()) {
            header("Expires: Sat, 18 Aug 2002 05:30:00 GMT");
            header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
            header("Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0");
        }

        $user = RcxUser::login($uname, $pass);
        if (false != $user)
        {
            if ( 0 == $user->getVar('level') )
            {
                rcx_set_login_log(_AD_NOACTTPADM, $user->getVar('uname'), $user->getVar('uid'));
                login_form(array('type' => 'error', 'title' => _NOTIFY_ERROR, 'description' => _AD_NOACTTPADM));
                //redirect_header("index.php", 5, _AD_NOACTTPADM);
                exit();
            }
            include_once(RCX_ROOT_PATH.'/class/sessions.class.php');
            $session = new RcxUserSession();
            $session->useUniqueHash(true);
            $session->setUid($user->getVar('uid'));
            $session->setUname($user->getVar('uname'));
            $session->setPass($user->getVar('pass'));
            $session->setSalt($user->getVar('pwdsalt'));
            if (!$session->store())
            {
                rcx_set_login_log(_NOTUPDATED, $user->getVar('uname'), $user->getVar('uid'));
                redirect_header("index.php", 1, _NOTUPDATED);
                exit();
            }
            $user->updateLastLogin();


            if ($rcxConfig['admin_login_notify'] == 1) {

                $rcxMailer =& getMailer();
                $rcxMailer->useMail();
                $rcxMailer->setTemplate("adminlogin.tpl");

                $rcxMailer->assign("IP", _REMOTE_ADDR);
                $rcxMailer->assign("UNAME", $user->getVar('uname'));
                $rcxMailer->assign("DATE", date('Y-m-d H:i:s'));

                $rcxMailer->setPriority(2);

                $rcxMailer->setToEmails($rcxConfig['adminmail']);

                $rcxMailer->setFromEmail($rcxConfig['adminmail']);
                $rcxMailer->setFromName($meta['title']);
                $rcxMailer->setSubject(sprintf(_AD_ADMIN_LOGIN_NOTIFY, $meta['title']));
                $rcxMailer->send();

            }

            rcx_set_login_log('', $user->getVar('uname'), $user->getVar('uid'), 'success');
            redirect_header('admin.php?' . time(), 2, sprintf(_AD_LOGGINGU, $user->getVar('uname')));
            exit();
        }
        else
        {
            rcx_set_login_log(_AD_INCORRECTLOGIN, $uname);

            if ($count > 0) {

                if ($rcxConfig['check_bruteforce_login'] == 1 && $rcxConfig['admin_bruteforce_notify'] == 1 && (($count + 1) == $rcxConfig['count_failed_auth'])) {

                    $rcxMailer =& getMailer();
                    $rcxMailer->useMail();
                    $rcxMailer->setTemplate("bruteforce.tpl");

                    $rcxMailer->assign("IP", _REMOTE_ADDR);
                    $rcxMailer->assign("UNAME", $uname);
                    $rcxMailer->assign("DATE", date('Y-m-d H:i:s'));

                    $rcxMailer->assign("COUNT_FAILED", $rcxConfig['count_failed_auth']);
                    $rcxMailer->assign("LOCK_TIME", $rcxConfig['failed_lock_time']);

                    $rcxMailer->setPriority(2);

                    $rcxMailer->setToEmails($rcxConfig['adminmail']);

                    $rcxMailer->setFromEmail($rcxConfig['adminmail']);
                    $rcxMailer->setFromName($meta['title']);
                    $rcxMailer->setSubject(sprintf(_AD_BRUTEFORCE_NOTIFY, $meta['title']));
                    $rcxMailer->send();

                }

                $description = _AD_INCORRECTLOGIN . sprintf(_AD_INCORRECTLOGIN2, $count + 1);

                //redirect_header("admin.php", 4, _AD_INCORRECTLOGIN . sprintf(_AD_INCORRECTLOGIN2, $count));
            } else {
                //redirect_header("admin.php", 2, _AD_INCORRECTLOGIN);
                $description =  _AD_INCORRECTLOGIN;
            }

            login_form(array('type' => 'warning', 'title' => _NOTIFY_WARNING, 'description' => $description));

            exit();
        }

        break;

    case "logout":

        if ($rcxUser) {
            $rcxUser->logout();
        }
        redirect_header("admin.php", 1, _AD_LOGGEDOUT . "<br />" . _AD_THANKYOUFORVISIT . "<br />");
        exit();
        break;

    default:
        break;
}

function login_form($notify = array())
{
    global $rcxConfig;

    $rcx_token = & RcxToken::getInstance();

    include_once("./header.php");

    OpenTable();


    if (!empty($notify)) {
        echo '<div class="' . $notify['type'] . '">
     <h4>' . $notify['title'] . '</h4>
     <p>' . $notify['description'] . '</p>
</div>';
    } else {
        echo '<br />';
    }

    echo "<div align='center'>
<form action='admin.php' method='post' autocomplete='off'>
<table width='75%' border='0' cellspacing='1' cellpadding='0'>
                <tr class='bg2'>
                    <td valign='top'><table width='100%' border='0' cellspacing='1' cellpadding='6'>
                            <tr class='bg3'> 
<td colspan='2'><b><u>"._AD_USERLOGIN."</u>:</b></td>
</tr><tr class='bg1'>
<td>"._AD_NICKNAMECOLON."</td>
<td><input type='text' class='text' name='uname' size='21' maxlength='30' /></td>
</tr><tr class='bg1'>
<td>"._AD_PASSWORDCOLON."</td>
<td><input type='password' class='text' name='pass' size='21' maxlength='20' /></td>
</tr>";
    if ($rcxConfig['use_captcha_for_admin'] == 1) {

        echo "<tr class='bg1'>
<td>"._AD_CAPTCHA."</td>
<td><img src='".RCX_URL."/class/kcaptcha/kcaptcha.php?".session_name()."=".session_id()."' /><br /><br /><input type='text' name='keystring' /></td>
</tr>";
    }

    echo "<tr class='bg1'>

<td colspan='2'>";

    echo $rcx_token->getTokenHTML();

    echo "<input type='submit' class='button' value='"._AD_LOGIN."' />
<input type='hidden' name='op' value='login' /></td>
                        </tr>
            </table></td></tr></table>
</form></div>";
    CloseTable();

    include_once("./footer.php");
}

?>
