<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if ( defined('GALL_ADMIN') ) {

        switch($op_pref){
        
          case "save":
                $upd_conf = new GalliConf(2);
                $upd_conf->setVar("parm1",$_POST['titelimg_yes_no']);
                $upd_conf->setVar("parm7",$_POST['newimg']);
                $upd_conf->setVar("parm10",$_POST['template_haupt']);
                $upd_conf->setVar("parm13",$_POST['titelimg']);
                $upd_conf->setVar("parm14",$_POST['newimg_sort']);
                $upd_conf->setVar("parm16",$_POST['temp_haupt_width']);
                $upd_conf->store();
                $upd_conf = new GalliConf(4);
                $upd_conf->setVar("parm7",$_POST['haupt_perpage_width']);
                $upd_conf->store();
                $userfile = $GLOBALS['rcx_upload_file'][0];
                if ($_FILES[$userfile]['name'] != ""){
                    include_once(GALLI_PATH . '/class/fileupload.php');
                    $upload = new fileupload();
                  $upload->set_upload_dir("../images/title_logo", $userfile);  
						$basename = str_replace(array(".jpg",".jpeg",".gif",".png",".wbmp",".JPG",".JPEG",".GIF",".PNG",".WBMP",".mov",".wmv",".mpg",".mpeg",".avi",".asf",".swf",".MOV",".WMV",".MPG",".MPEG",".AVI",".ASF",".SWF"), array("","","","","","","","","","","","","","","","","","","","","","","","") ,$_FILES[$userfile]['name']);  
                    if (strlen($basename) > 35){$basename = substr($basename, -35);}                    
                  $upload->set_basename($basename , $userfile);
                    $upload->set_accepted($galerieConfig['img_format'], $userfile);
                  $upload->set_overwrite(1, $userfile);
                    $upload->set_chmod(0777, $userfile);
                  $upload->set_max_image_height($galerieConfig['admin_picmaxwidth'], $userfile);
                  $upload->set_max_image_width($galerieConfig['admin_picmaxhight'], $userfile);        
                  $result = $upload->upload();     
                    if ($result[$userfile]['filename']) {
                        $upd_conf = new GalliConf(2);
                        $upd_conf->setVar("parm13", $result[$userfile]['filename']);
                        $upd_conf->store();
                    }else{
                        gall_cp_header(); 
                        gall_function("admin_meldung_go_hidden", array(_ERROR_FONT._Errorup.": ".$result[$userfile]['basename']."<br>".$upload->errors()."</font>", GAL_ADMIN_URL."/index.php", array("name='op' value='haupts_einst'"), "", _AD_MA_NEXT));
                      gall_cp_footer();
                        exit();
                    }
                }
                redirect_header("index.php?op=haupts_einst",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
                include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
                include_once(RCX_ROOT_PATH."/class/form/formtext.php");
                include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
                include_once(RCX_ROOT_PATH."/class/form/formselect.php");
                include_once(RCX_ROOT_PATH."/class/form/formfile.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                include_once(FUNC_INCL_PATH."/func_zahlen_array.php");
?>
<script type='text/javascript'>
<!--
function showLogoSelected(imgId, selectId, imgDir) {
  imgDom = rcxGetElementById(imgId);
  selectDom = rcxGetElementById(selectId);
    imgDom.src = "<?php echo RCX_URL;?>/"+ imgDir + "/" + selectDom.options[selectDom.selectedIndex].value;
}
//-->
</script>
<?php        
                gall_cp_header();
                openTable();
                $form = new RcxThemeForm(_AD_MA_HAUPT, "hauptseite", "index.php");
                $form->setExtra("enctype='multipart/form-data'");
                $titelimg_yes_no_radio = new RcxFormRadioYN(_AD_MA_titelimg_yes_no, "titelimg_yes_no", $galerieConfig['titelimg_yes_no'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($titelimg_yes_no_radio);
                $logo_list = gall_function("getLogoFileListAsArray", array ("../images/title_logo/", "jpg|gif|png"));
                if ( count($logo_list) > 0){
                    $titel_logo_tray = new RcxFormElementTray(_AD_MA_PREV, "");
                    $titel_img_label = new RcxFormLabel("", "<img id='title_logo' src='".IMG_URL."/title_logo/".$galerieConfig['titelimg']."' alt='' border='0'><br><br>");
                    $titel_logo_tray->addElement($titel_img_label);
                    $logo_select = new RcxFormSelect("", "titelimg", $galerieConfig['titelimg']);
                  $logo_select->addOptionArray($logo_list);
                    $logo_select->setExtra("onchange='showLogoSelected(\"title_logo\", \"titelimg\", \"modules/galleri/images/title_logo\")'");
                    $titel_logo_tray->addElement($logo_select);
                  $form->addElement($titel_logo_tray);
                }else{
                    $nologotext = new RcxFormLabel("<center><img src='".IMG_URL."/achtung.gif' alt='"._AD_MA_ACHTUNG."' width='20' height='20' border='0'></center>", "<font color='red'>"._AD_MA_NOTitelLOGO."</font>");
                  $form->addElement($nologotext);
                }
                $text2_label = new RcxFormLabel(_AD_MA_IMGFORMAT, "jpg|gif|png");
                $form->addElement($text2_label);
                $file_form = new RcxFormFile(_AD_MA_TitelLOGO, 'userfile', 0);
                $file_form->setExtra("size='50'");
                $form->addElement($file_form );
                $perpage_width_select = new RcxFormSelect(_AD_MA_CATwidth, "haupt_perpage_width", $galerieConfig['haupt_perpage_width']);
                $perpage_width_select->addOptionArray(array("1"=>"1","2"=>"2"));
                $form->addElement($perpage_width_select);
                $newimg_tray = new RcxFormElementTray(_AD_MA_newimg, "");
                $newimg_select = new RcxFormSelect("", "newimg", $galerieConfig['newimg']);
                $newimg_select->addOptionArray(array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6", "7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16", "17"=>"17","18"=>"18","19"=>"19","20"=>"20"));
                $newimg_select->setExtra("onchange='javascript:document.hauptseite.submit();'");
                $newimg_helptext = new RcxFormLabel("", "&nbsp;"._AD_MA_newimg_helptext."");
                $newimg_tray->addElement($newimg_select);
                $newimg_tray->addElement($newimg_helptext);
                $form->addElement($newimg_tray);
                if ($galerieConfig['newimg'] > 0){
                    $newimg_sort_select = new RcxFormSelect(_AD_MA_newimg_sort, "newimg_sort", $galerieConfig['newimg_sort']);
                    $newimg_sort_select->addOptionArray(array("date DESC"=>_MD_DATENEW, "date ASC"=>_MD_DATEOLD, "titre ASC"=>_MD_TITLEATOZ, "titre DESC"=>_MD_TITLEZTOA, "clic DESC"=>_MD_POPULARITYMTOL, "clic ASC"=>_MD_POPULARITYLTOM, "rating DESC"=>_MD_RATINGHTOL, "rating ASC"=>_MD_RATINGLTOH));
                    $form->addElement($newimg_sort_select);
                    $template_list = gall_function("getTemplateFileListAsArray", array ("../template/haupt/"));
                    $template_select = new RcxFormSelect(_AD_MA_TEMPLATEANZ, "template_haupt", $galerieConfig['template_haupt']);
                    $template_select->addOptionArray($template_list);
                    $template_select->setExtra("onchange='javascript:document.hauptseite.submit();'");
                    $form->addElement($template_select);
                    if ($galerieConfig['template_haupt'] == "detail.php"){
                        $perpage_width_select = new RcxFormSelect(_AD_MA_TNwidth, "temp_haupt_width", $galerieConfig['temp_haupt_width']);
                        $perpage_width_select->addOptionArray(arr1_3());
                        $form->addElement($perpage_width_select);                    
                    }
                }
                $op_hidden = new RcxFormHidden("op","haupts_einst");
                $op_pref_hidden = new RcxFormHidden("op_pref","save");
                $submit_button = new RcxFormButton("", "button", _AD_MA_SAVE, "submit");
                $form->addElement($op_hidden);
                $form->addElement($op_pref_hidden);
                $form->addElement($submit_button);  
		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 
                $form->display();
                closeTable();
                gall_cp_footer();
          break;
        }
    }
?>