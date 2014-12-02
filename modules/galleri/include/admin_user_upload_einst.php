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
          $imguploadano =  $_POST['imguploadano'];
            $imguploadreg =  $_POST['imguploadreg'];
          if ($imguploadano == 1){$imguploadreg = 1;}
            $user_autoupload =  $_POST['user_autoupload'];
            $admin_autoupload =  $_POST['admin_autoupload'];
          $picmaxwidth =  $_POST['picmaxwidth'];
            $picmaxhight =  $_POST['picmaxhight'];
            $picuplkb =  $_POST['picuplkb'];
          $ppm_tnheight =  $_POST['ppm_tnheight'];
          $ppm_jpegcomp =  $_POST['ppm_jpegcomp'];
          $imgfree =  $_POST['imgfree'];
          $img_up_mail =  $_POST['img_up_mail'];
          $yes =  $_POST['yes'];
          if ( $yes == ""._AD_MA_YES."" ){
                    $upd_conf = new GalliConf(1);
                    $upd_conf->setVar("parm4",$_POST['imguploadano']);
                    $upd_conf->setVar("parm5",$_POST['imguploadreg']);
                    $upd_conf->setVar("parm8",$_POST['ppm_tnheight']);
                    $upd_conf->setVar("parm16",$_POST['ppm_jpegcomp']);
                    $upd_conf->setVar("parm17",$_POST['img_up_mail']);
                    $upd_conf->store(); 
                    $upd_conf = new GalliConf(3);
                    $upd_conf->setVar("parm7",$_POST['picmaxwidth']);
                    $upd_conf->setVar("parm8",$_POST['picmaxhight']);
                    $upd_conf->setVar("parm9",$_POST['img_format']);
                    $upd_conf->setVar("parm16",$_POST['picuplkb']);
                    $upd_conf->setVar("parm17",$_POST['imgfree']);    
                    $upd_conf->store(); 
                    $upd_conf = new GalliConf(8);
                    $upd_conf->setVar("parm4",$_POST['max_anz_upload']);
                    $upd_conf->setVar("parm7",$_POST['admin_picmaxwidth']);
                    $upd_conf->setVar("parm8",$_POST['admin_picmaxhight']);
                    $upd_conf->setVar("parm16",$_POST['admin_picuplkb']);  
                    $upd_conf->store(); 
//          gall_function("thumbCorr");
                    include("upload_thumbCorr.php");
//                    redirect_header("index.php?op=upload_einst",1,_AD_MA_DBUPDATED);
          break;
          }else{
            if ( isset($_POST['no']) ) {
              $galerieConfig['ppm_tnheight'] = $ppm_tnheight;
              $galerieConfig['ppm_jpegcomp'] = $ppm_jpegcomp;
            }
          }
          if ( ($galerieConfig['ppm_tnheight'] <> $_POST['ppm_tnheight']) && $galerieConfig['safe_mode'] == 0|| ( $galerieConfig['ppm_jpegcomp'] <> $_POST['ppm_jpegcomp'] && $galerieConfig['safe_mode'] == 0) ){
            gall_cp_header();
              OpenTable();
                    echo "<table width='100%' border='0' cellspacing='0' cellpadding='2' class='bg2'><tr><td>&nbsp;</td></tr><tr>";
                    echo "<td align='center' class='bg1'>";
                    echo "<br><font size='2'><b>"._AD_MA_THUMBCORR."</b><br><br>"._AD_MA_THUMBCORR2;
                    echo "<br>";
                    echo "</font><br>";
                    echo "<table border=0><tr><td align='center'>";
            echo "<form method='post' action='".GAL_ADMIN_URL."/index.php'>";
            echo "<input type='hidden' name='imguploadano' value='".$imguploadano."'>";
            echo "<input type='hidden' name='imguploadreg' value='".$imguploadreg."'>";
            echo "<input type='hidden' name='img_format' value='".$img_format."'>";
            echo "<input type='hidden' name='max_anz_upload' value='".$max_anz_upload."'>";
            echo "<input type='hidden' name='picmaxwidth' value='".$picmaxwidth."'>";
            echo "<input type='hidden' name='picmaxhight' value='".$picmaxhight."'>";
            echo "<input type='hidden' name='picuplkb' value='".$picuplkb."'>";
                    echo "<input type='hidden' name='admin_picmaxwidth' value='".$admin_picmaxwidth."'>";
            echo "<input type='hidden' name='admin_picmaxhight' value='".$admin_picmaxhight."'>";
            echo "<input type='hidden' name='admin_picuplkb' value='".$admin_picuplkb."'>";
            echo "<input type='hidden' name='ppm_tnheight' value='".$ppm_tnheight."'>";
            echo "<input type='hidden' name='ppm_jpegcomp' value='".$ppm_jpegcomp."'>";
            echo "<input type='hidden' name='imgfree' value='".$imgfree."'>";
            echo "<input type='hidden' name='img_up_mail' value='".$img_up_mail."'>";
                    echo "<input type='hidden' name='op' value='upload_einst'>";
                    echo "<input type='hidden' name='op_pref' value='save'>";
                    echo "<input type='submit' name='yes' value='"._AD_MA_YES."'>&nbsp;&nbsp;";
                    echo "</form>";
            echo "</td><td>";
            echo "<form method='post' action='".GAL_ADMIN_URL."/index.php'>";
            echo "<input type='hidden' name='imguploadano' value='".$imguploadano."'>";
            echo "<input type='hidden' name='imguploadreg' value='".$imguploadreg."'>";
            echo "<input type='hidden' name='img_format' value='".$img_format."'>";
            echo "<input type='hidden' name='max_anz_upload' value='".$max_anz_upload."'>";
            echo "<input type='hidden' name='picmaxwidth' value='".$picmaxwidth."'>";
            echo "<input type='hidden' name='picmaxhight' value='".$picmaxhight."'>";
            echo "<input type='hidden' name='picuplkb' value='".$picuplkb."'>";
                    echo "<input type='hidden' name='admin_picmaxwidth' value='".$admin_picmaxwidth."'>";
            echo "<input type='hidden' name='admin_picmaxhight' value='".$admin_picmaxhight."'>";
            echo "<input type='hidden' name='admin_picuplkb' value='".$admin_picuplkb."'>";
            echo "<input type='hidden' name='ppm_tnheight' value='".$ppm_tnheight."'>";
            echo "<input type='hidden' name='ppm_jpegcomp' value='".$ppm_jpegcomp."'>";
            echo "<input type='hidden' name='imgfree' value='".$imgfree."'>";
            echo "<input type='hidden' name='img_up_mail' value='".$img_up_mail."'>";
                    echo "<input type='hidden' name='op' value='upload_einst'>";
                    echo "<input type='hidden' name='op_pref' value='save'>";
                    echo "<input type='submit' name='no' value='"._AD_MA_NO."'>";
                    echo "</form>";
                    echo "</td></tr></table>";
                    echo "</td></tr></table>";
            CloseTable();
          gall_cp_footer();
                  break;
          }
                $upd_conf = new GalliConf(1);
                $upd_conf->setVar("parm4",$_POST['imguploadano']);
                $upd_conf->setVar("parm5",$_POST['imguploadreg']);
                $upd_conf->setVar("parm8",$_POST['ppm_tnheight']);
                $upd_conf->setVar("parm16",$_POST['ppm_jpegcomp']);
                $upd_conf->setVar("parm17",$_POST['img_up_mail']);
                $upd_conf->store();
                $upd_conf = new GalliConf(3);
                $upd_conf->setVar("parm5",$_POST['zdat_adm_upload']);
                $upd_conf->setVar("parm7",$_POST['picmaxwidth']);
                $upd_conf->setVar("parm8",$_POST['picmaxhight']);
                $upd_conf->setVar("parm9",$_POST['img_format']);
                $upd_conf->setVar("parm16",$_POST['picuplkb']);
                $upd_conf->setVar("parm17",$_POST['imgfree']);
                $upd_conf->store();           
                $upd_conf = new GalliConf(8);
                $upd_conf->setVar("parm4",$_POST['max_anz_upload']);
                $upd_conf->setVar("parm7",$_POST['admin_picmaxwidth']);
                $upd_conf->setVar("parm8",$_POST['admin_picmaxhight']);
                $upd_conf->setVar("parm16",$_POST['admin_picuplkb']);  
                $upd_conf->store();     
                redirect_header("index.php?op=upload_einst",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(RCX_ROOT_PATH."/class/form/themeform.php");
                include_once(RCX_ROOT_PATH."/class/form/formradioyn.php");
                include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
                include_once(RCX_ROOT_PATH."/class/form/formtext.php");
                include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
                include_once(RCX_ROOT_PATH."/class/form/formselect.php");
                include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
                include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
                gall_cp_header();
                openTable();
                $form = new RcxThemeForm(_AD_MA_UPLOADSEITE, "upload", "index.php");
              $imguploadano_radio = new RcxFormRadioYN(_AD_MA_IMGUPLOADANO, "imguploadano", $galerieConfig['imguploadano'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($imguploadano_radio);
                $imguploadreg_radio = new RcxFormRadioYN(_AD_MA_IMGUPLOADREG, "imguploadreg", $galerieConfig['imguploadreg'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($imguploadreg_radio);
              $imgfree_radio = new RcxFormRadioYN(_AD_MA_IMGFREEYESNO, "imgfree", $galerieConfig['imgfree'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($imgfree_radio);
              $img_up_mail_radio = new RcxFormRadioYN(_AD_MA_img_up_mail, "img_up_mail", $galerieConfig['img_up_mail'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($img_up_mail_radio);
                $picmaxwidth_text = new RcxFormText("User "._AD_MA_PICMAXWIDTH, "picmaxwidth", 4, 4, $galerieConfig['picmaxwidth']);
                $form->addElement($picmaxwidth_text);
                $picmaxhight_text = new RcxFormText("User "._AD_MA_PICMAXHIGHT, "picmaxhight", 4, 4, $galerieConfig['picmaxhight']);
                $form->addElement($picmaxhight_text);
                $picuplkb_text = new RcxFormText("User "._AD_MA_PICUPLKB, "picuplkb", 4, 4, $galerieConfig['picuplkb']);
                $form->addElement($picuplkb_text);          
                $adminpicmaxwidth_text = new RcxFormText("Admin/Coadmin "._AD_MA_PICMAXWIDTH, "admin_picmaxwidth", 4, 4, $galerieConfig['admin_picmaxwidth']);
                $form->addElement($adminpicmaxwidth_text);
                $adminpicmaxhight_text = new RcxFormText("Admin/Coadmin "._AD_MA_PICMAXHIGHT, "admin_picmaxhight", 4, 4, $galerieConfig['admin_picmaxhight']);
                $form->addElement($adminpicmaxhight_text);
                $adminpicuplkb_text = new RcxFormText("Admin/Coadmin "._AD_MA_PICUPLKB, "admin_picuplkb", 4, 4, $galerieConfig['admin_picuplkb']);
                $form->addElement($adminpicuplkb_text);
                $max_anzuplad_select = new RcxFormSelect(_AD_MA_MAXANZUPLOAD, "max_anz_upload", $galerieConfig['max_anz_upload']);
                $max_anzuplad_select->addOptionArray(array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6"));
                $form->addElement($max_anzuplad_select);
                $zdat_adm_upload_radio = new RcxFormRadioYN(_AD_MA_ZDATYESNO, "zdat_adm_upload", $galerieConfig['zdat_adm_upload'], _AD_MA_YES, _AD_MA_NO);
                $form->addElement($zdat_adm_upload_radio);
                $img_format_tray = new RcxFormElementTray(_AD_MA_IMGFORMAT, "");
                $img_format_text = new RcxFormText("", "img_format", 50, 50, $galerieConfig['img_format']);
                $img_format_tray->addElement($img_format_text);
                $img_format_label = new RcxFormLabel("", "<br>"._AD_MA_IMGFORMAT2);
                $img_format_tray->addElement($img_format_label);
                $form->addElement($img_format_tray);
              $ppm_tnheight_text = new RcxFormText(_AD_MA_TNHEIGHT, "ppm_tnheight", 3, 3, $galerieConfig['ppm_tnheight']);
                $form->addElement($ppm_tnheight_text);
                $ppm_jpegcomp_text = new RcxFormText(_AD_MA_JPEGCOMP, "ppm_jpegcomp", 3, 3, $galerieConfig['ppm_jpegcomp']);
                $form->addElement($ppm_jpegcomp_text);
                $op_hidden = new RcxFormHidden("op","upload_einst");
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