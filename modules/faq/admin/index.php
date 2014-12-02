<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("admin_header.php");
include_once("../cache/config.php");


$op = "listcat";

if (isset($_GET)) {
        foreach ($_GET as $k => $v) {
                $$k = $v;
        }
}

if (isset($_POST)) {
        foreach ($_POST as $k => $v) {
                $$k = $v;
        }
}

if (!empty($contents_preview)) {
        rcx_cp_header();
        OpenTable();
        $allow_html    = intval($allow_html);
        $allow_smileys = intval($allow_smileys);
        $allow_bbcode  = intval($allow_bbcode);
        $p_title       = $myts->makeTboxData4Preview($contents_title);

        $myts->setType('admin');
        $p_contents = $myts->makeTareaData4Preview($contents_contents, $allow_html, $allow_smileys, $allow_bbcode);
        echo"<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
        <table width='100%' border='0' cellpadding='4' cellspacing='1'>
        <tr class='bg3' align='center'><td align='left'>$p_title</td></tr><tr class='bg1'><td>$p_contents</td></tr></table></td></tr></table><br />";
        $contents_title = $myts->makeTboxData4PreviewInForm($contents_title);
  
  //ESeditor integration
  if ($editorConfig["displayeditor"] == 1)
  {
    $myts->setType('admin');
    $contents_ed = $myts->makeTareaData4Preview($contents_contents, $allow_html, $allow_smileys, $allow_bbcode);
    $contents_contents    = $runESeditor->Value = $contents_ed;
  }else{
    $myts->setType('admin');
          $contents_contents = $myts->makeTboxData4PreviewInForm($contents_contents);
  }
  //end editor integration
        
        include_once("contentsform.php");
        CloseTable();
        rcx_cp_footer();
        exit();
}

// Burk .. need to rewrite all and make a switch()
if ($op == "faqconfig") {
        faqconfig();
}

if ($op == "faqsave") {
        faqsave();
}

if ($op == "listcat") {
        rcx_cp_header();
        OpenTable();

		           include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton(_MI_FAQ_CONFIG, "button", _MODIFY, "button");
         $retur_button->setExtra("onClick=\"location='index.php?op=faqconfig'\"");
             $form->addElement($retur_button); 

        $form->display(); 
        echo "
        <h4 style='text-align:left;'>"._XD_DOCS."</h4>
        <form action='index.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
        <table width='100%' border='0' cellpadding='4' cellspacing='1'>
        <tr class='bg3' align='center'><td align='left'>"._XD_CATEGORY."</td><td>"._XD_ORDER."</td><td>"._XD_CONTENTS."</td><td>&nbsp;</td></tr>";

        $result = $db->query("SELECT c.category_id, c.category_title, c.category_order, COUNT(f.category_id) FROM ".$db->prefix("faq_categories")." c LEFT JOIN ".$db->prefix("faq_contents")." f ON f.category_id=c.category_id GROUP BY c.category_id ORDER BY c.category_order ASC");
        $count = 0;
        while(list($cat_id, $category, $category_order, $faq_count) = $db->fetch_row($result)) {
                $category = $myts->makeTboxData4Edit($category);
                echo "
                <tr class='bg1'><td align='left'><input type='hidden' value='$cat_id' name='cat_id[]' /><input type='hidden' value='$category' name='oldcategory[]' /><input type='text' class='text' value='$category' name='newcategory[]' maxlength='255' size='20' /></td>
                <td align='center'><input type='hidden' value='$category_order' name='oldorder[]' /><input type='text' class='text' value='$category_order' name='neworder[]' maxlength='3' size='4' /></td>
                <td align='center'>$faq_count</td>
                <td align='right'><a href='index.php?op=listcontents&amp;cat_id=".$cat_id."'>" ._XD_CONTENTS."</a> | <a href='index.php?op=delcat&amp;cat_id=".$cat_id."&amp;ok=0'>"._DELETE."</a></td></tr>";
                $count++;
        }
        if ($count > 0) {
                echo "<tr align='center' class='bg3'><td colspan='4'><input type='submit' class='button' value='"._SUBMIT."' /><input type='hidden' name='op' value='editcatgo' /></td></tr>";
        }
        echo "</table></td></tr></table></form>
        <br /><br />
        <h4 style='text-align:left;'>"._XD_ADDCAT."</h4>
        <form action='index.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'><table width='100%' border='0' cellpadding='4' cellspacing='1'><tr nowrap='nowrap'><td class='bg3'>"._XD_TITLE." </td><td class='bg1'><input type='text' class='text' name='category' size='30' maxlength='255' /></td></tr>
        <tr nowrap='nowrap'><td class='bg3'>"._XD_ORDER." </td><td class='bg1'><input type='text' class='text' name='order' size='4' maxlength='3' /></td></tr>
        <tr><td class='bg3'>&nbsp;</td><td class='bg1'><input type='hidden' name='op' value='addcatgo' /><input type='submit' class='button' value='"._SUBMIT."' /></td></tr>
        </table></td></tr></table></form>";
        CloseTable();
        rcx_cp_footer();
        exit();
}

if ($op == "addcatgo") {
        $category = $myts->makeTboxData4Save($category);
        $newid    = $db->genId($db->prefix("faq_categories")."_category_id_seq");
        $sql = "INSERT INTO ".$db->prefix("faq_categories")." VALUES (".intval($newid).", '".$category."', ".intval($order).")";
        if (!$db->query($sql)) {
                redirect_header("index.php?op=listcat", 1, _NOTUPDATED);
                } else {
                        redirect_header("index.php?op=listcat", 1, _UPDATED);
                }
        exit();
}

if ($op == "editcatgo") {
        $count = count($newcategory);
        for ($i=0; $i<$count; $i++) {
                if ( $newcategory[$i] != $oldcategory[$i] || $neworder[$i] != $oldorder[$i] ) {
                        $category = $myts->makeTboxData4Save($newcategory[$i]);

                        $sql = "UPDATE ".$db->prefix("faq_categories")." SET category_title='".$category."', category_order=".intval($neworder[$i])." WHERE category_id=".$cat_id[$i]."";
                        $db->query($sql);
                }
        }
        redirect_header("index.php?op=listcat", 1, _UPDATED);
        exit();
}

if ($op == "listcontents") {
        rcx_cp_header();
        $sql = "SELECT category_title FROM ".$db->prefix("faq_categories")." WHERE category_id='".$cat_id."'";
        $result = $db->query($sql);
        list($category) = $db->fetch_row($result);
        $category = $myts->makeTboxData4Show($category);
        OpenTable();
        echo "<a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;".$category."<br /><br />
        <h4 style='text-align:left;'>"._XD_CONTENTS."</h4>
        <form action='index.php' method='post'>
        <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
        <table width='100%' border='0' cellpadding='4' cellspacing='1'>
        <tr class='bg3'><td>"._XD_TITLE."</td><td align='center'>"._XD_ORDER."</td><td align='center'>"._XD_DISPLAY."</td><td>&nbsp;</td></tr>";
        $result = $db->query("SELECT contents_id, contents_title, contents_time, contents_order, contents_visible FROM ".$db->prefix("faq_contents")." WHERE category_id='".$cat_id."' ORDER BY contents_order");
        $count = 0;
        while(list($id, $title, $time, $order, $visible) = $db->fetch_row($result)) {
                $title = $myts->makeTboxData4Show($title);
                echo "<tr class='bg1'><td><input type='hidden' value='$id' name='id[]' />".$title."</td>
                <td align='center'><input type='hidden' value='$order' name='oldorder[$id]' /><input type='text' class='text' value='$order' name='neworder[$id]' maxlength='3' size='4' /></td>";
                $checked = ($visible == 1) ? " checked='checked'" : "";
                echo "<td align='center'><input type='hidden' value='$visible' name='oldvisible[$id]' /><input type='checkbox' class='checkbox' value='1' name='newvisible[$id]'".$checked." /></td>
                <td align='right'><a href='index.php?op=editcontents&amp;id=".$id."&amp;cat_id=".$cat_id."'>"._EDIT."</a> | <a href='index.php?op=delcontents&amp;id=".$id."&amp;ok=0&amp;cat_id=".$cat_id."'>"._DELETE."</a></td></tr>";
                $count++;
        }
        if ($count > 0) {
                echo "<tr align='center' class='bg3'><td colspan='4'><input type='submit' class='button' value='"._SUBMIT."' /><input type='hidden' name='op' value='quickeditcontents' /><input type='hidden' name='cat_id' value='".$cat_id."' /></td></tr>";
        }
        echo "</table></td></tr></table></form>
        <br /><br />
        <h4 style='text-align:left;'>"._XD_ADDCONTENTS."</h4>";
        $contents_title    = "";
        $contents_contents = "";
        $contents_order    = 0;
        $contents_visible  = 1;
        $allow_html        = 1;
        $allow_smileys     = 1;
        $allow_bbcode      = 1;
        $contents_id       = 0;
        $category_id       = $cat_id;

        $op = "addcontentsgo";
        include_once("contentsform.php");
        CloseTable();
        rcx_cp_footer();
        exit();
}

if ($op == "quickeditcontents") {
        $count = count($id);
        for ($i = 0; $i < $count; $i++) {
                $index = $id[$i];
                if ( $neworder[$index] != $oldorder[$index] || $newvisible[$index] != $oldvisible[$index] ) {
                        $db->query("UPDATE ".$db->prefix("faq_contents")." SET contents_order=".intval($neworder[$index]).", contents_visible=".intval($newvisible[$index])." WHERE contents_id=".$index."");
                }
        }
        faq_write_conts(faq_get_conts($cat_id), $cat_id);
        build_rss();
        redirect_header("index.php?op=listcontents&amp;cat_id=$cat_id", 1, _UPDATED);
        exit();
}

if ($op == "addcontentsgo") {
        $title    = $myts->makeTboxData4Save($contents_title);
        $contents = $myts->makeTboxData4Save($contents_contents);
        $newid    = $db->genId($db->prefix("faq_contents")."_contents_id_seq");
        $sql = "
                INSERT INTO ".$db->prefix("faq_contents")." VALUES (
                ".intval($newid).",
                ".intval($category_id).",
                '".$title."',
                '".$contents."',
                ".time().",
                ".intval($contents_order).",
                ".intval($contents_visible).",
                ".intval($allow_html).",
                ".intval($allow_smileys).",
                ".intval($allow_bbcode).")";

        if (!$db->query($sql)) {
                redirect_header("index.php?op=listcontents&amp;cat_id=$category_id", 1, _NOTUPDATED);
                } else {
                        faq_write_conts(faq_get_conts($category_id), $category_id);
                        build_rss();
                        redirect_header("index.php?op=listcontents&amp;cat_id=$category_id", 1, _UPDATED);
                }
        exit();
}

if ($op == "editcontents") {
        rcx_cp_header();
        $sql = "SELECT category_title FROM ".$db->prefix("faq_categories")." WHERE category_id='".$cat_id."'";
        $result = $db->query($sql);
        list($category) = $db->fetch_row($result);
        $category = $myts->makeTboxData4Show($category);
        $result = $db->query("SELECT * FROM ".$db->prefix("faq_contents")." WHERE contents_id='$id'");
        $myrow  = $db->fetch_array($result);

        $contents_title    = $myts->makeTboxData4Edit($myrow['contents_title']);
        
        if ($editorConfig["displayeditor"] == 1)
  {
    $contents_contents    = $runESeditor->Value = $myrow['contents_contents'];
  }else{
    $contents_contents = $myts->makeTboxData4Edit($myrow['contents_contents']);
  }
  //end editor integration
        
        
        $contents_order    = $myrow['contents_order'];
        $contents_visible  = $myrow['contents_visible'];
        $allow_html        = $myrow['allow_html'];
        $allow_smileys     = $myrow['allow_smileys'];
        $allow_bbcode      = $myrow['allow_bbcode'];
        $contents_id       = $myrow['contents_id'];
        $category_id       = $myrow['category_id'];

        $op = "editcontentsgo";
        OpenTable();
        echo "<a href='index.php'>" ._XD_MAIN."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;<a href='index.php?op=listcontents&amp;cat_id=$cat_id'>".$category."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;"._XD_EDITCONTENTS."<br /><br />
        <h4 style='text-align:left;'>"._XD_EDITCONTENTS."</h4>";
        include_once("contentsform.php");
        CloseTable();
        rcx_cp_footer();
        exit();
}

if ($op == "editcontentsgo") {
        $title    = $myts->makeTboxData4Save($contents_title);
        $contents = $myts->makeTboxData4Save($contents_contents);

        $sql = "
                UPDATE ".$db->prefix("faq_contents")." SET
                contents_title='".$title."',
                contents_contents='".$contents."',
                contents_time=".time().",
                contents_order=".intval($contents_order).",
                contents_visible=".intval($contents_visible).",
                allow_bbcode=".intval($allow_bbcode).",
                allow_smileys=".intval($allow_smileys).",
                allow_bbcode=".intval($allow_bbcode)."
                WHERE contents_id=".$contents_id."";
        if (!$db->query($sql)) {
                redirect_header("index.php?op=listcontents&amp;cat_id=$category_id", 1, _NOTUPDATED);
                } else {
                        faq_write_conts(faq_get_conts($category_id), $category_id);
                        build_rss();
                        redirect_header("index.php?op=listcontents&amp;cat_id=$category_id", 1, _UPDATED);
                }
        exit();
}

if ($op == "delcat") {
        if ($ok == 1) {
                $sql = "DELETE FROM ".$db->prefix("faq_categories")." WHERE category_id=".$cat_id."";
                if (!$db->query($sql)) {
                        redirect_header("index.php?op=listcat", 1, _NOTUPDATED);
                        } else {
                                $sql = "DELETE FROM ".$db->prefix("faq_contents")." WHERE category_id=".$cat_id."";
                                $db->query($sql);
                                $filename = RCX_ROOT_PATH."/modules/faq/cache/doc".$cat_id.".php";
                                @unlink($filename);
                                build_rss();
                                redirect_header("index.php?op=listcat", 1, _UPDATED);
                        }
                exit();
        } else {
                rcx_cp_header();
                OpenTable();
                echo "<div align='center'><h4 style='color:#ff0000'>"._XD_RUSURECAT."</h4><table><tr><td>";
                echo myTextForm("index.php?op=delcat&amp;cat_id=".$cat_id."&amp;ok=1'" , _YES);
                echo "</td><td>";
                echo myTextForm("index.php?op=listcat", _NO);
                echo "</td></tr></table></div>";
                CloseTable();
                rcx_cp_footer();
                exit();
        }
}

if ($op == "delcontents") {
        if ($ok == 1) {
                $sql = "DELETE FROM ".$db->prefix("faq_contents")." WHERE contents_id=".$id."";
                if (!$db->query($sql)) {
                        redirect_header("index.php?op=listcontents&amp;cat_id=$cat_id", 1, _NOTUPDATED);
                        } else {
                                faq_write_conts(faq_get_conts($cat_id), $cat_id);
                                build_rss();
                                redirect_header("index.php?op=listcontents&amp;cat_id=$cat_id", 1, _UPDATED);
                        }
                exit();
        } else {
                rcx_cp_header();
                echo "<div align='center'><h4 style='color=:#ff0000'>"._XD_RUSURECONT."</h4><table><tr><td>";
                echo myTextForm("index.php?op=delcontents&amp;id=".$id."&amp;ok=1&amp;cat_id=$cat_id" , _YES);
                echo "</td><td>";
                echo myTextForm("index.php?op=listcontents&amp;cat_id=$cat_id", _NO);
                echo "</td></tr></table></div>";
                rcx_cp_footer();
                exit();
        }
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function faq_get_conts($cat_id) {
global $db, $myts;

$contents_arr = array();
$title_arr    = array();

$ret = "
        <table width='100%' cellpadding='4' cellspacing='0' border='0'><tr class='bg3'>
        <td colspan='2'><b>" ._XD_TOC."</b></td>
        </tr><tr>
        <td colspan='2'><ul style='list-style-image:url(images/question.gif);'>";

$result = $db->query("SELECT contents_id, category_id, contents_title, contents_contents, contents_time, allow_html, allow_smileys, allow_bbcode FROM ".$db->prefix("faq_contents")." WHERE contents_visible=1 AND category_id='".$cat_id."' ORDER BY contents_order ASC");
while (list($id, $cat_id, $title, $contents, $time, $allow_html, $allow_smileys, $allow_bbcode) = $db->fetch_row($result) ) {
        $title             = $myts->makeTboxData4Show($title);
        $title_arr[$id]    = $title;

        $myts->setType('admin');
        $contents_arr[$id] = $myts->makeTareaData4Show($contents, $allow_html, $allow_smileys, $allow_bbcode);
        $ret .= "<li><a href='#".$id."'>".$title."</a></li>";
}
$ret .= "</ul></td></tr></table><br /><br /><table width='100%' cellpadding='4' cellspacing='0' border='0'>";

foreach ($title_arr as $k => $v) {
        $ret .= "
                <tr class='bg3'>
                <td><a id='$k' name='$k'><b>".$v."</b></a></td>
                </tr><tr>
                <td>".$contents_arr[$k]."</td>
                </tr><tr>
                <td align='right'><a href='#top'>" ._XD_BACKTOTOP."</a></td>
                </tr>";
}
$ret .= "</table>";

return $ret;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function faq_write_conts($contents, $cat_id) {

$filename = RCX_ROOT_PATH."/modules/faq/cache/doc".$cat_id.".php";

if ( !$file = fopen($filename, "w") ) {
        return false;
}

if ( fwrite($file, $contents) == -1 ) {
        return false;
}

fclose($file);
return true;
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function faqconfig() {
global $faqConfig;

rcx_cp_header();
OpenTable();
?>

<h4><?php echo _AM_GENERALSET;?></h4><br />
<form action="index.php" method="post">
<table width="100%" border="0"><tr>

<?php
$chk1 = ''; $chk0 = '';
($faqConfig['rss_enable'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
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
<option value="<?php echo $faqConfig['rss_maxitems'];?>" selected="selected"><?php echo $faqConfig['rss_maxitems'];?></option>
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
<option value="<?php echo $faqConfig['rss_maxdescription'];?>" selected="selected"><?php echo $faqConfig['rss_maxdescription'];?></option>
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

<td colspan="2">
<input type="hidden" name="op" value="faqsave">
<input type="submit" class="button" name="submit" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)">
</td>

</tr></table>
</form>

<?php
CloseTable();
rcx_cp_footer();
}

//---------------------------------------------------------------------------------------//
/**
* Description
*
* @param type $var description
* @return type description
*/
function faqsave() {
global $_POST, $myts;

if ( !empty($_POST['submit']) ) {

$content  = "<?PHP\n";
$content .= "\$faqConfig['rss_enable']         = ".intval($_POST['rss_enable']).";\n";
$content .= "\$faqConfig['rss_maxitems']       = ".intval($_POST['rss_maxitems']).";\n";
$content .= "\$faqConfig['rss_maxdescription'] = ".intval($_POST['rss_maxdescription']).";\n";
$content .= "?>";

$filename = "../cache/config.php";
if ( $file = fopen($filename, "w") ) {
        fwrite($file, $content);
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
global $db, $faqConfig;

if ($faqConfig['rss_enable'] == 1) {

$SQL = "SELECT contents_id, category_id, contents_title, contents_contents FROM ".$db->prefix("faq_contents")." WHERE contents_time<".(time()+10)." ORDER BY contents_time DESC";

$query = $db->query($SQL, $faqConfig['rss_maxitems']);

if ($query) {
        include_once(RCX_ROOT_PATH . "/class/xml-rss.php");
        $rss = new xml_rss('../cache/faq.xml');
        $rss->channel_title .= " :: "._MI_FAQ_NAME;
        $rss->image_title   .= " :: "._MI_FAQ_NAME;
        $rss->max_items            = $faqConfig['rss_maxitems'];
        $rss->max_item_description = $faqConfig['rss_maxdescription'];

        while ( list($fid, $cid, $title, $content) = $db->fetch_row($query) ) {
                $link = RCX_URL."/modules/faq/index.php?cat_id=".$cid."#".$fid;
                $rss->build($title, $link, $content);
                }
$rss->save();
        }
}
}
?>