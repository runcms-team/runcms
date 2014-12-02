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
            global $db, $_POST, $eh;
                include_once(GALLI_PATH."/class/module.textsanitizer.php");         
              $gallts =& GallTextSanitizer::getInstance();                
              $scid = $_POST["cid"];
              $cname = $_POST["cname"];
              $coment = $_POST["coment"];
                $cname = gall_function("entfern_sonder", array ($cname));
            if ($cname == ""){$eh->show("0100");}
            if ($coment == ""){$eh->show("0105");}
            
                include_once(GALLI_PATH."/class/gall_cat.php");      
                $count_cname = GallCat::countAllCat(array("cname = '".$cname."' "));
                if($count_cname == 1){$eh->show("0116");}
                $store_conf = new GallCat();
                $store_conf->setVar("cid","");
                $store_conf->setVar("scid",$scid);
                $store_conf->setVar("cname",$gallts->makeTboxData4Save($cname));
                $store_conf->setVar("coment",$gallts->makeTboxData4Save($coment));
                $store_conf->setVar("date",time());
                $result = $store_conf->store();
                if (!$result){
                    echo "konnte nicht in Image DB Schreiben";
                }else{
                    redirect_header("index.php",1,_AD_MA_DBUPDATED);
                }
          break;

          default:
            gall_cp_header(); 
            OpenTable();
            include_once(FUNC_INCL_PATH."/func_titel_Verz.php");
            include_once(GALLI_PATH."/class/Gal_Tree.php");
            include_once(GALLI_PATH."/class/gall_img.php");
            include_once(GALLI_PATH."/class/gall_cat.php");
            titel_Verz(_AD_MA_TITEL, _AD_MA_TITEL2, "modCat", 1);
            $galltree = new GalTree($db->prefix("galli_category"),"cid","scid");
            $result = $db->query("SELECT * FROM ".$db->prefix("galli_category")." ORDER BY cname");
            $result_cat = $result;    
            echo "<br><table width=100% border=0 cellspacing=1 cellpadding=2 class='bg2'>\n"
                 ."<tr class='bg2' >\n"
                 ."<td><font color='#".$galerieConfig['tab_titel']."'><b>"._AD_MA_CAT."</b></font></td>\n"
                 ."<td><font color='#".$galerieConfig['tab_titel']."'><b>"._AD_MA_FILEINDEX."</b></font></td>\n"
                 ."<td><font color='#".$galerieConfig['tab_titel']."'><b>"._AD_MA_IMGTITEL."</b></font></td>\n"
               ."<td><font color='#".$galerieConfig['tab_titel']."'><b>"._AD_MA_BUTTON."</b></font></td>\n"
                 ."</tr>\n";
            if (!$db->num_rows($result_cat)){
              echo " <tr bgcolor='$bgcolor1'><td colspan=7 align=center>"._AD_MA_NOCAT."</td></tr>\n";
            }else{
                while ($val = $db->fetch_array($result_cat)) {
                    $cid_temp = $val[cid];
                    echo "<tr class='bg1'><td><a href='index.php?op=modCat&amp;cid=$val[cid]'>$val[cname]</a></td>\n";
                  if ($val[img]==''){
                    $result = $db->query("SELECT * FROM ".$db->prefix("galli_img")." WHERE cid=$cid_temp");
                    while ($temp = $db->fetch_array($result)){
                    if ($temp[cid] == $cid_temp){
                      $val[img] = $temp[img];
                    }
                  }
                    if ($val[img]==''){
                      echo "<td><b>"._AD_MA_NOIMG."</b></td>";
                    }else{
                            $cat_store = new GallCat($cid_temp);
                            $cat_store->setVar("img",$val[img]);
                            $result = $cat_store->store();
                        }
                  }
                    if ($val[img]!=''){
                        $cat_img = GallImg::getAllImg(array("img = '".$val[img]."' "));
                        $img_list = new GallImg($cat_img[0]);
                        $size = explode("|",$img_list->size());
                        $br = $size[0]+5; $ho = $size[1]+5;
                      echo "<td><a href='javascript:openImgPopup(\"../show-pop.php?id=".GAL_URL."/".$val[img]."&img=".$val[img]."\",\"popup\",".$br.",".$ho.")'>".$val[img]."</a></td>";
                  }
                  if (!$val[coment]){ echo "<td>&nbsp;</td>";}else{ echo "<td>$val[coment]</td>\n";}
                  if (!$val[button]){ echo "<td>&nbsp;</td>";}else{ echo "<td>$val[button]</td>\n";}
                    echo "   </tr>\n";
                  $wide = '';
                  $high = '';
                 }
            }
            echo "  </table>\n";
            echo "<br><br>";
            
            include_once(RCX_ROOT_PATH."/class/form/themeform.php");
            include_once(RCX_ROOT_PATH."/class/form/formelementtray.php");
            include_once(RCX_ROOT_PATH."/class/form/formlabel.php");
            include_once(RCX_ROOT_PATH."/class/form/formtext.php");
            include_once(RCX_ROOT_PATH."/class/form/formselect.php");
            include_once(RCX_ROOT_PATH."/class/form/formhidden.php");
            include_once(RCX_ROOT_PATH."/class/form/formbutton.php");
            include_once(GALLI_PATH."/class/galltree.php");
        $galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
        OpenTable();
        $form = new RcxThemeForm(_AD_MA_ADDMAINC, "cat_add", "index.php");                  
        $cname_tray = new RcxFormElementTray(_AD_MA_CNAME, "");
        $cname_text = new RcxFormText("", "cname", 25, 25, $cname);
        $cname_helptext = new RcxFormLabel("", "<br>&nbsp;"._AD_MA_NOCARC."");
        $cname_tray->addElement($cname_text);
        $cname_tray->addElement($cname_helptext);
            $form->addElement($cname_tray);               
        $coment_text = new RcxFormText(_AD_MA_CDESCRIPTION, "coment", 50, 50, $coment); 
            $form->addElement($coment_text);
        $cid_hidden = new RcxFormHidden("cid", 0);
            $form->addElement($cid_hidden);
        $op_hidden = new RcxFormHidden("op", "cat_conf");
            $form->addElement($op_hidden);
            $op_pref_hidden = new RcxFormHidden("op_pref","save");
            $form->addElement($op_pref_hidden);
        $submit_button = new RcxFormButton("", "submit", _AD_MA_ADD, "submit"); 
        $form->addElement($submit_button);
            $form->setRequired(array("cname", "coment"));
         $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
        CloseTable();
            if (GallCat::countAllCat(array()) > 0) {  
            OpenTable();
                $form = new RcxThemeForm(_AD_MA_ADDSUBC, "ucat_add", "index.php");                  
            $cname_tray = new RcxFormElementTray(_AD_MA_CNAME, "");
            $cname_text = new RcxFormText("", "cname", 25, 25, $cname);
                $cname_tray->addElement($cname_text);
                $ucat_select = new RcxFormSelect("&nbsp;"._AD_MA_INCAT, "cid");
                $ucat_select->addOptionArray(gall_function("makeCnameSelectArray", array ("galli_category", "cname", "cname", "cid", "scid")));
                $cname_tray->addElement($ucat_select);
            $cname_helptext = new RcxFormLabel("", "<br>&nbsp;"._AD_MA_NOCARC."");
            $cname_tray->addElement($cname_helptext);
                $form->addElement($cname_tray);     
                $coment_text = new RcxFormText(_AD_MA_CDESCRIPTION, "coment", 50, 50, $coment); 
                $form->addElement($coment_text);
                $op_hidden = new RcxFormHidden("op", "cat_conf");
                $form->addElement($op_hidden);
                $op_pref_hidden = new RcxFormHidden("op_pref","save");
                $form->addElement($op_pref_hidden);
            $submit_button = new RcxFormButton("", "submit", _AD_MA_ADD, "submit"); 
            $form->addElement($submit_button);
                $form->setRequired(array("cname", "coment"));
         $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
          $retur_button->setExtra("onClick=\"location='index.php'\"");
            $form->addElement($retur_button); 

            $form->display();
                CloseTable();
        }
          CloseTable();
          gall_cp_footer();
          break;
        }
    }

?>