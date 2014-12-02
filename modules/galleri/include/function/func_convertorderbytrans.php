<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    function convertorderbytrans($orderby) {
      if ($orderby == "clic ASC") $orderbyTrans = _MD_POPULARITYLTOM;
      if ($orderby == "clic DESC") $orderbyTrans = _MD_POPULARITYMTOL;
      if ($orderby == "titre ASC") $orderbyTrans = _MD_TITLEATOZ;
      if ($orderby == "titre DESC") $orderbyTrans = _MD_TITLEZTOA;
      if ($orderby == "date ASC") $orderbyTrans = _MD_DATEOLD;
      if ($orderby == "date DESC") $orderbyTrans = _MD_DATENEW;
      if ($orderby == "rating ASC") $orderbyTrans = _MD_RATINGLTOH;
      if ($orderby == "rating DESC") $orderbyTrans = _MD_RATINGHTOL;
      return $orderbyTrans;
    }
?>
