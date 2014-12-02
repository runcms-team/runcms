<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

function count_entries($dbtable, $datefield) {

$countres = array();
//today
$newDB=mktime(0,0,0,date("m"),date("d"),date("Y"));
$result = mysql_query("select count(*) as count FROM $dbtable WHERE $datefield > $newDB");
$countres[1] = mysql_result($result,0,"count");
//yesterday
$newDB1 = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
$result = mysql_query("select count(*) as count FROM $dbtable WHERE $datefield < $newDB and $datefield > $newDB1");
$countres[2] = mysql_result($result,0,"count");
//week
$newDB2 = mktime(0,0,0,date("m"),date("d")-7,date("Y"));
$result = mysql_query("select count(*) as count FROM $dbtable WHERE $datefield > $newDB2");
$countres[3] = mysql_result($result,0,"count");
// sum
$countres[4] = $countres[3];
// counter
$counter = 1;
    while ($counter <= 3) {
        if ($countres[$counter] > 0) {
            $countres[$counter] = "<b>".$countres[$counter]."</b>";
        }
        $counter++;
    }
    return $countres;

}
// show block


function b_whatsnew_show($options) {
        global $db, $rcxUser, $rcxConfig, $rcxModule;
        $block = array();
        $block['title'] = "";

$aline = "<tr><td class=\"bg2\" colspan=\"4\"><IMG src=".RCX_URL."/modules/whatnews/images/pix.gif width=\"1\" height=\"1\" alt=\"\" border=\"0\" hspace=\"0\"></td></tr>";
    $entry = 0;
   
	// title
    $block['content']="";
    $block['content'] .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
    $block['content'] .= "<tr><td><font class=\"pn-normal\">&nbsp;<b>"._RECENT."</b></font></td>";
    $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">&nbsp;"._T."&nbsp;</font></td>";
    $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">&nbsp;"._Y."&nbsp;</font></td>";
    $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">&nbsp;"._W."&nbsp;</font></td></tr>\n";
    $block['content'] .= "$aline\n";
   
	// stories
	 if (RcxModule::moduleExists("news")) {
    $stores = count_entries($db->prefix("stories"),"published");
    if ($stores[4] > 0) {
        $block['content'] .= "<tr><td><img src=".RCX_URL."/modules/whatnews/images/pix.gif alt=\"News\">&nbsp;<a class=\"pn-menu\" href=\"".RCX_URL."/modules/news/index.php\">"._ARTICLES."</a></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$stores[1]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$stores[2]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$stores[3]</font></td></tr>\n";
        $block['content'] .= "$aline\n";
        $entry = 1;
    }
   } 
    
	// downloads
	   if (RcxModule::moduleExists("downloads")) {
    $downres = count_entries($db->prefix("downloads_downloads"),"date");
    if ($downres[4] > 0) {
        $block['content'] .= "<tr><td><img src=".RCX_URL."/modules/whatnews/images/pix.gif alt=\"Downloads\">&nbsp;<a class=\"pn-menu\" href=\"".RCX_URL."/modules/downloads/index.php\">"._DOWNLOADS."</a></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$downres[1]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$downres[2]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$downres[3]</font></td></tr>\n";
        $block['content'] .= "$aline\n";
        $entry = 1;
    }
   } 

	// web links
	 if (RcxModule::moduleExists("links")) {
    $linkres = count_entries($db->prefix("links_links"),"date");
    if ($linkres[4] > 0) {
        $block['content'] .= "<tr><td><img src=".RCX_URL."/modules/whatnews/images/pix.gif alt=\"Links\">&nbsp;<a class=\"pn-menu\" href=\"".RCX_URL."/modules/links/index.php\">"._LINKS."</a></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$linkres[1]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$linkres[2]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$linkres[3]</font></td></tr>\n";
        $block['content'] .= "$aline\n";
        $entry = 1;
    }
   }
	// forums posts
	if (RcxModule::moduleExists("forum")) {
	$postbb = count_entries($db->prefix("forum_posts"),"post_time");
    if ($postbb[4] > 0) {
        $block['content'] .= "<tr><td><img src=".RCX_URL."/modules/whatnews/images/pix.gif alt=\"Posts\">&nbsp;<a class=\"pn-menu\" href=\"".RCX_URL."/modules/forum/index.php\">"._POSTFORUMS."</a></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$postbb[1]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$postbb[2]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$postbb[3]</font></td></tr>\n";
        $block['content'] .= "$aline\n";
        $entry = 1;
    }
    
// forums sujets
    $sujets = count_entries($db->prefix("forum_topics"),"topic_time");

    if ($sujets[4] > 0) {
        $block['content'] .= "<tr><td><img src=".RCX_URL."/modules/whatnews/images/pix.gif alt=\"Topics\">&nbsp;<a class=\"pn-menu\" href=\"".RCX_URL."/modules/forum/index.php\">"._POSTSUJETS."</a></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$sujets[1]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$sujets[2]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$sujets[3]</font></td></tr>\n";
        $block['content'] .= "$aline\n";
        $entry = 1;
    }
  }
	// users
            $userres = count_entries($db->prefix("users"),"user_regdate");
    if ($userres[4] > 0) {
        $block['content'] .= "<tr><td><img src=".RCX_URL."/modules/whatnews/images/pix.gif alt=\"Users\">&nbsp;<a class=\"pn-menu\" href=\"".RCX_URL."/modules/members/index.php\">"._MBERS."</a></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$userres[1]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$userres[2]</font></td>";
        $block['content'] .= "<td align=\"center\"><font class=\"pn-menu\">$userres[3]</font></td></tr>\n";
        $block['content'] .= "$aline\n";
        $entry = 1;
    }
		
   $block['content'] .= "</table>";
    if ($entry == 0) {  // don't we have any entries ?
        $block['content'] .= "<center><font class=\"pn-sub\"><br>"._ENTRIES."<br></font></center>";
    } else {
        $block['content'] .= "<center><font class=\"pn-sub\"><b>"._T."</b>"._TODAY." &middot; <b>"._Y."</b>"._iYESTERDAY." &middot; <b>"._W."</b>"._iWEEK."</font></center>";
    }
    return $block;
}
?>
