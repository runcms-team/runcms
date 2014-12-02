<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
global $db, $rcxConfig, $rcxModule, $meta;
include ('admin_header.php');
require('../cache/config.php');

$server = $rcxConfig['dbname'];

require('../include/defines.lib.php');
require('../include/build_dump.lib.php');
require('../include/zip.lib.php');

function PMA_myHandler($sql_insert)
{
    global $tmp_buffer;
    $eol_dlm = (isset($GLOBALS['extended_ins']) && ($GLOBALS['current_row'] < $GLOBALS['rows_cnt']))
             ? ','
             : ';';
    $tmp_buffer .= $sql_insert . $eol_dlm . $GLOBALS['crlf'];
}

function PMA_whichCrlf()
{
    $the_crlf = "\n";
    if (PMA_USR_OS == 'Win') {
        $the_crlf = "\r\n";
    }
    else if (PMA_USR_OS == 'Mac') {
        $the_crlf = "\r";
    }
    else {
        $the_crlf = "\n";
    }
    return $the_crlf;
}

$err_url = RCX_URL;

@set_time_limit($cfgExecTimeLimit);
$dump_buffer = '';
$crlf        = PMA_whichCrlf();

$names = $server;
$dates = date ("d-m-y");
$names_dates = $names.'_'.$dates;
$filename = 'BD_'.$names_dates;

if (($cfgZipType == 'bzip') && (PMA_PHP_INT_VERSION >= 40004 && @function_exists('bzcompress'))) {
    $ext       = 'bz2';
    $mime_type = 'application/x-bzip';
} else if (($cfgZipType == 'gzip') &&(PMA_PHP_INT_VERSION >= 40004 && @function_exists('gzencode'))) {
    $ext       = 'gz';
    $mime_type = 'application/x-gzip';
} else if (($cfgZipType == 'zip') && (PMA_PHP_INT_VERSION >= 40000 && @function_exists('gzcompress'))) {
    $ext       = 'zip';
    $mime_type = 'application/x-zip';
} else {
    $ext       = 'sql';
    $cfgZipType = 'none';
    $mime_type = (PMA_USR_BROWSER_AGENT == 'IE' || PMA_USR_BROWSER_AGENT == 'OPERA')
               ? 'application/octetstream'
               : 'application/octet-stream';
}

$tables     = mysql_list_tables($server);
$num_tables = @mysql_numrows($tables);

if ($num_tables == 0) {
    echo '# ' ._DB_NOTABLESFOUND;
}
else {
    $dump_buffer       .= '# Backup for MySQL' . $crlf
                       .  '#' . $crlf;
    $formatted_db_name = (isset($use_backquotes))
                       ? PMA_backquote($server)
                       : '\'' . $server . '\'';
    $i = 0;
    while ($i < $num_tables) {
        $table = mysql_tablename($tables, $i);
        $formatted_table_name = (isset($use_backquotes))
                              ? PMA_backquote($table)
                              : '\'' . $table . '\'';
        $dump_buffer .= '# --------------------------------------------------------' . $crlf
                     .  $crlf . '#' . $crlf
                     .  '# ' ._DB_TABLESTRUCTURE. ' ' . $formatted_table_name . $crlf
                     .  '#' . $crlf . $crlf
                     .  PMA_getTableDef($server, $table, $crlf, $err_url) . ';' . $crlf;

        $tcmt = $crlf . '#' . $crlf
                     .  '# ' ._DB_DUMPINGDATA. ' ' . $formatted_table_name . $crlf
                     .  '#' . $crlf .$crlf;
        $dump_buffer .= $tcmt;
        $tmp_buffer  = '';
        if (!isset($limit_from) || !isset($limit_to)) {
            $limit_from = $limit_to = 0;
        }
        PMA_getTableContent($server, $table, $limit_from, $limit_to, 'PMA_myHandler', $err_url);
        $dump_buffer .= $tmp_buffer;
        $i++;
    }
    $dump_buffer .= $crlf;
}

if ($cfgZipType == 'zip') {
    if (PMA_PHP_INT_VERSION >= 40000 && @function_exists('gzcompress')) {
        $extbis = '.sql';
        $zipfile = new zipfile();
        $zipfile -> addFile($dump_buffer, $filename . $extbis);
        $dump_buffer = $zipfile -> file();
    }
}
else if ($cfgZipType == 'bzip') {
    if (PMA_PHP_INT_VERSION >= 40004 && @function_exists('bzcompress')) {
        $dump_buffer = bzcompress($dump_buffer);
    }
}
else if ($cfgZipType == 'gzip') {
    if (PMA_PHP_INT_VERSION >= 40004 && @function_exists('gzencode')) {
        // without the optional parameter level because it bug
        $dump_buffer = gzencode($dump_buffer);
    }
}

if (isset($_POST['oldurl'])) {
   $oldurl = $_POST['oldurl'];
}
$oldurl = (!isset($oldurl)||empty($oldurl)) ? RCX_URL : $oldurl;
if ($cfgBackupTarget == 'download') {
    header('Content-Type: ' . $mime_type);
    if (PMA_USR_BROWSER_AGENT == 'IE') {
        header('Content-Disposition: inline; filename="' . $filename . '.' . $ext . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    } else {
        header('Content-Disposition: attachment; filename="' . $filename . '.' . $ext . '"');
        header('Expires: 0');
        header('Pragma: no-cache');
    }
    echo $dump_buffer;
} elseif ($cfgBackupTarget == 'email') {
    $fp = fopen(RCX_ROOT_PATH.'/modules/backup/cache/'. $filename . '.' . $ext,'w');
    fwrite($fp, $dump_buffer);
    fclose($fp);
    $name_files = RCX_ROOT_PATH.'/modules/backup/cache/'.$filename.'.'.$ext;
    $subject = 'Backup DB '.$server.'. Create on '.date('H:i D d-M-Y').'.' ;
    $message  = "This backup file:\n";
    $message .= "".$filename.'.'.$ext."\n\n";
    $message .= "--\n";
    $message .= $meta['title']."\n".$rcxConfig['rcx_url']."/";
    $rcxMailer =& getMailer();
    $rcxMailer->useMail();
    $rcxMailer->setToEmails($rcxConfig['adminmail']);
    $rcxMailer->setFromEmail($rcxConfig['adminmail']);
    $rcxMailer->setFromName($meta['title']);
    $rcxMailer->setSubject($subject);
    $rcxMailer->setBody($message);
    $rcxMailer->attachFile($name_files, $mime_type);
    $rcxMailer->send();
    @unlink($name_files);

    redirect_header($oldurl,3,_DB_SAVE_MAIL._DB_SAVE_OK );
} else {
    $fp = fopen(RCX_ROOT_PATH.'/modules/backup/cache/'. $filename . '.' . $ext,'w');
    fwrite($fp, $dump_buffer);
    fclose($fp);
    redirect_header($oldurl,3,_DB_SAVE_CACHE._DB_SAVE_OK );
}
?>
