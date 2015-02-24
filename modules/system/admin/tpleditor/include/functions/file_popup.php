<?php 
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* converted to Runcms2 serie by Farsus Design www.farsus.dk
*
* Original Author: LARK (balnov@kaluga.net)
* Support of the module : http://www.runcms.ru
* License Type : ATTENTION! See /LICENSE.txt
* Copyright: (C) 2005 Vladislav Balnov. All rights reserved
*
*/ 
defined( 'RCX_ROOT_PATH' ) or exit( '<h1>Forbidden</h1> You don\'t have permission to access' );

function file_popup()
{
$module = $_GET['module'];
if (!empty($module)) {
    include_once(RCX_ROOT_PATH . "/modules/" . $module . "/include/rcxv.php");
    if (empty($modversion['tpl'])) {
        echo <<<END
<script type="text/javascript">
<!-- 
window.close(); 
//-->
</script>
END;
        exit();
    } 
    $tpl_files['tpl'] = $modversion['tpl'];
    $tpl_files['css'] = $modversion['css'];
    unset($modversion);
} else {
    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/tpl_files_config.php");
} 

$tpl = $_GET['tpl'];
$type = $_GET['type'];

if (check_theme($tpl) == false || check_type($type) == false) {
    redirect_header('admin.php?fct=tpleditor', 3, _NOPERM);
    exit();
}

if (!empty($_GET['block'])) {
    $file = basename($_GET['block'] . '.html');
    $dir = RCX_ROOT_PATH . "/themes/" . $tpl . "/";
    $blocks_list = get_tpl_block_list($dir);
    if (!in_array($file, $blocks_list)) {
        redirect_header('admin.php?fct=tpleditor', 5, sprintf(_TE_NO_FILE2, $file));
        exit();
    } 
} else {
    $file = $tpl_files[$type][$_GET['file']]['name'];
} 
$pathinfo = pathinfo($file);
if (ereg('html|js|css', $pathinfo['extension'])) {
    $ext = $pathinfo['extension'];
} else {
    $ext = 'html';
} 
rcx_header(false);

?>
<link href="<?php echo RCX_URL;?>/modules/system/admin/tpleditor/images/style/<?php echo $ext ;?>.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
 if(window.self.name != 'file_popup')
    window.close();
	//-->
	</script>
</head>
<body>
<?php
$text = file_get_contents(RCX_ROOT_PATH . '/themes/' . $tpl . '/' . $file);
include_once(RCX_ROOT_PATH . '/modules/system/admin/tpleditor/class/highlighter/Highlighter.php');
$options = array('numbers' => HL_NUMBERS_LI,
    'tabsize' => 8,
    );
$hl = &Text_Highlighter::factory(strtolower($ext), $options);
$html = $hl->highlight($text);

?>
<div class="bg1"><center><br />
<font size="2"><?php echo sprintf(_TE_FILE, basename($file));?><b><?php echo $nomdufichier;?></b></font>
<br /><br /><hr>
<a href="javascript:window.print()"><img src="<?php echo RCX_URL;?>/modules/system/admin/tpleditor/images/print.png" alt="<?php echo _TE_PRINT_PAGE;?>"  title="<?php echo _TE_PRINT_PAGE;?>" border="0"></a>
<a href="javascript:window.close()"><img src="<?php echo RCX_URL;?>/modules/system/admin/tpleditor/images/close.png" alt="<?php echo _TE_CLOSE_PAGE;?>"  title="<?php echo _TE_CLOSE_PAGE;?>" border="0"></a>
</center><hr><br /><?php echo $html;?><br /><hr><center>
<a href="javascript:window.print()"><img src="<?php echo RCX_URL;?>/modules/system/admin/tpleditor/images/print.png" alt="<?php echo _TE_PRINT_PAGE;?>" title="<?php echo _TE_PRINT_PAGE;?>" border="0"></a>
<a href="javascript:window.close()"><img src="<?php echo RCX_URL;?>/modules/system/admin/tpleditor/images/close.png" alt="<?php echo _TE_CLOSE_PAGE;?>" title="<?php echo _TE_CLOSE_PAGE;?>" border="0"></a>
<hr>
</center><br />
<?php
rcx_footer(0);
echo '</div>';
}
?>