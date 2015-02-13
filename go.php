<?php

include_once("./mainfile.php");

if (!empty($_GET['url'])) {

    $url = strip_tags(base64_decode($_GET['url']));

    if (myRefererCheck($errstr) == true) {
        redirect_header($url, 5, _REDIRECT_LINK_ATTENTION);
    }

    exit();

}

?>