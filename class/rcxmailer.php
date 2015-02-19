<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("RCX_RCXMAILER_INCLUDED")) {
  define("RCX_RCXMAILER_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxMailer {

  var $fromEmail;
  var $fromName;
  var $toUsers;
  var $toEmails;
  var $subject;
  var $body;
  var $errors;
  var $success;
  var $isMail;
  var $isPM;
  var $assignedTags;
  var $template;
  var $templatedir;
  var $useToggle;
  var $type;
  var $pmUserType;

  function RcxMailer() {
    $this->reset();
  }


/**
* reset all properties to default
*/
function reset() {
  $this->fromEmail    = '';
  $this->fromName     = '';
  $this->toUsers      = array();
  $this->toEmails     = array();
  $this->headers      = array();
  $this->subject      = '';
  $this->body         = '';
  $this->errors       = array();
  $this->success      = array();
  $this->isMail       = false;
  $this->isPM         = false;
  $this->assignedTags = array();
  $this->template     = '';
  $this->templatedir  = '';
  $this->isToggle     = false;
  $this->type         = 'plain';
  $this->boundary     = '----'.md5(uniqid(mt_rand(), TRUE));
  $this->pmUserType   = 'user';
}

/**
 * Enter description here...
 *
 * @param unknown_type $str
 * @param unknown_type $charset
 * @return unknown
 */
function encode_mime_header($str, $charset = _CHARSET) {
    
    $str = trim($str);
    
    if ($this->is_ascii($str) || preg_match('/^=\?(.*?)\?B|Q\?(.*?)\?=/', $str)) {
    	return $str;
    }
    
    return '=?' . $charset . '?B?' . base64_encode($str) . '?=';
}

/**
 * Enter description here...
 *
 * @param unknown_type $str
 * @return unknown
 */
function is_ascii($str)
{
    return !preg_match('/[^\x00-\x7f]/', $str);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function assign($tag, $value=NULL) {

if ( is_array($tag) ) {
  foreach ($tag as $k => $v) {
    $this->assign($k, $v);
  }
  } else {
    if ( !empty($tag) && isset($value) ) {
      $tag = strtoupper(trim($tag));
        if ( substr($tag, 0, 2) != 'X_' ) {
          $this->assignedTags[$tag] = $value;
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
function attachFile($file, $type='application/x-unknown-content-type', $disposition='attachment') {

if ( empty($type) ) {
  $type = 'application/x-unknown-content-type';
}

if ( preg_match("'(audio|application|image|video)/'i", $type) ) {
  $mode = 'b';
}

if ($fp = @fopen($file, 'r'.$mode)) {
  $attachment = fread($fp, filesize($file));
  fclose($fp);
}

if ($attachment) {
  if ($disposition != 'inline') { $disposition = 'attachment'; }
  $this->attachments[] = '--'.$this->boundary;
  $this->attachments[] = 'Content-Type: '.$type.'; name="'.basename($file).'"';
  $this->attachments[] = 'Content-Transfer-Encoding: base64';
  $this->attachments[] = 'Content-Disposition: '.$disposition.'; filename="'.basename($file).'"'."\n";
  $this->attachments[] = chunk_split(base64_encode($attachment));
  return(TRUE);
}

return(FALSE);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setTemplateDir($value) {

if ( @is_dir($value) ) {
  if (substr($value, -1) == '/') {
    $value = substr($value, 0, -1);
  }
  $this->templatedir = $value;
  }
}

/**
* Sets path to the root of the module containing the template
* Do NOT set the path to the language dir
* Templates are always in <path>/language/(lang)/mail_template/<files>
*
* @param string $value full path to directory
*/
function setTemplate($value) {
  $this->template = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setFromEmail($value) {
  $this->fromEmail = trim($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setFromName($value) {
  $this->fromName = trim($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setSubject($value) {
  $this->subject = trim($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setBody($value) {
  $this->body = trim($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function useMail() {
  $this->isMail = true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function usePM($type = 'user') {
  $this->isPM = true;
  $this->pmUserType = $type;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function useToggle($value=false) {
  $this->useToggle = ($value == false) ? false : true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setToEmails($email) {

if (!is_array($email) && preg_match('#(,|;| )#', $email)) {
  $email = preg_split('#(,|;| )#', $email);
}

if ( !is_array($email) ) {
  $email = trim($email);
  if ( checkEmail($email) ) {
    array_push($this->toEmails, $email);
  }
  } else {
    foreach ($email as $e) {
      $this->setToEmails($e);
    }
  }

$this->toEmails = array_unique($this->toEmails);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setToUsers($user) {

if ( !is_array($user) ) {
//  if ( get_class($user) == 'rcxuser' ) {
  if ( is_object($user) && strtolower(get_class($user)) == 'rcxuser' ) {
    array_push($this->toUsers, $user->getVar('uid'));
    } elseif ( RcxUser::getUnameFromId($user) ) {
      array_push($this->toUsers, $user);
    }
  } else {
    foreach ($user as $u) {
      $this->setToUsers($u);
    }
  }

$this->toUsers = array_unique($this->toUsers);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setToGroups($group) {

if ( !is_array($group) ) {
  if ( !is_object($group) || strtolower(get_class($group)) != 'rcxgroup' ) {
    $group = new RcxGroup($group);
  }
  $this->setToUsers($group->getMembers());
  } else {
    foreach ($group as $g) {
      $this->setToGroups($g);
    }
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setType($type='text/plain') {
  $this->addHeader('Content-Type:', $type.';charset='._CHARSET);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setPriority($priority=3) {

switch($priority) {
  case 1:
    $this->addHeader('X-Priority:', '1 (Highest)');
    break;

  case 2:
    $this->addHeader('X-Priority:', '2 (High)');
    break;

  case 3:
    $this->addHeader('X-Priority:', '3 (Normal)');
    break;

  case 4:
    $this->addHeader('X-Priority:', '4 (Low)');
    break;

  case 5:
    $this->addHeader('X-Priority:', '5 (Lowest)');
    break;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setReciept($email='') {
  $email = checkEmail($email) ? $email : $this->fromEmail;
  $this->addHeader('Disposition-Notification-To:', $email);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function addHeader($type, $value) {

$type = trim($type);

if (substr($type, -1) != ':') {
  $type .= ':';
}

$this->headers[$type] = trim($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function removeHeader($value) {

$value = trim($value);

if (substr($value, -1) != ':') {
  $value .= ':';
}

unset($this->headers[$value]);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getHeaders() {

foreach ($this->headers as $key => $value) {
  if (substr($key, -1) != ':') {
    $key .= ':';
  }
  $header[] = trim($key).''.trim($value);
}

return join("\n", $header);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function send() {
global $rcxUser, $rcxConfig, $meta;

if ( $this->toggle(4) ) {
  return;
}

if (!empty($this->template))
{
  if (!empty($this->templatedir))
  {
    if (@file_exists($this->templatedir.'/language/'.RC_ULANG.'/mail_template/'.$this->template))
    {
      $path = $this->templatedir.'/language/'.RC_ULANG.'/mail_template/'.$this->template;
    }elseif(@file_exists($this->templatedir.'/language/english/mail_template/'.$this->template))
    {
      $path = $this->templatedir.'/language/english/mail_template/'.$this->template;
    }else
    {
      $this->errors[] = sprintf(_XM_FAILOPTPL, $this->templatedir.$this->template);
      return false;
    }
  }else
  {
    if (@file_exists(RCX_ROOT_PATH.'/language/'.RC_ULANG.'/mail_template/'.$this->template))
    {
      $path = RCX_ROOT_PATH.'/language/'.RC_ULANG.'/mail_template/'.$this->template;
    }elseif(@file_exists(RCX_ROOT_PATH.'/language/english/mail_template/'.$this->template))
    {
      $path = RCX_ROOT_PATH.'/language/english/mail_template/'.$this->template;
    }else
    {
      $this->errors[] = sprintf(_XM_FAILOPTPL, $this->templatedir.$this->template);
      return false;
    }
  }

  if ($fp = @fopen($path, 'r')) {
    $this->setBody(fread($fp, filesize($path)));
    fclose($fp);
    if ( stristr($this->body, '{X_ISHTML}') ) {
      $this->body = str_replace('{X_ISHTML}', '', $this->body);
      $this->setType('text/html');
    }
    } else {
      $this->errors[] = sprintf(_XM_FAILOPTPL, $path);
      return false;
    }
}elseif (empty($this->body))
{
  $this->errors[] = _XM_MSGBODY;
  return false;
}

// replace tags with actual values
foreach ( $this->assignedTags as $k => $v ) {
  $this->body = str_replace("{".$k."}", $v, $this->body);
}

$this->body = str_replace("\r\n", "\n"  , $this->body);
$this->body = str_replace("\r"  , "\n"  , $this->body);

if ($this->isMail || $this->toEmails) {
  if ( empty($this->fromName) && $rcxUser ) {
    $this->setFromName($rcxUser->uname());
    } elseif ( empty($this->fromName) ) {
      $this->setFromName($meta['title']);
    }

  if ( empty($this->fromEmail) && $rcxUser ) {
    $this->setFromEmail($rcxUser->email());
    } elseif ( empty($this->fromEmail) ) {
      $this->setFromEmail($rcxConfig['adminmail']);
    }

  $this->addHeader('From:', $this->encode_mime_header($this->fromName) . ' <' . $this->fromEmail . '>');
  $this->addHeader('Reply-To:', $this->fromEmail);
  $this->addHeader('Return-Path:', $this->fromEmail);
  $this->addHeader('Error-To:', $this->fromEmail);
  $this->addHeader('Return-Errors-To:', $this->fromEmail);
  $this->addHeader('X-Mailer:', RCX_VERSION);

  if ( !isset($this->headers['Content-Type:']) ) {
     $this->setType();
  }

  if ( !empty($this->attachments) ) {
    $body = "\n".'--'.$this->boundary."\n";
    if ( isset($this->headers['Content-Type:']) ) {
      $body .= 'Content-Type: '.$this->headers['Content-Type:']."\n\n";
      } else {
        $body .= 'Content-Type: text/plain'."\n\n";
      }
    $body       .= $this->body."\n\n";
    $body       .= join("\n", $this->attachments);
    $body       .= '--'.$this->boundary.'--';
    $this->body  = $body;
    $this->addHeader('Content-Type:', 'multipart/mixed; boundary="'.$this->boundary.'"');
  }

// RFC 822 compliency :: need to test header/attachments
$this->body = str_replace("\n", "\r\n", trim($this->body));
}

$headers = $this->getHeaders();

/*
echo "<pre>".$headers."</pre>";
exit();
*/

$pmatonce  = !empty($rcxConfig['pm_atonce']) ? intval($rcxConfig['pm_atonce']) : 300;
$mlatonce  = !empty($rcxConfig['ml_atonce']) ? intval($rcxConfig['ml_atonce']) : 25;
$sleeptime = !empty($rcxConfig['send_pause']) ? intval($rcxConfig['send_pause']) : 2; // fix by ZlydenGL

// send mail to specified mail addresses, if any
$letters=0;
foreach ($this->toEmails as $mailaddr)
{
  if (!$this->sendMail($mailaddr, $this->encode_mime_header($this->subject), $this->body, $headers))
    $this->errors[] = sprintf(_XM_SENDMAILNG, $mailaddr);
  else
    $this->success[] = sprintf(_XM_MAILGOOD, $mailaddr);
  // send only limited emails at once
  ++$letters;
  if ($letters == $mlatonce)
  {
    $letters = 0;
    sleep($sleeptime);
  }

}

//     if (function_exists('set_time_limit') AND get_cfg_var('safe_mode')==0)
if (function_exists('set_time_limit'))
  @set_time_limit(0);

ignore_user_abort(true);

// send message to specified users, if any
$pms=0;
foreach ($this->toUsers as $uid) {
  $user = new RcxUser($uid);
  // set some user specific variables
  $subject = str_replace("{X_UNAME}", $user->getVar("uname"), $this->subject );
  $text    = str_replace("{X_UID}", $user->getVar("uid"), $this->body );
  $text    = str_replace("{X_UEMAIL}", $user->getVar("email"), $text );
  $text    = str_replace("{X_UNAME}", $user->getVar("uname"), $text );
  $text    = str_replace("{X_UACTLINK}", RCX_URL."/user.php?op=actv&id=".$user->getVar("uid")."&key=".$user->getVar("actkey")."", $text );
  // send mail
  if ($this->isMail)
  {
    if (checkEmail($user->getVar("email")) && $this->sendMail($user->getVar("email"), $this->encode_mime_header($subject), $text, $headers))
      $this->success[] = sprintf(_XM_MAILGOOD, $user->getVar("uname"));
    else
      $this->errors[] = sprintf(_XM_SENDMAILNG, $user->getVar("uname"));
    // send only limited emails at once
    ++$letters;
    if ($letters == $mlatonce)
    {
      $letters = 0;
      sleep($sleeptime);
    }
  }
  // send private message
  if ($this->isPM)
  {
    if (!$this->sendPM($user->getVar("uid"), $subject, $text))
      $this->errors[] = sprintf(_XM_SENDPMNG, $user->getVar("uname"));
    else
      $this->success[] = sprintf(_XM_PMGOOD, $user->getVar("uname"));
    // send only limited PMs at once
    ++$pms;
    if ($pms == $pmatonce)
    {
      $pms = 0;
      sleep($sleeptime);
    }
  }
} // END FOREACH

if ( count($this->errors) > 0 ) {
  return false;
}

return true;
} // END SEND

/**
* Description
*
* @param type $var description
* @return type description
*/
function sendMail($to, $subject, $body, $headers) {
global $myts, $rcxConfig;

$subject = trim($myts->oopsStripSlashesGPC($subject));
$body    = trim($myts->oopsStripSlashesGPC($body));
$headers = trim($myts->oopsStripSlashesGPC($headers));

  if ($rcxConfig['mail_function'] == 'SMTP')
  {
    if (!$this->smtpmail($to, $subject, $body, $headers)) 
      return false;
  }elseif ($rcxConfig['mail_function'] == 'mail')
  {
    if (!mail($to, $subject, $body, $headers))
      return false;
  }elseif ($rcxConfig['mail_function'] == 'email')
  {
    if ( !email($this->fromEmail, $to, $subject, $body, $this->fromEmail, $headers) )
      return false;
  } else
    return false;

//sleep(1);
return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function sendPM($uid, $subject, $body) {
global $rcxUser;

include_once(RCX_ROOT_PATH."/modules/pm/class/pm.class.php");

$pm = new PM();
$pm->setVar("subject"    , $subject);
$pm->setVar("msg_text"   , $body);
$pm->setVar("to_userid"  , $uid);
$pm->setVar("from_userid", $rcxUser->getVar("uid"));
$pm->setVar('msg_folders', 1);

if ($this->pmUserType == 'admin') {
	$pm->setVar('type', 'admin');
	$pm->setVar('allow_html', 1);
}

if (!$pm->store())
  return false;

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getErrors($ashtml=true) {

  if (!$ashtml)
    return $this->errors;
  else
  {
    if (!empty($this->errors))
    {
      $ret = "<h6>"._ERROR."</h6>";
      foreach ($this->errors as $error)
      {
        $ret .= $error.'<br />';
      }
    }else
      $ret = "";

    return $ret;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function getSuccess($ashtml = true) {

  if (!$ashtml)
    return $this->success;
  else
  {
    $ret = "";
    if (!empty($this->success))
    {
      foreach ($this->success as $suc)
      {
        $ret .= $suc."<br />";
      }
    }
    return $ret;
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function toggle($trigger=5) {

$toUsers  = count($this->toUsers);
$toEmails = count($this->toEmails);

if ( ($this->useToggle == 1) && ($this->isMail || $toEmails) && (($toEmails+$toUsers) > $trigger) ) {
  $this->useToggle = 0;
  ?>
  <form action="<?php echo RCX_URL;?>/include/mailtoggle.php" method="post" id="toggle" name="toggle" target="mailer">
  <input type="hidden" name="mail" value="<?php echo urlencode(serialize($this));?>" />
  <input type="image" class="image" src="<?php echo RCX_URL;?>/images/pixel.gif" />
  </form>

  <script type="text/javascript">
    mailer = window.open("", "mailer", "width=450, height=250, location=no, menubar=no, resizable=no, scrollbars=yes, status=no, titlebar=no, toolbar=no, directories=no");
    mailer.moveTo(((screen.availWidth/2)-(450/2)), ((screen.availHeight/2)-(250/2)));
    rcxGetElementById("toggle").submit();
  </script>
  <?php
  echo "<h4>"._XM_BATCH."</h4>"._XM_LEAVE;
  return(TRUE);
  }

return(FALSE);
}

// remaked from phpBB2 smtp.php by SVL
//
// This function has been modified as provided
// by SirSir to allow multiline responses when 
// using SMTP Extensions
//
function server_parse($socket, $response, $line = __LINE__) 
{
  $server_response = ''; 
  while (substr($server_response, 3, 1) != ' ') 
  {
    if (!($server_response = fgets($socket, 256))) 
    { 
      return $this->errors[] = sprintf(_XM_SMTPRC, $line, __FILE__);
//       message_die "Couldn't get mail server response codes. line ... file ..."
    }
  } 

  if (!(substr($server_response, 0, 3) == $response)) 
  { 
    return $this->errors[] = sprintf(_XM_SMTPPS, $server_response, $line, __FILE__);
//    message_die "Ran into problems sending Mail. Response: $server_response. line ... file ..."
  } 
}

// Replacement or substitute for PHP's mail command
function smtpmail($mail_to, $subject, $message, $headers = '') {
  global $rcxConfig;

  // Fix any bare linefeeds in the message to make it RFC821 Compliant.
  $message = preg_replace("#(?<!\r)\n#si", "\r\n", $message);

  if ($headers != '')
  {
    if (is_array($headers))
    {
      if (sizeof($headers) > 1)
      {
        $headers = join("\n", $headers);
      }
      else
      {
        $headers = $headers[0];
      }
    }
    $headers = chop($headers);

    // Make sure there are no bare linefeeds in the headers
    $headers = preg_replace('#(?<!\r)\n#si', "\r\n", $headers);

    // Ok this is rather confusing all things considered,
    // but we have to grab bcc and cc headers and treat them differently
    // Something we really didn't take into consideration originally
    $header_array = explode("\r\n", $headers);
    @reset($header_array);

    $headers = '';
    while(list(, $header) = each($header_array))
    {
      if (preg_match('#^cc:#si', $header))
      {
        $cc = preg_replace('#^cc:(.*)#si', '\1', $header);
      }
      else if (preg_match('#^bcc:#si', $header))
      {
        $bcc = preg_replace('#^bcc:(.*)#si', '\1', $header);
        $header = '';
      }
      $headers .= ($header != '') ? $header . "\r\n" : '';
    }

    $headers = chop($headers);
    $cc = explode(', ', $cc);
    $bcc = explode(', ', $bcc);
  }

//  if (trim($subject) == '')
//  {
//    return $this->errors[] = _XM_SMTPNOSUBJ;
//    message_die "No email Subject specified"
//  }

//  if (trim($message) == '')
//  {
//    $this->errors[] = _XM_MSGBODY;
//    message_die "Email message was blank"
//  }

  // Ok we have error checked as much as we can to this point let's get on
  // it already.
  
  $smtp_port = $rcxConfig['smtp_port'] ? $rcxConfig['smtp_port'] : 25;
  
  if( !$socket = @fsockopen($rcxConfig['smtp_host'], $smtp_port, $errno, $errstr, 30) )
  {
    return $this->errors[] = sprintf(_XM_SMTPCONT, $errno, $errstr);
//    message_die "Could not connect to smtp host : $errno : $errstr"
  }
  // Wait for reply
  $this->server_parse($socket, "220", __LINE__);

  // Do we want to use AUTH?, send RFC2554 EHLO, else send RFC821 HELO
  // This improved as provided by SirSir to accomodate
  if( !empty($rcxConfig['smtp_uname']) && !empty($rcxConfig['smtp_pass']) )
  { 
    fputs($socket, "EHLO " . $rcxConfig['smtp_host'] . "\r\n");
    $this->server_parse($socket, "250", __LINE__);

    fputs($socket, "AUTH LOGIN\r\n");
    $this->server_parse($socket, "334", __LINE__);

    fputs($socket, base64_encode($rcxConfig['smtp_uname']) . "\r\n");
    $this->server_parse($socket, "334", __LINE__);

    fputs($socket, base64_encode($rcxConfig['smtp_pass']) . "\r\n");
    $this->server_parse($socket, "235", __LINE__);
  }
  else
  {
    fputs($socket, "HELO " . $rcxConfig['smtp_host'] . "\r\n");
    $this->server_parse($socket, "250", __LINE__);
  }

  // From this point onward most server response codes should be 250
  // Specify who the mail is from....
  fputs($socket, "MAIL FROM: <" . $rcxConfig['adminmail'] . ">\r\n");
  $this->server_parse($socket, "250", __LINE__);

  // Specify each user to send to and build to header.
  $to_header = '';

  // Add an additional bit of error checking to the To field.
  $mail_to = (trim($mail_to) == '') ? 'Undisclosed-recipients:;' : trim($mail_to);

  if (preg_match('#[^ ]+\@[^ ]+#', $mail_to))
  {
    fputs($socket, "RCPT TO: <$mail_to>\r\n");
    $this->server_parse($socket, "250", __LINE__);
  }

  // Ok now do the CC and BCC fields...
  @reset($bcc);
  while(list(, $bcc_address) = each($bcc))
  {
    // Add an additional bit of error checking to bcc header...
    $bcc_address = trim($bcc_address);
    if (preg_match('#[^ ]+\@[^ ]+#', $bcc_address))
    {
      fputs($socket, "RCPT TO: <$bcc_address>\r\n");
      $this->server_parse($socket, "250", __LINE__);
    }
  }

  @reset($cc);
  while(list(, $cc_address) = each($cc))
  {
    // Add an additional bit of error checking to cc header
    $cc_address = trim($cc_address);
    if (preg_match('#[^ ]+\@[^ ]+#', $cc_address))
    {
      fputs($socket, "RCPT TO: <$cc_address>\r\n");
      $this->server_parse($socket, "250", __LINE__);
    }
  }

  // Ok now we tell the server we are ready to start sending data
  fputs($socket, "DATA\r\n");

  // This is the last response code we look for until the end of the message.
  $this->server_parse($socket, "354", __LINE__);

  // Send the Subject Line...
  fputs($socket, "Subject: $subject\r\n");

  // Now the To Header.
  fputs($socket, "To: $mail_to\r\n");

  // Now any custom headers....
  fputs($socket, "$headers\r\n\r\n");

  // Ok now we are ready for the message...
  fputs($socket, "$message\r\n");

  // Ok the all the ingredients are mixed in let's cook this puppy...
  fputs($socket, ".\r\n");
  $this->server_parse($socket, "250", __LINE__);

  // Now tell the server we are done and close the socket...
  fputs($socket, "QUIT\r\n");
  fclose($socket);

  return TRUE;
}
} // END CLASS

}
?>
