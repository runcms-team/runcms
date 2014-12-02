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
            global $db, $_POST, $gallts, $eh;
                include_once(GALLI_PATH."/class/module.textsanitizer.php");     
              $gallts =& GallTextSanitizer::getInstance();        
                $cid =  $_POST['cid'];
              $new_scid =  $_POST['scid'];
              $new_cname =  $gallts->makeTboxData4Save($_POST['cname']);
              $new_coment =  $gallts->makeTboxData4Save($_POST['coment']);
            $new_img = $gallts->makeTboxData4Save($_POST["img"]);
            $new_button = $gallts->makeTboxData4Save($_POST["cat_button"]);
            if ($cid == $new_scid){$eh->show("0114");}
            if ( $new_scid != 0 ){
                include_once(GALLI_PATH."/class/Gal_Tree.php");
                    $galltree = new GalTree($db->prefix("galli_category"),"cid","scid");
                $testpfad = $galltree->makeCatDir("cname", "cname", $cid, $new_scid); 
              if ( !$testpfad ){$eh->show("0114");}
            }
            $new_cname = gall_function("entfern_sonder", array ($cname));
            if ($new_cname == ""){$eh->show("0100");}
            if ($new_coment == ""){$eh->show("0105");}
                include_once(GALLI_PATH."/class/gall_cat.php");  
                $count_cname = GallCat::countAllCat(array("cname = '".$new_cname."' "));
                $store_conf = new GallCat($cid);
                if($count_cname >= 1 && $store_conf->cname() != $new_cname){$eh->show("0116");}    
                
                $store_conf->setVar("scid",$new_scid);
                $store_conf->setVar("cname",$new_cname);
                $store_conf->setVar("coment",$new_coment);
                $store_conf->setVar("img",$new_img);
                $store_conf->setVar("button",$new_button);
                $store_conf->setVar("date",time());
                $result = $store_conf->store();
                if (!$result){
                    echo "konnte nicht in Image DB Schreiben";
                }else{
                    $userfile = $GLOBALS['rcx_upload_file'][0];
                    if ($_FILES[$userfile]['name'] != ""){
                        include_once(GALLI_PATH . '/class/fileupload.php');
                        $upload = new fileupload();
                      $upload->set_upload_dir("../images/button", $userfile);  
						$basename = str_replace(array(".jpg",".jpeg",".gif",".png",".wbmp",".JPG",".JPEG",".GIF",".PNG",".WBMP",".mov",".wmv",".mpg",".mpeg",".avi",".asf",".swf",".MOV",".WMV",".MPG",".MPEG",".AVI",".ASF",".SWF"), array("","","","","","","","","","","","","","","","","","","","","","","","") ,$_FILES[$userfile]['name']);  
                        if (strlen($basename) > 35){$basename = substr($basename, -35);}                    
                      $upload->set_basename($basename , $userfile);
                        $upload->set_accepted("jpg|gif|png", $userfile);
                      $upload->set_overwrite(1, $userfile);
                        $upload->set_chmod(0777, $userfile);
                      $upload->set_max_image_height($galerieConfig['admin_picmaxwidth'], $userfile);
                      $upload->set_max_image_width($galerieConfig['admin_picmaxhight'], $userfile);        
                      $result = $upload->upload();     
                        if ($result[$userfile]['filename']) {
                            $upd_conf = new GallCat($cid);
                            $upd_conf->setVar("button", $result[$userfile]['filename']);
                            $upd_conf->store();
                        }else{
                            gall_cp_header(); 
                            gall_function("admin_meldung_go_hidden", array(_ERROR_FONT._Errorup.": ".$result[$userfile]['basename']."<br>".$upload->errors()."</font>", GAL_ADMIN_URL."/index.php", array("name='op' value='cat_conf'"), "", _AD_MA_NEXT));
                          gall_cp_footer();
                            exit();
                        }
                    }
                    
                    redirect_header("index.php?op=cat_conf",1,_AD_MA_DBUPDATED);
                }
          break;
    
          default:
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
          if ( isset($_POST['cid']) ) {
          $cid =  $_POST['cid'];
        } elseif ( isset($_GET['cid']) ) {
          $cid =  $_GET['cid'];
        }
            include_once(FUNC_INCL_PATH."/func_titel_Verz.php");
            include_once(GALLI_PATH."/class/galltree.php");
            include_once(GALLI_PATH."/class/gall_cat.php"); 
            include_once(GALLI_PATH."/class/gall_img.php");      
            include_once(RCX_ROOT_PATH."/class/form/themeform.php");
            include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
            include_once(RCX_ROOT_PATH."/class/form/formtext.php");
            include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
            include_once(RCX_ROOT_PATH."/class/form/formselect.php");
            include_once(RCX_ROOT_PATH."/class/form/formfile.php");
            include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
            include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
            include_once(GALLI_PATH."/class/module.textsanitizer.php");    
          $gallts =& GallTextSanitizer::getInstance(); 
        titel_Verz(_AD_MA_TITEL, _AD_MA_TITEL2, "modCat", 6);
            $cat_Dat = new GallCat($cid);
        $cname = $gallts->makeTboxData4Edit($cat_Dat->cname());
        $img = $gallts->makeTboxData4Edit($cat_Dat->img());
          $coment = $gallts->makeTboxData4Edit($cat_Dat->coment());
        $button = $gallts->makeTboxData4Edit($cat_Dat->button());
            OpenTable();
            $form = new RcxThemeForm(_AD_MA_MODCAT, "cat_mod", "index.php");
            $form->setExtra("enctype='multipart/form-data'");
            $cname_tray = new RcxFormElementTray(_AD_MA_CNAME, "");
            $cname_text = new RcxFormText("", "cname", 25, 25, $cname);
            $cname_tray->addElement($cname_text);
            $cname_label = new RcxFormLabel("", "<br>"._AD_MA_NOCARC);
            $cname_tray->addElement($cname_label);
            $form->addElement($cname_tray);
            $cname_select = new RcxFormSelect(_AD_MA_INCAT, "scid", $cat_Dat->scid());
            $cname_select->addOptionArray(array ("0" => "----"));
            $cname_select->addOptionArray(gall_function("makeCnameSelectArray", array ("galli_category", "cname", "cname", "cid", "scid")));
            $form->addElement($cname_select);
            $coment_text = new RcxFormText(_AD_MA_CDESCRIPTION, "coment", 50, 50, $coment);
            $form->addElement($coment_text);
            $img_select = new RcxFormSelect(_AD_MA_FILEINDEX, "img", $cat_Dat->img());
            $img_select->addOptionArray(GallImg::getAllImgList(array("cid = ".$cid), $orderby="img ASC"));
            $form->addElement($img_select);
            $button_list = gall_function("getLogoFileListAsArray", array ("../images/button/", "jpg|gif|png"));
            if ( count($button_list) > 0){
                $button_logo_tray = new RcxFormElementTray("Button "._AD_MA_PREV, "");
                $button_img_label = new RcxFormLabel("", "<img id='button_logo' src='".IMG_URL."/button/".$cat_Dat->button()."' alt='' border='0'><br><br>");
                $button_logo_tray->addElement($button_img_label);
                $button_select = new RcxFormSelect("", "cat_button", $cat_Dat->button());
//             $button_select->addOptionArray(array("blank.gif" => "kein Button"));
                $button_select->addOptionArray($button_list);
                $button_select->setExtra("onchange='showLogoSelected(\"button_logo\", \"cat_button\", \"modules/galleri/images/button\")'");
                $button_logo_tray->addElement($button_select);
              $form->addElement($button_logo_tray);
            }else{
                $nobuttontext = new RcxFormLabel("<center><img src='".IMG_URL."/achtung.gif' alt='"._AD_MA_ACHTUNG."' width='20' height='20' border='0'></center>", "<font color='red'>"._AD_MA_NOButtonLOGO."</font>");
              $form->addElement($nobuttontext);
            }
            $text2_label = new RcxFormLabel(_AD_MA_IMGFORMAT, "jpg|gif|png");
            $form->addElement($text2_label);
            $file_form = new RcxFormFile(_AD_MA_TitelLOGO, 'userfile', 0);
            $file_form->setExtra("size='50'");
            $form->addElement($file_form );
            $op_hidden = new RcxFormHidden("op","modCat");
            $form->addElement($op_hidden);
            $cid_hidden = new RcxFormHidden("cid",$cid);
            $form->addElement($cid_hidden);
            $op_pref_hidden = new RcxFormHidden("op_pref","save");
            $form->addElement($op_pref_hidden);
            $button_tray = new RcxFormElementTray("", "");
            $submit_button = new RcxFormButton("", "button", _AD_MA_SAVE, "submit");
            $button_tray->addElement($submit_button); 
            $delet_button = new RcxFormButton("", "button", _AD_MA_CLEAR, "button");
            $delet_button->setExtra("onClick=\"location='index.php?op=delCat&cid=".$cid." '\"");
            $button_tray->addElement($delet_button);  
            $retour_button = new RcxFormButton("", "button", _AD_MA_GOBACK, "button");
            $retour_button->setExtra("onClick=\"location='index.php?op=cat_conf'\"");
            $button_tray->addElement($retour_button); 
            $retur_button = new RcxFormButton("", "button", TIL_HOVEDMENU, "button");
            $retur_button->setExtra("onClick=\"location='index.php'\"");
            $button_tray->addElement($retur_button); 

            $form->addElement($button_tray);  
            $form->display();
            CloseTable();
        gall_cp_footer();
          break;
        }
    }

?>