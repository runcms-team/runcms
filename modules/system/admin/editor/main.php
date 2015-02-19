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
    
$rcx_token = & RcxToken::getInstance();
  
if ($_POST['op'] == 'save' && !$rcx_token->check() ) {
    redirect_header('admin.php?fct=editor', 3, $rcx_token->getErrors(true));
    exit();
}     

rcx_cp_header();

include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
global $rcxConfig, $myts;

// ----------------------------------------------------------------------------------------//
function make_menu() {
include_once(RCX_ROOT_PATH."/class/rcxformloader.php"); 
include_once(RCX_ROOT_PATH.'/class/rcxgroup.php');
global $myts, $rcxConfig, $rcxUser, $rcxModule;

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_AM_EDITOR_CONFIG.'</div>
            <br />
            <br />';

OpenTable();
include("./cache/editor.php");

$allow_editor       = new RcxFormRadioYN(_MD_AM_DISPL_EDITOR, "displayeditor", $editorConfig['displayeditor'], _YES,_NO);
$allow_for_user     = new RcxFormRadioYN(_MD_AM_DISPL_USER, "displayforuser", $editorConfig['displayforuser'], _YES,_NO);
$allow_for_mailusers= new RcxFormRadioYN(_MD_AM_DISPL_MAILUSER, "displayformailusers", $editorConfig['displayformailusers'], _YES,_NO);
$op_hidden     = new RcxFormHidden("op", "save");
$submit_button = new RcxFormButton("", "button", _UPDATE, "submit");

$upload_group = new RcxFormSelectGroup(_MD_AM_GROUP_UPL,"uploadGroup",1,explode(",", $editorConfig['groupstoupload']),5,1);

$form = new RcxThemeForm("", "editor_form", "admin.php?fct=editor", "post", true);
$form->addElement($allow_editor);
$form->addElement($allow_for_user);
$form->addElement($allow_for_mailusers);
$form->addElement($upload_group);
$form->addElement($op_hidden);
$form->addElement($submit_button);
$form->display();
CloseTable();
echo "                        
        </td>
    </tr>
</table>";
}

function save_maint($content){
  global $rcxConfig, $myts;
  

  $filename = RCX_ROOT_PATH."/modules/system/cache/editor.php";
    
  if ( $file = fopen($filename, "w") ) {
  fwrite($file, $content);
  fclose($file);
  } else {
    redirect_header("admin.php?fct=editor", 1, _NOTUPDATED);
    exit();
  }
}
  




$op = $_POST['op'];

switch($op){
    
case "save":

$content = "<?php\n\n";
$content .= "/*********************************************************************
"._MD_AM_REMEMBER."
"._MD_AM_IFUCANT."
*********************************************************************/\n\n";
$content .= "// Activate editor\n";
$content .= "\$editorConfig['displayeditor']         = ".intval($_POST['displayeditor']).";\n\n";
$content .= "// Activate editor for user\n";
$content .= "\$editorConfig['displayforuser']        = ".intval($_POST['displayforuser']).";\n\n";
$content .= "// Activate editor for mailusers admin module\n";
$content .= "\$editorConfig['displayformailusers']   = ".intval($_POST['displayformailusers']).";\n\n";
$content .= "\$editorConfig['groupstoupload']   = '".implode(',',$_POST['uploadGroup'])."';\n\n";

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
