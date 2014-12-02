<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_URL')) die('Sorry, but this file cannot be requested directly');

include_once(RCX_ROOT_PATH."/class/rcxlists.php");
include_once(RCX_ROOT_PATH.'/class/form/formdhtmltextarea.php');

if (!isset($submit_page))
{
  $submit_page = _PHP_SELF;
}

echo "
    <table>
    <tr>
      <td>
        <form action='postcomment.php' method='post' id='commentform' onsubmit='return rcxValidate(\"subject\", \"message\", \"comment_submit\");'>
        <br />
        <br />
        <b>". _YOURNAME .":</b>&nbsp;";

if ($rcxUser)
{
  echo "
        <a href='".RCX_URL."/userinfo.php?uid=".$rcxUser->getVar("uid")."'>".$rcxUser->getVar("uname")."</a>&nbsp;[&nbsp;<a href='".RCX_URL."/user.php?op=logout'>"._LOGOUT."</a>&nbsp;]";
}
else
{
  echo "
        <b>".$rcxConfig['anonymous']."</b>
         [ <a href='".RCX_URL."/register.php'>"._REGISTER."</a> ] ";
}

echo "
        <br />
        <br />
        <b>". _SUBJECT ."</b>
        <br />";

if (!preg_match("/^re:/i", $subject))
{
  $subject = "Re: ".substr($subject, 0, 56);
}

echo "
        <input type='text' class='text' id='subject' name='subject' size='50' maxlength='60' value='$subject' />
        <br />
        <br />
        <b>". _MESSAGEICON ."</b>
        <table>
        <tr align='left'>
          <td>";

$lists    = new RcxLists;
$filelist = $lists->getSubjectsList();

$count = 1;
while (list ($key, $file) = each ($filelist))
{
  $checked = "";
  if (isset($icon) && $file == $icon)
  {
    $checked = " checked='checked'";
  }
  echo "
            <input type='radio' class='radio' value='$file' name='icon'$checked />&nbsp;
            <img src='".RCX_URL."/images/subject/".$file."' border='0' alt='' />&nbsp;";
  if ($count == 8)
  {
    echo "
            <br />";
    $count = 0;
  }
  $count++;
}

echo "
          </td>
        </tr>
        </table>
        <br />
        <b>". _COMMENT ."</b>
        <br />
        <br />";

$desc = new RcxFormDhtmlTextArea("", "message", $message, 10, 58);
echo $desc->render();

// CAPTCHA hack by SVL
// begin captcha
if (isset($rcxOption['use_captcha']) && (int)$rcxOption['use_captcha'] == 1 && !$rcxUser)
{
  session_start(); // captcha session
  ?>
        <br />
        <p><u><?php echo _INTERCAPKEY; ?></u>
        <br />
        <img src="<?php echo RCX_URL.'/class/kcaptcha/kcaptcha.php'; ?>?<?php echo session_name()?>=<?php echo session_id()?>">
        <br />
        <input type="text" name="keystring"></p>
  <?php
}
else
{
  echo "
        <br /><br />";
}
// end captcha

if ($rcxUser && !empty($rcxConfig['allow_html']))
{
  echo 
        _ALLOWEDHTML."<br />".
        get_allowed_html();
  if ($allow_html == '0' || $_POST['allow_html'] == '0')
  {
    $option0 = " selected";
  }
  elseif ($allow_html == '2' || $_POST['allow_html'] == '2')
  {
    $option2 = " selected";
  }
  else
  {
    $option1 = " selected";
  }
  echo "
        <br />
        <br />
        <select class='select' name='allow_html'>
          <option value='0'$option0>"._HTMLOFF."</option>
          <option value='1'$option1>"._HTMLAUTOWRAP."</option>
          <option value='2'$option2>"._HTMLNOAUTOWRAP."</option>
        </select>
        <br />";
  }
  else
  {
    echo "
        <input type='hidden' name='allow_html' value='0'>";
  }

echo "
        <input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if ((!isset($allow_smileys) && !isPost()) || $allow_smileys == '1' || $_POST['allow_smileys'] == '1')
{
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."
        <br />";

// Enable bbcode?
echo "
        <input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if ((!isset($allow_bbcode) && !isPost()) || $allow_bbcode == '1' || $_POST['allow_bbcode'] == '1')
{
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."
        <br />";

if ($rcxUser && $rcxConfig['anonpost'])
{
  echo "
        <input type='checkbox' class='checkbox' name='noname'";
  if (!empty($noname))
  {
    echo " checked='checked'";
  }
  echo " />"._POSTANON."
        <br />";
}

?>
        <input type="hidden" name="pid" value="<?php echo intval($pid);?>" />
        <input type="hidden" name="comment_id" value="<?php echo intval($comment_id);?>" />
        <input type="hidden" name="item_id" value="<?php echo intval($item_id);?>" />
        <input type="hidden" name="order" value="<?php echo intval($order);?>" />
        <select class="select" name="op">
          <option value="preview" selected="selected"><?php echo _PREVIEW;?></option>
          <option value="post"><?php echo _POSTCOMMENT;?></option>
        </select>
        <input type="submit" class="button" value="<?php echo _GO;?>" name="comment_submit" id="comment_submit" />
        </form>
      </td>
    </tr>
    </table>

<?php
unset($submit_page);
?>
