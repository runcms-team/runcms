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
                $upd_conf = new GalliConf(4);
                $upd_conf->setVar("parm1",$_POST['block_tb1_bo']);
                $upd_conf->setVar("parm2",$_POST['block_tb1_cspa']);
                $upd_conf->setVar("parm3",$_POST['block_tb1_cpad']);
                $upd_conf->setVar("parm4",$_POST['block_tb2_bo']);
                $upd_conf->setVar("parm5",$_POST['block_tb2_cspa']);
                $upd_conf->setVar("parm6",$_POST['block_tb2_cpad']);
                $upd_conf->setVar("parm8",$_POST['tnwidthblock']);
                $upd_conf->setVar("parm9",$_POST['imgblock_sort']);
                $upd_conf->setVar("parm10",$_POST['block_tb1_bordcol']);
                $upd_conf->setVar("parm11",$_POST['block_tb1_bgcol']);
                $upd_conf->setVar("parm12",$_POST['block_tb2_bordcol']);
                $upd_conf->setVar("parm13",$_POST['block_tb2_bgcol']);
                $upd_conf->store();
                redirect_header("index.php?op=design_block",1,_AD_MA_DBUPDATED);
          break;
    
          default:
                include_once(FUNC_INCL_PATH."/func_makeZahlSelBox.php");
                include_once(FUNC_INCL_PATH."/func_getSelColorDesign.php");
                include_once(INCL_PATH."/rcxhtmlform.php");
                $hf = new RcxHtmlForm();
                gall_cp_header();
                openTable();
              echo "<form method=post action=index.php>";
                echo "<table width='100%' border='0' cellspacing='0' align='center'>";
                echo "<tr><td>";
                echo "<h4 style='text-align:left;'>"._AD_BLOCKDESIGN."</h4>";
                echo "<table width='100%' border='0' cellpadding='4' cellspacing='1' class='bg2'>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._AD_MA_TNWIDTHBLOCK."</b></td>";
              echo "<td class='bg1'>";
              echo $hf->input_text("tnwidthblock",$galerieConfig['tnwidthblock'], 3, 3);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._AD_MA_imgblock_sort."</b></td>";
              echo "<td class='bg1'>";
              echo $hf->select("imgblock_sort",array("RAND()"=>_MD_ZUFALL,"date DESC"=>_MD_DATUM, "clic DESC"=>_AD_MA_CLICS, "rating DESC"=>_AD_MA_RATING), $galerieConfig['imgblock_sort']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_bo."<b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("block_tb1_bo", 0, 5, $galerieConfig['block_tb1_bo']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_bordcol."<b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("block_tb1_bordcol", $galerieConfig['block_tb1_bordcol']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_cspa."<b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("block_tb1_cspa", 0, 5, $galerieConfig['block_tb1_cspa']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_cpad."<b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("block_tb1_cpad", 0, 5, $galerieConfig['block_tb1_cpad']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb1_bgcol."<b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("block_tb1_bgcol", $galerieConfig['block_tb1_bgcol']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_bo."<b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("block_tb2_bo", 0, 5, $galerieConfig['block_tb2_bo']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_bordcol."<b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("block_tb2_bordcol", $galerieConfig['block_tb2_bordcol']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_cspa."<b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("block_tb2_cspa", 0, 5, $galerieConfig['block_tb2_cspa']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_cpad."<b></td>";
              echo "<td class='bg1'>";
              makeZahlSelBox("block_tb2_cpad", 0, 5, $galerieConfig['block_tb2_cpad']);
              echo "</td></tr>";
              echo "<tr><td nowrap class='bg3' valign='top'>";
                echo "<b>"._tb2_bgcol."<b></td>";
              echo "<td class='bg1'>";
              getSelColorDesign("block_tb2_bgcol", $galerieConfig['block_tb2_bgcol']);
              echo "</td></tr>";
              echo "<tr><td class='bg3'>&nbsp;</td><td class='bg1'>";
                echo "<input type='hidden' name='op' value='design_block'>";
              echo "<input type='hidden' name='op_pref' value='save'>";
              echo "<input type='submit' class='button' value='"._AD_MA_SAVE."'>";
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
              echo "<table border='".$galerieConfig['block_tb1_bo']."' cellspacing='".$galerieConfig['block_tb1_cspa']."' cellpadding='".$galerieConfig['block_tb1_cpad']."' bordercolor='#".$galerieConfig['block_tb1_bordcol']."' bgcolor='#".$galerieConfig['block_tb1_bgcol']."'>";
                echo "<tr><td>";
                echo "<table border='".$galerieConfig['block_tb2_bo']."' cellspacing='".$galerieConfig['block_tb2_cspa']."' cellpadding='".$galerieConfig['block_tb2_cpad']."' bordercolor='#".$galerieConfig['block_tb2_bordcol']."' bgcolor='#".$galerieConfig['block_tb2_bgcol']."'>";
                echo "<tr><td>";
                echo "<img src='".IMG_URL."/testbild.jpg-ppm' border='0'>";
                echo "</td></tr></table>";
                echo "</td></tr></table></center>";
                closeTable();
                gall_cp_footer();
          break;
        }
    }
?>