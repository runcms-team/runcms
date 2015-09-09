<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

include_once(RCX_ROOT_PATH."/class/rcxobject.php");

class RcxPollOption extends RcxObject {


        function RcxPollOption($id=NULL) {
        $this->RcxObject();
        $this->initVar("option_id", "int", NULL, false);
        $this->initVar("poll_id", "int", NULL, false);
        $this->initVar("option_text", "textbox", NULL, true, 255, true);
        $this->initVar("option_count", "int", 0, false);
        $this->initVar("option_color", "other", NULL, false);
        if ( !empty($id) ) {
                if ( is_array($id) ) {
                        $this->set($id);
                        } else {
                                $this->load(intval($id));
                        }
                }
        }

/**
* Description
*
* @param type $var description
* @return type description
*/
function store() {
global $db;

if ( !$this->isCleaned() ) {
        if ( !$this->cleanVars() ) {
                return false;
        }
}

foreach ( $this->cleanVars as $k=>$v ) {
        $$k = $v;
}

if ( empty($option_id) ) {
        $option_id = $db->genId($db->prefix("poll_option")."_option_id_seq");
        $sql = "
                INSERT INTO ".$db->prefix("poll_option")." VALUES (
                ".intval($option_id).",
                ".intval($poll_id).",
                '$option_text',
                ".intval($option_count).",
                '$option_color')";

        } else {
                $sql = "UPDATE ".$db->prefix("poll_option")." SET option_text='$option_text', option_count='$option_count', option_color='$option_color'  WHERE option_id=".$option_id."";
        }

if ( !$result = $db->query($sql) ) {
        $this->setErrors(_NOTUPDATED);
        return false;
}

if ( empty($option_id) ) {
        return $db->insert_id();
}

return $option_id;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function load($id) {
global $db;

$sql   = "SELECT * FROM ".$db->prefix("poll_option")." WHERE option_id=".$id."";
$myrow = $db->fetch_array($db->query($sql));
$this->set($myrow);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete() {
global $db;

$sql = "DELETE FROM ".$db->prefix("poll_option")." WHERE option_id=".$this->getVar("option_id")."";
if ( !$db->query($sql) ) {
        return false;
}

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function updateCount() {
global $db;

$votes = RcxPollLog::getTotalVotesByOptionId($this->getVar("option_id"));
$sql   = "UPDATE ".$db->prefix("poll_option")." SET option_count=$votes WHERE option_id=".$this->getVar("option_id")."";
$db->query($sql);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function &getAllByPollId($poll_id) {
global $db;

$poll_id = intval($poll_id);
$ret     = array();
$sql     = "
                SELECT
                *
                FROM
                ".$db->prefix("poll_option")."
                WHERE
                poll_id=$poll_id
                ORDER BY option_id";

  $result = $db->query($sql);

//  while ($myrow = $db->fetch_array($result))
  while ($myrow = $db->fetch_assoc($result))
  {
    $ret[] = new RcxPollOption($myrow);
  }

return $ret;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function deleteByPollId($poll_id) {
global $db;

$sql = "DELETE FROM ".$db->prefix("poll_option")." WHERE poll_id=".intval($poll_id);
if ( !$db->query($sql) ) {
        return false;
}

return true;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function resetCountByPollId($poll_id) {
global $db;

$sql = "UPDATE ".$db->prefix("poll_option")." SET option_count=0 WHERE poll_id=".intval($poll_id);
if ( !$db->query($sql) ) {
        return false;
}

return true;
}
}
?>