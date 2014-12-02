<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    function admin_sys_test(){
        global $galerieConfig;
        include_once(GALLI_PATH."/class/gall_conf.php");
        $text = "<h4>"._AD_MA_TESTTITEL."</h4>";
        
        if(extension_loaded("gd")){
            $mod1 = get_extension_funcs("gd");
            $x = 0; $images_format = array();
            while(list($key, $val) = each($mod1)){    
                if ( $val == "imagecreatefrompng" ){$images_format[$x] = "png"; $x ++;}
                if ( $val == "imagecreatefromjpeg" ){$images_format[$x] = "jpg"; $x ++;$images_format[$x] = "jpeg"; $x ++;}
                if ( $val == "imagecreatefromwbmp" ){$images_format[$x] = "wbmp"; $x ++;}
            }
            $gd2 = "";
          ob_start();
          phpinfo(8);
          $phpinfo = ob_get_contents();
          ob_end_clean();
          $phpinfo = strip_tags($phpinfo);
          $phpinfo = stristr($phpinfo,"gd version");
          $phpinfo = stristr($phpinfo,"version");
            if (strpos($phpinfo, "GIF Create Support") > 0){
                $images_format[$x] = "gif";
                $gif_ok = 1;
            }
          $phpinfo = substr($phpinfo,0,25);
          $phpinfo = substr($phpinfo,7);
            if (stristr($phpinfo,"2.")){$galerieConfig['gd2'] = 1;}else{$galerieConfig['gd2'] = 0;}            
            $upd_conf = new GalliConf(3);
            if ($gif_ok == 1){$upd_conf->setVar("parm3", 1);}else{$upd_conf->setVar("parm3", 0);}
            $upd_conf->setVar("parm9", implode("|", $images_format) );
            $result = $upd_conf->store();
            if (!$result){
                $text .= "<h4>"._AD_MA_ACHTUNG."</h4><br>";
                $text .= "<b>konnte Konfiguration nicht in DB Satz 3 speichern !</b><br><br>";
                gall_function("meldung", array ($text."<br><br>", 1));
                exit();
            }
            $upd_conf = new GalliConf(2);
            if ($galerieConfig['gd2'] == 1){$upd_conf->setVar("parm5", 1);}else{$upd_conf->setVar("parm5", 0);}
            $upd_conf->setVar("parm3", 1);
            $result = $upd_conf->store();
            if (!$result){
                $text .= "<h4>"._AD_MA_ACHTUNG."</h4><br>";
                $text .= "<b>konnte Konfiguration nicht in DB Satz 2 speichern !</b><br><br>";
                gall_function("meldung", array ($text."<br><br>", 1));
                exit();
            }
            $gdb = $galerieConfig['gd2']+1;
            $text .= "<img src='".IMG_URL."/galleri_logo.png' width='120' height='116' border='0'><br><br>";
            $text .= "<b>"._AD_MA_GDTEXT1."gd".$gdb._AD_MA_GDTEXT2."</b><br><br>";
            $text .= "<b>"._AD_MA_TESTERROR4._AD_MA_TESTERROR4a."</b><br><br>";
            gall_function("admin_meldung_go_hidden", array ($text, "index.php", "", "", _AD_MA_NEXT));
        }else{
            $text .= "<h4>"._AD_MA_ACHTUNG."</h4><br>";
            $text .= "<b>"._AD_MA_GDTEXT3."GD"._AD_MA_GDTEXT2."</b><br><br>";
            $text .= "<b>"._AD_MA_TESTERROR."</b><br><br>"._AD_MA_TESTERROR3."<br><br>";
            gall_function("meldung", array ($text."<br><br>", 1));
        }
    }
?>
