<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm RCX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include("header.php");
include_once(RCX_ROOT_PATH . "/class/rcxcomments.php");
include_once(GALLI_PATH."/class/galltree.php");
$galltree = new GallTree($db->prefix("galli_category"),"cid","scid");
include_once(GALLI_PATH."/class/gall_img.php");
include_once(GALLI_PATH."/class/gall_cat.php");
$id = (int)$_GET['id'];
if (isset($_GET['cid'])) {
   $cid = (int)$_GET['cid'];
 }elseif(isset($_POST['cid'])) {
   $cid = (int)$_POST['cid'];
 }else{
   if ($id == 0){
        ?>
      <html><head>
      <meta http-equiv='refresh' content='0;URL=index.php'>
      </head></html>
        <?php
        exit();
        }else{
            $tempid = new GallImg($id);
            $cid = $tempid->cid();
        }
  }
  $cid_temp = $cid;
    
    if ( ($mode != "0") && ($mode != "thread") && ($mode != "flat") ) {
      if ($rcxUser) {
        $mode = $rcxUser->getVar("umode");
    } else {
      $mode = $rcxConfig['com_mode'];
    }
    }

  include(RCX_ROOT_PATH."/header.php");
  OpenTable();
    gall_function("mainheader2");
  if ($_GET['show']!="") {
    $show = $_GET['show'];
  } else {
    $show = $gallgalerie_perpage;
  }
if (!isset($_GET['min'])) {
  $min = 0;
} else {
   $min = $_GET['min'];
  }
  if (!isset($max)) {
   $max = $min + $show;
}

if(isset($_GET['orderby']))
{
   $orderby = gall_function("convertorderbyin", array($_GET['orderby']));
}
else
{
   $orderby = $galerieConfig['imgcat_sort'];
}

echo "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td align='center'>";
echo "<table width='100%' cellspacing='1' cellpadding='2' border='0' class='bg3'><tr><td align='left' bgcolor='#".$galerieConfig['tb_view2_bgcol']."'>";

$pathstring = "<a href='index.php'>"._MD_MAIN."</a>&nbsp;:&nbsp;";
$nicepath = $galltree->getNicePathFromId($cid, "coment", "viewcat.php?");
$pathstring .= $nicepath;

echo "<b>".$pathstring."</b>";
echo "</td></tr></table><br>";

$u_cat = 0;
$arr=array();
$arr=$galltree->getFirstChild($cid, "cname");

if (count($arr) > 0)
{
   echo "</td></tr>";
   echo "<tr><td align='center'>";
   $u_cat = 1;
   $scount = 0;
   echo "<table width='90%'><tr>";

   foreach($arr as $ele)
   {
      $coment = $myts->makeTboxData4Show($ele['coment']);
      $totalimg = gall_function("getTotalItems", array($ele['cid'], 1));

      echo "<td align='left'><b><a href=viewcat.php?cid=".$ele['cid'].">".$coment."</a></b>&nbsp;(".$totalimg.")&nbsp;&nbsp;</td>";

      $scount++;

      if ($scount == 4)
      {
         echo "</tr><tr>";
         $scount = 0;
      }
   }
   echo "</tr></table><br />";
   echo "<hr /><br>";
}

$numrows = GallImg::countAllImg(array("cid=".$cid." ", "free > 0"));

if ($id > 0)
{
   $store_update_clic = new GallImg($id);
   $store_update_clic->setVar("clic", $store_update_clic->clic() +1);
   $store_update_clic->store();
   $img_Dat = new GallImg($id);
   $image = "./img_Dat->galerie/".$img_Dat->img();
   $size = explode("|",$img_Dat->size());
   $orderby = gall_function("convertorderbyout", array($orderby));

   include(GALLI_PATH."/navig_cat_show.php");
   echo "<center>";
   echo "<table border='".$galerieConfig['haupt_tb1_bo']."' cellspacing='".$galerieConfig['haupt_tb1_cspa']."' cellpadding='".$galerieConfig['haupt_tb1_cpad']."' bordercolor='#".$galerieConfig['haupt_tb1_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb1_bgcol']."'>";
   echo "<tr><td>";
   echo "<table border='".$galerieConfig['haupt_tb2_bo']."' cellspacing='".$galerieConfig['haupt_tb2_cspa']."' cellpadding='".$galerieConfig['haupt_tb2_cpad']."' bordercolor='#".$galerieConfig['haupt_tb2_bordcol']."' bgcolor='#".$galerieConfig['haupt_tb2_bgcol']."'>";
   echo "<tr><td>";
   echo "<table border='0' cellspacing='0' cellpadding='0'>";
   echo "<tr>";

   if ($galerieConfig['img_back'] == 1)
   {
      // ALT tag
      echo "<td style='background-image:url(".GAL_URL."/".$img_Dat->img().")'>";
      echo "<img src='".IMG_URL."/blank.gif' border='0' width='".$size[0]."' height='".$size[1]."' alt='".$img_Dat->alt()."'>";
   }
   else
   {
      echo "<td><img src='".GAL_URL."/".$img_Dat->img()."' border='0' width='".$size[0]."' height='".$size[1]."' alt='".$img_Dat->alt()."'>";
   }

   echo "</td></tr></table>";
   echo "</td></tr></table>";
   echo "</td></tr></table>";
   echo "</center>";

   if ($galerieConfig['votum'] == 1 || $galerieConfig['link_yn'] == 1)
   {
      echo "<br><table width='80%' border='0' cellspacing='0' cellpadding='2' align='center' class='bg2'>";
      echo "<tr><td bgcolor='#".$galerieConfig['tb_view2_bgcol']."' align='center'>";

      if ($galerieConfig['votum'] == 1)
      {
         echo "<a href='rateimg.php?id=".$img_Dat->id()."&image=".$image."&cid=".$cid."&min=".$prev."&orderby=".$orderby."&show=".$show."'>"._MD_VOTE."</a>";
      }

      if ($galerieConfig['votum'] == 1 && $galerieConfig['link_yn'] == 1)
      {
         echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
      }

      if ($galerieConfig['link_yn'] == 1)
      {
         $ende  = strrpos($galerieConfig['link_url'],"=");
         $laenge = strlen($galerieConfig['link_url']);
         if ($ende == $laenge-1)
         {
            $galerieConfig['link_url'] .= $img_Dat->id();
         }
         echo "<a href='".$galerieConfig['link_url']."'>".$galerieConfig['link_text']."</a>";
      }
      echo "</td></tr></table><br>";
   }
   else
   {
      echo"<p><hr align='center' width='30%'></p>";
   }
   $td_bgcol = "#".$galerieConfig['tb_view2_bgcol'];
   echo "<table width='80%' border='0' cellspacing='0' cellpadding='0' align='center'><tr><td>";
   echo "<table width='100%' border='0' cellspacing='1' cellpadding='2' align='center' bgcolor='#".$galerieConfig['tb_view2_bgcol']."'>";

   if ($img_Dat->coment() != "")
   {
      echo "<tr><td valign='top' align='right'><b>"._BA_DESCRIPTION.":</b></td><td>".$myts->makeTareaData4Show($img_Dat->coment(),1,1,1)."</td></tr>";
   }
   echo "<tr><td width='35%' align='right'><b>"._IMGSIZE.":</b></td><td>".$size[0]." x ".$size[1]."</td></tr>";
   $member = gall_function("test_member", array($img_Dat->email()));

   if ($member > 0)
   {
      $aut_user = new RcxUser($member);
      if ($aut_user->url() !="")
      {
         $autor = "<a href='".$aut_user->url()."' target='_blank'>".$aut_user->uname()."</a>";
      }
      else
      {
         $autor = $aut_user->uname();
      }
   }
   else
   {
      $autor = "";
   }

   if ($autor != "")
   {
      echo "<tr><td align='right'><b>Autor: </b></td><td>".$autor."</td></tr>";
   }

   echo "<tr><td align='right'><b>"._IMGTITEL.":</b></td><td>".$img_Dat->titre()."</td></tr>";
   $cat_Dat = new GallCat($img_Dat->cid());
   echo "<tr><td align='right'><b>"._CATEGORY.":</b></td><td>".$cat_Dat->coment()."</td></tr>";

   if ($galerieConfig['popdruck'] == 1)
   {
      $br=$size[0]+20;$ho=$size[1]+5;
      echo "<tr><td align='right'><b>"._EXPRESSION.":</b></td><td><a href=\"javascript:openWithSelfMain('show-pop.php?id=".GAL_URL."/".$img_Dat->img()."&img=".$img_Dat->img()."','popup','".$br."','".$ho."')\"><img src='images/print.gif' border='0' alt='"._EXPRESSION."'></a></td></tr>";
   }

 /*  if ($galerieConfig['imgversand'])
   {
      echo "<tr><td align='right'><b>"._ECARDTRANS.":</b></td><td><a href='carte.php?id=".$img_Dat->id()."'><img src='images/friend.gif' border='0' alt='"._ECARDTRANS."'></a></td></tr>";
   }*/

   if ($galerieConfig['votum'] == 1)
   {
      echo "<tr><td align='right'><b>"._CLICS.":</b></td><td>".$img_Dat->clic()."</td></tr>";
      echo "<tr><td align='right'><b>"._RATING.":</b></td><td>".$img_Dat->rating()."&nbsp;&nbsp;( ".$img_Dat->vote()." ";
      if ($vote == 1)
      {
         echo ""._VOTE."";
      }
      else
      {
         echo ""._VOTES."";
      }
      echo " )</td></tr>";
   }

   echo "</table></td></tr></table>";

   if ($galerieConfig['coment'] == 1)
   {
      if ($galerieConfig['coment_anon'] == 1)
      {
         $rcxConfig['anonpost'] = 1;
      }
      else if (!$rcxUser)
      {
         echo "<br><center>"._NW_EDITNOREGUSER."</center><br>";
      }


      if (!empty($comment_id))
      {
         $artcomment = new RcxComments($db->prefix("galli_comments"), $comment_id);
      }
      else
      {
         $artcomment = new RcxComments($db->prefix("galli_comments"));
      }
      $item_id = $id;
      $orderby = ($order == 1) ? "date DESC" : "date ASC";
      if ($mode == "flat")
      {
         $criteria = array("item_id=".$item_id."");
         $commentsArray = $artcomment->getAllComments($criteria, true, $orderby);
      }
      elseif ($mode=="thread")
      {
         $criteria = array("item_id=".$item_id."", "pid=".$artcomment->getVar("pid")."");
         $commentsArray = $artcomment->getAllComments($criteria, true, $orderby);
      }
      else
      {
         $commentsArray = "";
      }

      if (is_array($commentsArray) && count($commentsArray) || $galerieConfig['coment_anon'] == 1 || $rcxUser)
      {
         $artcomment->printNavBar($item_id, $mode, $order);
      }

      if (is_array($commentsArray) && count($commentsArray))
      {
         if ($rcxUser && $rcxUser->isAdmin($rcxModule->mid()))
         {
            $adminview = 1;
         }
         else
         {
            $adminview = 0;
         }

         if ($mode=="flat")
         {
            $count = 0;

            foreach($commentsArray as $ele)
            {
               if (!($count % 2))
               {
                  $color_num = 1;
               }
               else
               {
                  $color_num = 2;
               }
               $ele->showThreadPost($order, $mode, $adminview, $color_num);
               $count++;
            }
         }

         if ($mode=="thread")
         {
            foreach($commentsArray as $ele)
            {
               $ele->showThreadPost($order, $mode, $adminview);
               if ($ele->getVar("pid") != 0)
               {
                  echo "<div style='text-align:left'>";
                  echo "<a href='./article.php?item_id=".$ele->getVar("item_id")."&amp;mode=".$mode."&amp;order=".$order."'>"._TOP."</a> | ";
                  echo "<a href='./article.php?item_id=".$ele->getVar("item_id")."&amp;comment_id=".$ele->getVar("pid")."&amp;mode=".$mode."&amp;order=".$order."#".$ele->getVar("pid")."'>"._PARENT."</a>";
                  echo "</div>";
               }

               echo "<br />";
               $treeArray = $ele->getCommentTree();

               if (count($treeArray) >0)
               {
                  $ele->showTreeHead();
                  $count = 0;
                  foreach ($treeArray as $treeItem)
                  {
                     if (!($count % 2))
                     {
                        $color_num = 1;
                     }
                     else
                     {
                        $color_num = 2;
                     }
                     $treeItem->showTreeItem($order, $mode, $color_num);
                     $count++;
                  }
                  $ele->showTreeFoot();
               }
            }
            echo "<br />";
         }
      }
   }
}
elseif($numrows>0)
{
   $images_list = GallImg::getAllImg(array("cid=".$cid." ", "free > 0"), true, $orderby, $show, $min);
   if($numrows>1)
   {
      $orderbyTrans = gall_function("convertorderbytrans", array($orderby));

      echo "<br /><small><center>"._MD_SORTBY."&nbsp;&nbsp;
           "._MD_TITLE." (<a href='viewcat.php?cid=$cid&orderby=titreA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=titreD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
           "._MD_DATE." (<a href='viewcat.php?cid=$cid&orderby=dateA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=dateD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
           "._MD_RATING." (<a href='viewcat.php?cid=$cid&orderby=ratingA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href=viewcat.php?cid=$cid&orderby=ratingD><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
           "._MD_POPULARITY." (<a href='viewcat.php?cid=$cid&orderby=clicA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewcat.php?cid=$cid&orderby=clicD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>)
           ";
      echo "<br /><b><small>";
      printf(_MD_CURSORTBY,$orderbyTrans);
      echo "</small></b><br /><br /></center>";
   }
   else
   {
      echo "<br>";
   }
   echo "<table width='100%' cellspacing='0' cellpadding='10' border='0'>";
   echo "<tr><td>";

   $br = 100/$galerieConfig['perpage_width'];
   $x=0;
   $b=1;
   $h=1;
   $orderby = gall_function("convertorderbyout", array($orderby));

   foreach ($images_list as $img_Dat)
   {
      $rating = number_format($rating, 2);
      $cname = $myts->makeTboxData4Show($img_Dat->cname());
      $nom = $myts->makeTboxData4Show($img_Dat->nom());
      $titre = $myts->makeTboxData4Show($img_Dat->titre());
      $email = $myts->makeTboxData4Show($img_Dat->email());

      $clic = number_format($img_Dat->clic(), 0);
      $vote = number_format($img_Dat->vote(), 0);
      $img = $myts->makeTboxData4Show($img_Dat->img());
      $datetime = formatTimestamp($img_Dat->date(),"s");
      $coment = $myts->makeTareaData4Show($img_Dat->coment(), 1, 1, 1);
      // ALT tag
      $alt = $myts->makeTboxData4Show($img_Dat->alt());
      include(RCX_ROOT_PATH."/modules/galleri/template/cat/detail.php");
      $x++;
   }
   echo "</td></tr></table>";
   $cid= $cid_temp;

   if (gall_function("coadmin_bere", array($cid)))
   {
      echo "<form action='".GAL_ADMIN_URL."/coadmin.php' method='post'><input type='hidden' name='cid' value='".$cid."'><input type='hidden' name='op_coad' value='".$cid."'><input type='submit' class='button' name='Submit' value='"._COADMIN."'></form>";
   }
   elseif ($galerieConfig['imguploadano'] == 1||( $galerieConfig['imguploadreg'] == 1 and $rcxUser)||gall_function("upload_bere", array($cid)))
   {
      echo "<form action='".RCX_URL."/modules/galleri/uploaduser.php' method='post'><input type='hidden' name='cid' value='".$cid."'><input type='submit' class='button' name='Submit' value='"._YOUUPLOAD."'></form>";
   }
   $imgpages = ceil($numrows / $show);
   echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='40' align='center'>";
   if ($numrows % $show == 0)
   {
      $imgpages = $imgpages - 1;
   }
   if ($imgpages!=1 && $imgpages!=0)
   {
      $prev = $min - $show;
      if ($prev>=0)
      {
         echo "<a href='viewcat.php?cid=$cid&min=$prev&orderby=$orderby&show=$show'>";
         echo "<img src='".IMG_URL."/left.gif' align='center' valign='absmiddle' border='0' alt='"._MD_PREVIOUS."'></a>";
      }
      else
      {
         echo "&nbsp;";
      }
      echo "</td><td>";
      $counter = 1;
      $currentpage = ($max / $show);
      while ($counter<=$imgpages)
      {
         $mintemp = ($show * $counter) - $show;
         if ($counter == $currentpage)
         {
            echo "<b>$counter</b>&nbsp;";
         }
         else
         {
            echo "<a href='viewcat.php?cid=$cid&min=$mintemp&orderby=$orderby&show=$show'>$counter</a>&nbsp;";
         }
         $counter++;
      }
      echo "</td><td width='40' align='center'>";
      if ($numrows>$max)
      {
         echo "<a href='viewcat.php?cid=$cid&min=$max&orderby=$orderby&show=$show'>";
         echo "<img src='".IMG_URL."/right.gif' border='0' alt='"._MD_NEXT."'></a>";
      }
      else
      {
         echo "&nbsp;";
      }
   }
   echo "</td></tr></table>";
}
else
{
   echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
   echo "<td class='bg1' width='100%' align='center'>";
   if ($u_cat == 0 && $galerieConfig['hase_yn'] == 1)
   {
      // ALT tag
      gall_function("makeRahmen", array($link, "./images/hase_cat.jpg", "./images/hase_cat.jpg", $img_Dat->alt() ));
   }
   elseif ($u_cat > 0)
   {
      echo "<br><br><b>"._U_CAT."</b><br><br>";
   }
   echo "</td></tr></table>";
   if (gall_function("coadmin_bere", array($cid)))
   {
      echo "<form action='".GAL_ADMIN_URL."/coadmin.php' method='post'><input type='hidden' name='cid' value='".$cid."'><input type='hidden' name='op_coad' value='".$cid."'><input type='submit' class='button' name='Submit' value='"._COADMIN."'></form>";
   }
   elseif ($galerieConfig['imguploadano'] == 1||( $galerieConfig['imguploadreg'] == 1 and $rcxUser)||gall_function("upload_bere", array($cid)))
   {
      echo "<form action='".RCX_URL."/modules/galleri/uploaduser.php' method='post'><input type='hidden' name='cid' value='".$cid."'><input type='submit' class='button' name='Submit' value='"._YOUUPLOAD."'></form>";
   }
}
echo "</td></tr></table>";

CloseTable();

include("footer.php");
include(RCX_ROOT_PATH."/footer.php");
?>
