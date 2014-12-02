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
        
        case "addCoAdmin":
          $size = sizeof($uids);
          for ( $i = 0; $i < $size; $i++ ) {
            $sql = "INSERT INTO ".$db->prefix("galli_coadmin")." (cid, uid) VALUES (".$cid.",".$uids[$i].")";
            $db->query($sql); 
          }
          redirect_header("index.php?&op=CoAdmin_config&cid=".$cid."",1,_AD_MA_DBUPDATED);
          break;
        
        case "delCoAdmin":
          $size = sizeof($uids);
          for ( $i = 0; $i < $size; $i++ ) {
            $sql = "DELETE FROM ".$db->prefix("galli_coadmin")." WHERE uid=".$uids[$i]." AND cid=".$cid."";
            $db->query($sql); 
          }
          redirect_header("index.php?&op=CoAdmin_config&cid=".$cid."",1,_AD_MA_DBUPDATED);
          break;    
    
          default:
            gall_cp_header();
              if ( isset($_POST['cid']) ) {
              $cid =  $_POST['cid'];
            } elseif ( isset($_GET['cid']) ) {
              $cid =  $_GET['cid'];
            }
                
            OpenTable();
                include_once(FUNC_INCL_PATH."/func_titel_Verz.php");
              titel_Verz(_AD_MA_RECHTETEXT1, _AD_MA_CATMENUE." ( "._AD_MA_COADMIN." )", "CoAdmin_config");
              echo "<table width=100% border=0 cellspacing=0 cellpadding=2 class='bg1'><tr>";
              echo "<td width=3%>&nbsp;</td>";  
              echo "<td><font size='2'><b>"._AD_MA_COADMINTEXT3."</b><font>";
            include_once(RCX_ROOT_PATH."/class/rcxformloader.php");


                    $form = new RcxThemeForm("", "","");  

		 $retur_button = new RcxFormButton( TIL_HOVEDMENU, "button", "->>---->>", "button");
         $retur_button->setExtra("onClick=\"location='index.php'\"");
             $form->addElement($retur_button); 

        $form->display(); 
              echo "</td><td width=3%>&nbsp;</td></tr></table>";
              CloseTable();
                if ($cid > 0){
                  $result=$db->query("select cname from ".$db->prefix("galli_category")." where cid=$cid");
                  list($cname) = $db->fetch_row($result);
                  echo "<table width=100% border=0 cellspacing=0 cellpadding=2 class='bg1'><tr>";
                  echo "<td width=3%>&nbsp;</td>";  
                  echo "<td><font size='2'><b>"._AD_MA_COADMIN._AD_MA_COADMINTEXT2."$cname</b><font>";
                  echo "</td><td width=3%>&nbsp;</td></tr></table>";
                  $sql = "SELECT l.uid, u.uname FROM ".$db->prefix("galli_coadmin")." l, ".$db->prefix("users")." u WHERE l.cid = ".$cid." AND l.uid=u.uid ORDER BY uname";
                  $result = $db->query($sql);
                  $admins= array();
                  while($myrow = $db->fetch_array($result)){
                    array_push($admins, $myrow);
                  }
                  $sql = "SELECT uid, uname FROM ".$db->prefix("users")." WHERE level>0 ORDER BY uname";
                  $result = $db->query($sql);
                  $users = array();
                  while($myrow = $db->fetch_array($result)){
                    array_push($users, $myrow);
                  }
                  echo "<table width=100% border=0 cellspacing=0 cellpadding=2 class='bg2'><tr><td>&nbsp;";
                  echo "</td></tr><tr><td class='bg1'>";
                  echo "<table border='0' align='center' class='bg1'>
                  
                  <tr><td align='center'>"._AD_NONMEMBERS."</td><td></td><td align='center'>"._AD_MEMBERS."</td></tr>
                  <tr><td align='center'>
                  <form action='index.php' method='post'>
                  <select name='uids[]' size='10' multiple='multiple'>\n";
                  $usersize = sizeof($users);
                  $adminsize = sizeof($admins);
                  for ( $i = 0; $i < $usersize; $i++ ) {
                    $isadmin = 0;
                    for ( $j = 0; $j < $adminsize; $j++ ) {
                      if ( $users[$i]['uid'] == $admins[$j]['uid'] ) {
                        $isadmin = 1;
                        continue;
                      }
                    }
                    if ( !$isadmin ) {
                      echo "<option value='".$users[$i]['uid']."'>".$users[$i]['uname']."</option>\n";
                    }
                  }
                  echo "</select>
                  </td>
                  <td align='center'>
                  <input type='hidden' name='op' value='CoAdmin_config' />
                    <input type='hidden' name='op_pref' value='addCoAdmin' />
                  <input type='hidden' name='cid' value='".$cid."' />
                  <input type='submit' name='submit' value='"._AD_ADDBUTTON."' />
                  </form><br />
                  <form action='index.php' method='post' />
                  <input type='hidden' name='op' value='CoAdmin_config' />
                    <input type='hidden' name='op_pref' value='delCoAdmin' />
                  <input type='hidden' name='cid' value='".$cid."' />
                  <input type='submit' name='submit' value='"._AD_DELBUTTON."' />
                  </td>
                  <td align='center'>
                  <select name='uids[]' size='10' multiple='multiple'>";
                  for ( $i = 0; $i < $adminsize; $i++ ) {
                    echo "<option value='".$admins[$i]['uid']."'>".$admins[$i]['uname']."</option>";
                  }
                  echo "</select>
                  </td></tr>
                  </form>

                  </table>";  
                  echo "</td></tr><tr><td class='bg2'>&nbsp";

				  echo "</td></tr></table>";
                    CloseTable();           
                }
              gall_cp_footer();
          break;
        }
    }

?>