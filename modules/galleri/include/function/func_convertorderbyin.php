<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

    function convertorderbyin($orderby) {
      if ($orderby == "titreA") $orderby = "titre ASC";
      if ($orderby == "dateA") $orderby = "date ASC";
      if ($orderby == "clicA") $orderby = "clic ASC";
      if ($orderby == "ratingA") $orderby = "rating ASC";
      if ($orderby == "titreD") $orderby = "titre DESC";
      if ($orderby == "dateD") $orderby = "date DESC";
      if ($orderby == "clicD") $orderby = "clic DESC";
      if ($orderby == "ratingD") $orderby = "rating DESC";
      return $orderby;
    }
?>
