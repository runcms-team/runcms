<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once(RCX_ROOT_PATH."/mainfile.php");

function b_galli_show($options) {
    global $rcxConfig, $db, $rcxTheme, $rcxUser, $galerieConfig;
    define("GALLI_ACCESS", 1);
    include_once(RCX_ROOT_PATH."/modules/galleri/include/config.php");
    $az = 0;
    $result = $db->query("SELECT * FROM ".$db->prefix("galli_img")." WHERE free >= '1' ORDER BY ".$galerieConfig['imgblock_sort']."");
    list($id, $cid, $nom, $email, $cname, $titre, $img, $size) = $db->fetch_row($result); 
    $result2 = $db->query("SELECT coment FROM ".$db->prefix("galli_category")." WHERE cid='".$cid."'");
    list($coment) = $db->fetch_row($result2);
    if(@is_file("".RCX_ROOT_PATH."/modules/galleri/thumbnails/".$img) and ($galerieConfig['tnwidthblock'] > 0)){
      $th_size = @GetImageSize("".RCX_ROOT_PATH."/modules/galleri/thumbnails/".$img);
      if ($th_size[0] > $galerieConfig['tnwidthblock']){$az = 1;}
    }
    $block = array();
    $block['title'] = "galleri";
    $block['content'] = "";
    $block['content'] .= "<br><center>";
    $block['content'] .= "<table border='".$galerieConfig['block_tb1_bo']."' cellspacing='".$galerieConfig['block_tb1_cspa']."' cellpadding='".$galerieConfig['block_tb1_cpad']."' bordercolor='#".$galerieConfig['block_tb1_bordcol']."' bgcolor='#".$galerieConfig['block_tb1_bgcol']."'>";
    $block['content'] .= "<tr><td>";
    $block['content'] .= "<table border='".$galerieConfig['block_tb2_bo']."' cellspacing='".$galerieConfig['block_tb2_cspa']."' cellpadding='".$galerieConfig['block_tb2_cpad']."' bordercolor='#".$galerieConfig['block_tb2_bordcol']."' bgcolor='#".$galerieConfig['block_tb2_bgcol']."'>";
    $block['content'] .= "<tr><td>";
    if ( $img == "" || !@is_file("".RCX_ROOT_PATH."/modules/galleri/thumbnails/".$img) ){
      $block['content'] .= "<img src='".RCX_URL."/modules/galleri/images/galleri_logo.png' border='0'>";
    }else{  
    if ($galerieConfig['safe_mode'] == 0){
        $block['content'] .= "<a href='".RCX_URL."/modules/galleri/viewcat.php?id=".$id."&cid=".$cid."&min=0&orderby=titreA&show=".$show."'>";
        if ($az == 0){
          $block['content'] .= "<img src='".RCX_URL."/modules/galleri/thumbnails/".$img."' width = '".$th_size[0]."' alt='"._MD_CATEGORYC." ".$coment."' border='0'></a>";
        }else{
          $block['content'] .= "<img src='".RCX_URL."/modules/galleri/thumbnails/".$img."' width = '".$galerieConfig['tnwidthblock']."' alt='"._MD_CATEGORYC." ".$coment."' border='0'></a>";
        }
    }else{
      $name = GAL_PATH."/".$img;
      $img_size = GetImageSize($name);
        $img_width = $img_size[0];
        $img_height = $img_size[1];
      $frame_w=round($img_width * $galerieConfig['ppm_tnheight'] / $img_height);
      if ($frame_w > $galerieConfig['tnwidthblock']){$frame_w = $galerieConfig['tnwidthblock'];}
      $block['content'] .= "<iframe name='Thumbnail' src='".INCL_URL."/thframe.php?name=".$name."&jpegcomp=".$galerieConfig['ppm_jpegcomp']."&tn_height=".$galerieConfig['ppm_tnheight']."&gd2=".$galerieConfig['gd2']."&gif_ok=".$galerieConfig['gif_ok']."' marginwidth='0' marginheight='0' height='".$galerieConfig['ppm_tnheight']."' width='".$frame_w."' scrolling='no' align='middle' border='0' frameborder='0'></iframe><br>";
    }
    } 
    $block['content'] .="</td></tr></table>";
    $block['content'] .="</td></tr></table>";
    if ($cid != 0){$block['content'] .="<br><a href='".RCX_URL."/modules/galleri/viewcat.php?cid=".$cid."'>"._MI_GALLI_MORE."</a></center>";}
    return $block;
}
?>