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
                $upd_conf = new GalliConf(5);
                $upd_conf->setVar("parm1",$_POST['haupt_tb1_bo']);
                $upd_conf->setVar("parm2",$_POST['haupt_tb1_cspa']);
                $upd_conf->setVar("parm3",$_POST['haupt_tb1_cpad']);
                $upd_conf->setVar("parm4",$_POST['haupt_tb2_bo']);
                $upd_conf->setVar("parm5",$_POST['haupt_tb2_cspa']);
                $upd_conf->setVar("parm6",$_POST['haupt_tb2_cpad']);
                $upd_conf->setVar("parm7",$_POST['haupt_egal']);
                $upd_conf->setVar("parm8",$_POST['haupt_hgtrans']);
                $upd_conf->setVar("parm10",$_POST['haupt_tb1_bordcol']);
                $upd_conf->setVar("parm11",$_POST['haupt_tb1_bgcol']);
                $upd_conf->setVar("parm12",$_POST['haupt_tb2_bordcol']);
                $upd_conf->setVar("parm13",$_POST['haupt_tb2_bgcol']);
                $upd_conf->setVar("parm14",$_POST['haupt_hgclass']);
                $upd_conf->store();
                redirect_header("index.php?op=rahmen_einst",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(FUNC_INCL_PATH."/func_makeZahlSelBox.php");
                include_once(FUNC_INCL_PATH."/func_getSelColorDesign.php");
                include_once(FUNC_INCL_PATH."/func_makeRahmen.php");
                include_once(INCL_PATH."/rcxhtmlform.php");
                $hf = new RcxHtmlForm();
                gall_cp_header();
                openTable();
              echo "<form method=post action=index.php>";
                echo "<table width='100%' border='0' cellspacing='0' align='center'>";
                echo "<tr><td>";
                echo "<h4 style='text-align:left;'>"._AD_HAUPTDESIGN."</h4>";
                echo "<table width='100%' border='0' cellpadding='4' cellspacing='1' class='bg2'>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._AD_HAUPTEGAL."</b></td>";
              echo "<td class='bg1'>";
              echo $hf->input_radio_YN("haupt_egal",_AD_MA_YES,_AD_MA_NO,$galerieConfig['haupt_egal']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._AD_HAUPT_HGTRANS."</b><br>"._AD_HAUPT_HGTRANS_text."</td>";
              echo "<td class='bg1'>";
              echo $hf->input_radio_YN("haupt_hgtrans",_AD_MA_YES,_AD_MA_NO,$galerieConfig['haupt_hgtrans']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._AD_HAUPT_HGCLASS."</b><br>"._AD_HAUPT_HGTRANS_text."</td>";
              echo "<td class='bg1'>";
              echo $hf->select("haupt_hgclass",array("bg1"=>"bg1","bg2"=>"bg2","bg3"=>"bg3","bg4"=>"bg4","bg5"=>"bg5","bg6"=>"bg6"), $galerieConfig['haupt_hgclass']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_bo."</b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("haupt_tb1_bo", 0, 5, $galerieConfig['haupt_tb1_bo']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_bordcol."</b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("haupt_tb1_bordcol", $galerieConfig['haupt_tb1_bordcol']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_cspa."</b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("haupt_tb1_cspa", 0, 5, $galerieConfig['haupt_tb1_cspa']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_cpad."</b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("haupt_tb1_cpad", 0, 5, $galerieConfig['haupt_tb1_cpad']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_bgcol."</b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("haupt_tb1_bgcol", $galerieConfig['haupt_tb1_bgcol']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_bo."</b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("haupt_tb2_bo", 0, 5, $galerieConfig['haupt_tb2_bo']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_bordcol."</b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("haupt_tb2_bordcol", $galerieConfig['haupt_tb2_bordcol']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_cspa."</b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("haupt_tb2_cspa", 0, 5, $galerieConfig['haupt_tb2_cspa']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_cpad."</b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("haupt_tb2_cpad", 0, 5, $galerieConfig['haupt_tb2_cpad']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_bgcol."</b></td>";
              echo "<td class='bg1'>";
              echo "<input type=text name=haupt_tb2_bgcol value='".$galerieConfig['haupt_tb2_bgcol']."' maxlength='8' size='8'>";
              echo "</td></tr>";
              echo "<tr><td class='bg3'>&nbsp;</td><td class='bg1'>";
                echo "<input type='hidden' name='op' value='rahmen_einst'>";
              echo "<input type='hidden' name='op_pref' value='save'>";
              echo "<input type='submit' value='"._AD_MA_SAVE."'>";
                echo "</td></tr></table>";
                echo "</td></tr></table>";
                echo "</form>";
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 

              echo "<center><br>";
              echo "<table width='30%' border='0' cellspacing='0' cellpadding='0'><tr><td align='center'>";
// ALT tag - add ""
              makeRahmen("", IMG_URL."/testbild.jpg-ppm", IMG_PATH."/testbild.jpg-ppm", "");
                echo "</td></tr></table></center>";
                closeTable();
                gall_cp_footer();
          break;
        }
    }
?>