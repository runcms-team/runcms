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
echo "<div align='center'><a href='".RCX_URL."/modules/downloads/index.php'><img src='".RCX_URL."/modules/downloads/images/logo.gif' border='0' alt='' /></a></div><br />";
}
/**
* Description
*
* @param type $var description
* @return type description
*/
function newdownloadgraphic($time, $status) {

$count     = 7;
$startdate = ( time() - (86400 * $count) );

if ($startdate < $time) {
	if ($status == 1) {
		echo "&nbsp;<img src='".RCX_URL."/modules/downloads/images/newred.gif' alt='"._MD_NEWTHISWEEK."' />";
		} elseif ($status == 2) {
			echo "&nbsp;<img src='".RCX_URL."/modules/downloads/images/update.gif' alt='"._MD_UPTHISWEEK."' />";
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
global $downloadsConfig;

if ($hits >= $downloadsConfig['popular']) {
	echo "&nbsp;<img src ='".RCX_URL."/modules/downloads/images/pop.gif' alt='"._MD_POPULAR."' />";
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
function PrettySize($size) {
$mb = (1024*1024);
if ( $size > $mb ) {
	$mysize = sprintf ("%01.2f", ($size/$mb)) . " MB";
	} elseif ( $size >= 1024 ) {
		$mysize = sprintf ("%01.2f", ($size/1024)) . " KB";
		} else {
			$mysize = sprintf(_MD_NUMBYTES, $size);
		}
return $mysize;
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
$sql    = "SELECT rating FROM ".$db->prefix("downloads_votedata")." WHERE lid=".$sel_id."";
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
$sql = "UPDATE ".$db->prefix("downloads_downloads")." SET rating=$finalrating, votes=$num_votes WHERE lid = $sel_id";
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
$query .= ' FROM '.$db->prefix('downloads_downloads').'';
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
/**
 * Extracting data from a PAD file. More: - {@link http://www.asp-shareware.org/pad/padsdk/php/ PAD SDK}
 *
 * @author Vladislav Balnov (LARK) <balnov@kaluga.net>
 * @param string $pad_url - url to PAD file
 * @param boolean $validate - use validated PAD file
 * @return array - array with the data extracted from the PAD file
 */
function parse_pad_file($pad_url, $validate = false)
{
    global $myts;
    
    include_once(RCX_ROOT_PATH."/modules/downloads/include/padsdk/padfile.php");

    $PAD = new PADFile($pad_url);
    $PAD->Load();
    switch ($PAD->LastError) {
        case ERR_NO_URL_SPECIFIED:
            $pad_array['error'] = _PAD_ERR_NO_URL_SPECIFIED;
            return $pad_array;
        case ERR_READ_FROM_URL_FAILED:
            $pad_array['error'] = _PAD_ERR_CANNOT_OPEN_URL . ($PAD->LastErrorMsg != "" ? $PAD->LastErrorMsg : "");
            return $pad_array;
        case ERR_PARSE_ERROR:
            $pad_array['error'] = _PAD_ERR_PARSE_ERROR . $PAD->ParseError;
            return $pad_array;
    }
    
    if (!empty($validate)) {
    	include_once(RCX_ROOT_PATH."/modules/downloads/include/padsdk/padvalidator.php");
    	$PADValidator = new PADValidator(RCX_ROOT_PATH."/modules/downloads/include/padsdk/pad_spec.xml");
    	if (!$PADValidator->Load()) {
    	    $pad_array['error'] = _PAD_ERR_LOADING_VALIDATOR;
    	    return $pad_array;
    	}
    	$nErrors = $PADValidator->Validate($PAD);
    	if ($nErrors != 0) {
    	    $pad_array['error'] = _PAD_ERR_NOT_VALID;
    	    return $pad_array;
    	}
    }
    $pad_array['title'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name"));
    $pad_array['url'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Download_URLs/Primary_Download_URL"));
    $pad_array['homepage'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_WebSite_URL"));
    $pad_array['version'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version"));
    $pad_array['platform'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_OS_Support"));
    $pad_array['size'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/File_Info/File_Size_Bytes"));
    $pad_array['filedesc'] = $myts->oopsHtmlSpecialChars($PAD->GetBestDescription(2000, ucfirst(RC_ULANG)));
    $pad_array['logourl'] = $myts->oopsHtmlSpecialChars($PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Screenshot_URL"));
    
    return $pad_array;
}

function get_pad_array()
{
    return array('homepage' => 'http://', 'title' => '', 'url' => 'http://', 'version' => '', 'platform' => '', 'size' => '', 'filedesc' => '', 'logourl' => '');
}
?>


