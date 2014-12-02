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

if(!isset($dirname) || $dirname == "") {
  $dirname = "admin/version";
}
if ( is_numeric($mid) ) {
  $versioninfo = new RcxModule($mid);
} else {
  $versioninfo = new RcxModule();
  $versioninfo->loadModInfo($mid);
}
?>

<html>
<head>
<title><?php echo $meta['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CHARSET;?>"/>
<link href="<?php echo RCX_URL;?>/include/style.css" rel="stylesheet" type="text/css" />

<?php
$themecss = getcss(getTheme());
if ( $themecss ) {
echo "<style type='text/css' media='all'><!-- @import url($themecss); --></style>\n";
}
?>

</head>
<body class="sysbody"><br />

<table align="center" width="80%"><tr>

<td align="center">
<img src="<?php echo RCX_URL."/modules/".$versioninfo->dirname()."/".$versioninfo->image();?>" border="0" />
<br />
<big><b><?php echo $versioninfo->name();?></b></big>
<br /><hr />
</td>

</tr><tr>

<td><br /><u>Version</u>:</td>

</tr><tr>

<td><?php echo $versioninfo->currentVersion();?></td>

</tr><tr>

<td><br /><u>Description</u>:</td>

</tr><tr>

<td><?php echo $versioninfo->description();?></td>

</tr><tr>

<td><br /><u>Author</u>:</td>

</tr><tr>

<td><?php echo $versioninfo->author();?></td>

</tr><tr>

<td><br /><u>Credits</u>:</td>

</tr><tr>

<td><?php echo $versioninfo->credits();?></td>

</tr><tr>

<td><br /><u>License</u>:</td>
</tr><tr>

<td><?php echo $versioninfo->license();?></td>

</tr><tr>

<td align="center"><br /><hr /><a href="javascript:window.close();"><?php echo _CLOSE;?></a><hr /></td>

</tr></table>

</body></html>
