<?php

include ('./mainfile.php');

$meta['title'] = _404_PAGE_TITLE;

include (RCX_ROOT_PATH . '/header.php');

$rcxOption['show_rblock'] = 1;

OpenTable();

echo '<div class="error">';

echo '<h4>' . _404_PAGE_H1 . '</h4>';

echo '<p>' . _404_PAGE_DESCRIPTION . '</p>';

echo '</div>';

CloseTable();

include (RCX_ROOT_PATH . '/footer.php');

?>