<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    include("header.php");
    include_once(RCX_ROOT_PATH."/class/module.textsanitizer.php");
    $myts = new MyTextSanitizer; 
    include_once(GALLI_PATH."/include/user.errorhandler.php");
    include_once(GALLI_PATH."/class/gall_img.php");
    if(isset($_POST['cid'])) {
      $cid = $_POST['cid'];
      $prev = $_POST['prev'];
      $orderby = $_POST['orderby'];
      $show = $_POST['show'];
    }
    if($_POST['submit']) {
      $eh = new ErrorHandler;
      if(!$rcxUser){
        $ratinguser = 0;
      }else{
        $ratinguser = $rcxUser->uid();
      }
        $anonwaitdays = 1;
        $ip = getenv("REMOTE_ADDR");
      $id = (int)$_POST['id'];
      $rating = $_POST['rating'];
        if ($rating=="--") {
        $eh->show("0050");
        exit();
      }
      //$id = $_POST['id'];
        if ($ratinguser != 0) {
            $result=$db->query("select email from ".$db->prefix("galli_img")." where id=$id");
            while(list($ratinguserDB) = $db->fetch_row($result)) {
              if ($ratinguserDB == $ratinguser) {
            $eh->show("0051");
            exit();
                }
            }
          $result=$db->query("select ratinguser from ".$db->prefix("galli_vote")." where id=$id");
            while(list($ratinguserDB) = $db->fetch_row($result)) {
              if ($ratinguserDB == $ratinguser) {
            $eh->show("0052");
            exit();
                }
            }
        }
        if ($ratinguser == 0){
          $yesterday = (time()-(86400 * $anonwaitdays));
            $result=$db->query("select count(*) FROM ".$db->prefix("galli_vote")." WHERE id=$id AND ratinguser=0 AND ratinghostname = '$ip' AND ratingtimestamp > $yesterday");
          list($anonvotecount) = $db->fetch_row($result);
          if ($anonvotecount > 0) {
          $eh->show("0052");
          exit();
            }
        }
      if($rating > 10){
        $rating = 10;
      }
      $newid = $db->genId("galli_vote_ratingid_seq");
      $datetime = time();
        $db->query("INSERT INTO ".$db->prefix("galli_vote")." (ratingid, id, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES ($newid, $id, $ratinguser, $rating, '$ip', $datetime)") or $eh->show("0013");
//        updaterating($id);
        gall_function("updaterating", array($id)); 
      $ratemessage = _MD_VOTEAPPRE."<br>".sprintf(_MD_THANKURATE,$rcxConfig[sitename]);
      redirect_header("viewcat.php?id=$id&cid=$cid&min=$prev&orderby=$orderby&show=$show",2,$ratemessage);
      exit();
    }else{
        include(RCX_ROOT_PATH."/header.php");
      $vote_img = new GallImg($id);
        OpenTable();
        gall_function("mainheader", array("thumbnails/".$vote_img->img())); 
        $result=$db->query("select titre from ".$db->prefix("galli_img")." where id=$id");
      list($titre) = $db->fetch_row($result);
      
      $titre = $myts->makeTboxData4Show($titre);
        echo "<hr size='1' noshade>";
      echo "<table border='0' cellpadding='1' cellspacing='0' width='80%'><tr><td>";
        echo "<h4><center>$titre</center></h4>";
        echo "<UL>";
        echo "<LI>"._MD_VOTEONCE."";
        echo "<LI>"._MD_RATINGSCALE."";
        echo "<LI>"._MD_BEOBJECTIVE."";
        echo "<LI>"._MD_DONOTVOTE."";
        echo "</UL></td></tr><tr><td align='center'>";
        echo "<form method='POST' action='rateimg.php'>";
      echo "<input type='hidden' name='id' value='".$id."'>";
      echo "<input type='hidden' name='cid' value='".$cid."'>";
      echo "<input type='hidden' name='orderby' value='".$orderby."'>";
      echo "<input type='hidden' name='show' value='".$show."'>";
      echo "<input type='hidden' name='prev' value='".$prev."'>";
      echo "<input type='hidden' name='image' value='".$image."'>";
        echo "<select name='rating'>";
        echo "<option>--</option>";
        for($i=10;$i>0;$i--){
        echo "<option value='".$i."'>".$i."</option>";
      }
        echo "</select>&nbsp;&nbsp;<input type='submit' class='button' name='submit' value='"._MD_RATEIT."'>";
      echo "&nbsp;<input type=button class='button' value="._MD_CANCEL." onclick='javascript:history.go(-1)'>";
        echo "</form></td></tr></table>";
        CloseTable(); 
    }
    
    include("footer.php");
    include(RCX_ROOT_PATH."/footer.php");
?>