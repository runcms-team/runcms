<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include("./admin_header.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function sections($preview="") {
include(RCX_ROOT_PATH.'/modules/system/cache/editor.php'); //integration ESeditor
global $db, $myts, $rcxModule, $secid, $title, $content, $allow_html, $allow_smileys, $allow_bbcode, $byline, $rcxConfig;

rcx_cp_header();

echo "<br />";
$result = $db->query("SELECT secid, secname FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." ORDER BY secid");
if ($db->num_rows($result) > "0") {

OpenTable();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
  <tr>
    <td width="100%" class="KPindex">
<div class="KPstor" ><?php echo _MI_NSECTIONS_NAME;?>-<?php echo _MI_NSECTIONS_CONFIG;?></div><br />
	
	<br />
	<div class="kpicon"><table id="table1"><tr><td>
		<a href="index.php?op=secconfig"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MI_NSECTIONS_CONFIG;?>">
	<br /><?php echo _MI_NSECTIONS_CONFIG;?></a>
	<a href="index.php"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MI_NSECTIONS_NAME;?>"/>
	<br /><?php echo _MI_NSECTIONS_NAME;?></a>
	
		</td></tr></table><br /><br />
<?php
echo "
<div align='center'>
<b>"._MD_CURACTIVESEC."</b>:<br />
<select class='select' onchange='location.href=\"./index.php?op=sectionedit&secid=\"+this.options[this.selectedIndex].value'>
<option value=''></option>";
while (list($sid, $secname) = $db->fetch_row($result)) {
  $secname = $myts->makeTboxData4Show($secname);
  echo "<option value='$sid'>$secname</option>";
  }
echo "</select></div>";

CloseTable();
echo "<br />";
OpenTable();

if ($preview) {
$myts->setType('admin');
$ncontent = $myts->makeTareaData4Preview($content, $allow_html, 0, $allow_bbcode);
$title    = $myts->makeTboxData4PreviewInForm($title);
if ($editorConfig["displayeditor"] == 1)
  {
    $myts->setType('admin');
    $contents_ed = $myts->makeTareaData4Preview($content, $allow_html, $allow_smileys, $allow_bbcode);
    $content    = $runESeditor->Value = $contents_ed;
  }else{
$content  = $myts->makeTboxData4PreviewInForm($content);
}
$byline   = $myts->makeTboxData4PreviewInForm($byline);

echo "
<table border='0' cellpadding='3' cellspacing='5' width='100%'><tr>
<td><div class='indextitle'>$title</div><br /></td>
</tr><tr>
<td>$ncontent</td>
</tr></table>";
}

echo "
<h4>"._MD_ADDARTICLE."</h4>
<form name='edit' action='./index.php' method='post'><br />";

echo _MD_GROUPPROMPT."<br />";

$articleAccess = new groupAccess('addArticle');
echo $articleAccess->listGroups();

echo "
<br /><br />
<b>"._MD_TITLEC."</b><br />
<input type='text' class='text' name='title' value='$title' size='50' value='' /><br /><br />";

$result = $db->query("SELECT secid, secname FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." ORDER BY secid");

echo "<select class='select' name='secid'>";
while (list($sid, $secname) = $db->fetch_row($result)) {
$secname = $myts->makeTboxData4Show($secname);
echo "<option value='$sid'";
if ($sid == $secid) { echo " selected='selected'"; }
echo ">$secname</option>";
}
echo "</select>";

echo "
<br /><b>"._MD_CONTENTC."</b> <i>"._MD_PAGEBREAK."</i><br /><br />";

//integration ESeditor

$toolbar = 'rcx_lib' ;


$runESeditor = new ESeditor('content');
$runESeditor->BasePath = RCX_URL."/class/eseditor/";
if ($runESeditor->IsCompatible() && $editorConfig["displayeditor"] == 1)
{
//  $runESeditor->Width = "650" ;
//  $runESeditor->Height = "500" ;
  $runESeditor->Value = $content ;
  $runESeditor->ToolbarSet = $toolbar ;
//  echo $runESeditor->Create('content',650,500) ;
  echo $runESeditor->Create('content') ;
  echo "<input type='hidden' name='allow_html' value='2' />";
  echo "<input type='hidden' name='allow_smileys' value='0' />";
  
  // Enable bbcode?
  echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
  if ( (!isset($allow_bbcode) && !isPost()) || $allow_bbcode == '1' || $_POST['allow_bbcode'] == '1' ) {
  echo " checked='checked'";
  }
  echo " />&nbsp;"._ENABLEBBCODE."<br />";
}else{
//$desc = new RcxFormDhtmlTextArea('', 'content', $content, 10, 88);
$desc = new RcxFormDhtmlTextArea('', 'content', $content);
echo $desc->render();
// Enable html?
echo "<br /><br />"._ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0' || $_POST['allow_html'] == '0') {
  $option0 = " selected";
  } elseif ($allow_html == '2' || $_POST['allow_html'] == '2') {
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
//Slut integration ESeditor
echo "
<br /><br /><b>"._MD_BYLINEC."</b><br />
<input type='text' class='text' name='byline' value='$byline' size='85' maxlength='255' /><br /><br />
<input type='hidden' name='op' value='secarticleadd' />
"._PREVIEW." <input type='checkbox' class='checkbox' name='preview' value='1' />
<input type='submit' class='button' value='"._MD_DOADDARTICLE."' />
</form>";

CloseTable();
echo "<br />";
OpenTable();

echo "
<h4>"._MD_LAST20ART."</h4>
<table width='100%' cellpadding='0' cellspacing='0'><tr class='bg4'><td>"._MD_EDITARTICLE."</td><td>"._MD_SECNAMEC."</td></tr>
";

$result = $db->query("SELECT artid, secid, title FROM ".$db->prefix(_MI_NSECCONT_TABLE)." ORDER BY artid DESC",20,0);
while ( list($artid, $secid, $title) = $db->fetch_row($result) ) {
$title   = $myts->makeTboxData4Show($title);
$result2 = $db->query("SELECT secid, secname FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid='$secid'");
list($secid, $secname) = $db->fetch_row($result2);
$secname = $myts->makeTboxData4Show($secname);
echo "
<tr><td><li>&nbsp;<a href='./index.php?op=secartedit&artid=$artid'>$title</a></li></td><td>$secname</td></tr>";
}

echo "
</table>
<form action='./index.php' method='post'>
"._MD_EDITARTICLE."<br />
<input type='hidden' name='op' value='secartedit' />

<select class='select' name='artid'>";

$result = $db->query("SELECT artid, secid, title, date FROM ".$db->prefix(_MI_NSECCONT_TABLE)." ORDER BY artid DESC");
while ( list($artid, $secid, $title, $date) = $db->fetch_row($result) ) {
$title = $myts->makeTboxData4Show($title);
echo "<option value='$artid'>$title : ".date("M-d-Y", $date)."</option>";
}
echo "
</select>
<input type='submit' class='button' value='"._GO."' />
</form>";
CloseTable();
}
echo "<br />";

OpenTable();

echo "
<h4>"._MD_ADDNEWSEC."</h4>
<form action='./index.php' method='post' enctype='multipart/form-data'><br />";

echo _MD_GROUPPROMPT."<br />";

$sectionAccess = new groupAccess('addSection');
echo $sectionAccess->listGroups();

echo "
<br /><br />
<b>"._MD_SECNAMEC."</b>  "._MD_MAXCHAR."<br />
<input type='text' class='text' name='secname' size='35' maxlength='60' /><br /><br />
<b>"._MD_SECIMAGEC."</b><br />
<input type='text' class='text' name='image' size='35' maxlength='255' /> :: <input type='file' class='file' name='image1' /><br />".sprintf(_MD_EXIMAGE, "modules/".$rcxModule->dirname()."/cache/images/")."
<br /><br />
<b>"._MD_SECDESCC."</b><br />
<textarea class='textarea' name='secdesc' cols='50' rows='10'></textarea><br /><br />
<input type='hidden' name='op' value='sectionmake' />
<input type='submit' class='button' value='"._MD_GOADDSECTION."' />
</form>";

CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function secarticleadd($secid, $title, $content, $allow_html, $allow_smileys, $allow_bbcode, $byline) {
global $db, $rcxUser, $myts, $_POST;

if ( empty($title) || empty($content) ) {
$title   = $myts->oopsStripSlashesGPC($title);
$content = $myts->oopsStripSlashesGPC($content);
$byline  = $myts->oopsStripSlashesGPC($byline);

$title   = urlencode($title);
$content = urlencode($content);
$byline  = urlencode($byline);
$allow_html = urlencode($allow_html);
$allow_smileys = urlencode($allow_smileys);
$allow_bbcode = urlencode($allow_bbcode);

$groupid = urlencode(@implode(' ', $_POST['addArticle']));

$extra   = "title=$title&content=$content&allow_html=$allow_html&allow_smileys=$allow_smileys&allow_bbcode=$allow_bbcode&byline=$byline&groupid=$groupid&secid=$secid&preview=1";
redirect_header("./index.php?op=secarticleadd&$extra", "2", _ALL_FIELDS);
exit();
}

$title   = $myts->makeTboxData4Save($title);
$content = $myts->makeTboxData4Save($content);
$byline  = $myts->makeTboxData4Save($byline);
$newid   = $db->genId("seccont_artid_seq");
$author  = $rcxUser->uid();
$date    = time();
$groupid = @implode(' ', $_POST['addArticle']);

$db->query("INSERT INTO ".$db->prefix(_MI_NSECCONT_TABLE)." SET artid='$newid', secid='$secid', groupid='$groupid', title='$title', byline='$byline', author='$author', date='$date', content='$content', allow_html='$allow_html', allow_smileys='$allow_smileys', allow_bbcode='$allow_bbcode', counter='0'");
build_rss();
redirect_header("./index.php?op=sections", "2", _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function secartedit($artid, $preview="") {
include(RCX_ROOT_PATH.'/modules/system/cache/editor.php'); //integration ESeditor
global $db, $myts, $secid, $title, $content, $allow_html, $allow_smileys, $allow_bbcode, $byline;

rcx_cp_header();

echo "<br />";

OpenTable();

if ($preview) {
  $myts->setType('admin');
  $ncontent = $myts->makeTareaData4Preview($content,  $allow_html, $allow_smileys, $allow_bbcode);
  $title    = $myts->makeTboxData4PreviewInForm($title);
  //integration ESeditor
  if ($editorConfig["displayeditor"] == 1)
  {
    $myts->setType('admin');
    $contents_ed = $myts->makeTareaData4Preview($content,  $allow_html, $allow_smileys, $allow_bbcode);
    $content    = $runESeditor->Value = $contents_ed;
  }else{
  $content  = $myts->makeTboxData4PreviewInForm($content);
  }
  //Slut integration ESeditor
  $byline   = $myts->makeTboxData4PreviewInForm($byline);

echo "
<table border='0' cellpadding='3' cellspacing='5' width='100%'><tr>
<td><div class='indextitle'>$title</div><br /></td>
</tr><tr>
<td>
html : $allow_html<br>
smileys : $allow_smileys<br>
bbcode : $allow_bbcode<br>
$ncontent</td>
</tr></table>";

} else {
$result = $db->query("SELECT artid, secid, title, byline, content, allow_html, allow_smileys, allow_bbcode FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE artid='$artid'");
list($artid, $secid, $title, $byline, $content, $allow_html, $allow_smileys, $allow_bbcode) = $db->fetch_row($result);
$title   = $myts->makeTboxData4Edit($title);
//integration ESeditor
if ($editorConfig["displayeditor"] == 1)
  {
    $myts->setType('admin');
    $contents_ed = $myts->makeTareaData4Preview($content,  $allow_html, $allow_smileys, $allow_bbcode);
    $content    = $runESeditor->Value = $contents_ed;
  }else{
  $content = $myts->makeTboxData4Edit($content);
}
//Slut integration ESeditor
$byline  = $myts->makeTboxData4Edit($byline);
}


echo "
<h4>"._MD_EDITARTICLE."</h4>
<form name='edit' action='./index.php' method='post'><br />";

echo _MD_GROUPPROMPT."<br />";

$access = new groupAccess('editArticle');
$access->loadGroups($artid, 'artid', _MI_NSECCONT_TABLE);

echo $access->listGroups();

echo "
<br /><br />
<b>"._MD_TITLEC."</b><br />
<input type='text' class='text' name='title' size='60' value='$title' /><br /><br />";

$result2 = $db->query("SELECT secid, secname FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." ORDER BY secname");

echo "<select class='select' name='secid'>";
while (list($sid, $secname) = $db->fetch_row($result2)) {
  $secname = $myts->makeTboxData4Show($secname);
  echo "<option value='$sid'";
  if ($sid == $secid) { echo " selected='selected'"; }
    echo ">$secname</option>";
  }
echo "</select>";

echo "
<br /><b>"._MD_CONTENTC."</b> <i>"._MD_PAGEBREAK."</i><br /><br />
<input type='hidden' name='artid' value='$artid' />
<input type='hidden' name='op' value='secartchange' />";

//integration ESeditor

$toolbar = 'rcx_lib' ;

$runESeditor = new ESeditor('content');
$runESeditor->BasePath = RCX_URL."/class/eseditor/";
if ($runESeditor->IsCompatible() && $editorConfig["displayeditor"] == 1)
{
//  $runESeditor->Width = "650" ;
//  $runESeditor->Height = "500" ;
  $runESeditor->Value = $content ;
  $runESeditor->ToolbarSet = $toolbar ;
  
//  echo $runESeditor->Create('content',650,500) ;
  echo $runESeditor->Create('content') ;
  echo "<input type='hidden' name='allow_html' value='2' />";
  echo "<input type='hidden' name='allow_smileys' value='0' />";
  // Enable bbcode?
  echo "<input type='checkbox' class='checkbox' name='allow_bbcode' value='1'";
  if ( (!isset($allow_bbcode) && !isPost()) || $allow_bbcode == '1' || $_POST['allow_bbcode'] == '1' ) {
  echo " checked='checked'";
  }
  echo " />&nbsp;"._ENABLEBBCODE."<br />";
}else{
//$desc = new RcxFormDhtmlTextArea('', 'content', $content, 10, 88);
$desc = new RcxFormDhtmlTextArea('', 'content', $content);
echo $desc->render();
// Enable html?
echo "<br /><br />"._ALLOWEDHTML."<br />";
echo get_allowed_html();
if ($allow_html == '0' || $_POST['allow_html'] == '0') {
  $option0 = " selected";
  } elseif ($allow_html == '2' || $_POST['allow_html'] == '2') {
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
//Slut integration ESeditor

echo "
<br /><br /><b>"._MD_BYLINEC."</b><br />
<input type='text' class='text' name='byline' value='$byline' size='85' maxlength='255' /><br />

<table border='0'><tr><td>
"._PREVIEW." <input type='checkbox' class='checkbox' name='preview' value='1' />
</td><td>
<input type='submit' class='button' value='"._SAVE."' />
</td>
</form>

<form name='delete' action='./index.php' method='post'>
<td>
<input type='hidden' name='artid' value='$artid' />
<input type='hidden' name='op' value='secartdelete' />
<input type='submit' class='button' value='"._DELETE."' />
</td>
</form>

</tr></table>";

CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function sectionmake($secname, $image, $secdesc) {
global $db, $myts, $_POST, $_FILES;

if ( empty($secname) ) {
  redirect_header("./index.php?op=sections", "2", _ALL_FIELDS);
  exit();
}

$secname = $myts->makeTboxData4Save($secname);
$image   = $myts->makeTboxData4Save($image);
$secdesc = $myts->makeTboxData4Save($secdesc);
$newid   = $db->genId("sections_secid_seq");
$groupid = @implode(' ', $_POST['addSection']);

if ( !empty($_FILES['image1']['name']) ) {
  include_once(RCX_ROOT_PATH."/class/fileupload.php");
  $upload = new fileupload();
  $upload->set_upload_dir(RCX_ROOT_PATH . "/modules/"._MI_DIR_NAME."/cache/images/", 'image1');
  $upload->set_accepted("gif|jpg|png", 'image1');
  $upload->set_overwrite(1, 'image1');
  $result = $upload->upload();
  if ($result['image1']['filename']) {
    $image = $result['image1']['filename'];
    } else {
      redirect_header("./index.php?op=sections", 3, $upload->errors());
      exit();
    }
}

$db->query("INSERT INTO ".$db->prefix(_MI_NSECTIONS_TABLE)." SET secid='$newid', groupid='$groupid', secname='$secname', image='$image', secdesc='$secdesc'");
redirect_header("./index.php?op=sections", "2", _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function sectionedit($secid) {
global $db, $myts;

rcx_cp_header();

echo "<br />";

$result = $db->query("SELECT secid, secname, image, secdesc FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid='$secid'");
list($secid, $secname, $image, $secdesc) = $db->fetch_row($result);
$secname = $myts->makeTboxData4Edit($secname);
$image   = $myts->makeTboxData4Edit($image);
$secdesc = $myts->makeTboxData4Edit($secdesc);

$result2 = $db->query("SELECT artid FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE secid='$secid'");
$number  = $db->num_rows($result2);

OpenTable();

echo "
<h4>"._MD_EDITTHISSEC." $secname </h4>";

if ( !empty($image) ) {
  echo "<img src='".formatURL(RCX_URL."/modules/"._MI_DIR_NAME."/cache/images/", $image)."' border='0'>";
  } else {
    echo "<img src='".RCX_URL."/modules/"._MI_DIR_NAME."/images/na.gif' border='0'>";
  }

echo "
<br /><br />
".sprintf(_MD_THISSECHAS, $number)."

<form action='./index.php' method='post' enctype='multipart/form-data'>";

echo _MD_GROUPPROMPT."<br />";

$access = new groupAccess('editSection');
$access->loadGroups($secid, 'secid', _MI_NSECTIONS_TABLE);

echo $access->listGroups();

echo "
<br /><br />
<b>"._MD_SECNAMEC."</b> "._MD_MAXCHAR."<br />
<input type='text' class='text' name='secname' size='35' maxlength='60' value='$secname' />
<br /><br />
<b>"._MD_SECIMAGEC."</b><br />
<input type='text' class='text' name='image' size='35' maxlength='255' value='$image' /> :: <input type='file' class='file' name='image1' /><br />".sprintf(_MD_EXIMAGE, "modules/sections/cache/images/")."
<br /><br />
<b>"._MD_SECDESCC."</b><br />
<textarea class='textarea' name='secdesc' cols='50' rows='10'>$secdesc</textarea><br />
<input type='hidden' name='secid' value='$secid' />
<input type='hidden' name='op' value='sectionchange' />

<table border='0'><tr><td>
<input type='submit' class='button' value='"._SAVE."' />
</form>
</td>

<td>
<form action='./index.php' method='post'>
<input type='hidden' name='secid' value='$secid' />
<input type='hidden' name='op' value='sectiondelete' />
<input type='submit' class='button' value='"._DELETE."' />
</form></td>

</tr></table>";

CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function sectionchange($secid, $secname, $image, $secdesc) {
global $db, $myts, $_POST, $_FILES;

if ( empty($secname) ) {
  redirect_header("./index.php?op=sections", "2", _ALL_FIELDS);
  exit();
}

$secname = $myts->makeTboxData4Save($secname);
$image   = $myts->makeTboxData4Save($image);
$secdesc = $myts->makeTboxData4Save($secdesc);
$groupid = @implode(' ', $_POST['editSection']);

if ( !empty($_FILES['image1']['name']) ) {
  include_once(RCX_ROOT_PATH."/class/fileupload.php");
  $upload = new fileupload();
  $upload->set_upload_dir(RCX_ROOT_PATH . "/modules/"._MI_DIR_NAME."/cache/images/", 'image1');
  $upload->set_accepted("gif|jpg|png", 'image1');
  $upload->set_overwrite(1, 'image1');
  $result = $upload->upload();
  if ($result['image1']['filename']) {
    $old = $db->query("SELECT image FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid=$secid");
    list($oldimage) = $db->fetch_row($old);
    @unlink(RCX_ROOT_PATH."/modules/"._MI_DIR_NAME."/cache/images/".basename($oldimage));
    $image = $result['image1']['filename'];
    } else {
      redirect_header("./index.php?op=sections", 3, $upload->errors());
      exit();
    }
}

$db->query("UPDATE ".$db->prefix(_MI_NSECTIONS_TABLE)." SET groupid='$groupid', secname='$secname', image='$image', secdesc='$secdesc' WHERE secid='$secid'");
redirect_header("./index.php?op=sections", "2", _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function secartchange($artid, $secid, $title, $content, $allow_html, $allow_smileys, $allow_bbcode, $byline) {
global $db, $myts, $_POST;

if ( empty($title) || empty($content) ) {
$title   = $myts->oopsStripSlashesGPC($title);
$content = $myts->oopsStripSlashesGPC($content);
$byline  = $myts->oopsStripSlashesGPC($byline);

$title   = urlencode($title);
$content = urlencode($content);
$allow_html = urlencode($allow_html);
$allow_smileys = urlencode($allow_smileys);
$allow_bbcode = urlencode($allow_bbcode);
$byline  = urlencode($byline);
$groupid = urlencode(@implode(" ", $_POST['editArticle']));

$extra   = "title=$title&content=$content&allow_html=$allow_html&allow_smileys=$allow_smileys&allow_bbcode=$allow_bbcode&byline=$byline&groupid=$groupid&secid=$secid&preview=1";
redirect_header("./index.php?op=secartchange&$extra", "2", _ALL_FIELDS);
exit();
}

$title   = $myts->makeTboxData4Save($title);
$content = $myts->makeTboxData4Save($content);
$byline  = $myts->makeTboxData4Save($byline);
$groupid = @implode(" ", $_POST['editArticle']);

$db->query("UPDATE ".$db->prefix(_MI_NSECCONT_TABLE)." SET secid='$secid', groupid='$groupid', title='$title', byline='$byline', content='$content', allow_html='$allow_html', allow_smileys='$allow_smileys', allow_bbcode='$allow_bbcode' WHERE artid='$artid'");
build_rss();
redirect_header("./index.php?op=sections", "2", _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function sectiondelete($secid, $ok=0) {
global $db, $myts;

if ($ok == "1") {
  $old = $db->query("SELECT image FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid=$secid");
  list($oldimage) = $db->fetch_row($old);
  @unlink(RCX_ROOT_PATH."/modules/"._MI_DIR_NAME."/cache/images/".basename($oldimage));

  $db->query("DELETE FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE secid='$secid'");
  $db->query("DELETE FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid='$secid'");
  redirect_header("./index.php?op=sections", "2", _UPDATED);
  build_rss();
  exit();
  } else {
    rcx_cp_header();
    echo "<br />";
    $result=$db->query("SELECT secname FROM ".$db->prefix(_MI_NSECTIONS_TABLE)." WHERE secid='$secid'");
    list($secname) = $db->fetch_row($result);
    $secname = $myts->makeTboxData4Show($secname);
    OpenTable();

    echo "
    <h4 style='color:#ff0000;'>".sprintf(_MD_DELETETHISSEC, $secname)."</h4><br />
    "._MD_RUSUREDELSEC."<br />
    "._MD_THISDELETESALL."<br /><br />";
    echo "<table><tr><td>";
    echo myTextForm("./index.php?op=sectiondelete&secid=$secid&ok=1" , _YES);
    echo "</td><td>";
    echo myTextForm("./index.php?op=sections", _NO);
    echo "</td></tr></table>";
    CloseTable();
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function secartdelete($artid, $ok="") {
global $db, $myts;

if ($ok) {
  $db->query("DELETE FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE artid='$artid'");
  redirect_header("./index.php?op=sections", "2", _UPDATED);
  build_rss();
  exit();
  } else {
    rcx_cp_header();
    echo "<br />";
    $result = $db->query("SELECT title FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE artid='$artid'");
    list($title) = $db->fetch_row($result);
    $title = $myts->makeTboxData4Show($title);
    OpenTable();

    echo "
    <b>".sprintf(_MD_DELETETHISART, $title)."</b><br /><br />
    "._MD_RUSUREDELART."
    <br /><br />
    <table><tr><td>
    ".myTextForm("./index.php?op=secartdelete&artid=$artid&ok=1" , _YES)."
    </td><td>
    ".myTextForm("./index.php?op=sections", _NO)."
    </td></tr></table>";
    CloseTable();
  }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function secconfig() {
global $myts, $sectionsConfig;

rcx_cp_header();
OpenTable();
?>

<h4><?php echo _AM_GENERALSET;?></h4><br />
<form action="index.php" method="post">
<table width="100%" border="0"><tr>

<td nowrap><?php echo _AM_ARTLIMIT;?></td>
<td width="100%">
<select class="select" name="article_limit">
<option value="<?php echo $sectionsConfig['article_limit'];?>" selected><?php echo $sectionsConfig['article_limit'];?></option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="50">50</option>
</select>
</td>

</tr><tr>

<?php
$chk1 = ''; $chk0 = '';
($sectionsConfig['rss_enable'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td nowrap><?php echo _AM_RSS_ENABLE;?></td>
<td width="100%">
<input type="radio" class="radio" name="rss_enable" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="rss_enable" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td>

</tr><tr>

<td nowrap><?php echo _AM_RSS_MAXITEMS;?></td>
<td width="100%">
<select class="select" name="rss_maxitems">
<option value="<?php echo $sectionsConfig['rss_maxitems'];?>" selected="selected"><?php echo $sectionsConfig['rss_maxitems'];?></option>
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
</select>
</td>

</tr><tr>

<td nowrap><?php echo _AM_RSS_MAXDESCRIPTION;?></td>
<td width="100%">
<select class="select" name="rss_maxdescription">
<option value="<?php echo $sectionsConfig['rss_maxdescription'];?>" selected="selected"><?php echo $sectionsConfig['rss_maxdescription'];?></option>
<option value="50">50</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="250">250</option>
<option value="300">300</option>
</select>
</td>

</tr><tr>
<td colspan="2"><hr /></td>
</tr><tr>

<td valign="top" nowrap><?php echo _AM_INTRO;?></td>
<td width="100%">
<?php
$intro = join('', file("../cache/intro.php"));
$intro = $myts->makeTboxData4PreviewInForm($intro);
//$desc  = new RcxFormDhtmlTextArea('', 'intro', $intro, 10, 88);
$desc  = new RcxFormDhtmlTextArea('', 'intro', $intro);
echo $desc->render();
?>
</td>

</tr><tr>
<td colspan="2"><hr /></td>
</tr><tr>

<td colspan="2">
<input type="hidden" name="op" value="configsave">
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)">
</td>

</tr></table>
</form>

<?php
CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function configsave() {
global $_POST, $myts;

if ( !empty($_POST['submit']) ) {

$content  = "<?PHP\n";
$content .= "\$sectionsConfig['article_limit']      = ".intval($_POST['article_limit']).";\n";
$content .= "\$sectionsConfig['rss_enable']         = ".intval($_POST['rss_enable']).";\n";
$content .= "\$sectionsConfig['rss_maxitems']       = ".intval($_POST['rss_maxitems']).";\n";
$content .= "\$sectionsConfig['rss_maxdescription'] = ".intval($_POST['rss_maxdescription']).";\n";
$content .= "?>";

$filename = "../cache/config.php";
if ( $file = fopen($filename, "w") ) {
  fwrite($file, $content);
  fclose($file);
  } else {
    redirect_header("index.php", 1, _NOTUPDATED);
    exit();
  }

$filename = "../cache/intro.php";
if ( $file = fopen($filename, "wb") ) {
  $disclaimer = $myts->oopsStripSlashesGPC($_POST['intro']);
  $disclaimer = $myts->stripPHP($disclaimer);
  fwrite($file, $disclaimer);
  fclose($file);
  } else {
    redirect_header("index.php", 1, _NOTUPDATED);
    exit();
}
}

redirect_header("index.php", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function build_rss() {
global $db, $sectionsConfig;

if ($sectionsConfig['rss_enable']) {

$SQL = "SELECT artid, title, content FROM ".$db->prefix(_MI_NSECCONT_TABLE)." WHERE date<".(time()+10)." ORDER BY date DESC";

$query = $db->query($SQL, $sectionsConfig['rss_maxitems']);

if ($query) {
  include_once(RCX_ROOT_PATH . "/class/xml-rss.php");
  $rss = new xml_rss('../cache/sections.xml');
  $rss->channel_title .= " :: "._MI_NSECTIONS_NAME;
  $rss->image_title   .= " :: "._MI_NSECTIONS_NAME;
  $rss->max_items            = $sectionsConfig['rss_maxitems'];
  $rss->max_item_description = $sectionsConfig['rss_maxdescription'];

  while ( list($artid, $title, $content) = $db->fetch_row($query) ) {
    $link = RCX_URL . '/modules/sections/index.php?op=viewarticle&amp;artid='. $artid;
    $rss->build($title, $link, $content);
    }
$rss->save();
  }
}
}

$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch ($op) {

case "sections":
  sections();
  break;

case "sectionedit":
  sectionedit($secid);
  break;

case "sectionmake":
  sectionmake($secname, $image, $secdesc);
  break;

case "sectiondelete":
  sectiondelete($secid, $ok);
  break;

case "sectionchange":
  sectionchange($secid, $secname, $image, $secdesc);
  break;

case "secarticleadd":
  if ($preview) {
    sections("1");
    } else {
      secarticleadd($secid, $title, $content, $allow_html, $allow_smileys, $allow_bbcode, $byline);
    }
  break;

case "secartedit":
  secartedit($artid);
  break;

case "secartchange":
  if ($preview) {
    secartedit($artid, "1");
    } else {
      secartchange($artid, $secid, $title, $content, $allow_html, $allow_smileys, $allow_bbcode, $byline);
    }
  break;

case "secartdelete":
  secartdelete($artid, $ok);
  break;

case "secconfig":
  secconfig();
  break;

case "configsave":
  configsave();
  break;

default:
  sections();
  break;
}

rcx_cp_footer();
?>
