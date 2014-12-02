<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  function showNew(){
    global $myts, $db, $rcxConfig, $orderby, $galerieConfig;
    global $votum, $popdruck, $imgversand;
        include_once(GALLI_PATH."/class/gall_img.php");
    if ( $galerieConfig['imgfree']==1 ){$ing_conf="free>'0'";}else{$ing_conf="free=1";}
        $new_list = GallImg::getAllImg(array($ing_conf), true, $orderby, $galerieConfig['newimg'], 0);
    echo "<table width='100%' cellspacing='0' cellpadding='10' border='0'>";
            if ($galerieConfig['temp_haupt_width'] > 0){$dif = $galerieConfig['temp_haupt_width'];}else{$dif = 1;}
            $br = intval(100/$dif);
        $x=0;
      $b=1;
            foreach ( $new_list as $img_Dat ) {
        $rating = number_format($img_Dat->rating(), 2);
              $cid = $myts->makeTboxData4Show($img_Dat->cid());
                $cname = $myts->makeTboxData4Show($img_Dat->cname());
              $nom = $myts->makeTboxData4Show($img_Dat->nom());
              $titre = $myts->makeTboxData4Show($img_Dat->titre());

              $clic = number_format($img_Dat->clic(), 0);
              $vote = number_format($img_Dat->vote(), 0);
              $img = $myts->makeTboxData4Show($img_Dat->img());
              $datetime = formatTimestamp($img_Dat->date(),"s");
              $coment = $myts->makeTareaData4Show($img_Dat->coment(), 1, 1 ,1);
// ALT tag
              $alt = $myts->makeTboxData4Show($img_Dat->alt());

        include(GALLI_PATH."/template/haupt/".$galerieConfig['template_haupt']);
            $x++;
        }
    echo "</table>";    
  }
?>
