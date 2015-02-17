<?php
/**
 *
 * @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
 * @ Package: ScarPoX / shortterm SPX
 * @ Subpackage: RUNCMS 
 * @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
 *
 */
define("RCX_INDEX", 1);

include_once("mainfile.php");

//check if start page is defined
if (!empty($rcxConfig['startpage']) && $rcxConfig['startpage'] != '-1' && $rcxConfig['startpage'] != '--') {

    if ($rcxConfig['no_redirect'] == 1) {
        // hack set Module for your start page to index.php
        include(RCX_ROOT_PATH . '/modules/' . $rcxConfig['startpage'] . '/index.php');
        // end hack set Module for your start page to index.php
    } else {
        $url = "modules/" . $rcxConfig['startpage'] . "/";
        header('Status: 302 Found');
        header("Location: $url");
        ?>
        <html>
            <head><meta http-equiv="Refresh" content="0; URL=<?php echo $url; ?>" /></head>
            <body></body>
        </html>
        <?php
    }
    exit();
} else {
    $rcxOption['show_rblock'] = 1;
    include_once('./header.php');
    make_cblock();
    include_once('./footer.php');
}
?>