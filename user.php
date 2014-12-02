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

include_once('./mainfile.php');

function main() {
global $rcxUser, $rcxConfig;

if (!$rcxUser) {
include_once("./header.php");
OpenTable();

echo "
<form action='user.php' method='post'>
<table><tr>
<td colspan='2'><b><u>"._US_USERLOGIN."</u>:</b></td>
</tr><tr>
<td>"._US_NICKNAMECOLON."</td>
<td><input type='text' class='text' name='uname' size='21' maxlength='30'";
if ( isset($_COOKIE[$rcxConfig['cookie_name']]) && empty($rcxConfig['cache_time']) ) {
  echo " value='".$_COOKIE[$rcxConfig['cookie_name']]."'";
}
echo " /></td>
</tr><tr>
<td>"._US_PASSWORDCOLON."</td>
<td><input type='password' class='text' name='pass' size='21' maxlength='20' /></td>
<tr><tr>
<td colspan='2' align='right'>
<input type='submit' class='button' value='"._US_LOGIN."' />
<input type='hidden' name='op' value='login' /></td>
</tr></form></table>";
CloseTable();

echo "<a name='lost'></a><p><b>". _US_NOTREGISTERED ."</b></p>";

OpenTable();

echo "
<b>"._US_LOSTPASSWORD."</b>
<br /><br />"._US_NOPROBLEM."<br />
<form action='lostpass.php' method='post'>
"._US_YOUREMAIL."
<input type='text' class='text' name='email' size='26' maxlength='60' /><br /><br />
"._US_ACTKEYCOLON."<input type='radio' class='radio' name='actkey' value='1' />
"._US_PASSWORDCOLON."<input type='radio' class='radio' name='actkey' value='0' checked />
<input type='hidden' name='op' value='mailpasswd' />
<input type='submit' class='button' value='"._SEND."' />";

CloseTable();

echo "</form>";

include_once("./footer.php");
} elseif ($rcxUser) {
  header("Location: userinfo.php?uid=".$rcxUser->getVar("uid")."");
  exit();
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function logout() {
  global $rcxUser;
  if ($rcxUser) {
    $rcxUser->logout();
  }
  redirect_header("index.php", 1, _US_LOGGEDOUT."<br />"._US_THANKYOUFORVISIT."<br />");
  exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function login() {
  sleep(1);
  $uname = !isset($_POST['uname']) ? '' : trim($_POST['uname']);
  $pass = !isset($_POST['pass']) ? '' : trim($_POST['pass']);
  if ($uname == '' || $pass == '')
  {
    redirect_header("user.php", 1, _US_INCORRECTLOGIN);
    exit();
  }
  $user = RcxUser::login($uname, $pass);
  if (false != $user)
  {
    if ( 0 == $user->getVar('level') )
    {
      redirect_header("index.php", 5, _US_NOACTTPADM);
      exit();
    }
    include_once(RCX_ROOT_PATH.'/class/sessions.class.php');
    $session = new RcxUserSession();
    $session->setUid($user->getVar('uid'));
    $session->setUname($user->getVar('uname'));
    $session->setPass($user->getVar('pass'));
    $session->setSalt($user->getVar('pwdsalt'));
    if (!$session->store())
    {
      redirect_header("index.php", 1, _NOTUPDATED);
      exit();
    }
    $user->updateLastLogin();
                          /* retur til index  start */
    $url  = (_HTTP_REFERER != "") ? _HTTP_REFERER : 'index.php';      
    if (eregi("user.php", $url)) { $url = "index.php"; }
                          /* slut */
    // If caching probs persist, turn this hack on
    $url .= preg_match('/\&/', $url) ? '&'.time() : '?'.time();
    redirect_header($url, 1, sprintf(_US_LOGGINGU, $user->getVar('uname')));
    exit();
  }
  else
  {
    redirect_header("user.php", 1, _US_INCORRECTLOGIN);
    exit();
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function activate($id, $key) {

if ( empty($id) || !is_numeric($id) ) {
  redirect_header("index.php", 1, "No possible activate!");
  exit();
}

$thisuser = new RcxUser($id);

if ( $thisuser->actkey() != $key ) {
  redirect_header("index.php", 5, _US_ACTKEYNOT);
  exit();
  } else {
    if ( $thisuser->isActive() ) {
      redirect_header("user.php", 5, _US_ACONTACT);
      exit();
    } else {
      if ($thisuser->activate()) {
        redirect_header("user.php", 5, _US_ACTLOGIN);
        exit();
        } else {
          redirect_header("index.php", 5, "Activation failed!");
          exit();
        }
    }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete($ok=0) {
global $rcxUser, $rcxConfig, $_POST;

if ( !$rcxUser || !$rcxConfig['self_delete'] ) {
  redirect_header("index.php", 5, _NOACTION);
  exit();
  } else {
    if ($ok == 1) {
      if (!$rcxUser->isAdmin()) {
        $rcxUser->delete();
        redirect_header("index.php", 3, _US_BEENDELED);
        exit();
        } else {
          redirect_header("index.php", 5, _NOACTION);
          exit();
        }
      } else {
        include_once("header.php");
        echo "<h4>"._US_SURETODEL."</h4>"._US_REMOVEINFO."<br />";
        echo "<table><tr><td>";
        echo myTextForm("user.php?op=delete&amp;ok=1", _YES);
        echo "</td><td>";
        echo myTextForm("user.php", _NO);
        echo "</td></tr></table>";
        include_once("footer.php");
        exit();
      }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch($op) {
  case "logout":
    logout();
    break;

  case "login":
    if (!headers_sent()) {
      header("Expires: Sat, 18 Aug 2002 05:30:00 GMT");
      header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
      header("Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0");
    }
    login();
    break;

  case "actv":
    activate($_GET['id'], $_GET['key']);
    break;

  case "delete":
    delete($_POST['ok']);
    break;

  default:
    main();
}
?>
