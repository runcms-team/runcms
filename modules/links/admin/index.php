<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
include_once("admin_header.php");

$eh     = new ErrorHandler(0);
$mytree = new RcxTree($db->prefix("links_cat"), "cid", "pid");

/**
* Description
*
* @param type $var description
* @return type description
*/
function links() {
global $db;

rcx_cp_header();
OpenTable();

// Temporarily 'homeless' links (to be revised in admin.php breakup)
$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_broken")."");
list($totalbrokenlinks) = $db->fetch_row($result);
if ($totalbrokenlinks > 0) {
        $totalbrokenlinks = "<span style='font-weight: bold'>$totalbrokenlinks</span>";
}

$result2 = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_mod")."");
list($totalmodrequests) = $db->fetch_row($result2);
if ($totalmodrequests > 0) {
        $totalmodrequests = "<span style='font-weight: bold'>$totalmodrequests</span>";
}

$result3 = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_links")." WHERE status=0");
list($totalnewlinks) = $db->fetch_row($result3);
if ($totalnewlinks>0) {
        $totalnewlinks = "<span style='font-weight: bold'>$totalnewlinks</span>";
}

?>

    <h4><?php echo _MI_LINKS_NAME;?></h4>
	<br /><br /><br /><br />
	<div class="kpicon"><table><tr><td>
	<a href="index.php?op=LinksConfigAdmin"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MD_GENERALSET;?>">
	<br /><?php echo _MD_GENERALSET;?></a>
	<a href="index.php?op=linksConfigMenu"><img src="<?php echo RCX_URL;?>/images/system/moduler.png" alt="<?php echo _MD_ADDMODDELETE;?>"/>	
	<br /><?php echo _MD_ADDMODDELETE;?></a>
	<a href="index.php?op=listNewLinks"><img src="<?php echo RCX_URL;?>/images/system/indstil.png" alt="<?php echo _MD_LINKSWAITING;?>"/>
	<br /><?php echo _MD_LINKSWAITING;?> (<?php echo $totalnewlinks;?>)</a>
	<a href="index.php?op=listBrokenLinks"><img src="<?php echo RCX_URL;?>/images/system/disclaimer.png" alt="<?php echo _MD_BROKENREPORTS;?>"/>
	<br /><?php echo _MD_BROKENREPORTS;?> (<?php echo $totalbrokenlinks;?>)</a>
	<a href="index.php?op=listModReq"><img src="<?php echo RCX_URL;?>/images/system/disclaimer.png" alt="<?php echo _MD_MODREQUESTS;?>"/>
	<br /><?php echo _MD_MODREQUESTS;?> (<?php echo $totalmodrequests;?>)</a>
	</td></tr></table></div>

<?php

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_links")." WHERE status>0");
list($numrows) = $db->fetch_row($result);
echo "<br /><br /><div align='center'>";
printf(_MD_THEREARE, $numrows);
echo "</div>";

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function listNewLinks(){
global $db, $myts, $eh, $mytree, $rcxConfig;

// List links waiting for validation
$result  = $db->query("SELECT lid, cid, title, description, url, email, logourl, submitter FROM ".$db->prefix("links_links")." WHERE status=0 ORDER BY date DESC");
$numrows = $db->num_rows($result);

rcx_cp_header();
OpenTable();
echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_LINKSWAITING."&nbsp;($numrows)</h4><br />";

if ($numrows > 0) {
        while (list($lid, $cid, $title, $description, $url, $email, $logourl, $submitterid) = $db->fetch_row($result)) {
                $title       = $myts->makeTboxData4Edit($title);
                $url         = $myts->makeTboxData4Edit($url);
                $email       = $myts->makeTboxData4Edit($email);
                $description = $myts->makeTboxData4Edit($description);
                if ($submitterid != 0) {
                        $submitter = RcxUser::getUnameFromId($submitterid);
                        $submitter = $myts->makeTboxData4Show($submitter);
                        } else {
                                $submitter = $myts->makeTboxData4Show($rcxConfig['anonymous']);
                        }

?>
<form action="index.php" method="post">
<table width="100%"><tr>
<td nowrap><?php echo _MD_SUBMITTER;?></td>
<td><a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $submitterid;?>"><?php echo $submitter;?></a></td>
</tr><tr>
<td nowrap><?php echo _MD_SITETITLE;?></td>
<td><input type="text" class="text" name="title" size="50" maxlength="100" value="<?php echo $title;?>" /></td>
</tr><tr>
<td nowrap><?php echo _MD_SITEURL;?></td>
<td><input type="text" class="text" name="url" size="50" maxlength="255" value="<?php echo $url;?>" /> [ <a href="<?php echo $url;?>" target="_blank"><?php echo _MD_VISIT;?></a> ]</td>
</tr><tr>
<td nowrap><?php echo _MD_CATEGORYC;?></td>
<td><?php $mytree->makeMySelBox("title", "title", $cid);?></td>
</tr><tr>
<td nowrap><?php echo _MD_CONTACTEMAIL;?></td>
<td><input type="text" class="text" name="email" size="50" maxlength="60" value="<?php echo $email;?>" /></td>
</tr><tr>
<td valign="top" nowrap><?php echo _MD_DESCRIPTIONC;?></td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'linkdesc', $description, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'linkdesc', $description);
echo $desc->render();
?>
</td>
</tr><tr>
<td align="right">
<input type="hidden" name="op" value="approve" />
<input type="hidden" name="lid" value="<?php echo $lid;?>" />
<input type="submit" class="button" value="<?php echo _MD_APPROVE;?>" />
</form></td>
<td align="left"><?php echo myTextForm("index.php?op=delNewLink&lid=$lid", _DELETE);?></td>
</tr></table>
<?php

        }
        } else {
                echo _MD_NOSUBMITTED;
        }

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function linksConfigMenu() {
global $db,$rcxConfig, $myts, $eh, $mytree;

rcx_cp_header();

$result = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_cat")."");
list($numrows) = $db->fetch_row($result);

if ($numrows > 0) {
        OpenTable();
        // If there is a category, add a New Link

?>
<form method="post" action="index.php" enctype="multipart/form-data">
<h4><a href="index.php"><?php echo _MAIN;?></a>: <?php echo _MD_ADDNEWLINK;?></h4><br />
<table width="100%"><tr>
<td><?php echo _MD_SITETITLE;?></td>
<td><input type="text" class="text" name="title" size="50" maxlength="100" /></td>
</tr><tr>
<td nowrap><?php echo _MD_SITEURL;?></td>
<td><input type="text" class="text" name="url" size="50" maxlength="255" value="http://"></td>
</tr><tr>
<td nowrap><?php echo _MD_CATEGORYC;?></td>
<td><?php $mytree->makeMySelBox("title", "title");?></td>
</tr><tr>
<td nowrap><?php echo _MD_EMAILC;?></td>
<td><input type="text" class="text" name="email" size="50" maxlength="60" /></td>
</tr><tr>
<td valign="top" nowrap><?php echo _MD_DESCRIPTIONC;?></td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'linkdesc', '', 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'linkdesc', '');
echo $desc->render();
?>
</td>
</tr><tr>
<td valign="top" nowrap><?php echo _MD_SHOTIMAGE;?></td>
<td>
<input type="text" class="text" name="logourl" size="50" maxlength="255" /><br />
<?php
$upload = new fileupload();
$upload->render(1, 'image');
?>
</td>
</tr><tr>
<td>&nbsp;</td>
<td><?php printf(_MD_SHOT, "modules/links/cache/images/shots/");?></td>
</tr></table>
<br />
<input type="hidden" name="op" value="addLink" />
<input type="submit" class="button" value="<?php echo _ADD;?>" />
</form>
<?php

CloseTable();
echo "<br />";
OpenTable();
// Modify Link

?>
<form method="post" action="index.php">
<h4><?php echo _MD_MODLINK;?></h4>
<?php echo _MD_LINKID;?>
<input type="text" class="text" name="lid" size="12" maxlength="11">
<input type="hidden" name="fct" value="links">
<input type="hidden" name="op" value="modLink">
<input type="submit" class="button" value="<?php echo _MD_MODIFY;?>">
</form>
<?php

CloseTable();
echo "<br />";
OpenTable();
// Modify Category

?>
</center>
<form method="post" action="index.php">
<h4><?php echo _MD_MODCAT;?></h4>
<?php echo _MD_CATEGORYC;?>
<?php $mytree->makeMySelBox("title", "title");?>
<input type="hidden" name="op" value="modCat" />
<input type="submit" class="button" value="<?php echo _MD_MODIFY;?>" />
</form>
<?php

CloseTable();
echo "<br />";
OpenTable();
// Add a New Sub-Category

?>
<form method="post" action="index.php">
<h4><?php echo _MD_ADDSUB;?></h4>
<?php echo _MD_TITLEC;?>
<input type="text" class="text" name="title" size="30" maxlength="50" />
<?php echo _MD_IN;?>
<?php $mytree->makeMySelBox("title", "title");?>
<input type="hidden" name="op" value="addCat" />
<input type="submit" class="button" value="<?php echo _ADD;?>" />
</form>
<?php

CloseTable();
echo "<br />";
}

OpenTable();
// Add a New Main Category

?>
<form method="post" action="index.php">
<h4><?php echo _MD_ADDMAIN;?></h4>
<?php echo _MD_TITLEC;?>
<input type="text" class="text" name="title" size="30" maxlength="50" />
<input type="hidden" name="cid" value="0" />
<input type="hidden" name="op" value="addCat" />
<input type="submit" class="button" value="<?php echo _ADD;?>" />
</form>
<?php

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function modLink() {
global $db, $myts, $_GET, $_POST, $eh, $mytree, $rcxConfig;

$lid= !empty($_POST['lid']) ? intval($_POST['lid']) : intval($_GET['lid']);

$result = $db->query("SELECT cid, title, description, url, email, logourl FROM ".$db->prefix("links_links")." WHERE lid=$lid") or $eh->show("0013");
list($cid, $title, $description, $url, $email, $logourl) = $db->fetch_row($result);
$title       = $myts->makeTboxData4Edit($title);
$url         = $myts->makeTboxData4Edit($url);
$email       = $myts->makeTboxData4Edit($email);
$logourl     = $myts->makeTboxData4Edit($logourl);
$description = $myts->makeTboxData4Edit($description);

rcx_cp_header();
OpenTable();

?>
<form method="post" action="index.php" enctype="multipart/form-data">
<h4><a href="index.php"><?php echo _MAIN;?></a>: <?php echo _MD_MODLINK;?></h4><br />
<table width="100%"><tr>
<td><?php echo _MD_LINKID;?></td>
<td><b><?php echo $lid;?></b></td>
</tr><tr>
<td><?php echo _MD_SITETITLE;?></td>
<td><input type="text" class="text" name="title" value="<?php echo $title;?>" size="50" maxlength="100" /></td>
</tr><tr>
<td><?php echo _MD_SITEURL;?></td>
<td><input type="text" class="text" name="url" value="<?php echo $url;?>" size="50" maxlength="255" /></td>
</tr><tr>
<td><?php echo _MD_EMAILC;?></td>
<td><input type="text" class="text" name="email" value="<?php echo $email;?>" size="50" maxlength="60" /></td>
</tr><tr>
<td valign="top"><?php echo _MD_DESCRIPTIONC;?></td>
<td>
<?php
//$desc = new RcxFormDhtmlTextArea('', 'linkdesc', $description, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'linkdesc', $description);
echo $desc->render();
?>
</td>
</tr><tr>
<td><?php echo _MD_CATEGORYC;?></td>
<td><?php $mytree->makeMySelBox('title', 'title', $cid);?></td>
</tr><tr>
<td valign="top"><?php echo _MD_SHOTIMAGE;?></td>
<td>
<input type="text" class="text" name="logourl" value="<?php echo $logourl;?>" size="50" maxlength="255" />
<br /><input type="file" class="file" name="image">
</td>
</tr><tr>
<td>&nbsp;</td>
<td><?php printf(_MD_SHOT, "modules/links/cache/images/shots/");?></td>
</tr>
<tr>
<!--- tilføjet --->
<td><?php echo _MD_LNKSTATUS; ?></td>
<td><select name="lnkstatus" id="lnkstatus" class="select">
<option value="3"<?php if ( intval($status) == 3 ) { echo " selected"; } ?>><?php echo _MD_LNKSTATUSNORMAL; ?></option>
<option value="1"<?php if ( intval($status) == 1 ) { echo " selected"; } ?>><?php echo _MD_LNKSTATUSNEW; ?></option>
<option value="2"<?php if ( intval($status) == 2 ) { echo " selected"; } ?>><?php echo _MD_LNKSTATUSUPDATED; ?></option>
</select></td>
</tr>
<!---  slut --->

<tr>
<td>
<input type="hidden" name="lid" value="<?php echo $lid;?>" />
<input type="hidden" name="op" value="modLinkS" />
<input type="submit" class="button" value="<?php echo _MD_MODIFY;?>" />
</form>
</td>
<td>
<table><tr>
<td><?php echo myTextForm("index.php?op=delLink&lid=$lid", _DELETE);?></td>
<td><?php echo myTextForm("index.php?op=linksConfigMenu", _CANCEL);?></td>
</tr></table>
</td>
</tr></table><hr />
<?php

$result5 = $db->query("SELECT count(*) FROM ".$db->prefix("links_votedata")." WHERE lid = $lid");
list($totalvotes) = $db->fetch_row($result5);

echo "<table valign='top' width='100%'><tr><td colspan='7'><b>";
printf(_MD_TOTALVOTES, $totalvotes);
echo "</b><br /><br /></td></tr>";

// Show Registered Users Votes
$result5 = $db->query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM ".$db->prefix("links_votedata")." WHERE lid = $lid AND ratinguser >0 ORDER BY ratingtimestamp DESC");
$votes   = $db->num_rows($result5);

echo "<tr><td colspan='7'><br /><br /><b>";
printf(_MD_USERTOTALVOTES, $votes);
echo "
</b><br /><br /></td>
</tr><tr>
<td><b>"._MD_USER."</b></td>
<td><b>"._MD_IP."</b></td>
<td><b>"._MD_RATING."</b></td>
<td><b>"._MD_USERAVG."</b></td>
<td><b>"._MD_TOTALRATE."</b></td>
<td><b>"._MD_DATE."</b></td>
<td align='center'><b>"._DELETE."</b></td>
</tr>";

if ($votes == 0) {
        echo "<tr><td align='center' colspan='7'>"._MD_NOREGVOTES."</td></tr>";
}

$x=0;
$colorswitch = "bg1";
while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp)=$db->fetch_row($result5)) {
        //Individual user information
        $result2       = $db->query("SELECT rating FROM ".$db->prefix("links_votedata")." WHERE ratinguser='$ratinguser'");
        $uservotes     = $db->num_rows($result2);
        $useravgrating = 0;

        while (list($rating2) = $db->fetch_row($result2)) {
                $useravgrating  = ($useravgrating + $rating2);
        }

        $useravgrating  = ($useravgrating / $uservotes);
        $useravgrating  = number_format($useravgrating, 1);
        $ratingusername = RcxUser::getUnameFromId($ratinguser);

        echo "
        <tr>
        <td class='$colorswitch'>$ratingusername</td>
        <td class='$colorswitch'>$ratinghostname</td>
        <td class='$colorswitch'>$rating</td>
        <td class='$colorswitch'>$useravgrating</td>
        <td class='$colorswitch'>$uservotes</td>
        <td class='$colorswitch'>$ratingtimestamp</td>
        <td class='$colorswitch' align='center'><b><a href='index.php?op=delVote&lid=$lid&rid=$ratingid'>X</a></b></td>
        </tr>";

        $x++;
        if ($colorswitch == "bg1") {
                $colorswitch = "bg3";
                } else {
                        $colorswitch = "bg1";
                }
}

// Show Unregistered Users Votes
$result5 = $db->query("SELECT ratingid, rating, ratinghostname, ratingtimestamp FROM ".$db->prefix("links_votedata")." WHERE lid = $lid AND ratinguser = 0 ORDER BY ratingtimestamp DESC");
$votes   = $db->num_rows($result5);

echo "<tr><td colspan='7'><br /><br /><b>";
printf(_MD_ANONTOTALVOTES, $votes);
echo "
</b><br /><br /></td>
</tr><tr>
<td colspan='2'><b>"._MD_IP."</b></td>
<td colspan='3'><b>"._MD_RATING."</b></td>
<td><b>"._MD_DATE."</b></b></td>
<td align='center'><b>"._DELETE."</b></td>
</tr>";

if ($votes == 0) {
        echo "<tr><td colspan='7' align='center'>"._MD_NOUNREGVOTES."<br /></td></tr>";
}

$x=0;
$colorswitch = "bg1";
while (list($ratingid, $rating, $ratinghostname, $ratingtimestamp) = $db->fetch_row($result5)) {
        $formatted_date = formatTimestamp($ratingtimestamp, "s");
        echo "
        <td colspan='2' class='$colorswitch'>$ratinghostname</td>
        <td colspan='3' class='$colorswitch'>$rating</td>
        <td class='$colorswitch'>$formatted_date</td>
        <td class='$colorswitch' align='center'><b><a href='index.php?op=delVote&lid=$lid&rid=$ratingid'>X</a></b></td>
        </tr>";
        $x++;

        if ($colorswitch == "bg1") {
                $colorswitch = "bg3";
                } else {
                        $colorswitch="bg1";
                }
        }

echo "<tr><td colspan='6'>&nbsp;</td></tr></table>";

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function modLinkS() {
global $db, $_POST, $_FILES, $myts, $eh;

$cid         = intval($_POST['cid']);
$lid         = intval($_POST['lid']);
$url         = $myts->makeTboxData4Save($_POST["url"]);
$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$email       = $myts->makeTboxData4Save($_POST["email"]);
$description = $myts->makeTboxData4Save($_POST["linkdesc"]);
// tilføjet
$lnkstatus   = intval($_POST['lnkstatus']);
// slut
// Check if Title is empty
if ( empty($title) ) {
        redirect_header("index.php?op=modLink&lid=$lid", 3, _MD_ERRORTITLE);
        exit();
}

// Check if Description is empty
if ( empty($description) ) {
        redirect_header("index.php?op=modLink&lid=$lid", 3, _MD_ERRORDESC);
        exit();
}

if ( !empty($_FILES['image']['name']) ) {
        $upload = new fileupload();

        $upload->set_upload_dir('../cache/shots/', 'image');
        $upload->set_overwrite(2, 'image');
        $upload->set_basename($lid, 'image');

        $result = $upload->upload();
        if ($result['image']['filename']) {
                $logourl = $result['image']['filename'];
                } else {
                        redirect_header("index.php?op=modLink&lid=$lid", 3, $upload->errors());
                        exit();
                }
}


// Check if URL is empty
if ( empty($url) ) {
        redirect_header("index.php?op=modLink&lid=$lid", 3, _MD_ERRORURL);
        exit();
}

$sql = "UPDATE ".$db->prefix("links_links")." SET
        cid=$cid,
        title='$title',
        description='$description',
        url='$url',
        email='$email',
        logourl='$logourl',
    status=".$lnkstatus.",
        date=".time()."
        WHERE lid=$lid";

$db->query($sql) or $eh->show("0013");

build_rss();
redirect_header("index.php", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function addLink() {
global $db, $myts, $rcxUser, $eh, $_POST, $_FILES;

$url         = formatURL($myts->makeTboxData4Save($_POST["url"]));
$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$email       = $myts->makeTboxData4Save($_POST["email"]);
$description = $myts->makeTboxData4Save($_POST["linkdesc"]);
$submitter   = $rcxUser->uid();

$result        = $db->query("SELECT COUNT(*) FROM ".$db->prefix("links_links")." WHERE url='$url'");
list($numrows) = $db->fetch_row($result);

// Check if Link exist
if ($numrows > 0) {
        redirect_header("index.php?op=linksConfigMenu", 3, _MD_ERROREXIST);
        exit();
}

// Check if URL is empty
if ( empty($url) ) {
        redirect_header("index.php?op=linksConfigMenu", 3, _MD_ERRORURL);
        exit();
}

// Check if Title is empty
if ($title == "") {
        redirect_header("index.php?op=linksConfigMenu", 3, _MD_ERRORTITLE);
        exit();
}

// Check if Description is empty
if ($description == "") {
        redirect_header("index.php?op=linksConfigMenu", 3, _MD_ERRORDESC);
        exit();
}

if ( !empty($_POST['cid']) ) {
        $cid = intval($_POST['cid']);
        } else {
                $cid = 0;
        }

if ( !empty($_FILES['image']['name']) ) {
        $upload = new fileupload();
        $upload->set_upload_dir('../cache/shots/', 'image');
        $upload->set_overwrite(1, 'image');
        $result = $upload->upload();
        if ($result['image']['filename']) {
                $logourl = $result['image']['filename'];
                } else {
                        redirect_header("index.php?op=linksConfigMenu", 3, $upload->errors());
                        exit();
                }
}

$newid = $db->genId($db->prefix("links_links")."_lid_seq");
$sql   = "INSERT INTO ".$db->prefix("links_links")." VALUES (
        ".intval($newid).",
        ".intval($cid).",
        '$title',
        '$description',
        '$url',
        '$email',
        '$logourl',
        ".intval($submitter).",
        1,
        ".time().",
        0,
        0,
        0,
        0)";

$db->query($sql) or $eh->show("0013");

build_rss();
redirect_header("index.php", 1, _MD_NEWLINKADDED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delNewLink() {
global $db, $_GET, $eh;

$lid = intval($_GET['lid']);

$query  = "SELECT logourl FROM ".$db->prefix("links_links")." WHERE lid=$lid";
$result = $db->query($query);
list($logourl) = $db->fetch_row($result);
@unlink("../cache/shots/" . basename($logourl));

$query = "DELETE FROM ".$db->prefix("links_links")." WHERE lid=$lid";
$db->query($query) or $eh->show("0013");

redirect_header("./index.php?op=listNewLinks", 1, _MD_LINKDELETED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delLink() {
global $db, $_GET, $eh;

$lid = intval($_GET['lid']);

$query  = "SELECT logourl FROM ".$db->prefix("links_links")." WHERE lid=$lid";
$result = $db->query($query);
list($logourl) = $db->fetch_row($result);
@unlink("../cache/shots/" . basename($logourl));

$query = "DELETE FROM ".$db->prefix("links_links")." WHERE lid=$lid";
$db->query($query) or $eh->show("0013");

$query = "DELETE FROM ".$db->prefix("links_votedata")." WHERE lid=$lid";
$db->query($query) or $eh->show("0013");

build_rss();
redirect_header("index.php", 1, _MD_LINKDELETED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delVote() {
global $db, $_GET, $eh;

$rid = $_GET['rid'];
$lid = $_GET['lid'];

$query = "DELETE FROM ".$db->prefix("links_votedata")." WHERE ratingid=$rid";
$db->query($query) or $eh->show("0013");

updaterating($lid);
redirect_header("index.php", 1, _MD_VOTEDELETED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function listBrokenLinks() {
global $db, $myts, $eh, $rcxConfig;

$result = $db->query("SELECT reportid, lid, sender, ip FROM ".$db->prefix("links_broken")." ORDER BY reportid");
$totalbrokenlinks = $db->num_rows($result);
rcx_cp_header();
OpenTable();

echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_BROKENREPORTS." ($totalbrokenlinks)</h4><br />";

if ($totalbrokenlinks == 0) {
        echo _MD_NOBROKEN;
        } else {
                $colorswitch = "bg1";
                ?>
                <center><?php echo _MD_IGNOREDESC;?><br /><?php echo _MD_DELETEDESC;?></center>
                <br /><br /><br />
                <table align="center" width="90%"><tr>
                <td><b><?php echo _MD_SITETITLE;?></b></td>
                <td><b><?php echo _MD_REPORTER;?></b></td>
                <td><b><?php echo _MD_LINKSUBMITTER;?></b></td>
                <td><b><?php echo _MD_IGNORE;?></b></td>
                <td><b><?php echo _EDIT;?></b></td>
                <td><b><?php echo _DELETE;?></b></td>
                </tr>
                <?php


while (list($reportid, $lid, $senderid, $ip)=$db->fetch_row($result)) {
        $result2 = $db->query("SELECT title, url, submitter FROM ".$db->prefix("links_links")." WHERE lid=$lid");
        list($title, $url, $ownerid) = $db->fetch_row($result2);
        $title = $myts->makeTboxData4Show($title);

        if ($senderid != 0) {
                $sender = RcxUser::getUnameFromId($senderid);
                $sender = $myts->makeTboxData4Show($sender);
                } else {
                        $sender = $myts->makeTboxData4Show($rcxConfig['anonymous']);
                }

        if ($ownerid != 0) {
                $owner = RcxUser::getUnameFromId($ownerid);
                $owner = $myts->makeTboxData4Show($owner);
                } else {
                        $owner = $myts->makeTboxData4Show($rcxConfig['anonymous']);
                }

        echo "
        <tr>
        <td class='$colorswitch'><a href='$url' target='_blank'>$title</a></td>
        <td class='$colorswitch'><a href='".RCX_URL."/userinfo.php?uid=$senderid' target='_blank'>$sender</a> ($ip)</td>
        <td class='$colorswitch'><a href='".RCX_URL."/userinfo.php?uid=$ownerid' target='_blank'>$owner</a></td>
        <td class='$colorswitch' align='center'>";

        echo myTextForm("index.php?op=ignoreBrokenLinks&lid=$lid" , "X");
        echo "</td><td class='$colorswitch' align='center'>";
        echo myTextForm("index.php?op=modLink&lid=$lid" , "X");
        echo "</td><td align='center' class='$colorswitch'>";
        echo myTextForm("index.php?op=delBrokenLinks&lid=$lid" , "X");
        echo "</td></tr>";

        if ($colorswitch == "bg1") {
                $colorswitch="bg3";
                } else {
                        $colorswitch="bg1";
                }
        }
        echo "</table>";
}

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delBrokenLinks() {
global $db, $_GET, $eh;

$lid = intval($_GET['lid']);

$query  = "SELECT logourl FROM ".$db->prefix("links_links")." WHERE lid=$lid";
$result = $db->query($query);
list($logourl) = $db->fetch_row($result);
@unlink("../cache/shots/" . basename($logourl));

$query = "DELETE FROM ".$db->prefix("links_broken")." WHERE lid=$lid";
$db->query($query) or $eh->show("0013");

$query = "DELETE FROM ".$db->prefix("links_links")." WHERE lid=$lid";
$db->query($query) or $eh->show("0013");

build_rss();
redirect_header("./index.php?op=listBrokenLinks", 1, _MD_LINKDELETED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function ignoreBrokenLinks() {
global $db, $_GET, $eh;

$lid = intval($_GET['lid']);
$db->query("DELETE FROM ".$db->prefix("links_broken")." WHERE lid=$lid") or $eh->show("0013");

redirect_header("./index.php?op=listBrokenLinks", 1, _MD_BROKENDELETED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function listModReq() {
global $db, $myts, $eh, $mytree, $linksConfig;

rcx_cp_header();
OpenTable();

$sql_mod = $db->query("SELECT requestid, lid, cid, title, url, email, description, modifysubmitter FROM ".$db->prefix("links_mod")." ORDER BY requestid");

$totalmodrequests = $db->num_rows($sql_mod);
echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_USERMODREQ." ($totalmodrequests)</h4><br />";

if ($totalmodrequests > 0) {
        while (list($requestid, $lid, $cid, $title, $url, $email, $description, $modifysubmitter) = $db->fetch_row($sql_mod)) {
                $cidtitle      = $mytree->getNicePathFromId($cid, "title", RCX_URL."/modules/links/viewcat.php?");
                $cidtitle      = substr($cidtitle, 0, -2);
                $title         = $myts->makeTboxData4Show($title);
                $url           = $myts->makeTboxData4Show($url);
                $email         = $myts->makeTboxData4Show($email);
                $description   = $myts->makeTareaData4Show($description);
                if ($modifysubmitter != 0) {
                        $submittername = RcxUser::getUnameFromId($modifysubmitter);
                        $submittername = $myts->makeTareaData4Show($submittername);
                }

                $sql_original = $db->query("SELECT cid, title, url, email, description, submitter FROM ".$db->prefix("links_links")." WHERE lid=$lid");
                list($origcid, $origtitle, $origurl, $origemail, $origdescription, $owner) = $db->fetch_row($sql_original);
                $origcidtitle    = $mytree->getNicePathFromId($origcid, "title", RCX_URL."/modules/links/viewcat.php?");
                $origcidtitle    = substr($origcidtitle, 0, -2);
                $origtitle       = $myts->makeTboxData4Show($origtitle);
                $origurl         = $myts->makeTboxData4Show($origurl);
                $origemail       = $myts->makeTboxData4Show($origemail);
                $origdescription = $myts->makeTareaData4Show($origdescription);
                if ($owner != 0) {
                        $ownername       = RcxUser::getUnameFromId($owner);
                        $ownername       = $myts->makeTareaData4Show($ownername);
                }

?>
<hr align="center" size="1" noshade="noshade" />
<table width="100%" cellspacing="0" cellpadding="0"><tr>

<td valign="top"><small><?php echo _MD_REQUESTID;?></small></td>
<td valign="top"><b><?php echo $requestid;?></b></td>
</tr><tr>
<td valign="top"><b><?php echo _MD_PROPOSED;?></b></td>
<td width="50%" rowspan="5" valign="top"><?php echo _MD_DESCRIPTIONC;?><br /><?php echo $description;?></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_SITETITLE;?> <?php echo $title;?></small></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_SITEURL;?> <a href="<?php echo $url;?>" target="_blank"><?php echo $url;?></a></small></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_CATEGORYC;?> <?php echo $cidtitle;?></small></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_EMAILC;?> <a href="mailto:<?php echo $email;?>" target="_blank"><?php echo $email;?></a></small></td>
</tr><tr>

<td colspan="2">&nbsp;</td>
</tr><tr>

<td valign="top"><b><?php echo _MD_ORIGINAL;?></b></td>
<td width="50%" rowspan="5" valign="top"><?php echo _MD_DESCRIPTIONC;?><br /><?php echo $origdescription;?></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_SITETITLE;?> <?php echo $origtitle;?></small></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_SITEURL;?> <a href="<?php echo $origurl;?>" target="_blank"><?php echo $origurl;?></a></small></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_CATEGORYC;?> <?php echo $origcidtitle;?></small></td>
</tr><tr>
<td valign="top"><small><?php echo _MD_EMAILC;?> <a href="mailto:<?php echo $origemail;?>" target="_blank"><?php echo $origemail;?></a></small></td>
</tr><tr align="center">

<td colspan="2">
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
<td valign="top" width="35%"><small><?php echo _MD_SUBMITTER;?> <a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $modifysubmitter;?>" target="_blank"><?php echo $submittername;?></a></small></td>
<td valign="top" width="35%"><small><?php echo _MD_OWNER;?> <a href="<?php echo RCX_URL;?>/userinfo.php?uid=<?php echo $owner;?>" target="_blank"><?php echo $ownername;?></a></small></td>

<td valign="top" width="5%"><?php echo myTextForm("index.php?op=changeModReq&requestid=$requestid" , _MD_APPROVE);?></td>
<td valign="top" width="5%"><?php echo myTextForm("index.php?op=modLink&lid=$lid" , _EDIT);?></td>
<td valign="top" width="5%"><?php echo myTextForm("index.php?op=ignoreModReq&requestid=$requestid", _MD_IGNORE);?></td>
</tr></table>
</td>
</tr></table>
<?php

        }
        } else {
                echo _MD_NOMODREQ;
        }

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function changeModReq() {
global $db, $_GET, $eh, $myts;

$requestid = intval($_GET['requestid']);

$sql  = "SELECT
        lid,
        cid,
        title,
        url,
        email,
        description
        FROM ".$db->prefix("links_mod")."
        WHERE requestid=$requestid";

$result = $db->query($sql);
list($lid, $cid, $title, $url, $email, $description) = $db->fetch_row($result);
$title       = $myts->oopsAddSlashesRT($title);
$url         = $myts->oopsAddSlashesRT($url);
$email       = $myts->oopsAddSlashesRT($email);
$description = $myts->oopsAddSlashesRT($description);


$sql = "UPDATE ".$db->prefix("links_links")." SET
        cid='$cid',
        title='$title',
        description='$description',
        url='$url',
        email='$email',
        status=2,
        date=".time()."
        WHERE lid=$lid";
$db->query($sql) or $eh->show("0013");


$db->query("DELETE FROM ".$db->prefix("links_mod")." WHERE requestid='$requestid'") or $eh->show("0013");
redirect_header("index.php?op=listModReq", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function ignoreModReq() {
global $db, $_GET, $eh;

$requestid = intval($_GET['requestid']);
$db->query("DELETE FROM ".$db->prefix("links_mod")." WHERE requestid=$requestid") or $eh->show("0013");

redirect_header("./index.php?op=listModReq", 1, _MD_MODREQDELETED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function addCat() {
global $db, $_POST, $myts, $eh;

$pid    = intval($_POST["cid"]);
$title  = $myts->makeTboxData4Save($_POST["title"]);

$newid = $db->genId($db->prefix("links_cat")."_cid_seq");
$db->query("INSERT INTO ".$db->prefix("links_cat")." SET cid='$newid', pid='$pid', title='$title'") or $eh->show("0013");

if ($newid == 0) {
        $newid = $db->insert_id($query);
}

redirect_header("index.php?op=modCat&cid=$newid", 1, _MD_NEWCATADDED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function modCat() {
global $db, $rcxModule, $_POST, $_GET, $myts, $eh, $mytree;

$cid = !empty($_POST["cid"]) ? intval($_POST["cid"]) : intval($_GET["cid"]);

rcx_cp_header();
OpenTable();

echo "<h4><a href='index.php'>"._MAIN."</a>: "._MD_MODCAT."</h4><br />";

global $desc;
$result = $db->query("SELECT pid, title, imgurl, description FROM ".$db->prefix("links_cat")." WHERE cid=$cid");
list($pid, $title, $imgurl, $description) = $db->fetch_row($result);
$title  = $myts->makeTboxData4Edit($title);
$imgurl = $myts->makeTboxData4Edit($imgurl);
$desc   = $myts->makeTboxData4Edit($description);

?>
<form action="./index.php" method="post" enctype="multipart/form-data">

<?php echo _MD_TITLEC;?><br />
<input type="text" class="text" name="title" value="<?php echo $title;?>" size="51" maxlength="50">

<br /><br />
<input type="text" class="text" name="imgurl" value="<?php echo $imgurl;?>" size="51" maxlength="255"><br />
<?php
$upload = new fileupload();
$upload->set_basename($cid, 'image');
$upload->render(1, 'image');
echo "<br />".sprintf(_AM_IMGLOCATION, "modules/".$rcxModule->dirname()."/cache/logos/");
?>

<br /><br />
<?php echo _MD_DESCRIPTION;?>:<br />
<?php
//$desc = new RcxFormDhtmlTextArea('', 'desc', $desc, 10, 58);
$desc = new RcxFormDhtmlTextArea('', 'desc', $desc);
echo $desc->render();
?>

<br /><br />
<?php echo _MD_PARENT;?><br />
<?php $mytree->makeMySelBox("title", "title", $pid, 1, "pid");?>

<br /><br />
<input type="hidden" name="cid" value="<?php echo $cid;?>">
<input type="hidden" name="op" value="modCatS"><br />
<input type="submit" class="button" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _DELETE;?>" onclick="location='index.php?pid=<?php echo $pid;?>&cid=<?php echo $cid;?>&op=delCat';">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="location='index.php';">
</form>
<?php

CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function modCatS() {
global $db, $myts, $_POST, $_FILES;

$cid         = intval($_POST['cid']);
$pid         = intval($_POST['pid']);
$imgurl      = $myts->makeTboxData4Save($_POST['imgurl']);
$title       = $myts->makeTboxData4Save($_POST['title']);
$description = $myts->makeTboxData4Save($_POST['desc']);

if ( !empty($_FILES['image']['name']) ) {
        $upload = new fileupload();
        $upload->set_upload_dir('../cache/logos/', 'image');
        $upload->set_accepted('gif|jpg|png', 'image');
        $upload->set_overwrite(2, 'image');
        $result = $upload->upload();
        if ($result['image']['filename']) {
                $imgurl = $result['image']['filename'];
                } else {
                        redirect_header("index.php?op=modCat&cid=$cid", 3, $upload->errors());
                        exit();
                }
}

$db->query("UPDATE ".$db->prefix("links_cat")." SET pid='$pid', title='$title', imgurl='$imgurl', description='$description' WHERE cid=$cid");

build_rss();
redirect_header("index.php", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delCat() {
global $db, $_GET, $mytree;

$cid = intval($_GET['cid']);

if ($_GET['ok'] == 1) {
        //get all subcategories under the specified category
        $arr  = $mytree->getAllChildId($cid);

        $size = count($arr);
        for ($i=0; $i<$size; $i++) {
                //get all links in each subcategory
                $result=$db->query("SELECT lid, logourl FROM ".$db->prefix("links_links")." WHERE cid=".$arr[$i]."");

                //now for each link, delete the text data and vote data associated with the link
                while (list($lid, $logourl) = $db->fetch_row($result)) {
                        @unlink("../cache/shots/" . basename($logourl));
                        $db->query("DELETE FROM ".$db->prefix("links_votedata")." WHERE lid=$lid");
                        $db->query("DELETE FROM ".$db->prefix("links_links")." WHERE lid=$lid");
                }

                //all links for each subcategory is deleted, now delete the subcategory data
                $result = $db->query("SELECT imgurl FROM ".$db->prefix("links_cat")." WHERE cid=".$arr[$i]."");
                list($imgurl) = $db->fetch_row($result);
                @unlink("../cache/logos/" . basename($imgurl));
                $db->query("DELETE FROM ".$db->prefix("links_cat")." WHERE cid=".$arr[$i]."");
        }

        //all subcategory and associated data are deleted, now delete category data and its associated data
        $result = $db->query("SELECT lid, logourl from ".$db->prefix("links_links")." WHERE cid=$cid");
        while (list($lid, $logourl) = $db->fetch_row($result)) {
                @unlink("../cache/shots/" . basename($logourl));
                $db->query("DELETE FROM ".$db->prefix("links_votedata")." WHERE lid=$lid");
                $db->query("DELETE FROM ".$db->prefix("links_links")." WHERE lid=$lid");
        }

        $result = $db->query("SELECT imgurl FROM ".$db->prefix("links_cat")." WHERE cid=$cid");
        list($imgurl) = $db->fetch_row($result);
        @unlink("../cache/logos/" . basename($imgurl));
        $db->query("DELETE FROM ".$db->prefix("links_cat")." WHERE cid=$cid");

        redirect_header("index.php", 1, _MD_CATDELETED);
        exit();
        } else {
                rcx_cp_header();
                OpenTable();
                echo "<center><h4>"._MD_WARNING."</h4><table><tr><td>";
                echo myTextForm("index.php?op=delCat&cid=$cid&ok=1", _YES);
                echo "</td><td>";
                echo myTextForm("index.php", _NO);
                echo "</td></tr></table>";
                CloseTable();
                rcx_cp_footer();
        }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function approve() {
global $rcxConfig, $db, $_POST, $myts, $eh, $meta;

$cid = intval($_POST['cid']);

if ( empty($cid) ) {
        $cid = 0;
}

$lid         = intval($_POST['lid']);
$url         = $myts->makeTboxData4Save($_POST["url"]);
$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
$title       = $myts->makeTboxData4Save($_POST["title"]);
$email       = $myts->makeTboxData4Save($_POST["email"]);
$description = $myts->makeTboxData4Save($_POST["linkdesc"]);

$query = "UPDATE ".$db->prefix("links_links")." SET cid='$cid', title='$title', description='$description', url='$url', email='$email', logourl='$logourl', status=1, date=".time()." where lid=".$lid."";
$db->query($query) or $eh->show("0013");

$result = $db->query("SELECT submitter FROM ".$db->prefix("links_links")." WHERE lid=$lid");
list($submitterid)=$db->fetch_row($result);
$submitter   = RcxUser::getUnameFromId($submitterid);
$subject     = sprintf(_MD_YOURLINK, $meta['title']);
$message     = sprintf(_MD_HELLO, $submitter);
$message    .= "\n\n"._MD_WEAPPROVED."\n\n";
$yourlinkurl = RCX_URL."/modules/links/";
$message    .= sprintf(_MD_YOUCANBROWSE, $yourlinkurl);
$message    .= "\n\n"._MD_THANKSSUBMIT."\n\n".$meta['title']."\n".RCX_URL."\n".$rcxConfig['adminmail']."";
$rcxMailer =& getMailer();
$rcxMailer->useMail();
$rcxMailer->setToEmails($email);
$rcxMailer->setFromEmail($rcxConfig['adminmail']);
$rcxMailer->setFromName($meta['title']);
$rcxMailer->setSubject($subject);
$rcxMailer->setBody($message);
$rcxMailer->send();

build_rss();
redirect_header("./index.php?op=listNewLinks", 1, _MD_NEWLINKADDED);
exit();
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function LinksConfigAdmin() {
global $myts, $linksConfig;

rcx_cp_header();
OpenTable();
?>

<h4><a href="index.php"><?php echo _MAIN;?></a>: <?php echo _MD_GENERALSET;?></h4><br />
<form action="index.php" method="post">
<table width="100%" border="0"><tr>

<td nowrap><?php echo _MD_LINKSPERPAGE;?></td>
<td width="100%">
<select class="select" name="perpage">
<option value="<?php echo $linksConfig['perpage'];?>" selected><?php echo $linksConfig['perpage'];?></option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="50">50</option>
</select>
</td>

</tr><tr>

<td nowrap><?php echo _MD_HITSPOP;?></td>
<td width="100%">
<select class="select" name="popular">
<option value="<?php echo $linksConfig['popular'];?>" selected><?php echo $linksConfig['popular'];?></option>
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="100">100</option>
<option value="500">500</option>
<option value="1000">1000</option>
</select>
</td>

</tr><tr>

<td nowrap><?php echo _MD_LINKSNEW;?></td>
<td width="100%">
<select class="select" name="newlinks">
<option value="<?php echo $linksConfig['newlinks'];?>" selected><?php echo $linksConfig['newlinks'];?></option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="50">50</option>
</select>
</td>

</tr><tr>

<?php
$chk1 = ''; $chk0 = '';
($linksConfig['useshots'] == 1) ? $chk1 = " checked='checked'": $chk0 = " checked='checked'";
?>
<td nowrap><?php echo _MD_USESHOTS;?></td>
<td width="100%">
<input type="radio" class="radio" name="useshots" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="useshots" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td>

</tr><tr>

<td nowrap><?php echo _MD_IMGWIDTH;?></td>
<td width="100%">
<input type="text" class="text" size="10" name="shotwidth" value="<?php echo $linksConfig['shotwidth'];?>" />
</td>

</tr><tr>

<?php
$chk1 = ''; $chk0 = '';
($linksConfig['anon_add'] == 1) ? $chk1 = " checked='checked'": $chk0 = " checked='checked'";
?>
<td nowrap><?php echo _AM_ANON_ADD;?></td>
<td width="100%">
<input type="radio" class="radio" name="anon_add" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="anon_add" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td>

</tr><tr>
<td colspan="2"><hr /></td>
</tr><tr>

<?php
$chk1 = ''; $chk0 = '';
($linksConfig['rss_enable'] == 1) ? $chk1 = " checked='checked'" : $chk0 = " checked='checked'";
?>
<td nowrap><?php echo _AM_RSS_ENABLE;?></td>
<td width="100%">
<input type="radio" class="radio" name="rss_enable" value="1"<?php echo $chk1;?> /> <?php echo _YES;?>
<input type="radio" class="radio" name="rss_enable" value="0"<?php echo $chk0;?> /> <?php echo _NO;?>
</td>

</tr><tr>

<td nowrap><?php echo _AM_RSS_MAXITEMS;?></td>
<td width="100%">
<select class="select" name="rss_maxitems">
<option value="<?php echo $linksConfig['rss_maxitems'];?>" selected="selected"><?php echo $linksConfig['rss_maxitems'];?></option>
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
</select>
</td>

</tr><tr>

<td nowrap><?php echo _AM_RSS_MAXDESCRIPTION;?></td>
<td width="100%">
<select class="select" name="rss_maxdescription">
<option value="<?php echo $linksConfig['rss_maxdescription'];?>" selected="selected"><?php echo $linksConfig['rss_maxdescription'];?></option>
<option value="50">50</option>
<option value="100">100</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="250">250</option>
<option value="300">300</option>
</select>
</td>

</tr><tr>
<td colspan="2"><hr /></td>
</tr><tr>

<td valign="top" nowrap><?php echo _AM_DISCLAIMER;?></td>
<td width="100%">
<?php
$disclaimer = join('', file("../cache/disclaimer.php"));
$disclaimer = $myts->makeTboxData4PreviewInForm($disclaimer);
//$desc       = new RcxFormDhtmlTextArea('', 'disclaimer', $disclaimer, 10, 58);
$desc       = new RcxFormDhtmlTextArea('', 'disclaimer', $disclaimer);
echo $desc->render();
?>
</td>

</tr><tr>
<td colspan="2"><hr /></td>
</tr><tr>

<td colspan="2">
<input type="hidden" name="op" value="LinksConfigChange">
<input type="submit" class="button" value="<?php echo _SAVE;?>">
<input type="button" class="button" value="<?php echo _CANCEL;?>" onclick="javascript:history.go(-1)">
</td>

</tr></table>
</form>

<?php
CloseTable();
rcx_cp_footer();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function LinksConfigChange() {
global $_POST, $myts;

$content  = "<?PHP\n";
$content .= "\$linksConfig['popular']            = ".intval($_POST['popular']).";\n";
$content .= "\$linksConfig['newlinks']           = ".intval($_POST['newlinks']).";\n";
$content .= "\$linksConfig['perpage']            = ".intval($_POST['perpage']).";\n";
$content .= "\$linksConfig['useshots']           = ".intval($_POST['useshots']).";\n";
$content .= "\$linksConfig['shotwidth']          = ".intval($_POST['shotwidth']).";\n";
$content .= "\$linksConfig['anon_add']           = ".intval($_POST['anon_add']).";\n";
$content .= "\$linksConfig['rss_enable']         = ".intval($_POST['rss_enable']).";\n";
$content .= "\$linksConfig['rss_maxitems']       = ".intval($_POST['rss_maxitems']).";\n";
$content .= "\$linksConfig['rss_maxdescription'] = ".intval($_POST['rss_maxdescription']).";\n";
$content .= "?>";

$filename = "../cache/config.php";
if ( $file = fopen($filename, "w") ) {
        fwrite($file, $content);
        fclose($file);
        } else {
                redirect_header("index.php", 1, _NOTUPDATED);
                exit();
        }

$filename = "../cache/disclaimer.php";
if ( $file = fopen($filename, "wb") ) {
        $disclaimer = $myts->oopsStripSlashesGPC($_POST['disclaimer']);
        $disclaimer = $myts->stripPHP($disclaimer);
        fwrite($file, $disclaimer);
        fclose($file);
        } else {
                redirect_header("index.php", 1, _NOTUPDATED);
                exit();
        }

redirect_header("index.php", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function build_rss() {
global $db, $linksConfig;

if ($linksConfig['rss_enable'] == 1) {

$SQL= "SELECT title, lid, description FROM ".$db->prefix("links_links")." WHERE status != 0 ORDER BY date DESC";

$query = $db->query($SQL, $linksConfig['rss_maxitems']);

if ($query) {
        $rss = new xml_rss(RCX_ROOT_PATH . '/modules/links/cache/links.xml');
        $rss->channel_title .= " :: "._MI_LINKS_NAME;
        $rss->image_title   .= " :: "._MI_LINKS_NAME;
        $rss->max_items            = $linksConfig['rss_maxitems'];
        $rss->max_item_description = $linksConfig['rss_maxdescription'];

        while ( list($title, $link, $description) = $db->fetch_row($query) ) {
                $link = RCX_URL . '/modules/links/singlelink.php?lid=' . $link;
                $rss->build($title, $link, $description);
        }
        $rss->save();
        }
}
}

$op = !empty($_POST['op']) ? $_POST['op'] : $_GET['op'];

switch ($op) {

case "delNewLink":
        delNewLink();
        break;

case "approve":
        approve();
        break;

case "addCat":
        addCat();
        break;

case "addLink":
        addLink();
        break;

case "listBrokenLinks":
        listBrokenLinks();
        break;

case "delBrokenLinks":
        delBrokenLinks();
        break;

case "ignoreBrokenLinks":
        ignoreBrokenLinks();
        break;

case "listModReq":
        listModReq();
        break;

case "changeModReq":
        changeModReq();
        break;

case "ignoreModReq":
        ignoreModReq();
        break;

case "delCat":
        delCat();
        break;

case "modCat":
        modCat();
        break;

case "modCatS":
        modCatS();
        break;

case "modLink":
        modLink();
        break;

case "modLinkS":
        modLinkS();
        break;

case "delLink":
        delLink();
        break;

case "delVote":
        delVote();
        break;

case "LinksConfigAdmin":
        LinksConfigAdmin();
        break;

case "LinksConfigChange":
        LinksConfigChange();
        break;

case "linksConfigMenu":
        linksConfigMenu();
        break;

case "listNewLinks":
        listNewLinks();
        break;

default:
        links();
        break;
}
?>