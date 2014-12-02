<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("./header.php");


if ( $rcxConfig['startpage'] == "members" ) {
  $rcxOption['show_rblock'] = 1;
  include_once(RCX_ROOT_PATH."/header.php");
  make_cblock();
  echo "<br />";
  } else {
    $rcxOption['show_rblock'] = 0;
    include_once(RCX_ROOT_PATH."/header.php");
  }
global $rcxConfig, $rcxUser;

if (!$rcxUser) {
  header("Location:".RCX_URL."/whyregister.php");
}
else {

$op = "form";
if ( $_POST['op'] == "submit" ) {
  $op = "submit";
}

OpenTable();

if ( $op == "form" ) {
  $total = RcxUser::countAllUsers(array("level>0"));
  include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
  $uname_text  = new RcxFormText("", "user_uname", 30, 60);
  $uname_match = new RcxFormSelectMatchOption("", "user_uname_match");
  $uname_tray  = new RcxFormElementTray(_MM_UNAME, "&nbsp;");
  $uname_tray->addElement($uname_match);
  $uname_tray->addElement($uname_text);
  $name_text  = new RcxFormText("", "user_name", 30, 60);
  $name_match = new RcxFormSelectMatchOption("", "user_name_match");
  $name_tray  = new RcxFormElementTray(_MM_REALNAME, "&nbsp;");
  $name_tray->addElement($name_match);
  $name_tray->addElement($name_text);
  $email_text  = new RcxFormText("", "user_email", 30, 60);
  $email_match = new RcxFormSelectMatchOption("", "user_email_match");
  $email_tray  = new RcxFormElementTray(_MM_EMAIL, "&nbsp;");
  $email_tray->addElement($email_match);
  $email_tray->addElement($email_text);
  $url_text = new RcxFormText(_MM_URLC, "user_url", 30, 100);
  //$theme_select = new RcxFormSelectTheme(_MM_THEME, "user_theme");
  //$timezone_select = new RcxFormSelectTimezone(_MM_TIMEZONE, "user_timezone_offset");
  $icq_text  = new RcxFormText("", "user_icq", 30, 100);
  $icq_match = new RcxFormSelectMatchOption("", "user_icq_match");
  $icq_tray  = new RcxFormElementTray(_MM_ICQ, "&nbsp;");
  $icq_tray->addElement($icq_match);
  $icq_tray->addElement($icq_text);
  $aim_text  = new RcxFormText("", "user_aim", 30, 100);
  $aim_match = new RcxFormSelectMatchOption("", "user_aim_match");
  $aim_tray  = new RcxFormElementTray(_MM_AIM, "&nbsp;");
  $aim_tray->addElement($aim_match);
  $aim_tray->addElement($aim_text);
  $yim_text  = new RcxFormText("", "user_yim", 30, 100);
  $yim_match = new RcxFormSelectMatchOption("", "user_yim_match");
  $yim_tray  = new RcxFormElementTray(_MM_YIM, "&nbsp;");
  $yim_tray->addElement($yim_match);
  $yim_tray->addElement($yim_text);
  $msnm_text  = new RcxFormText("", "user_msnm", 30, 100);
  $msnm_match = new RcxFormSelectMatchOption("", "user_msnm_match");
  $msnm_tray  = new RcxFormElementTray(_MM_MSNM, "&nbsp;");
  $msnm_tray->addElement($msnm_match);
  $msnm_tray->addElement($msnm_text);
  $location_text   = new RcxFormText(_MM_LOCATION, "user_from", 30, 100);
  $occupation_text = new RcxFormText(_MM_OCCUPATION, "user_occ", 30, 100);
  $interest_text   = new RcxFormText(_MM_INTEREST, "user_intrest", 30, 100);

  //$bio_text = new RcxFormText(_MM_EXTRAINFO, "user_bio", 30, 100);
  $lastlog_more = new RcxFormText(_MM_LASTLOGMORE, "user_lastlog_more", 10, 5);
  $lastlog_less = new RcxFormText(_MM_LASTLOGLESS, "user_lastlog_less", 10, 5);
  $reg_more     = new RcxFormText(_MM_REGMORE, "user_reg_more", 10, 5);
  $reg_less     = new RcxFormText(_MM_REGLESS, "user_reg_less", 10, 5);
  $posts_more   = new RcxFormText(_MM_POSTSMORE, "user_posts_more", 10, 5);
  $posts_less   = new RcxFormText(_MM_POSTSLESS, "user_posts_less", 10, 5);
  $sort_select  = new RcxFormSelect(_MM_SORT, "user_sort");
  $sort_select->addOptionArray(array("uname"=>_MM_UNAME,"email"=>_MM_EMAIL,"last_login"=>_MM_LASTLOGIN,"user_regdate"=>_MM_REGDATE,"posts"=>_MM_POSTS));
  $order_select = new RcxFormSelect(_MM_ORDER, "user_order");
  $order_select->addOptionArray(array("ASC"=>_MM_ASC,"DESC"=>_MM_DESC));
  $limit_text    = new RcxFormText(_MM_LIMIT, "limit", 6, 2);
  $op_hidden     = new RcxFormHidden("op", "submit");
  $submit_button = new RcxFormButton("", "user_submit", _SUBMIT, "submit");

  $form = new RcxThemeForm("", "uesr_findform", "index.php");
  $form->addElement($uname_tray);
  $form->addElement($name_tray);
  $form->addElement($email_tray);
  //$form->addElement($theme_select);
  //$form->addElement($timezone_select);
  $form->addElement($icq_tray);
  $form->addElement($aim_tray);
  $form->addElement($yim_tray);
  $form->addElement($msnm_tray);
  $form->addElement($url_text);
  $form->addElement($location_text);
  $form->addElement($occupation_text);
  $form->addElement($interest_text);
  //$form->addElement($bio_text);
  $form->addElement($lastlog_more);
  $form->addElement($lastlog_less);
  $form->addElement($reg_more);
  $form->addElement($reg_less);
  $form->addElement($posts_more);
  $form->addElement($posts_less);
  $form->addElement($sort_select);
  $form->addElement($order_select);
  $form->addElement($limit_text);
  $form->addElement($op_hidden);
  $form->addElement($submit_button);
  echo "<h4 style='text-align:left;'>"._MM_SEARCH."</h4>(".sprintf(_MM_TOTALUSERS, "<span style='color:#ff0000;'>$total</span>").")";
  $form->display();
}

if ( $op == "submit" ) {
  $iamadmin = false;
  if ($rcxUser && $rcxUser->isAdmin(1)) {
    $iamadmin = true;
  }
  $criteria = array();
  if ( !empty($_POST['user_uname']) ) {
    $match = (!empty($_POST['user_uname_match'])) ? intval($_POST['user_uname_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "uname LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_uname']))."%'";
        break;

      case RCX_MATCH_END:
        $criteria[] = "uname LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_uname']))."'";
        break;

      case RCX_MATCH_EQUAL:
        $criteria[] = "uname = '".$myts->oopsAddSlashesGPC(trim($_POST['user_uname']))."'";
        break;

      case RCX_MATCH_CONTAIN:
        $criteria[] = "uname LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_uname']))."%'";
        break;
    }
  }

  if ( !empty($_POST['user_name']) ) {
    $match = (!empty($_POST['user_name_match'])) ? intval($_POST['user_name_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "name LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_name']))."%'";
        break;

      case RCX_MATCH_END:
        $criteria[] = "name LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_name']))."'";
        break;

      case RCX_MATCH_EQUAL:
        $criteria[] = "name = '".$myts->oopsAddSlashesGPC(trim($_POST['user_name']))."'";
        break;

      case RCX_MATCH_CONTAIN:
        $criteria[] = "name LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_name']))."%'";
        break;
    }
  }

  if ( !empty($_POST['user_email']) ) {
    $match = (!empty($_POST['user_email_match'])) ? intval($_POST['user_email_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "email LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_email']))."%'";
        break;

      case RCX_MATCH_END:
        $criteria[] = "email LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_email']))."'";
        break;

      case RCX_MATCH_EQUAL:
        $criteria[] = "email = '".$myts->oopsAddSlashesGPC(trim($_POST['user_email']))."'";
        break;

      case RCX_MATCH_CONTAIN:
        $criteria[] = "email LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_email']))."%'";
        break;
    }
    if ( !$iamadmin ) {
      $criteria[] = "user_viewemail=1";
    }
  }

  if ( !empty($_POST['user_url']) ) {
    $url = formatURL(trim($_POST['user_url']));
    $criteria[] = "url LIKE '".$myts->oopsAddSlashesGPC($url)."%'";
  }

  if ( !empty($_POST['user_icq']) ) {
    $match = (!empty($_POST['user_icq_match'])) ? intval($_POST['user_icq_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "user_icq LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_icq']))."%'";
        break;

      case RCX_MATCH_END:
        $criteria[] = "user_icq LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_icq']))."'";
        break;

      case RCX_MATCH_EQUAL:
        $criteria[] = "user_icq = '".$myts->oopsAddSlashesGPC(trim($_POST['user_icq']))."'";
        break;

      case RCX_MATCH_CONTAIN:
        $criteria[] = "user_icq LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_icq']))."%'";
        break;
    }
  }

  if ( !empty($_POST['user_aim']) ) {
    $match = (!empty($_POST['user_aim_match'])) ? intval($_POST['user_aim_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "user_aim LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_aim']))."%'";
        break;

      case RCX_MATCH_END:
        $criteria[] = "user_aim LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_aim']))."'";
        break;

      case RCX_MATCH_EQUAL:
        $criteria[] = "user_aim = '".$myts->oopsAddSlashesGPC(trim($_POST['user_aim']))."'";
        break;

      case RCX_MATCH_CONTAIN:
        $criteria[] = "user_aim LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_aim']))."%'";
        break;
    }
  }
  if ( !empty($_POST['user_yim']) ) {
    $match = (!empty($_POST['user_yim_match'])) ? intval($_POST['user_yim_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "user_yim LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_yim']))."%'";
        break;
      case RCX_MATCH_END:
        $criteria[] = "user_yim LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_yim']))."'";
        break;
      case RCX_MATCH_EQUAL:
        $criteria[] = "user_yim = '".$myts->oopsAddSlashesGPC(trim($_POST['user_yim']))."'";
        break;
      case RCX_MATCH_CONTAIN:
        $criteria[] = "user_yim LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_yim']))."%'";
        break;
    }
  }
  if ( !empty($_POST['user_msnm']) ) {
    $match = (!empty($_POST['user_msnm_match'])) ? intval($_POST['user_msnm_match']) : RCX_MATCH_START;
    switch ($match) {
      case RCX_MATCH_START:
        $criteria[] = "user_msnm LIKE '".$myts->oopsAddSlashesGPC(trim($_POST['user_msnm']))."%'";
        break;
      case RCX_MATCH_END:
        $criteria[] = "user_msnm LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_msnm']))."'";
        break;
      case RCX_MATCH_EQUAL:
        $criteria[] = "user_msnm = '".$myts->oopsAddSlashesGPC(trim($_POST['user_msnm']))."'";
        break;
      case RCX_MATCH_CONTAIN:
        $criteria[] = "user_msnm LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_msnm']))."%'";
        break;
    }
  }
  if ( !empty($_POST['user_from']) ) {
    $criteria[] = "user_from LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_from']))."%'";
  }
  if ( !empty($_POST['user_intrest']) ) {
    $criteria[] = "user_intrest LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_intrest']))."%'";
  }
  if ( !empty($_POST['user_occ']) ) {
    $criteria[] = "user_occ LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_occ']))."%'";
  }
//  if ( !empty($_POST['user_bio']) ) {
//    $criteria[] = "bio LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_bio']))."%'";
//  }
//  if ( isset($_POST['user_timezone_offset']) && $_POST['user_timezone_offset'] != "" ) {
//    $criteria[] = "timezone_offset=".intval($_POST['user_timezone_offset'])."";
//  }

  if ( !empty($_POST['user_lastlog_more']) && is_numeric($_POST['user_lastlog_more']) ) {
    $f_user_lastlog_more = intval(trim($_POST['user_lastlog_more']));
    $time = time() - (86400 * $f_user_lastlog_more);
    if ( $time > 0 ) {
      $criteria[] = "last_login < $time";
      $criteria[] = "last_login != 0";
    }
  }
  if ( !empty($_POST['user_lastlog_less']) && is_numeric($_POST['user_lastlog_less']) ) {
    $f_user_lastlog_less = intval(trim($_POST['user_lastlog_less']));
    $time = time() - (86400 * $f_user_lastlog_less);
    if ( $time > 0 ) {
      $criteria[] = "last_login > $time";
    }
  }
  if ( !empty($_POST['user_reg_more']) && is_numeric($_POST['user_reg_more']) ) {
    $f_user_reg_more = intval(trim($_POST['user_reg_more']));
    $time = time() - (86400 * $f_user_reg_more);
    if ( $time > 0 ) {
      $criteria[] = "user_regdate < $time";
    }
  }
  if ( !empty($_POST['user_reg_less']) && is_numeric($_POST['user_reg_less']) ) {
    $f_user_reg_less = intval($_POST['user_reg_less']);
    $time = time() - (86400 * $f_user_reg_less);
    if ( $time > 0 ) {
      $criteria[] = "user_regdate > $time";
    }
  }
  if ( !empty($_POST['user_posts_more']) && is_numeric($_POST['user_posts_more']) ) {
    $criteria[] = "posts > ".intval($_POST['user_posts_more'])."";
  }
  if ( !empty($_POST['user_posts_less']) && is_numeric($_POST['user_posts_less']) ) {
    $criteria[] = "posts < ".intval($_POST['user_posts_less'])."";
  }
  $criteria[] = "level>0";
  $validsort = array("uname", "email", "last_login", "user_regdate", "posts");
  $sort = (!in_array($_POST['user_sort'], $validsort)) ? "uname" : $_POST['user_sort'];
  $order = "ASC";
  if ( isset($_POST['user_order']) && $_POST['user_order'] == "DESC") {
    $order = "DESC";
  }
  $limit = (!empty($_POST['limit'])) ? intval($_POST['limit']) : 20;
  if ( $limit > 50 ) {
    $limit = 50;
  }
  $start = (!empty($_POST['start'])) ? intval($_POST['start']) : 0;
  $total = RcxUser::countAllUsers($criteria);
  echo "<a href='index.php'>". _MM_SEARCH ."</a>&nbsp;<span style='font-weight:bold;'>&raquo;&raquo;</span>&nbsp;". _MM_RESULTS."<br /><br />";
  if ( $total == 0 ) {
    echo "<h4>"._MM_NOFOUND,"</h4>";
    } elseif ( $start < $total ) {
    echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='bg2'>
    <table width='100%' border='0' cellspacing='1' cellpadding='4'><tr class='bg3'><td align='center'><b>"._MM_AVATAR."</b></td><td align='center'><b>"._MM_UNAME."</b></td><td align='center'><b>"._MM_REALNAME."</b></td><td align='center'><b>"._MM_EMAIL."</b></span></td><td align='center'><b>"._MM_PM."</b></td><td align='center'><b>"._MM_URL."</b></td><td align='center'><b>"._MM_REGDATE."</b></td><td align='center'><b>"._MM_LASTLOGIN."</b></td><td align='center'><b>"._MM_POSTS."</b></td>";
    if ( $iamadmin ) {
      echo "<td align='center'>&nbsp;</td>";
    }
    echo "</tr>";
    $foundusers =& RcxUser::getAllUsers($criteria, true, "$sort $order", $limit, $start);
    foreach ($foundusers as $fuser) {
      $fuser_uid = $fuser->getVar('uid');
      $thisUser= new RcxUser($fuser_uid);
      $fuser_avatar = $fuser->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$fuser->getVar("user_avatar")."' alt='' />" : "&nbsp;";
      $fuser_name = $fuser->getVar("name") ? $fuser->getVar("name") : "&nbsp;";
      echo "<tr class='bg1'><td>".$fuser_avatar."</td><td><a href='".RCX_URL."/userinfo.php?uid=".$fuser->getVar("uid")."'>".$fuser->getVar("uname")."</a></td><td>".$fuser_name."</td><td align='center'>";
      if ( ($rcxUser && $fuser->getVar("user_viewemail") == 1) || $iamadmin ) {
        echo "<a href='mailto:".$fuser->getVar("email")."'><img src='".RCX_URL."/images/icons/email.gif' border='0' alt='";
        printf(_SENDEMAILTO, $fuser->getVar("uname", "E"));
        echo "' /></a>";
        } else {
          echo "&nbsp;";
        }

      $module = RcxModule::getByDirname('pm');
      echo "</td><td align='center'>";
      if ( $rcxUser  && RcxModule::moduleExists('pm') && $module->isActivated() && RcxGroup::checkRight('module', $module->mid(), $rcxUser->groups())) {
        if ( !RcxGroup::checkRight('module', $module->mid(), $thisUser->groups()) ){
        echo _US_NOT_AUTORIZED_PM;  
        }else{
        echo "<a href='".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$fuser->getVar("uid")."'><img src='".RCX_URL."/images/icons/pm.gif' border='0' alt='";
        printf(_SENDPMTO,$fuser->getVar("uname", "E"));
        echo "' /></a>";
        }
      } else {
        echo "&nbsp;";
        }
      echo "</td><td align='center'>";
      if ( $fuser->getVar("url","E") != "" ) {
        echo "<a href='".$fuser->getVar("url","E")."' target='_blank'><img src='".RCX_URL."/images/icons/www.gif' border='0' alt='"._VISITWEBSITE."' /></a>";
        } else {
          echo "&nbsp;";
        }
      echo "</td><td align='center'>".formatTimeStamp($fuser->getVar("user_regdate"),"s")."</td><td align='center'>";
      if ( $fuser->getVar("last_login") != 0 ) {
        echo formatTimeStamp($fuser->getVar("last_login"),"m");
        } else {
          echo "&nbsp;";
        }
      echo "</td><td align='center'>".$fuser->getVar("posts")."</td>";
      if ( $iamadmin ) {
        echo "<td align='center'><a href='".RCX_URL."/modules/system/admin.php?fct=users&amp;uid=".$fuser->getVar("uid")."&amp;op=modifyUser'>"._EDIT."</a> | <a href='".RCX_URL."/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=".$fuser->getVar("uid")."'>"._DELETE."</a></td>";
      }
      echo "</tr>";
    }
    echo "</table></td></tr></table>";
    $totalpages = ceil($total / $limit);
    if ( $totalpages > 1 ) {
      $hiddenform = "<form name='findnext' action='index.php' method='post'>";
      foreach ( $_POST as $k => $v ) {
        $hiddenform .= "<input type='hidden' name='".$myts->oopsHtmlSpecialChars($k)."' value='".$myts->makeTboxData4PreviewInForm($v)."' />";
      }
      if (!isset($_POST['limit'])) {
        $hiddenform .= "<input type='hidden' name='limit' value='".$limit."' />\n";
      }
      if (!isset($_POST['start'])) {
        $hiddenform .= "<input type='hidden' name='start' value='".$start."' />\n";
      }
      $prev = ($start - $limit);
      if ( $prev >= 0 ) {
        $hiddenform .= "<a href='#0' onclick='javascript:document.findnext.start.value=".$prev.";document.findnext.submit();'>"._PREVIOUS."</a>&nbsp;";
      }
      $counter = 1;
      $currentpage = (($start + $limit) / $limit);
      while ( $counter <= $totalpages ) {
        if ( $counter == $currentpage ) {
          $hiddenform .= "<b>".$counter."</b> ";
        } elseif ( ($counter > $currentpage-4 && $counter < $currentpage+4) || $counter == 1 || $counter == $totalpages ) {
          if ( $counter == $totalpages && $currentpage < $totalpages-4 ) {
            $hiddenform .= "... ";
          }
          $hiddenform .= "<a href='#".$counter."' onclick='javascript:document.findnext.start.value=".($counter-1)*$limit.";document.findnext.submit();'>".$counter."</a> ";
          if ( $counter == 1 && $currentpage > 5 ) {
            $hiddenform .= "... ";
          }
        }
        $counter++;
      }
      $next = ($start + $limit);
      if ( $total > $next ) {
        $hiddenform .= "&nbsp;<a href='#".$total."' onclick='javascript:document.findnext.start.value=".$next.";document.findnext.submit();'>"._NEXT."</a>\n";
      }
      $hiddenform .= "</form>";
      echo "<div style='text-align:center'>".$hiddenform."<br />";
      printf(_MM_USERSFOUND, $total);
      echo "</div>";
    }
  }

}
}
CloseTable();
include_once(RCX_ROOT_PATH."/footer.php");
?>
