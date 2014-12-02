<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if ( defined('GALL_ADMIN') || defined('GALL_CO_ADMIN') ) {

        switch($op_pref){

          case "file_upload":

                include_once(GALLI_PATH . '/class/fileupload.php');
                include_once(GALLI_PATH . '/class/gall_img.php');
                include_once(GALLI_PATH . '/class/gall_cat.php');
                include_once(GALLI_PATH . '/class/module.textsanitizer.php');
                $gallts = new GallTextSanitizer();
                $cat_name = new GallCat($cid);
                $x=0;
                while($x < count($GLOBALS['rcx_upload_file'])){
                    $userfile = $GLOBALS['rcx_upload_file'][$x];
                    if ($_FILES[$userfile]['name'] != ""){
                      $upload = new fileupload();
                        $tempx = $x+1;
                      $upload->set_upload_dir("../galerie", $userfile);  
						$basename = str_replace(array(".jpg",".jpeg",".gif",".png",".wbmp",".JPG",".JPEG",".GIF",".PNG",".WBMP",".mov",".wmv",".mpg",".mpeg",".avi",".asf",".swf",".MOV",".WMV",".MPG",".MPEG",".AVI",".ASF",".SWF"), array("","","","","","","","","","","","","","","","","","","","","","","","") ,$_FILES[$userfile]['name']);  
                        if (strlen($basename) > 35){$basename = substr($basename, -35);}                    
                      $upload->set_basename($basename , $userfile);
                        $upload->set_accepted($galerieConfig['img_format'], $userfile);
                      $upload->set_overwrite(1, $userfile);
                        $upload->set_chmod(0777, $userfile);
                      $upload->set_max_image_height($galerieConfig['admin_picmaxhight'], $userfile);
                      $upload->set_max_image_width($galerieConfig['admin_picmaxwidth'], $userfile);        
                      $result = $upload->upload();     
                        if ($result[$userfile]['filename']) {
                            $store_img = new GallImg();
                        $store_img->setVar("cid", $cid);
                        $store_img->setVar("nom", $rcxUser->uname());
                        $store_img->setVar("email", $rcxUser->email());
                        $store_img->setVar("cname", $cat_name->cname());
                        $store_img->setVar("titre", $gallts->makeTboxData4Save($titre[$x]));
                        $store_img->setVar("img", $result[$userfile]['filename']);
                        $store_img->setVar("coment", $gallts->makeTboxData4Save($coment[$x]));
                        $store_img->setVar("alt", $gallts->makeTboxData4Save($alt[$x]));
                        $store_img->setVar("free", 1);
                        $store_img->setVar("copy", 0);
                            if ( defined('GALL_ADMIN') ) {$new = 0;}else{$new = 1;}
                        $store_img->setVar("new_img", $new);
                            $store_img->setVar("date", time());
                            $size = getimagesize("../galerie/".$result[$userfile]['filename']);
                            $store_img->setVar("size", implode("|", $size));
                            $store_img->setVar("byte", $result[$userfile]['size']);
                            $store = $store_img->store();
                            if (!$store){
                                gall_cp_header(); 
                                OpenTable();
                                echo _AD_MA_NOSTOREIMGDB."<br><br>"; 
                                echo "<center><a href='".GAL_ADMIN_URL."/".GALL_PAGE."?op=img_conf&cid=".$cid."&op_coad=".$op_coad."'>"._AD_MA_NEXT."</a></center>"; 
                                CloseTable();
                              gall_cp_footer();
                                exit();                            
                            }else{
                                if ($cat_name->img() == ""){
                                    $cat_name->setVar("img", $result[$userfile]['filename']);
                                    $store = $cat_name->store();
                                }
                                if ($size[1] < $galerieConfig['ppm_tnheight']){
                                    if (!@copy("../galerie/".$result[$userfile]['filename'], "../thumbnails/".$result[$userfile]['filename'])){
                                $eh->show("0117");
                              }
                              }else{
                                    gall_function("ppm_do_thumb", array ("../galerie/".$result[$userfile]['filename'], "../thumbnails/".$result[$userfile]['filename'], $galerieConfig['ppm_tnheight']));
                                    if ($galerieConfig['wz_typ'] == 2||$galerieConfig['wz_typ'] == 3){
                                        $img_id = $store;
                                        include(INCL_PATH."/upload_solo_img_copyr.php");
                                    }
                                }
                            }
                        }else{
                            gall_cp_header(); 
                            gall_function("admin_meldung_go_hidden", array(_ERROR_FONT._Errorup.": ".$result[$userfile]['basename']."<br>".$upload->errors()."</font>", GAL_ADMIN_URL."/".GALL_PAGE."", array("name='op' value='img_conf'", "name='cid' value='".$cid."'", "name='op_coad' value='".$op_coad."'"), "", _AD_MA_NEXT));
                          gall_cp_footer();
                            exit();
                        }
                    }
                    $x++;
                }                
                redirect_header("".GALL_PAGE."?op=img_conf&cid=".$cid."&op_coad=".$op_coad, 1, _AD_MA_DBUPDATED);

          break;
    
          default:
            gall_cp_header(); 
            OpenTable();
            gall_function("titel_Verz", array (_AD_MA_FILEMANAG, _AD_MA_CATMENUE, "modImg"));
        echo "<br>";
            if ($cid > 0){
                gall_function("img_table", array ($cid));
                
            }else{
            echo "<h5 style='text-align:left;'>"._AD_MA_NOTCATIMG."</h5>";
            }
            CloseTable();
          gall_cp_footer();
          break;
        }
    }
?>