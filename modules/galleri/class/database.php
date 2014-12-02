<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if(!defined("RCX_C_DATABASE_INCLUDED")){
  define("RCX_C_DATABASE_INCLUDED",1);

class AbsDatenbank {
  var $prefix;
  var $debug = false;

  function AbsDatenbank(){
    die("Cannot instantiate this class directly");
  }

  function setPrefix($value) {
    $this->prefix = $value;
  }

  function prefix($tablename="") {
    if($tablename != ""){
      return $this->prefix ."_". $tablename;
    } else {
      return $this->prefix;
    }
  }

  function setDebug($flag=true) {
    if ( $flag ) {
      $this->debug = true;
    } else {
      $this->debug = false;
    }
  }
}

}
?>