<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once(RCX_ROOT_PATH.'/class/eseditor/eseditor.php'); //integration ESeditor
?>
<form action="index.php" method="post">
<table border="0" cellpadding="0" cellspacing="0" valign="top" width="100%"><tr>
<td class="bg2">
<table width="100%" border="0" cellpadding="4" cellspacing="1"><tr>
<td nowrap="nowrap" class="bg3"><?php echo _XD_QUESTION;?></td>
<td class="bg1"><input type="text" class="text" name="contents_title" value="<?php echo $contents_title;?>" size="31" maxlength="255" /></td>

</tr><tr>
<td nowrap="nowrap" class="bg3"><?php echo _XD_ORDER;?></td>
<td class="bg1"><input type="text" class="text" name="contents_order" value="<?php echo $contents_order;?>" size="4" maxlength="3" /></td>
</tr>

<?php
$checked = ($contents_visible == 1) ? " checked='checked'" : '';
?>

<tr>
<td nowrap="nowrap" class="bg3"><?php echo _XD_DISPLAY;?></td>
<td class="bg1"><input type="checkbox" class="checkbox" name="contents_visible" value="1"<?php echo $checked;?> /></td>
</tr><tr>
<td nowrap="nowrap" class="bg3"><?php echo _XD_ANSWER;?></td>
<td class="bg1">

<?php
//integration ESeditor 
$admin = 0;
if ($rcxUser && $rcxUser->isAdmin()) {
  $admin = 1;
}
if($admin == 0 && $rcxConfig['allow_library'] == 0){
  $toolbar = 'runcms' ;
  }else{
  $toolbar = 'rcx_lib' ;
  }
$runESeditor = new ESeditor('contents_contents');
$runESeditor->BasePath = RCX_URL."/class/eseditor/";
if ($runESeditor->IsCompatible() && $editorConfig["displayeditor"] == 1)
{
//    $runESeditor->Width = "650" ;
//  $runESeditor->Height = "500" ;
  $runESeditor->Value = $contents_contents ;
  $runESeditor->ToolbarSet = $toolbar ;
  
//  echo $runESeditor->Create('contents_contents',650,500) ;
  echo $runESeditor->Create('contents_contents') ;
  echo "<input type='hidden' name='allow_html' value='2' />";
}
else
{
include_once(RCX_ROOT_PATH."/class/form/formdhtmltextarea.php");
//$desc  = new RcxFormDhtmlTextArea("", "contents_contents", $contents_contents, 10, 58);
$desc  = new RcxFormDhtmlTextArea("", "contents_contents", $contents_contents);
echo $desc->render();

// Enable html?
echo "<br /><br />"._ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0' || $_POST['allow_html'] == '0') {
  $option0 = " selected";
  } elseif ($_POST['allow_html'] == '2') {
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

// Enable smileys?
echo "<input type='checkbox' class='checkbox' name='allow_smileys' value='1'";
if ( (!isset($allow_smileys) && !isPost()) || $allow_smileys == '1' || $_POST['allow_smileys'] == '1') {
  echo " checked='checked'";
}
echo " /> "._ENABLESMILEY."<br />";

// Enable bbcode?
echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
if ( (!isset($allow_bbcode) && !isPost()) || $allow_bbcode == '1' || $_POST['allow_bbcode'] == '1' ) {
  echo " checked='checked'";
}
echo " />&nbsp;"._ENABLEBBCODE."<br />";
}
?>

</td>

</tr><tr>
<td nowrap="nowrap" class="bg3">&nbsp;</td>
<td class="bg1">
<input type="hidden" name="category_id" value="<?php echo $category_id;?>" />
<input type="hidden" name="contents_id" value="<?php echo $contents_id;?>" />
<input type="hidden" name="op" value="<?php echo $op;?>" />
<input type="submit" class="button" name="contents_preview" value="<?php echo _PREVIEW;?>" />
<input type="submit" class="button" name="contents_submit" value="<?php echo _SUBMIT;?>" />
</td>

</tr></table></td>
</tr></table>
</form><br /><br />
