<table width="99%" align="center"><tr><td>
<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

$form = new RcxThemeForm("", "dbform", "./install.php");

	$db_select = new RcxFormSelect(_INSTALL_DF_DB."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_DB1."</span><b>", "database", $database);
	$db_select->addOption("mysql", "MySQL");
	$dbhost_text      = new RcxFormText(_INSTALL_DF_HOST."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_HOST1."</span><b>", "dbhost", 30, 100, $dbhost);
	$dbuname_text     = new RcxFormText(_INSTALL_DF_UNAME."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_UNAME1."</span><b>", "dbuname", 30, 100, $dbuname);
	$dbpass_text      = new RcxFormText(_INSTALL_DF_PASS."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_PASS1."</span><b>", "dbpass", 30, 100, $dbpass);
	$dbname_text      = new RcxFormText(_INSTALL_DF_DBNAME."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_DBNAME1."</span><b>", "dbname", 30, 100, $dbname);
	$dbprefix_text    = new RcxFormText(_INSTALL_DF_PREFIX."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_PREFIX1."</span><b>", "prefix", 30, 100, $prefix);
	$dbpconnect_radio = new RcxFormRadioYN(_INSTALL_DF_PCONNECT."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_PCONNECT1."</span><b>", "db_pconnect", $db_pconnect, _YES, _NO);
	$rootpath_text    = new RcxFormText(_INSTALL_DF_PATH."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_PATH1."</span><b>", "root_path", 50, 100, $root_path);
	$rcxurl_text    = new RcxFormText(_INSTALL_DF_URL."<br /><br /></b><span style='font-size:x-small;'>"._INSTALL_DF_URL1."</span><b>", "rcx_url", 50, 100, $rcx_url);
	$op_hidden        = new RcxFormHidden("op", "dbconfirm");
	$submit_button    = new RcxFormButton("", "dbsubmit", _NEXT, "submit");

	$form->addElement($db_select);
	$form->addElement($dbhost_text);
	$form->addElement($dbuname_text);
	$form->addElement($dbpass_text);
	$form->addElement($dbname_text);
	$form->addElement($dbprefix_text);
	$form->addElement($dbpconnect_radio);
	$form->addElement($rootpath_text);
	$form->addElement($rcxurl_text);
	$form->addElement($op_hidden);
	$form->addElement($submit_button);
	$form->setRequired(array('dbhost', 'dbname', 'prefix', 'root_path', 'rcx_url'));

$form->display();
?>
</td></tr></table>
<script type="text/javascript">
re      = /\/_install.*/gi;
str     = top.location.href;
result  = str.replace(re, "");
current = "<?php echo RCX_URL;?>";
if (result != current) {
	rcxGetElementById("rcx_url").value = result;
}
</script>
