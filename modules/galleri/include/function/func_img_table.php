<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function img_table($cid){
        global $op_coad, $rcxConfig, $galerieConfig, $sens, $ordre, $op_coad, $start;
        include_once(GALLI_PATH . '/class/gall_img.php');
        include_once(GALLI_PATH . "/class/gall_cat.php");
        include_once(RCX_ROOT_PATH.'/class/rcxpagenav.php');
        $cat_info = new GallCat($cid);
         
        echo "<table border='0' cellpadding='3' cellspacing='0' width='100%' class='tb_tabletitle'><tr><td width='100%'><img width='20' height='20' src='".IMG_URL."/dossier.gif' align='absmiddle'><font size='2'><b>&nbsp;"._AD_MA_TITEL4.$cat_info->coment()."</b></font></td><td align='right'>";
        if ( GALL_PAGE != "coadmin.php" ){
        if (GallImg::countAllImg(array("cname = '".$cat_info->cname()."' ", "new_img = 1")) >= 1){
          echo "<a href='".GAL_ADMIN_URL."/index.php?op=modNewImg&&cid=".$cid."'><img src='".IMG_URL."/new.gif' width='25' height='12' alt='"._AD_MA_NEWACT."'></a><img src='".IMG_URL."/pixel.gif' width='87' height='12'>";
        }else{
          echo "&nbsp;";
        }
        }
        echo "</td></tr></table>";    
        $img_total = GallImg::countAllImg(array("cid = ".$cid." "));       
//echo "img_total = ".$img_total."<br>";        
        echo "<TABLE width='100%' border='0' cellpadding='2' cellspacing='1' class='bg1'>";
//        if($sens==""){$sens=0;$oby=" desc";}else{if($sens==1){$sens=0;$oby=" desc";}else{$sens=1;$oby=" asc";}}
        if($sens==""){$sens=$galerieConfig['sort_admin_tablead'];}
        $temp_sens = $sens;
        if($sens==1){$sens=0;$oby=" desc";}else{$sens=1;$oby=" asc";}
        if ($ordre==""){$ordre=$galerieConfig['sort_admin_table'];}
        $cat_img_list = GallImg::getAllImg(array("cid = ".$cid." "), true, $ordre.$oby, $galerieConfig['img_in_tab'], $start);
        $pagenav = new RcxPageNav($img_total, $galerieConfig['img_in_tab'], $start, "op=img_conf&cid=".$cid."&amp;start", "sens=".$temp_sens."&amp;ordre=".$ordre);
        $rank = 1;
        $poidstotal = 0;
        echo "<tr class='bg2'>\n";
        echo "<td><font size='2' color='#".$galerieConfig['tab_titel']."'>"._AD_MA_TYPE."</font></td>\n";
        echo "<td align='left'><b><a href='".GALL_PAGE."?op=img_conf&cid=".$cid."&ordre=img&sens=".$sens."&op_coad=".$op_coad."'><font size='2' color='#".$galerieConfig['tab_titel']."'>"._Filename."</font></a></b>";
        if($ordre=="img"||$ordre=="") {echo "&nbsp;&nbsp;<img src='".IMG_URL."/fleche${sens}.gif' width='10' height='10'>";}
        echo "</td>\n";
    echo "<td align='left'><b><a href='".GALL_PAGE."?op=img_conf&cid=".$cid."&ordre=titre&sens=".$sens."&op_coad=".$op_coad."'><font size='2' color='#".$galerieConfig['tab_titel']."'>"._AD_MA_IMGTITEL."</font></a></b>";
        if($ordre=="titre") {echo "&nbsp;&nbsp;<img src='".IMG_URL."/fleche${sens}.gif' width='10' height='10'>";}
        echo "</td>\n";
        echo"<td align='right'><b><a href='".GALL_PAGE."?op=img_conf&cid=".$cid."&ordre=byte&sens=".$sens."&op_coad=".$op_coad."'><font size='2' color='#".$galerieConfig['tab_titel']."'>"._fSize."</font></a></b>";
        if($ordre=="byte") {echo "&nbsp;&nbsp;<img src='".IMG_URL."/fleche${sens}.gif' width='10' height='10'>";}
        echo "</td>\n";
        echo "<td align='center'><b><font size='2' color='#".$galerieConfig['tab_titel']."'>"._AD_MA_WH."</font></b>";
        echo "</td>\n";
        echo "<td align='center'><b><a href='".GALL_PAGE."?op=img_conf&cid=".$cid."&ordre=date&sens=".$sens."&op_coad=".$op_coad."'><font size='2' color='#".$galerieConfig['tab_titel']."'>"._AD_MA_PROVIDED."</font></a></b>\n";
        if($ordre=="date") {echo "&nbsp;&nbsp;<img src='".IMG_URL."/fleche${sens}.gif' width='10' height='10'>";}
        echo "</td>\n";
        echo "<td align='center'><b><font size='2' color='#".$galerieConfig['tab_titel']."'>"._Actions."</font></b></td>\n";
        echo "</tr>\n";
         
        foreach ( $cat_img_list as $img_list ) {
            if(is_integer($rank/2)){$color="bg4";}else{$color="bg3";}
            $size = explode("|",$img_list->size());
            echo "<tr class='".$color."'>";
            echo "<td><img width='20' height='20' src=".IMG_URL."/".gall_function("mimetype", array ($img_list->img(), "image"))."></td>\n";
            echo "<td align='left'>";
            $br = $size[0]+5; $ho = $size[1]+5;
            echo "<a href='javascript:openImgPopup(\"../show-pop.php?id=".GAL_URL."/".$img_list->img()."&img=".$img_list->img()."\",\"popup\",".$br.",".$ho.")'>".$img_list->img()."</a></td>\n";
            echo "<td width='20%'>".$img_list->titre()."</td>\n";
            echo "<td width='11%' align='right'>".gall_function("format_filegroesse", array ($img_list->byte()))." </td>\n";
            $poidstotal = $poidstotal + $img_list->byte();
            echo "<td width='15%' align='center'>".$size[0]." / ".$size[1]."</td>\n";
            echo "<td width='17%' align='center'>".formatTimestamp($img_list->date(), "l")."</td>\n";
            echo "<td width='15%' align='right'>";
            $free = $img_list->free(); $new_img = $img_list->new_img(); 
            switch ($free){         
              case 0: echo "<img src='".IMG_URL."/disconnect1.gif' width='20' height='20' align='absmiddle'>";
                      echo "<img src='".IMG_URL."/pixel.gif' width='29' height='20'>";
                  break;
              case 1: echo "<img src='".IMG_URL."/pixel.gif' width='25' height='20'>";
                      echo "<img src='".IMG_URL."/pixel.gif' width='5' height='20'>";
                  break;
              case 2: echo "<img src='".IMG_URL."/new.gif' width='25' align='absmiddle'>";
                      echo "<img src='".IMG_URL."/pixel.gif' width='5' height='20'>";
                  break;
            }     
            switch ($new_img){
                case 0: echo "<img src='".IMG_URL."/pixel.gif' width='25' height='20'>";
                      echo "<img src='".IMG_URL."/pixel.gif' width='5' height='20'>";
                  break;
              case 1: echo "<img src='".IMG_URL."/new.gif' width='25' align='absmiddle'>";
                      echo "<img src='".IMG_URL."/pixel.gif' width='5' height='20'>";
                  break;
            }
            if(GALL_PAGE != "coadmin.php" && $galerieConfig['safe_mode'] == 0 ){
            if ($img_list->copy() == 0){
              echo "<a href='".GAL_ADMIN_URL."/index.php?op=solo_img_copyr&img_id=".$img_list->id()."'><img src='".IMG_URL."/copyr.jpg' alt='"._AD_MA_COPYRGEN."' width='20' height='20' border='0'></a>";            
            }else{
              echo "<img src='".IMG_URL."/copyr_trans.jpg' alt='"._AD_MA_COPYRTEXT6."' width='20' height='20' border='0'>";
            }
            echo "<img src='".IMG_URL."/pixel.gif' width='5' height='20'>";
          }
            echo "<a href='".GAL_ADMIN_URL."/";
          if ( GALL_PAGE != "coadmin.php" ){
            echo "index.php";
          }else{
            echo "coadmin.php";
          }
          echo "?op=editImg&img_id=".$img_list->id()."&op_coad=".$op_coad."'>";
            echo "<img src='".IMG_URL."/editer.gif' alt='"._Editfile."' width='32' height='20' border='0'></a>";
            echo "<img src='".IMG_URL."/pixel.gif' width='5' height='20'>";
            echo "<a href='".GALL_PAGE."?op=delImg&img_id=".$img_list->id()."&cid=".$cid."&op_coad=".$op_coad."'><img src='".IMG_URL."/supprimer.gif' alt='"._Deletefile."' width='20' height='20' border='0'></a>\n";
            echo "</td>\n";
            echo "</tr>";
            $rank++;
        }
         
        echo "<tr class='bg2'>\n";
        echo "<td width='20'>&nbsp;</td>\n";
        echo "<td>&nbsp;</td>\n";
    echo "<td width='20%'>&nbsp;</td>\n";
        echo "<td width='11%' align='right'>".gall_function("format_filegroesse", array ($poidstotal))."</td>\n";
        echo "<td width='15%'>&nbsp;</td>\n";
        echo "<td width='17%'>&nbsp;</td>\n";
        echo "<td width='15%'>&nbsp;</td>\n";
        echo "</tr>\n";
        echo "</table>\n<br>";
        if ($img_total > 0){
            echo '<br><div align="center">'.$pagenav->renderNav(10, 1).'</div>';
        }
        include(INCL_PATH."/form_img_upload.php");
    }

?>
