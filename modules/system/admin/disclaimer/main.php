<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {
   
function make_menu() {
global $myts;

$rcx_token = & RcxToken::getInstance();

rcx_cp_header();
OpenTable();
?>
<table align="center">
<div align="center">
<h3><u><?php echo _MI_DIS_NAME;?></u></h3>
<hr size="1" noshade="noshade" />
</div>
<form name="settings" action="./admin.php?fct=disclaimer" method="post">
<div align="center">
<textarea class="textarea" name="disclaimer" rows="30" cols="80">
<?php readfile("./cache/disclaimer.php");?>
</textarea>
</div><br>
<tr align="center" valign="middle">
<td colspan="4"><?php echo $rcx_token->getTokenHTML();?><input type="submit" class="button" name="submit" value="<?php echo _AM_UPDATE;?>" /></td>
</tr>
</form></table>
<br /><br />
<?php
CloseTable();
rcx_cp_footer();
}

function write_file($file, $content, $mode='wb') {

$file = fopen('./cache/'.$file.'.php', $mode);
fwrite($file, trim($content) );
fclose($file);
} 

function write_disc() {
global $myts;

write_file("disclaimer", $content, "w");
$content = $myts->oopsStripSlashesGPC($_POST["disclaimer"]);
$content = $myts->stripPHP($content);
write_file("disclaimer", $content, "wb");
}


function clean_text($text) {
global $myts;

$text = $myts->oopsStripSlashesGPC($text);
$text = str_replace('"', "", $text);
return $text;
}

switch($_POST['submit'])
  {
/* case _AM_MERGE:
if ($_POST["which"] && $_FILES["merge"]["name"] && preg_match("/text\/plain/i", $_FILES["merge"]["type"])) {
  if (function_exists('move_uploaded_file')) {
    $copymode = 'move_uploaded_file';
    } else {
      $copymode = 'copy';
    }
  $copymode($_FILES["merge"]["tmp_name"], RCX_ROOT_PATH.'/modules/system/cache/merge.tmp');
  merge(RCX_ROOT_PATH.'/modules/system/cache/merge.tmp', $_POST["which"]);
  @unlink(RCX_ROOT_PATH.'/modules/system/cache/merge.tmp');
}
make_menu();
break;*/

case _AM_UPDATE:

$rcx_token = & RcxToken::getInstance();

if (!$rcx_token->check() ) {
    redirect_header('admin.php?fct=disclaimer', 3, $rcx_token->getErrors(true));
    exit();
}      
    
write_disc();
make_menu();
break;


default:
make_menu();
break;
}
  } else {
    echo "Access Denied";
  }
?>
