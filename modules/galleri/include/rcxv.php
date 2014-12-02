<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
$modversion['name'] = _MI_GALLI_NAME;
$modversion['version'] = 2.03;
$modversion['description'] = _MI_GALLI_DESC;
$modversion['author'] = "";
$modversion['credits'] = "Module for E-XOOPS/Runcms create:<br>Marx Hans (http://www.bama-webdesign.de)<br />Remake for RUNCMS by SVL:(www.propan-sochi.ru)<br>(xtro.onego.ru) Video mod for RUNCMS - source (www.slo-source.com)<br />Administration and other part makeover and opdatet to RunCms Serie 2 by Farsus (http://www.farsus.dk)";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/galleri_slogo.png";
$modversion['dirname'] = "galleri";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'][0] = "galli_img";
$modversion['tables'][1] = "galli_category";
$modversion['tables'][2] = "galli_vote";
$modversion['tables'][3] = "galli_conf";
$modversion['tables'][4] = "galli_user";
$modversion['tables'][5] = "galli_mail";
$modversion['tables'][6] = "galli_coadmin";
$modversion['tables'][7] = "galli_comments";

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";

$modversion['blocks'][1]['file'] = "block.php";
$modversion['blocks'][1]['name'] = "Billeder";
$modversion['blocks'][1]['description'] = "Galleri til billeder";
$modversion['blocks'][1]['show_func'] = "b_galli_show";

$modversion['hasMain'] = 1;
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "galli_search";

?>