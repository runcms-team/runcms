<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function birthday_show($options){
        global $db, $rcxConfig, $rcxUser, $timeoffset, $time, $mm, $pm, $my, $py;
        $block = array();
        $block['title'] = ""._NCB_BDAY."";
$useroffset = "";

if($rcxUser){
        $timezone = $rcxUser->timezone();
        if(isset($timezone)){
               $useroffset = $rcxUser->timezone();
        }else{
                $useroffset = $rcxConfig['default_TZ'];
        }

}
    $usertimevent = time() + ($useroffset*3600);
	$heute = date("j", $usertimevent);
	$m = date("m", $usertimevent);
	$d = date("j", $usertimevent);
	$y = date("Y", $usertimevent);
if ($mm != "") {
if ($mm != $m) {
	    $heute = 31;
	}
	$m = $mm;
	$d = date("j", $usertimevent);
	$y = date("Y", $usertimevent);
	$y = $my;
		if ($mm == "0"){
			$m = 12;
			$y = $y-1;
		}
}
if ($pm != "") {
	if ($pm != $m) {
	    $heute = 31;
	}
	$m = $pm;
	$d = date("j", $usertimevent);
	$y = date("Y", $usertimevent);
	$y = $py;
		if ($pm == "13"){
			$m = 1;
			$y = $y+1;
		}
}
$block['content'] .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  width=\"100%\" ><tr><td>";
if ($options[1] == 1){
	$result=$db->query("SELECT uid, uname FROM ".$db->prefix("users")." WHERE birthday = ".date("dm",$usertimevent)."");
	while (list($uid, $uname) = $db->fetch_row($result)){
		$ff = $ff."<br><a href=\"".$rcxConfig['rcx_url']."/userinfo.php?uid=$uid\">$uname</a>  ";
	}
	if ($ff)
		$block['content'] .= "". _NCB_BIRTHDAY ." $ff";
	else
		$block['content'] .= "". _NCB_NOTHDAY ."";
}
$block['content'] .= "</td></tr></table>";
return $block ;
}

?>