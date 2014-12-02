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
  rcx_cp_header();

include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
global $rcxConfig, $myts, $_POST,$_GET;

function make_menu() {
  
global $myts, $rcxConfig, $rcxUser, $rcxModule;

OpenTable();
include("./cache/maintenance.php");

$texte = stripCSlashes($texte);
$texte = $myts->makeTareaData4PreviewInForm($texte);

$in_block = new RcxFormRadioYN(_MI_SHOW_IN_BLOCK, "in_block",$in_block);
$textarea = new RcxFormDhtmlTextArea(_MI_TEXT,"maintenance","$texte",10,100);
$ahtml = "<table><tr><td>".get_allowed_html()."</td></tr></table>";
$allowed_html = new RcxFormLabel( _ALLOWEDHTML, $ahtml );

$submit_button = new RcxFormButton("", "button", _AM_UPDATE, "submit");

$form = new RcxThemeForm(_MI_MAINT_NAME, "settings", "admin.php?fct=maintenance&op=save", "post", true);
$form->addElement($in_block);
$form->addElement($textarea);
$form->addElement($allowed_html);
$form->addElement($submit_button);
$form->display();

echo _MI_MAINT_NAME . "";
CloseTable();
}

function save_maint($content){
  global $rcxConfig, $myts;
  
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      redirect_header('admin.php?fct=maintenanc', 3, $rcx_token->getErrors(true));
      exit();
  }
  
  $filename = RCX_ROOT_PATH."/modules/system/cache/maintenance.php";
    
  if ( $file = fopen($filename, "w") ) {
  fwrite($file, $content);
  fclose($file);
  } else {
    redirect_header("admin.php?fct=maintenanc", 1, _NOTUPDATED);
    exit();
  }
}
  
$op = $_GET[op];

switch($op){
    
case "save":

$content = "<?php\n";
$content .= "\$in_block  =  \"".$myts->makeTareaData4Save($_POST['in_block'])."\";\n";
$content .= "\$texte  =  \"".$myts->makeTareaData4Save($myts->stripPHP($_POST['maintenance']),1,1,1)."\";\n";
$content .= "?>";
save_maint($content);
make_menu();
break;
default:
make_menu();
break;
}
rcx_cp_footer();
  } else {
    echo "Access Denied";
  }

?>
