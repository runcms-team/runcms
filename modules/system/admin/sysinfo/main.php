<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

//error_reporting (E_ALL);
if (!preg_match("/admin\.php/i", $_SERVER['PHP_SELF']))
    exit();

//include_once(RCX_ROOT_PATH."/class/rcxformloader.php");

/**
* Description
*
* @param type $var description
* @return type description
*/
function get_system_information() {
  global $rcxConfig, $db, $_SERVER;
    
  $db_host  = $rcxConfig['dbhost'];
  $mhost    = $_SERVER['SERVER_NAME'];
  $sql      = 'SELECT now() as datetime';
  $db_query = $db->query($sql);
  $dbinfo   = $db->fetch_array($db_query);
  list($system, $kernel) = preg_split('/[\s,]+/', @exec('uname -a'), 5);

  return array('date'       => date('d-m-Y H:i:s'),
                'ip'         => gethostbyname($mhost),
                'host'       => $mhost,
                'db_server'  => $db_host,
               'db_ip'      => gethostbyname($db_host),
               'db_date'    => $dbinfo['datetime']
          
               );
}

$sysinfo = get_system_information();

rcx_cp_header();


echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_AM_SYSINFO.'</div>
            <br />
            <br />';

OpenTable();

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}
error_reporting(0); // Ingen error reporting!

?>

<h2><?php echo _T_SI_FILP;?></h2>

<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg3'>



<td class="sysbg1" ><strong><?php echo _T_SI_FILPAP;?></strong></td>
<td class="sysbg3" style="width: 800px">&nbsp;<?php echo RCX_ROOT_PATH;?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><strong><?php echo _T_SI_FILPSAP;?></strong></td>
<td class="sysbg3" >&nbsp;<?php $sp=ini_get('session.save_path'); if ($sp!="") { echo "<b>".$sp."</b>"; } else { echo "<b>Ikke sat...</b>"; } ?>&nbsp;</td>

    </tr></table></td>
    </tr></table>

<h2><?php echo _T_SI_SERSI;?></h2>

<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg3'>


        
<td class="sysbg1" ><?php echo _T_SI_SERSIO;?></td>
<td class="sysbg3">&nbsp;<?php echo substr(php_uname(),0,7); ?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1"><?php echo _T_SI_SERSIW;?></td>
<td class="sysbg3">&nbsp;<?php if ($_SERVER['SERVER_SOFTWARE'] != null) { echo "<b>". $_SERVER['SERVER_SOFTWARE'] ."</b>"; }else { echo "Server name and version: <b>Disable on server!</b><br />\n"; } ?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><?php echo _T_SI_SERSIPHP;?></td>
<td class="sysbg3">&nbsp;<?php echo phpversion();?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1"><?php echo _T_SI_SERSIMYS;?></td>
<td class="sysbg3">&nbsp;<?php echo mysql_get_server_info();?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><?php echo _T_SI_SERSIDB;?></td>
<td class="sysbg3">&nbsp;<?php echo $sysinfo['db_server'];?>&nbsp;(<?php echo $sysinfo ['db_ip'];?>)&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><?php echo _T_SI_SERSIGD;?></td>
<td class="sysbg3">&nbsp;<?php if (extension_loaded('gd')) { echo "<font color=\"green\">YES</font>"; } else { echo "<font color=\"red\">NO</font>"; } ?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><?php echo _T_SI_SERSIGZI;?></td>
<td class="sysbg3">&nbsp;<?php if ($_SERVER['HTTP_ACCEPT_ENCODING'] != null) { echo "<font color=\"green\">YES</font>"; } else { echo "<font color=\"red\">NO</font>"; } ?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><?php echo _T_SI_SERSICGI;?></td>
<td class="sysbg3">&nbsp;<?php echo $_SERVER['GATEWAY_INTERFACE']; ?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1"><?php echo _T_SI_SERSIMAXF;?></td>
<td class="sysbg3">&nbsp;<?php echo ini_get('post_max_size'); ?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1"><?php echo _T_SI_SERSIKLS;?></td>
<td class="sysbg3">&nbsp;<?php echo  $sysinfo['date'];?>&nbsp;</td>
</tr>
<tr>
<td class="sysbg1" ><?php echo _T_SI_SERSISERV;?></td>
<td class="sysbg3">&nbsp;<?php echo $sysinfo['host'];?>&nbsp;(<?php echo $sysinfo['ip'];?>)&nbsp;</td>

    </tr></table></td>
    </tr></table>

<h2><?php echo _T_SI_PHPC;?></h2>

<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg3'>

<td style="width: 182px"><b><?php echo _T_SI_PHPCKON;?></b></td>
<td style="width: 150px"><b><?php echo _T_SI_PHPCANB;?></b>&nbsp;&nbsp;</td>
<td style="width: 150px"><b><?php echo _T_SI_PHPCAKT;?></b></td>
</tr>
<?php 
    $php_recommended_settings = array(array (_T_SI_PHPCSAF,'safe_mode','OFF'),
	array (_T_SI_PHPCDIS ,'display_errors','OFF'),
	array (_T_SI_PHPCFIL,'file_uploads','ON'),
	array (_T_SI_PHPCMQG,'magic_quotes_gpc','OFF'),
	array (_T_SI_PHPCMQR,'magic_quotes_runtime','OFF'),
	array (_T_SI_PHPCRG,'register_globals','OFF'),
	array (_T_SI_PHPCOP,'output_buffering','OFF'),
	array (_T_SI_PHPCSES,'session.auto_start','OFF'),
	);
    foreach ($php_recommended_settings as $phprec) {
?>
<tr>
<td class="sysbg1" style="width: 182px"><?php echo $phprec[0];?></td>
<td class="sysbg1" style="width: 150px"><?php echo $phprec[2];?></td>
<td class="sysbg1" style="width: 150px">
<?php
	if ( get_php_setting($phprec[1]) == $phprec[2] ) {
?>
<font color="green"><b>
<?php
	} else {
?>
<font color="red"><b>
<?php
	}
	echo get_php_setting($phprec[1]);
?>
</b></font>
</td>
</tr>
<?php } ?>
    </table></td>
    </tr></table>
<?php
CloseTable();

echo "                        
        </td>
    </tr>
</table>";

rcx_cp_footer();
?>