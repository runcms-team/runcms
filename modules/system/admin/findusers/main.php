<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {

$op = "form";

if ( isset($_POST['op']) && $_POST['op'] == "submit" ) {
  $op = "submit";
}

rcx_cp_header();


echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">';

OpenTable();

if ( $op == "form" ) {
  $acttotal   = RcxUser::countAllUsers(array("level>0"));
  $inacttotal = RcxUser::countAllUsers(array("level=0"));
  include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
  $uname_text  = new RcxFormText("", "user_uname", 30, 60);
  $uname_match = new RcxFormSelectMatchOption("", "user_uname_match");
  $uname_tray  = new RcxFormElementTray(_AM_UNAME, "&nbsp;");
  $uname_tray->addElement($uname_match);
  $uname_tray->addElement($uname_text);
  $name_text  = new RcxFormText("", "user_name", 30, 60);
  $name_match = new RcxFormSelectMatchOption("", "user_name_match");
  $name_tray  = new RcxFormElementTray(_AM_REALNAME, "&nbsp;");
  $name_tray->addElement($name_match);
  $name_tray->addElement($name_text);
  $email_text  = new RcxFormText("", "user_email", 30, 60);
  $email_match = new RcxFormSelectMatchOption("", "user_email_match");
  $email_tray  = new RcxFormElementTray(_AM_EMAIL, "&nbsp;");
  $email_tray->addElement($email_match);
  $email_tray->addElement($email_text);
  $url_text = new RcxFormText(_AM_URLC, "user_url", 30, 100);
 //timezone ikke aktiveret
 //$timezone_select = new RcxFormSelectTimezone(_AM_TIMEZONE, "user_timezone_offset");

  $icq_text  = new RcxFormText("", "user_icq", 30, 100);
  $icq_match = new RcxFormSelectMatchOption("", "user_icq_match");
  $icq_tray  = new RcxFormElementTray(_AM_ICQ, "&nbsp;");
  $icq_tray->addElement($icq_match);
  $icq_tray->addElement($icq_text);
  $aim_text  = new RcxFormText("", "user_aim", 30, 100);
  $aim_match = new RcxFormSelectMatchOption("", "user_aim_match");
  $aim_tray  = new RcxFormElementTray(_AM_AIM, "&nbsp;");
  $aim_tray->addElement($aim_match);
  $aim_tray->addElement($aim_text);
  $yim_text  = new RcxFormText("", "user_yim", 30, 100);
  $yim_match = new RcxFormSelectMatchOption("", "user_yim_match");
  $yim_tray  = new RcxFormElementTray(_AM_YIM, "&nbsp;");
  $yim_tray->addElement($yim_match);
  $yim_tray->addElement($yim_text);

  $msnm_text  = new RcxFormText("", "user_msnm", 30, 100);
  $msnm_match = new RcxFormSelectMatchOption("", "user_msnm_match");
  $msnm_tray  = new RcxFormElementTray(_AM_MSNM, "&nbsp;");
  $msnm_tray->addElement($msnm_match);
  $msnm_tray->addElement($msnm_text);
  $location_text   = new RcxFormText(_AM_LOCATION, "user_from", 30, 100);
  $occupation_text = new RcxFormText(_AM_OCCUPATION, "user_occ", 30, 100);
  $interest_text   = new RcxFormText(_AM_INTEREST, "user_intrest", 30, 100);
	$rank_select = new RcxFormSelect(_AM_RANGSTAT, "user_rank");
	$ranklist = RcxLists::getUserRankList();
	if ( count($ranklist) > 0 ) {
		$rank_select->addOption(0, "--------------");
		$rank_select->addOptionArray($ranklist);
	} else {
		$rank_select->addOption(0, "--------------");
	}
  $lastlog_more = new RcxFormText(_AM_LASTLOGMORE, "user_lastlog_more", 10, 5);
  $lastlog_less = new RcxFormText(_AM_LASTLOGLESS, "user_lastlog_less", 10, 5);
  $reg_more = new RcxFormText(_AM_REGMORE, "user_reg_more", 10, 5);
  $reg_less = new RcxFormText(_AM_REGLESS, "user_reg_less", 10, 5);
  $posts_more = new RcxFormText(_AM_POSTSMORE, "user_posts_more", 10, 5);
  $posts_less = new RcxFormText(_AM_POSTSLESS, "user_posts_less", 10, 5);
  $type_radio = new RcxFormRadio(_AM_SHOWTYPE, "user_type", "actv");
  $type_radio->addOptionArray(array("actv"=>_AM_ACTIVE, "inactv"=>_AM_INACTIVE, "both"=>_AM_BOTH));
  $sort_select = new RcxFormSelect(_AM_SORT, "user_sort");
  $sort_select->addOptionArray(array("uname"=>_AM_UNAME,"email"=>_AM_EMAIL,"last_login"=>_AM_LASTLOGIN,"user_regdate"=>_AM_REGDATE,"posts"=>_AM_POSTS));
  $order_select = new RcxFormSelect(_AM_ORDER, "user_order");
  $order_select->addOptionArray(array("ASC"=>_AM_ASC,"DESC"=>_AM_DESC));
  $limit_text    = new RcxFormText(_AM_LIMIT, "limit", 6, 2);
  $fct_hidden    = new RcxFormHidden("fct", "findusers");
  $op_hidden     = new RcxFormHidden("op", "submit");
  $submit_button = new RcxFormButton("", "user_submit", _SUBMIT, "submit");
  $form = new RcxThemeForm("", "uesr_findform", "admin.php", "post", true);
  $form->addElement($uname_tray);
  $form->addElement($name_tray);
  $form->addElement($email_tray);
// time zone ikke aktiveret
//$form->addElement($timezone_select);
  $form->addElement($icq_tray);
  $form->addElement($aim_tray);
  $form->addElement($yim_tray);
  $form->addElement($msnm_tray);
  $form->addElement($url_text);
  $form->addElement($location_text);
  $form->addElement($occupation_text);
  $form->addElement($interest_text);
  $form->addElement($rank_select);
  $form->addElement($lastlog_more);
  $form->addElement($lastlog_less);
  $form->addElement($reg_more);
  $form->addElement($reg_less);
  $form->addElement($posts_more);
  $form->addElement($posts_less);
  $form->addElement($type_radio);
  $form->addElement($sort_select);
  $form->addElement($order_select);
  $form->addElement($fct_hidden);
  $form->addElement($limit_text);
  $form->addElement($op_hidden);

  if ( !empty($_GET['group']) && intval($_GET['group']) > 0 ) {
    $group_hidden = new RcxFormHidden("group", intval($_GET['group']));
    $form->addElement($group_hidden);
  }
  $form->addElement($submit_button);

  echo '<div class="KPstor" >'._AM_FINDUS.'</div>
            <br />
            <br />';
  
 echo "(".sprintf(_AM_ACTUS, "<span style='color:#ff0000;'>$acttotal</span>")." ".sprintf(_AM_INACTUS, "<span style='color:#ff0000;'>$inacttotal</span>").")<br /><br />";
   
  $form->display();
}

if ( $op == "submit" ) {
  
  $rcx_token = & RcxToken::getInstance();
  
  if ( !$rcx_token->check() ) {
      redirect_header('admin.php?fct=findusers', 3, $rcx_token->getErrors(true));
      exit();
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
	if ( !empty($_POST['user_rank']) ) {
		$criteria[] = "rank LIKE '%".$myts->oopsAddSlashesGPC(trim($_POST['user_rank']))."%'";
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
// timezone ikke aktiveret
  if ( isset($_POST['user_timezone_offset']) && $_POST['user_timezone_offset'] != "" ) {
    $criteria[] = "timezone_offset=".intval($_POST['user_timezone_offset'])."";
  }

  if ( !empty($_POST['user_lastlog_more']) && is_numeric($_POST['user_lastlog_more']) ) {
    $f_user_lastlog_more = intval(trim($_POST['user_lastlog_more']));
    $time = time() - (60 * 60 * 24 * $f_user_lastlog_more);
    if ( $time > 0 ) {
      $criteria[] = "last_login < $time";
    }
  }

  if ( !empty($_POST['user_lastlog_less']) && is_numeric($_POST['user_lastlog_less']) ) {
    $f_user_lastlog_less = intval(trim($_POST['user_lastlog_less']));
    $time = time() - (60 * 60 * 24 * $f_user_lastlog_less);
    if ( $time > 0 ) {
      $criteria[] = "last_login > $time";
    }
  }

  if ( !empty($_POST['user_reg_more']) && is_numeric($_POST['user_reg_more']) ) {
    $f_user_reg_more = intval(trim($_POST['user_reg_more']));
    $time = time() - (60 * 60 * 24 * $f_user_reg_more);
    if ( $time > 0 ) {
      $criteria[] = "user_regdate < $time";
    }
  }

  if ( !empty($_POST['user_reg_less']) && is_numeric($_POST['user_reg_less']) ) {
    $f_user_reg_less = intval($_POST['user_reg_less']);
    $time = time() - (60 * 60 * 24 * $f_user_reg_less);
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

  if ( isset($_POST['user_type']) ) {
    if ( $_POST['user_type'] == "inactv" ) {
      $criteria[] = "level=0";
      } elseif ( $_POST['user_type'] == "actv" ) {
        $criteria[] = "level>0";
        } else {
          $criteria[] = "level>=0";
        }
  }

  $validsort = array("uname", "email", "last_login", "user_regdate", "posts");
  $sort      = (!in_array($_POST['user_sort'], $validsort)) ? "uname" : $_POST['user_sort'];
  $order     = "ASC";

  if ( isset($_POST['user_order']) && $_POST['user_order'] == "DESC") {
    $order = "DESC";
  }

  $limit = (!empty($_POST['limit'])) ? intval($_POST['limit']) : 20;
  if ( $limit > 100 ) {
    $limit = 100;
  }

  $start = (!empty($_POST['start'])) ? intval($_POST['start']) : 0;
  $total = RcxUser::countAllUsers($criteria);

  
  echo '<div class="KPstor" >'. _AM_RESULTS.': '.sprintf(_AM_USERSFOUND, $total).'</div>
            <br />
            <br />';

  if ( $total == 0 ) {
    echo "<h2>"._AM_NOFOUND,"</h2>";
    } elseif ( $start < $total ) {
    echo "
    <form action='admin.php' method='post' name='memberslist' id='memberslist'>
    <input type='hidden' name='op' value='delete_many' />
    <table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>
    <td class='sysbg2'>
    <table width='100%' border='0' cellspacing='1' cellpadding='4'><tr class='sysbg3'>
    <td align='center'>
    <input type='checkbox' class='checkbox' name='memberslist_checkall' id='memberslist_checkall' onclick='rcxCheckAll(\"memberslist\", \"memberslist_checkall\");' />
    </td>
    <td align='center'><b>"._AM_AVATAR."</b></td>
    <td align='center'><b>"._AM_UNAME."</b></td>
    <td align='center'><b>"._AM_REALNAME."</b></td>
    <td align='center'><b>"._AM_EMAIL."</b></span></td>
    <td align='center'><b>"._AM_PM."</b></td>
    <td align='center'><b>"._AM_URL."</b></td>
    <td align='center'><b>"._AM_REGDATE."</b></td>
    <td align='center'><b>"._AM_LASTLOGIN."</b></td>
    <td align='center'><b>"._AM_POSTS."</b></td>
    <td align='center'>&nbsp;</td>
    </tr>";

    $module = RcxModule::getByDirname('pm');

    $foundusers =& RcxUser::getAllUsers($criteria, true, "$sort $order", $limit, $start);
    foreach ($foundusers as $fuser) {
      $fuser_uid = $fuser->getVar('uid');
      $thisUser= new RcxUser($fuser_uid);
      $fuser_avatar = $fuser->getVar("user_avatar") ? "<img src='".RCX_URL."/images/avatar/".$fuser->getVar("user_avatar")."' alt='' />" : "&nbsp;";
      $fuser_name = $fuser->getVar("name") ? $fuser->getVar("name") : "&nbsp;";
      echo "<tr class='sysbg1'><td align='center'><input type='checkbox' class='checkbox' name='memberslist_id[]' id='memberslist_id[]' value='".$fuser->getVar("uid")."' /><input type='hidden' name='memberslist_uname[".$fuser->getVar("uid")."]' id='memberslist_uname[]' value='".$fuser->getVar("uname")."' /></td>";
      echo "<td>".$fuser_avatar."</td><td>";
      echo "<a href='".RCX_URL."/userinfo.php?uid=".$fuser->getVar("uid")."'>".$fuser->getVar("uname")."</a></td><td>".$fuser_name."</td><td align='center'><a href='mailto:".$fuser->getVar("email")."'><img src='".RCX_URL."/images/icons/email.gif' border='0' alt='";
      printf(_SENDEMAILTO,$fuser->getVar("uname", "E"));
      echo "' /></a></td><td align='center'>";
// mulig fejl i modul navn her    
   $module = RcxModule::getByDirname('pm');
      if (RcxModule::moduleExists('pm') && $module->isActivated())
      {
        if ( !RcxGroup::checkRight('module', $module->mid(), $thisUser->groups()) ){
        echo _AM_NOT_AUTORIZED_PM;  
        }else{
        echo "<a href='".RCX_URL."/modules/pm/pmlite.php?send=1&amp;to_userid=".$fuser->getVar("uid")."'><img src='".RCX_URL."/images/icons/pm.gif' border='0' alt='";
        printf(_SENDPMTO,$fuser->getVar("uname", "E"));
        echo "' /></a>";
        }
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
      echo "<td align='center'><a href='".RCX_URL."/modules/system/admin.php?fct=users&amp;uid=".$fuser->getVar("uid")."&amp;op=modifyUser'>"._EDIT."</a></td></tr>\n";
    }
    echo "
    </table></td>
    </tr><tr><td><br /><select class='select' name='fct'>
    <option value='users'>"._AM_DELUSER."</option>
    <option value='mailusers'>"._AM_SENDMAIL."</option>";

    $group = !empty($_POST['group']) ? intval($_POST['group']) : 0;
    if ( $group > 0 ) {
      $add2group = new RcxGroup($group);
      echo "<option value='groups' selected='selected'>".sprintf(_AM_ADD2GROUP, $add2group->getVar('name'))."</option>";
    }
    echo "</select>&nbsp;";
    if ( $group > 0 ) {
      echo "<input type='hidden' name='groupid' value='".$group."' />";
      $rcx_token = & RcxToken::getInstance();
      echo $rcx_token->getTokenHTML();
    }
    echo "
    <input type='submit' class='button' value='"._SUBMIT."' />
    </td></tr></table>
    </form>";

    $totalpages = ceil($total / $limit);
    if ( $totalpages > 1 ) {
      $hiddenform = "<form name='findnext' action='admin.php' method='post'><input type='hidden' name='op' value='findusers' />";
      foreach ( $_POST as $k => $v ) {
          if ($k == 'RCX_TOKEN_REQUEST') {
              // regenerate token value
              $rcx_token = & RcxToken::getInstance();
              $hiddenform .= $rcx_token->getTokenHTML()."\n";
          } else {
              $hiddenform .= "<input type='hidden' name='$k' value='".$myts->oopsStripSlashesGPC($v)."' />\n";
          }
      }
      if (!isset($_POST['limit'])) {
        $hiddenform .= "<input type='hidden' name='limit' value='".$limit."' />\n";
      }
      if (!isset($_POST['start'])) {
        $hiddenform .= "<input type='hidden' name='start' value='".$start."' />\n";
      }
      $prev = $start - $limit;
      if ( $start - $limit >= 0 ) {
        $hiddenform .= "<a href='#0' onclick='javascript:document.findnext.start.value=".$prev.";document.findnext.submit();'>"._PREVIOUS."</a>&nbsp;";
      }
      $counter = 1;
      $currentpage = ($start+$limit) / $limit;
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
      $next = $start+$limit;
      if ( $total > $next ) {
        $hiddenform .= "&nbsp;<a href='#".$total."' onclick='javascript:document.findnext.start.value=".$next.";document.findnext.submit();'>"._NEXT."</a>";
      }
      $hiddenform .= "</form>";
      echo "<div style='text-align:center'>".$hiddenform."<br />";
      printf(_AM_USERSFOUND, $total);
      echo "</div>";
    }
  }

}
CloseTable();


echo "                        
        </td>
    </tr>
</table>";

rcx_cp_footer();

  } else {
    echo "Access Denied";
  }
?>
