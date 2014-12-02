<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once("header.php");
include_once(RCX_ROOT_PATH."/class/module.errorhandler.php");
$lid = intval($_REQUEST['lid']);
if ($_POST['submit']) {
        $eh = new ErrorHandler();
        if (!$rcxUser) {
                $ratinguser = 0;
                } else {
                        $ratinguser = $rcxUser->uid();
                }
//Make sure only 1 anonymous from an IP in a single day.
$anonwaitdays = 1;
$ip     = _REMOTE_ADDR;
$rating = intval($_POST['rating']);
// Check if Rating is Null  
if ($rating=="--") {
        redirect_header("ratefile.php?lid=".$lid."", 4, _MD_NORATING);
        exit();
}
// Check if Download POSTER is voting (UNLESS Anonymous users allowed to post)
if ($ratinguser != 0) {
        $result = $db->query("SELECT submitter FROM ".$db->prefix("downloads_downloads")." WHERE lid=$lid");
        while (list($ratinguserDB)=$db->fetch_row($result)) {
                if ($ratinguserDB==$ratinguser) {
                        redirect_header("index.php", 4, _MD_CANTVOTEOWN);
                        exit();
                }
        }

        // Check if REG user is trying to vote twice.
        $result = $db->query("SELECT ratinguser FROM ".$db->prefix("downloads_votedata")." WHERE lid=$lid");
        while (list($ratinguserDB) = $db->fetch_row($result)) {
                if ($ratinguserDB==$ratinguser) {
                        redirect_header("index.php", 4, _MD_VOTEONCE);
                        exit();
                }
        }
}
// Check if ANONYMOUS user is trying to vote more than once per day.
if ($ratinguser==0) {
        $yesterday = ( (time()-(86400 * $anonwaitdays)) );
        $result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("downloads_votedata")." WHERE lid=$lid AND ratinguser=0 AND ratinghostname = '$ip'  AND ratingtimestamp > $yesterday");
        list($anonvotecount) = $db->fetch_row($result);
        if ($anonvotecount >= 1) {
                redirect_header("index.php", 4, _MD_VOTEONCE);
                exit();
        }
}
//All is well.  Add to Line Item Rate to DB.
$newid    = $db->genId($db->prefix("downloads_votedata")."_ratingid_seq");
$datetime = time();
$db->query("INSERT INTO ".$db->prefix("downloads_votedata")." SET ratingid=$newid, lid=$lid, ratinguser=$ratinguser, rating=$rating, ratinghostname='$ip', ratingtimestamp=$datetime") or $eh->show("0013");
//All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
updaterating($lid);
$ratemessage = _MD_VOTEAPPRE."<br />".sprintf(_MD_THANKYOU, $meta['title']);
redirect_header("index.php", 4, $ratemessage);
exit();
} else {
include_once(RCX_ROOT_PATH."/header.php");
OpenTable();
mainheader();
$result      = $db->query("SELECT title FROM ".$db->prefix("downloads_downloads")." WHERE lid=".intval($lid).""); 
list($title) = $db->fetch_row($result);
$title = $myts->makeTboxData4Show($title);
?>
<hr size="1" noshade="noshade" />
<table border="0" cellpadding="1" cellspacing="0" width="80%"><tr><td>
<h4><center><?php echo $title;?></center></h4>
<ul>
<li><?php echo _MD_VOTEONCE;?>
<li><?php echo _MD_RATINGSCALE;?>
<li><?php echo _MD_BEOBJECTIVE;?>
<li><?php echo _MD_DONOTVOTE;?>
</ul>
</td></tr>
<tr><td align="center">
<form method="post" action="ratefile.php">
<input type="hidden" name="lid" value="<?php echo $lid;?>">
<select class="select" name="rating">
<option>--</option>
<?php
for ($i=10; $i>0; $i--) {
        echo "<option value='$i'>$i</option>";
}
echo "
</select>
<input type='submit' class='button' name='submit' value='"._MD_RATEIT."'>
<input type='button' class='button' value='"._CANCEL."' onclick='javascript:history.go(-1)'>
</form></td></tr></table>";
CloseTable();
}
include_once("footer.php");
?>