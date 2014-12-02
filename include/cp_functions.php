<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !defined("ERCX_CPFUNCTIONS_INCLUDED") ) {
  define("ERCX_CPFUNCTIONS_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
function rcx_cp_header() {
global $rcxConfig, $rcxUser, $rcxModule, $fct, $meta;

rcx_header(false);
$currenttheme = getTheme();
include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/theme.php');
if ( @file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.$rcxConfig['language'].'.php') ) {
			include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-'.$rcxConfig['language'].'.php');
		} elseif ( @file_exists(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php') ) {
			include_once(RCX_ROOT_PATH.'/themes/'.$currenttheme.'/language/lang-english.php');
		}
		include_once(RCX_ROOT_PATH."/modules/system/language/".RC_ULANG."/admin.php");
		
		
if ($rcxModule) {
  if ($rcxModule->dirname() == "system")
  {
    if (@is_dir(RCX_ROOT_PATH . "/modules/system/admin/".$fct."/manual/".RC_ULANG.""))
      $modinfo = "<a href='".RCX_URL."/modules/system/admin/".$fct."/manual/".RC_ULANG."/' target='_blank'><b>".ucfirst($fct)." "._MANUAL."</b></a> <img src='".RCX_URL."/images/language/".RC_ULANG.".gif' border ='0' height='10' width='15'>";
    elseif (@is_dir(RCX_ROOT_PATH . "/modules/system/admin/".$fct."/manual/english"))
      $modinfo = "<a href='".RCX_URL."/modules/system/admin/".$fct."/manual/english/' target='_blank'><b>".ucfirst($fct)." "._MANUAL."</b></a> <img src='".RCX_URL."/images/language/english.gif' border ='0' height='10' width='15'>";
  }else
  {
    if (@is_dir(RCX_ROOT_PATH . "/modules/".$rcxModule->dirname()."/manual/".RC_ULANG))
      $modinfo = "<a href='".RCX_URL."/modules/".$rcxModule->dirname()."/manual/".RC_ULANG."/' target='_blank'><b>".$rcxModule->name()." "._MANUAL."</b></a> <img src='".RCX_URL."/images/language/".RC_ULANG.".gif' border ='0' height='10' width='15'>";
    elseif(@is_dir(RCX_ROOT_PATH . "/modules/".$rcxModule->dirname()."/manual/english"))
      $modinfo = "<a href='".RCX_URL."/modules/".$rcxModule->dirname()."/manual/english/' target='_blank'><b>".$rcxModule->name()." "._MANUAL."</b></a> <img src='".RCX_URL."/images/language/english.gif' border ='0' height='10' width='15'>";
  }
}

//include_once(RCX_ROOT_PATH .'/include/rcxjs.php');

?>
</head>
<?php
    $mids =& RcxModule::getHasAdminModulesList(false);
    $i = 0;
    $mid = 1;    
    if ( isset($rcxUser) && $rcxUser->isAdmin($mid) ) {
        $mod       = new RcxModule($mid);
        $adminmenu = $mod->getAdminMenu();
        $tree[$i]['name']  = $mod->name();
        $tree[$i]['link']  = RCX_URL."/modules/".$mod->dirname()."/".$mod->adminindex();
        $tree[$i]['image'] = '&nbsp;&nbsp;&nbsp;<img src="'.RCX_URL.'/modules/system/images/arrow.png">';
        if ( !empty($adminmenu) ) {
            $j = 0;
            foreach ( $adminmenu as $menuitem ) {
                $tree[$i]['leaves'][$j]['name']  = $menuitem['title'];
                $tree[$i]['leaves'][$j]['link']  = (empty($menuitem['link'])) ? "#" : RCX_URL."/modules/".$mod->dirname()."/".$menuitem['link'];
                $tree[$i]['leaves'][$j]['image'] = '<img src="'.RCX_URL.'/modules/system/images/config.png">';
                $j++;
            }
        }
        $i++;
    }
    $j = 0;
    $tree[$i]['name']  =  _MD_AM_INSTALLED_MODULES;
    $tree[$i]['link']  = 'javascript://';
    $tree[$i]['image'] = '&nbsp;&nbsp;&nbsp;<img src="'.RCX_URL.'/modules/system/images/arrow.png">';
    foreach ( $mids as $mid ) {
        if ( ($mid != 1) && isset($rcxUser) && $rcxUser->isAdmin($mid) ) {
            $mod       = new RcxModule($mid);
            $adminmenu = $mod->getAdminMenu();
            $tree[$i]['leaves'][$j]['name']  = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>'.$mod->name();
            $tree[$i]['leaves'][$j]['title'] = $mod->name();
            $tree[$i]['leaves'][$j]['link']  = RCX_URL."/modules/".$mod->dirname()."/".$mod->adminindex();
            $tree[$i]['leaves'][$j]['image'] = '<img src="'.RCX_URL.'/modules/system/images/module.png">';
            if ( !empty($adminmenu) ) {
                $tree[$i]['leaves'][$j]['name'] .=  '</td><td align="right"><img src="'.RCX_URL.'/modules/system/images/arrow.png">';
                $k=0;
                foreach ( $adminmenu as $menuitem ) {
                    $tree[$i]['leaves'][$j]['leaves'][$k]['name']  = trim($menuitem['title']);
                    $tree[$i]['leaves'][$j]['leaves'][$k]['link']  = (empty($menuitem['link'])) ? "#" : RCX_URL."/modules/".$mod->dirname()."/".$menuitem['link'];
                    $tree[$i]['leaves'][$j]['leaves'][$k]['image'] = '<img src="'.RCX_URL.'/modules/system/images/edit.png">';
                    $k++;
                }
            }
            $tree[$i]['leaves'][$j]['name'] .= '</td></tr></table>';
            $j++;
        }
    }
    array_unshift($tree, array('image' => '&nbsp;&nbsp;&nbsp;<img src="'.RCX_URL.'/modules/system/images/arrow.png">', 'link' => RCX_URL.'/user.php?op=logout', 'name' => _LOGOUT));
    array_push($tree, array('image' => '&nbsp;&nbsp;&nbsp;<img src="'.RCX_URL.'/modules/system/images/arrow.png">', 'link' => RCX_URL.'/', 'name' => _YOURHOME));
    include_once(RCX_ROOT_PATH.'/class/jsmenu/jstree.class.php');
    $adminmenu = New jstree('adminmenu', $tree, 'horizontal_bottom_right');
    $adminmenu->setCSS(RCX_URL.'/themes/'.getTheme().'/style/admin_menu.css');
        ?>
<body class="sysbody">
<center>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr align="center" id="admintop">
			<td><a href="http://www.scarpox.dk" ><img src="<?php echo RCX_URL;?>/images/system/adminlogo.png" alt="Scarpox"/></a>
<table width="100%" border="0" cellspacing="1" cellpadding="2">
	<tr class="sysbg1a">
		<td style="text-align: left;"><?php echo "".$adminmenu->render().""; ?> </td>
<?php
//global $modinfo,$rcxModule,$rcxConfig;
if ($modinfo) {
echo "<td style='text-align: center;'>" . $modinfo . "</td>";
}
?>
	</tr>
</table>
		</td>
	</tr>
</table>
<table  style="border: 1px solid #4671a4; align: center; width:100%;"><tr class="sysbg1">
	<td style='border: 1px solid #4671a4;text-align:left; vertical-align:top; width: 150px;'>

<div style="text-align: center;"><a
 href="http://www.scarpox.dk"><img
 style="border: 0px solid ; width: 142px; height: 139px;"
 alt="ScarPoX Dansk Cmssystem"
 src="<?php echo RCX_URL;?>/images/promo.jpg" /></a><br />

<div style='text-align:center;'><?php echo _AM_YOUR_VERSION;?> :<br /><br />
<b><?php echo RCX_VERSION;?></b><br /><br />

</div>
<div style='text-align:center;'><?php echo _AM_LATEST_VERSION;?> :<br /><br />
<b><a href="http://www.runcms.org" ><img src="http://www.scarpox.dk/latest/runcmslatest.gif" alt="RunCms Latest"/></b>

</div>
</div>
</td><td class='bg1'>



<?php
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function rcx_cp_footer() {
global $rcxConfig;
?>
</td>
</tr><tr>
<td colspan="2">
<!--- you are not allowed to remove or changes this copyright and link in this footer --->
<div align="center"><a href="http://www.runcms.org/" target='_blank'> Powered by <?php echo RCX_VERSION;?> &copy; 2002-<?php echo date('Y');?></a> :: <a href="http://www.runcms.ru/" target="_blank">Localization &copy; 2010 RUNCMS.RU</a></div>
</td>
</tr></table></center>
<?php
if ( !empty($rcxConfig['debug_mode']) ) {
  debug_info($rcxConfig['debug_mode']);
}
echo "</body></html>";
ob_end_flush();
}
function showModuleAdminMenu()
{		
	global $modinfo,$rcxModule,$rcxConfig,$rcxUser;
		if (!$rcxModule){
    			$mid2 = 1;
    			}else{
    			$mid2 = $rcxModule->mid();
    			}
			$modul = new RcxModule($mid2);
		$file_menu = $modul->modinfo['adminmenu'];
		if ($file_menu){
			    $file = RCX_ROOT_PATH."/modules/".$modul->dirname()."/".$modul->modinfo['adminmenu'];
    if ( isset($rcxUser) && $rcxUser->isAdmin($mid2) ) {  
    if ( @file_exists($file) ) {
        require($file);
        echo "<ul>";
        $i = 0;
        foreach ( $adminmenu as $menuarray ) {
            echo "<li><a href='".RCX_URL."/modules/".$modul->dirname()."/".$adminmenu[$i]['link']."'>".$adminmenu[$i]['title']."</a></li>";
            $i++;
        }
      echo "</ul>";
        
    }
  }
  
}else{
	echo "";
}
}
}
?>