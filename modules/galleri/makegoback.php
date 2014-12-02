<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
  if ( !eregi("gall_page", $galerieConfig['page_type']) ) {
    echo "Go Back ! (makegoback)";
  }else{
      $messtmp.="</b><br><br><form action='".RCX_URL."/modules/galleri/uploaduser.php' method='post'>"
      ."<input type='hidden' name='cid' value='".$cid."'>"
      ."<input type='hidden' name='titre' value='".$titre."'>"
      ."<input type='hidden' name='nom' value='".$nom."'>"
      ."<input type='hidden' name='email' value='".$email."'>"
      ."<input type='hidden' name='coment' value='".$coment."'>"
      ."<input type='submit' value='"._BA_GOBACK."'></form>";
      echo "<br>";
      OpenTable("80%");
        echo "<center>\n";
        echo $messtmp;
        echo "</center>\n";
      CloseTable();
  }
?>