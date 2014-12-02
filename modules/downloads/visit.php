<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

include_once('../../mainfile.php');
include_once('./cache/config.php');
include_once(RCX_ROOT_PATH."/class/groupaccess.php");

$lid    = intval($_GET['lid']);

if ( empty($lid) ) {
	redirect_header(RCX_URL."/modules/downloads",3);
	exit();
} elseif ( !RcxDownload::isAccessible($lid) ) {
	redirect_header(RCX_URL."/user.php",3,_MD_MUSTREGFIRST);
	exit();
}

if ($downloadsConfig['check_external']) {
	$dl_ref   = parse_url(_HTTP_REFERER);
	$ref_host = $dl_ref['host'];
	if ($ref_host != _HTTP_HOST) {
		?>
		<script type="text/javascript">
		<!--
		self.moveTo(0,0);
		self.resizeTo(screen.availWidth,screen.availHeight);
		window.focus();
		// -->
		</script>
		<?php
		redirect_header(RCX_URL . '/modules/downloads/singlefile.php?lid='.$lid.'', 5, _MD_NOLINK);
		exit();
	}
}
$db->query('UPDATE '.$db->prefix('downloads_downloads').' SET hits=hits+1 WHERE lid='.$lid.' AND status>0');
$result    = $db->query('SELECT url FROM '.$db->prefix('downloads_downloads').' WHERE lid='.$lid.' AND status>0');
list($url) = $db->fetch_row($result);
// Hide file from browser by streaming it, if it's local:
if ( !preg_match('/^(http|https|ftp|ftps)/i', $url) && @is_file('cache/files/'.$url.'') ) {
	header('Cache-Control: no-store, no-cache, max-age=1, s-maxage=1, must-revalidate, post-check=0, pre-check=0');
	header('Content-type: application/octet-stream; name="'.$url.'"');
	header('Content-Disposition: attachment; filename="'.$url.'"');
	header('Location: cache/files/'.$url.'');
	exit();
}
header('Location: '.$url.'');
?>
<html>
<head>
<meta http-equiv="Refresh" content="0; URL=<?php echo $url;?>" />
</head>
<body></body>
</html>
<?php
exit();
?>
