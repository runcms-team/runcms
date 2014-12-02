<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function convertorderbyout($orderby) {
      if ($orderby == "titre ASC") $orderby = "titreA";
      if ($orderby == "date ASC") $orderby = "dateA";
      if ($orderby == "clic ASC") $orderby = "clicA";
      if ($orderby == "rating ASC") $orderby = "ratingA";
      if ($orderby == "titre DESC") $orderby = "titreD";
      if ($orderby == "date DESC") $orderby = "dateD";
      if ($orderby == "clic DESC") $orderby = "clicD";
      if ($orderby == "rating DESC") $orderby = "ratingD";
      return $orderby;
    }
?>
