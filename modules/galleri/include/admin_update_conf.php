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
        $error = "";
        if ($galerieConfig['old_Vers'] >= 2.1 ){                
            $sql = "select parm1, parm2, parm3, parm4, parm5, parm6, parm7, parm8, parm16, parm17 from ".$db->prefix("galli_conf")." where id=1";
            $result=$db->query($sql);
            list($parm1, $parm2, $parm3, $parm4, $parm5, $parm6, $parm7, $parm8, $parm16, $parm17) = $db->fetch_row($result);
            $upd_conf = new GalliConf(1);
            $upd_conf->setVar("parm1", $parm1);
            $upd_conf->setVar("parm2", $parm2);
            $upd_conf->setVar("parm3", $parm3);
            $upd_conf->setVar("parm4", $parm4);
            $upd_conf->setVar("parm5", $parm5);
            $upd_conf->setVar("parm6", $parm6);
            $upd_conf->setVar("parm7", $parm7);
            $upd_conf->setVar("parm8", $parm8);
            $upd_conf->setVar("parm16", $parm16);
            $upd_conf->setVar("parm17", $parm17);                
            $result_store = $upd_conf->store();
            if (!$result_store){
                $error = "galli_conf DS: 1";
                exit();
            }
            
            $sql = "select parm1, parm2, parm7, parm8, parm12, parm13, parm14, parm15 from ".$db->prefix("galli_conf")." where id=2";
            $result=$db->query($sql);
            list($parm1, $parm2, $parm7, $parm8, $parm12, $parm13, $parm14, $parm15) = $db->fetch_row($result);
            $upd_conf = new GalliConf(2);
            $upd_conf->setVar("parm1", $parm1);
            $upd_conf->setVar("parm2", $parm2);
            $upd_conf->setVar("parm7", $parm7);
            $upd_conf->setVar("parm8", $parm8);
            $upd_conf->setVar("parm12", $parm12);
            $upd_conf->setVar("parm13", $parm13);
            $upd_conf->setVar("parm14", $parm14);
            $upd_conf->setVar("parm15", $parm15);
            $result_store = $upd_conf->store();
            if (!$result_store){
                $error = "galli_conf DS: 2";
                exit();
            }
            
            $sql = "select parm1, parm2, parm7, parm8, parm12, parm16, parm17 from ".$db->prefix("galli_conf")." where id=3";
            $result=$db->query($sql);
            list($parm1, $parm2, $parm7, $parm8, $parm12, $parm16, $parm17) = $db->fetch_row($result);
            $upd_conf = new GalliConf(3);
            $upd_conf->setVar("parm1", $parm1);
            $upd_conf->setVar("parm2", $parm2);
            $upd_conf->setVar("parm7", $parm7);
            $upd_conf->setVar("parm8", $parm8);
            $upd_conf->setVar("parm12", $parm12);
            $upd_conf->setVar("parm16", $parm16);
            $upd_conf->setVar("parm17", $parm17);
            $result_store = $upd_conf->store();
            if (!$result_store){
                $error = "galli_conf DS: 3";
                exit();
            }
            
            $sql = "select parm1, parm2, parm3, parm4, parm5, parm6, parm8, parm9, parm10, parm11, parm12, parm13 from ".$db->prefix("galli_conf")." where id=4";
            $result=$db->query($sql);
            list($parm1, $parm2, $parm3, $parm4, $parm5, $parm6, $parm8, $parm9, $parm10, $parm11, $parm12, $parm13) = $db->fetch_row($result);
            $upd_conf = new GalliConf(4);
            $upd_conf->setVar("parm1", $parm1);
            $upd_conf->setVar("parm2", $parm2);
            $upd_conf->setVar("parm3", $parm3);
            $upd_conf->setVar("parm4", $parm4);
            $upd_conf->setVar("parm5", $parm5);
            $upd_conf->setVar("parm6", $parm6);
            $upd_conf->setVar("parm8", $parm8);
            $upd_conf->setVar("parm9", $parm9);
            $upd_conf->setVar("parm10", $parm10);
            $upd_conf->setVar("parm11", $parm11); 
            $upd_conf->setVar("parm12", $parm12);
            $upd_conf->setVar("parm13", $parm13);               
            $result_store = $upd_conf->store();
            if (!$result_store){
                $error = "galli_conf DS: 4";
                exit();
            }
            
            $sql = "select parm1, parm2, parm3, parm4, parm5, parm6, parm8, parm10, parm11, parm12, parm13, parm14 from ".$db->prefix("galli_conf")." where id=5";
            $result=$db->query($sql);
            list($parm1, $parm2, $parm3, $parm4, $parm5, $parm6, $parm8, $parm10, $parm11, $parm12, $parm13, $parm14) = $db->fetch_row($result);
            $upd_conf = new GalliConf(5);
            $upd_conf->setVar("parm1", $parm1);
            $upd_conf->setVar("parm2", $parm2);
            $upd_conf->setVar("parm3", $parm3);
            $upd_conf->setVar("parm4", $parm4);
            $upd_conf->setVar("parm5", $parm5);
            $upd_conf->setVar("parm6", $parm6);
            $upd_conf->setVar("parm8", $parm8);
            $upd_conf->setVar("parm10", $parm10);
            $upd_conf->setVar("parm11", $parm11); 
            $upd_conf->setVar("parm12", $parm12);
            $upd_conf->setVar("parm13", $parm13);   
            $upd_conf->setVar("parm14", $parm14);                            
            $result_store = $upd_conf->store();
            if (!$result_store){
                $error = "galli_conf DS: 5";
                exit();
            }
            
            if ($vers >= 2.2 ){ 
                $sql = "select parm1, parm2, parm3, parm4, parm5, parm7, parm8, parm9, parm16 from ".$db->prefix("galli_conf")." where id=6";
                $result=$db->query($sql);
                list($parm1, $parm2, $parm3, $parm4, $parm5, $parm7, $parm8, $parm9, $parm16) = $db->fetch_row($result);
                $upd_conf = new GalliConf(6);
                $upd_conf->setVar("parm1", $parm1);
                $upd_conf->setVar("parm2", $parm2);
                $upd_conf->setVar("parm3", $parm3);
                $upd_conf->setVar("parm4", $parm4);
                $upd_conf->setVar("parm5", $parm5);
                $upd_conf->setVar("parm7", $parm7);
                $upd_conf->setVar("parm8", $parm8);
                $upd_conf->setVar("parm9", $parm9);
                $upd_conf->setVar("parm16", $parm16); 
                $result_store = $upd_conf->store();
                if (!$result_store){
                    $error = "galli_conf DS: 6";
                    exit();
                }
    
                $sql = "select parm1, parm2, parm3, parm4, parm7, parm8, parm9, parm16 from ".$db->prefix("galli_conf")." where id=7";
                $result=$db->query($sql);
                list($parm1, $parm2, $parm3, $parm4, $parm7, $parm8, $parm9, $parm16) = $db->fetch_row($result);
                $upd_conf = new GalliConf(7);
                $upd_conf->setVar("parm1", $parm1);
                $upd_conf->setVar("parm2", $parm2);
                $upd_conf->setVar("parm3", $parm3);
                $upd_conf->setVar("parm4", $parm4);
                $upd_conf->setVar("parm7", $parm7);
                $upd_conf->setVar("parm8", $parm8);
                $upd_conf->setVar("parm9", $parm9);
                $upd_conf->setVar("parm16", $parm16); 
                $result_store = $upd_conf->store();
                if (!$result_store){
                    $error = "galli_conf DS: 7";
                    exit();
                }
            }
            if ($vers >= 2.3 ){ 
                $sql = "select parm1, parm2, parm3 from ".$db->prefix("galli_conf")." where id=8";
                $result=$db->query($sql);
                list($parm1, $parm2, $parm3) = $db->fetch_row($result);
                $upd_conf = new GalliConf(8);
                $upd_conf->setVar("parm1", $parm1);
                $upd_conf->setVar("parm2", $parm2);
                $upd_conf->setVar("parm3", $parm3);
                $result_store = $upd_conf->store();
                if (!$result_store){
                    $error = "galli_conf DS: 8";
                    exit();
                }
            }
        }else{    
            $error = "admin_apdate_conf default ";
        }
    }
?>