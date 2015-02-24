<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('./admin_header.php');

if ($_POST['submit'])
{
$content  = "<?php\r\n";
$content .= "\$forumConfig['disc_show'] = ".intval($_POST['disc_show']).";\r\n";
$content .= "\$forumConfig['image_set'] = '".$myts->makeTboxData4Save($_POST['image_set'])."';\r\n";
$content .= "\$forumConfig['max_img_width'] = ".intval($_POST['max_img_width']).";\r\n";
$content .= "\$forumConfig['post_anon'] = ".intval($_POST['post_anon']).";\r\n";
$content .= "\$forumConfig['wol_enabled'] = ".intval($_POST['wol_enabled']).";\r\n";
$content .= "\$forumConfig['wol_admin_col'] = '".$myts->makeTboxData4Save($_POST['wol_admin_col'])."';\r\n";
$content .= "\$forumConfig['wol_mod_col'] = '".$myts->makeTboxData4Save($_POST['wol_mod_col'])."';\r\n";
$content .= "\$forumConfig['levels_enabled'] = ".intval($_POST['levels_enabled']).";\r\n";
$content .= "\$forumConfig['rss_enable'] = ".intval($_POST['rss_enable']).";\r\n";
$content .= "\$forumConfig['rss_maxitems'] = ".intval($_POST['rss_maxitems']).";\r\n";;
$content .= "\$forumConfig['rss_maxdescription'] = ".intval($_POST['rss_maxdescription']).";\r\n";
$content .= "\$forumConfig['similar_threads'] = ".intval($_POST['similar_threads']).";\r\n";;

$content .= "?>";

$filename = "../cache/config.php";
if ( $file = fopen($filename, "w") ) {
  fwrite($file, $content);
  fclose($file);
  } else {
    redirect_header("index.php", 1, _NOTUPDATED);
    exit();
  }

$filename = "../cache/disclaimer.php";
if ( $file = fopen($filename, "wb") ) {
  $disclaimer = $myts->oopsStripSlashesGPC($_POST['disclaimer']);
  $disclaimer = $myts->stripPHP($disclaimer);
  fwrite($file, $disclaimer);
  fclose($file);
  } else {
    redirect_header("index.php", 1, _NOTUPDATED);
    exit();
}

redirect_header("index.php", 1, _UPDATED);
exit();
}


include_once(RCX_ROOT_PATH.'/class/rcxformloader.php');

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_A_CONFIGFORUM.'</div>
            <br />
            <br />';


$cfg_form = new RcxThemeForm('', 'cfg_form', 'forum_config.php');

// General Options
$cfg_form->addElement(new RcxFormLabel(_MD_A_GENERAL_OPTS.":"));
$cfg_form->addElement(new RcxFormRadioYN(_MD_A_ALLOW_POSTANON,'post_anon',$forumConfig['post_anon']));
$cfg_form->addElement(new RcxFormRadioYN(_MD_A_LEVELS_ENABLE,'levels_enabled',$forumConfig['levels_enabled']));
$img_sets = RcxLists::getDirListAsArray("../images/imagesets/");
$img_set_sel = new RcxFormSelect(_MD_A_IMG_SET, image_set, $forumConfig['image_set']);
$img_set_sel->addOptionArray($img_sets);
$cfg_form->addElement($img_set_sel);
$cfg_form->addElement(new RcxFormText(_MD_A_MAX_IMG_WIDTH,'max_img_width',10,10,$forumConfig['max_img_width']));
$cfg_form->addElement(new RcxFormRadioYN(_MD_A_ALLOW_SIMILAR_THREADS,'similar_threads',$forumConfig['similar_threads']));

// Disclaimer
$cfg_form->addElement(new RcxFormLabel(_MD_A_DISCLAIMER.":"));
$show_dislcaimer = new RcxFormSelect(_MD_A_SHOW_DIS, "disc_show", $forumConfig['disc_show']);
$show_dislcaimer->addOption(0,  _NONE);
$show_dislcaimer->addOption(1,  _POST);
$show_dislcaimer->addOption(2,  _REPLY);
$show_dislcaimer->addOption(3,  _MD_A_BOTH);
$cfg_form->addElement($show_dislcaimer);
$disclaimer = join('', file("../cache/disclaimer.php"));
$disclaimer = trim($disclaimer);
//$desc       = new RcxFormDhtmlTextArea(_MD_A_DISCLAIMER, 'disclaimer', $disclaimer, 10, 58);
$desc       = new RcxFormDhtmlTextArea(_MD_A_DISCLAIMER, 'disclaimer', $disclaimer);
$cfg_form->addElement($desc);




// RSS Feed
$cfg_form->addElement(new RcxFormLabel(_MD_A_RSS_OPTS.":"));
$cfg_form->addElement(new RcxFormRadioYN(_MD_A_RSS_ENABLE,'rss_enable',$forumConfig['rss_enable']));
$cfg_form->addElement(new RcxFormText(_MD_A_RSS_MAX_ITEMS,'rss_maxitems',10,10,$forumConfig['rss_maxitems']));
$cfg_form->addElement(new RcxFormText(_MD_A_RSS_MAX_DESCRIPTION,'rss_maxdescription',10,10,$forumConfig['rss_maxdescription']));


// Who's Online
$cfg_form->addElement(new RcxFormLabel(_MD_A_WOL_OPTS.":"));
$cfg_form->addElement(new RcxFormRadioYN(_MD_A_WOL_ENABLE,'wol_enabled',$forumConfig['wol_enabled']));
$cfg_form->addElement(new RcxFormText(_MD_A_WOL_ADMIN_COL,'wol_admin_col',10,10,$forumConfig['wol_admin_col']));
$cfg_form->addElement(new RcxFormText(_MD_A_WOL_MOD_COL,'wol_mod_col',10,10,$forumConfig['wol_mod_col']));


$cfg_form->addElement(new RcxFormButton('','submit',_SAVE, 'submit'));
echo $cfg_form->render();


echo "                        
        </td>
    </tr>
</table>";

CloseTable();
rcx_cp_footer();
exit();
?>
