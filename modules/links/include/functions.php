<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

/**
* Description
*
* @param type $var description
* @return type description
*/
function mainheader() {
echo "<div align='center'><a href='".RCX_URL."/modules/links/index.php'><img src='".RCX_URL."/modules/links/images/logo.gif' border='0' alt='' /></a></div><br />";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function newlinkgraphic($time, $status) {

$count     = 7;
$startdate = ( time() - (86400 * $count) );

if ($startdate < $time) {
	if ($status == 1) {
		echo "&nbsp;<img src='".RCX_URL."/modules/links/images/newred.gif' alt='"._MD_NEWTHISWEEK."' />";
		} elseif ($status == 2) {
			echo "&nbsp;<img src='".RCX_URL."/modules/links/images/update.gif' alt='"._MD_UPTHISWEEK."' />";
		}
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function popgraphic($hits) {
global $linksConfig;

if ($hits >= $linksConfig['popular']) {
	echo "&nbsp;<img src='".RCX_URL."/modules/links/images/pop.gif' alt='"._MD_POPULAR."' />";
	}
}

/**
* Description
*
* @param type $var description
* @return type description
*/
//Reusable Link Sorting Functions
function convertorderbyin($orderby) {

if ($orderby == "titleA")  { $orderby = "title ASC";   }
if ($orderby == "dateA")   { $orderby = "date ASC";    }
if ($orderby == "hitsA")   { $orderby = "hits ASC";    }
if ($orderby == "ratingA") { $orderby = "rating ASC";  }
if ($orderby == "titleD")  { $orderby = "title DESC";  }
if ($orderby == "dateD")   { $orderby = "date DESC";   }
if ($orderby == "hitsD")   { $orderby = "hits DESC";   }
if ($orderby == "ratingD") { $orderby = "rating DESC"; }

return $orderby;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function convertorderbytrans($orderby) {

if ($orderby == "hits ASC")    { $orderbyTrans = _MD_POPULARITYLTOM; }
if ($orderby == "hits DESC")   { $orderbyTrans = _MD_POPULARITYMTOL; }
if ($orderby == "title ASC")   { $orderbyTrans = _MD_TITLEATOZ;      }
if ($orderby == "title DESC")  { $orderbyTrans = _MD_TITLEZTOA;      }
if ($orderby == "date ASC")    { $orderbyTrans = _MD_DATEOLD;        }
if ($orderby == "date DESC")   { $orderbyTrans = _MD_DATENEW;        }
if ($orderby == "rating ASC")  { $orderbyTrans = _MD_RATINGLTOH;     }
if ($orderby == "rating DESC") { $orderbyTrans = _MD_RATINGHTOL;     }

return $orderbyTrans;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function convertorderbyout($orderby) {

if ($orderby == "title ASC")   { $orderby = "titleA";  }
if ($orderby == "date ASC")    { $orderby = "dateA";   }
if ($orderby == "hits ASC")    { $orderby = "hitsA";   }
if ($orderby == "rating ASC")  { $orderby = "ratingA"; }
if ($orderby == "title DESC")  { $orderby = "titleD";  }
if ($orderby == "date DESC")   { $orderby = "dateD";   }
if ($orderby == "hits DESC")   { $orderby = "hitsD";   }
if ($orderby == "rating DESC") { $orderby = "ratingD"; }

return $orderby;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
//updates rating data in itemtable for a given item
function updaterating($sel_id) {
global $db;

$sql    = "SELECT rating FROM ".$db->prefix("links_votedata")." WHERE lid = ".$sel_id."";
$result = $db->query($sql);

$num_votes   = intval($db->num_rows($result));
$totalrating = 0;

while (list($rating) = @$db->fetch_row($result)) {
	$totalrating += intval($rating);
}

if ($result) {
	$finalrating = ($totalrating/$num_votes);
	$finalrating = number_format($finalrating, 2);
	} else {
		$finalrating = 0;
	}

$sql = "UPDATE ".$db->prefix("links_links")." SET rating=$finalrating, votes=$num_votes WHERE lid=$sel_id";
$db->query($sql) or print($db->error());
}

/**
* returns the total number of items in table that
* are accociated with a given table $table id
*
* @param type $var description
* @return type description
*/
function getTotalItems($sel_id, $status='') {
global $db, $mytree;

$query = 'SELECT SUM(cid='.intval($sel_id).')';
$arr   = array();
$arr   = $mytree->getAllChildId($sel_id);
$size  = count($arr);

for ($i=0; $i<$size; $i++) {
	$query .= ', SUM(cid='.intval($arr[$i]).')';

}

$query .= ' FROM '.$db->prefix('links_links').'';

if ($status != '') {
	$query .= ' WHERE status >= '.intval($status).'';
}

$result = $db->query($query);
$count  = $db->fetch_row($result);

if (!empty($count)) {
	foreach ($count as $key => $value) {
		$out += $value;
	}
}

return $out;
}
?>
