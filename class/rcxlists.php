<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("RCX_RCXLISTS_INCLUDED")) {
	define("RCX_RCXLISTS_INCLUDED", 1);

/**
* Description
*
* @param type $var description
* @return type description
*/
class RcxLists {

/**
* Description
*
* @param type $var description
* @return type description
*/
static function &getTimeZoneList() {
$time_zone_list = array ("-12" => _GMTM12, "-11" => _GMTM11, "-10" => _GMTM10, "-9" => _GMTM9, "-8" => _GMTM8, "-7" => _GMTM7, "-6" => _GMTM6, "-5" => _GMTM5, "-4" => _GMTM4, "-3.5" => _GMTM35, "-3" => _GMTM3, "-2" => _GMTM2, "-1" => _GMTM1, "0" => _GMT0, "1" => _GMTP1, "2" => _GMTP2, "3" => _GMTP3, "3.5" => _GMTP35, "4" => _GMTP4, "4.5" => _GMTP45, "5" => _GMTP5, "5.5" => _GMTP55, "6" => _GMTP6, "7" => _GMTP7, "8" => _GMTP8, "9" => _GMTP9, "9.5" => _GMTP95, "10" => _GMTP10, "11" => _GMTP11, "12" => _GMTP12);

return $time_zone_list;
}

/**
* gets list of themes folder from themes directory
*/
static function &getThemesList() {
$themes_list = array();
$themes_list =& RcxLists::getDirListAsArray(RCX_ROOT_PATH."/themes/");

return $themes_list;
}

/**
* gets list of name of directories inside a directory
*
* @param type $var description
* @return type description
*/
static function &getDirListAsArray($dirname) {
$dirlist = array();
if ($handle = @opendir($dirname)) {
	while (false !== ($file = readdir($handle))) {
		if ( ($file != ".") && ($file != "..") ) {
			if ( @is_dir($dirname.$file) ) {
				$dirlist[$file] = $file;
			}
		}
	}
	closedir($handle);
	asort($dirlist);
	reset($dirlist);
}
return $dirlist;
}

/**
* gets list of image file names in a directory
*
* @param type $var description
* @return type description
*/
static function &getImgListAsArray($dirname, $prefix="") {

$filelist = array();

if ($handle = @opendir($dirname)) {
	while (false !== ($file = readdir($handle))) {
		if ( preg_match("/\.(gif|jpg|png)$/i", $file) ) {
			$file = $prefix.$file;
			$filelist[$file] = $file;
		}
	}

	closedir($handle);
	asort($filelist);
	reset($filelist);
}

return $filelist;
}

/**
* gets list of avatar file names in a certain directory
* if directory is not specified, default directory will be searched
*
* @param type $var description
* @return type description
*/
static function &getAvatarsList($avatar_dir="") {

$avatars = array();

if ( $avatar_dir != "" ) {
	$avatars =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/".$avatar_dir."/", $avatar_dir."/");
	} else {
		$avatars =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/");
	}

return $avatars;
}

/**
* gets list of all avatar image files inside default avatars directory
*/
static function &getAllAvatarsList() {

$avatars = array();
$dirlist = array();
$dirlist =& RcxLists::getDirListAsArray(RCX_ROOT_PATH."/images/avatar/");

if ( count($dirlist) > 0 ) {
	foreach ( $dirlist as $dir ) {
		$avatars[$dir] =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/avatar/".$dir."/", $dir."/");
	}
	} else {
		return false;
	}

return $avatars;
}

/**
* gets list of subject icon image file names in a certain directory
* if directory is not specified, default directory will be searched
*
* @param type $var description
* @return type description
*/
function &getSubjectsList($sub_dir="") {

$subjects = array();

if ($sub_dir != "") {
	$subjects =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/subject/".$sub_dir, $sub_dir."/");
	} else {
		$subjects =& RcxLists::getImgListAsArray(RCX_ROOT_PATH."/images/subject/");
	}

return $subjects;
}

/**
* gets list of language folders inside default language directory
*/
static function &getLangList() {

$lang_list = array();
$lang_list =& RcxLists::getDirListAsArray(RCX_ROOT_PATH."/language/");

return $lang_list;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function &getCountryList() {

$country_list = array (
	""   => "-",
	"AD" => "Andorra",
	"AE" => "United Arab Emirates",
	"AF" => "Afghanistan",
	"AG" => "Antigua and Barbuda",
	"AI" => "Anguilla",
	"AL" => "Albania",
	"AM" => "Armenia",
	"AN" => "Netherlands Antilles",
	"AO" => "Angola",
	"AQ" => "Antarctica",
	"AR" => "Argentina",
	"AS" => "American Samoa",
	"AT" => "Austria",
	"AU" => "Australia",
	"AW" => "Aruba",
	"AZ" => "Azerbaijan",
	"BA" => "Bosnia and Herzegovina",
	"BB" => "Barbados",
	"BD" => "Bangladesh",
	"BE" => "Belgium",
	"BF" => "Burkina Faso",
	"BG" => "Bulgaria",
	"BH" => "Bahrain",
	"BI" => "Burundi",
	"BJ" => "Benin",
	"BM" => "Bermuda",
	"BN" => "Brunei Darussalam",
	"BO" => "Bolivia",
	"BR" => "Brazil",
	"BS" => "Bahamas",
	"BT" => "Bhutan",
	"BV" => "Bouvet Island",
	"BW" => "Botswana",
	"BY" => "Belarus",
	"BZ" => "Belize",
	"CA" => "Canada",
	"CC" => "Cocos (Keeling) Islands",
	"CF" => "Central African Republic",
	"CG" => "Congo",
	"CH" => "Switzerland",
	"CI" => "Cote D'Ivoire (Ivory Coast)",
	"CK" => "Cook Islands",
	"CL" => "Chile",
	"CM" => "Cameroon",
	"CN" => "China",
	"CO" => "Colombia",
	"CR" => "Costa Rica",
	"CS" => "Czechoslovakia (former)",
	"CU" => "Cuba",
	"CV" => "Cape Verde",
	"CX" => "Christmas Island",
	"CY" => "Cyprus",
	"CZ" => "Czech Republic",
	"DE" => "Germany",
	"DJ" => "Djibouti",
	"DK" => "Denmark",
	"DM" => "Dominica",
	"DO" => "Dominican Republic",
	"DZ" => "Algeria",
	"EC" => "Ecuador",
	"EE" => "Estonia",
	"EG" => "Egypt",
	"EH" => "Western Sahara",
	"ER" => "Eritrea",
	"ES" => "Spain",
	"ET" => "Ethiopia",
	"FI" => "Finland",
	"FJ" => "Fiji",
	"FK" => "Falkland Islands (Malvinas)",
	"FM" => "Micronesia",
	"FO" => "Faroe Islands",
	"FR" => "France",
	"FX" => "France, Metropolitan",
	"GA" => "Gabon",
	"GB" => "Great Britain (UK)",
	"GD" => "Grenada",
	"GE" => "Georgia",
	"GF" => "French Guiana",
	"GH" => "Ghana",
	"GI" => "Gibraltar",
	"GL" => "Greenland",
	"GM" => "Gambia",
	"GN" => "Guinea",
	"GP" => "Guadeloupe",
	"GQ" => "Equatorial Guinea",
	"GR" => "Greece",
	"GS" => "S. Georgia and S. Sandwich Isls.",
	"GT" => "Guatemala",
	"GU" => "Guam",
	"GW" => "Guinea-Bissau",
	"GY" => "Guyana",
	"HK" => "Hong Kong",
	"HM" => "Heard and McDonald Islands",
	"HN" => "Honduras",
	"HR" => "Croatia (Hrvatska)",
	"HT" => "Haiti",
	"HU" => "Hungary",
	"ID" => "Indonesia",
	"IE" => "Ireland",
	"IL" => "Israel",
	"IN" => "India",
	"IO" => "British Indian Ocean Territory",
	"IQ" => "Iraq",
	"IR" => "Iran",
	"IS" => "Iceland",
	"IT" => "Italy",
	"JM" => "Jamaica",
	"JO" => "Jordan",
	"JP" => "Japan",
	"KE" => "Kenya",
	"KG" => "Kyrgyzstan",
	"KH" => "Cambodia",
	"KI" => "Kiribati",
	"KM" => "Comoros",
	"KN" => "Saint Kitts and Nevis",
	"KP" => "Korea (North)",
	"KR" => "Korea (South)",
	"KW" => "Kuwait",
	"KY" => "Cayman Islands",
	"KZ" => "Kazakhstan",
	"LA" => "Laos",
	"LB" => "Lebanon",
	"LC" => "Saint Lucia",
	"LI" => "Liechtenstein",
	"LK" => "Sri Lanka",
	"LR" => "Liberia",
	"LS" => "Lesotho",
	"LT" => "Lithuania",
	"LU" => "Luxembourg",
	"LV" => "Latvia",
	"LY" => "Libya",
	"MA" => "Morocco",
	"MC" => "Monaco",
	"MD" => "Moldova",
	"MG" => "Madagascar",
	"MH" => "Marshall Islands",
	"MK" => "Macedonia",
	"ML" => "Mali",
	"MM" => "Myanmar",
	"MN" => "Mongolia",
	"MO" => "Macau",
	"MP" => "Northern Mariana Islands",
	"MQ" => "Martinique",
	"MR" => "Mauritania",
	"MS" => "Montserrat",
	"MT" => "Malta",
	"MU" => "Mauritius",
	"MV" => "Maldives",
	"MW" => "Malawi",
	"MX" => "Mexico",
	"MY" => "Malaysia",
	"MZ" => "Mozambique",
	"NA" => "Namibia",
	"NC" => "New Caledonia",
	"NE" => "Niger",
	"NF" => "Norfolk Island",
	"NG" => "Nigeria",
	"NI" => "Nicaragua",
	"NL" => "Netherlands",
	"NO" => "Norway",
	"NP" => "Nepal",
	"NR" => "Nauru",
	"NT" => "Neutral Zone",
	"NU" => "Niue",
	"NZ" => "New Zealand (Aotearoa)",
	"OM" => "Oman",
	"PA" => "Panama",
	"PE" => "Peru",
	"PF" => "French Polynesia",
	"PG" => "Papua New Guinea",
	"PH" => "Philippines",
	"PK" => "Pakistan",
	"PL" => "Poland",
	"PM" => "St. Pierre and Miquelon",
	"PN" => "Pitcairn",
	"PR" => "Puerto Rico",
	"PT" => "Portugal",
	"PW" => "Palau",
	"PY" => "Paraguay",
	"QA" => "Qatar",
	"RE" => "Reunion",
	"RO" => "Romania",
	"RU" => "Russian Federation",
	"RW" => "Rwanda",
	"SA" => "Saudi Arabia",
	"Sb" => "Solomon Islands",
	"SC" => "Seychelles",
	"SD" => "Sudan",
	"SE" => "Sweden",
	"SG" => "Singapore",
	"SH" => "St. Helena",
	"SI" => "Slovenia",
	"SJ" => "Svalbard and Jan Mayen Islands",
	"SK" => "Slovak Republic",
	"SL" => "Sierra Leone",
	"SM" => "San Marino",
	"SN" => "Senegal",
	"SO" => "Somalia",
	"SR" => "Suriname",
	"ST" => "Sao Tome and Principe",
	"SU" => "USSR (former)",
	"SV" => "El Salvador",
	"SY" => "Syria",
	"SZ" => "Swaziland",
	"TC" => "Turks and Caicos Islands",
	"TD" => "Chad",
	"TF" => "French Southern Territories",
	"TG" => "Togo",
	"TH" => "Thailand",
	"TJ" => "Tajikistan",
	"TK" => "Tokelau",
	"TM" => "Turkmenistan",
	"TN" => "Tunisia",
	"TO" => "Tonga",
	"TP" => "East Timor",
	"TR" => "Turkey",
	"TT" => "Trinidad and Tobago",
	"TV" => "Tuvalu",
	"TW" => "Taiwan",
	"TZ" => "Tanzania",
	"UA" => "Ukraine",
	"UG" => "Uganda",
	"UK" => "United Kingdom",
	"UM" => "US Minor Outlying Islands",
	"US" => "United States",
	"UY" => "Uruguay",
	"UZ" => "Uzbekistan",
	"VA" => "Vatican City State (Holy See)",
	"VC" => "Saint Vincent and the Grenadines",
	"VE" => "Venezuela",
	"VG" => "Virgin Islands (British)",
	"VI" => "Virgin Islands (U.S.)",
	"VN" => "Viet Nam",
	"VU" => "Vanuatu",
	"WF" => "Wallis and Futuna Islands",
	"WS" => "Samoa",
	"YE" => "Yemen",
	"YT" => "Mayotte",
	"YU" => "Yugoslavia",
	"ZA" => "South Africa",
	"ZM" => "Zambia",
	"ZR" => "Zaire",
	"ZW" => "Zimbabwe"
	);

asort($country_list);
reset($country_list);

return $country_list;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function &getHtmlList() {

$html_list = array (
	"a"          => "&lt;a&gt;",
	"abbr"       => "&lt;abbr&gt;",
	"acronym"    => "&lt;acronym&gt;",
	"address"    => "&lt;address&gt;",
	"applet"     => "&lt;applet&gt;",
	"area"       => "&lt;area&gt;",
	"b"          => "&lt;b&gt;",
	"base"       => "&lt;base&gt;",
	"basefont"   => "&lt;basefont&gt;",
	"bdo"        => "&lt;bdo&gt;",
	"big"        => "&lt;big&gt;",
	"blockquote" => "&lt;blockquote&gt;",
	"body"       => "&lt;body&gt;",
	"br"         => "&lt;br&gt;",
	"button"     => "&lt;button&gt;",
	"caption"    => "&lt;caption&gt;",
	"center"     => "&lt;center&gt;",
	"cite"       => "&lt;cite&gt;",
	"code"       => "&lt;code&gt;",
	"col"        => "&lt;col&gt;",
	"colgroup"   => "&lt;colgroup&gt;",
	"dd"         => "&lt;dd&gt;",
	"del"        => "&lt;del&gt;",
	"dfn"        => "&lt;dfn&gt;",
	"dir"        => "&lt;dir&gt;",
	"div"        => "&lt;div&gt;",
	"dl"         => "&lt;dl&gt;",
	"dt"         => "&lt;dt&gt;",
	"em"         => "&lt;em&gt;",
	"embed"      => "&lt;embed&gt;",
	"fieldset"   => "&lt;fieldset&gt;",
	"font"       => "&lt;font&gt;",
	"form"       => "&lt;form&gt;",
	"frame"      => "&lt;frame&gt;",
	"frameset"   => "&lt;frameset&gt;",
	"h1"         => "&lt;h1&gt;",
	"h2"         => "&lt;h2&gt;",
	"h3"         => "&lt;h3&gt;",
	"h4"         => "&lt;h4&gt;",
	"h5"         => "&lt;h5&gt;",
	"h6"         => "&lt;h6&gt;",
	"head"       => "&lt;head&gt;",
	"hr"         => "&lt;hr&gt;",
	"html"       => "&lt;html&gt;",
	"i"          => "&lt;i&gt;",
	"iframe"     => "&lt;iframe&gt;",
	"img"        => "&lt;img&gt;",
	"input"      => "&lt;input&gt;",
	"ins"        => "&lt;ins&gt;",
	"kbd"        => "&lt;kbd&gt;",
	"label"      => "&lt;label&gt;",
	"legend"     => "&lt;legend&gt;",
	"li"         => "&lt;li&gt;",
	"link"       => "&lt;link&gt;",
	"map"        => "&lt;map&gt;",
	"marquee"	 => "&lt;marquee&gt;",
	"menu"       => "&lt;menu&gt;",
	"meta"       => "&lt;meta&gt;",
	"noframes"   => "&lt;noframes&gt;",
	"noscript"   => "&lt;noscript&gt;",
	"object"     => "&lt;object&gt;",
	"ol"         => "&lt;ol&gt;",
	"optgroup"   => "&lt;optgroup&gt;",
	"option"     => "&lt;option&gt;",
	"p"          => "&lt;p&gt;",
	"param"      => "&lt;param&gt;",
	"pre"        => "&lt;pre&gt;",
	"q"          => "&lt;q&gt;",
	"s"          => "&lt;s&gt;",
	"samp"       => "&lt;samp&gt;",
	"script"     => "&lt;script&gt;",
	"select"     => "&lt;select&gt;",
	"small"      => "&lt;small&gt;",
	"span"       => "&lt;span&gt;",
	"strike"     => "&lt;strike&gt;",
	"strong"     => "&lt;strong&gt;",
	"style"      => "&lt;style&gt;",
	"sub"        => "&lt;sub&gt;",
	"sup"        => "&lt;sup&gt;",
	"table"      => "&lt;table&gt;",
	"tbody"      => "&lt;tbody&gt;",
	"td"         => "&lt;td&gt;",
	"textarea"   => "&lt;textarea&gt;",
	"tfoot"      => "&lt;tfoot&gt;",
	"th"         => "&lt;th&gt;",
	"thead"      => "&lt;thead&gt;",
	"title"      => "&lt;title&gt;",
	"tr"         => "&lt;tr&gt;",
	"tt"         => "&lt;tt&gt;",
	"u"          => "&lt;u&gt;",
	"ul"         => "&lt;ul&gt;",
	"var"        => "&lt;var&gt;"
	);

asort($html_list);
reset($html_list);

return $html_list;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
static function &getUserRankList() {
global $myts, $db;

$sql    = "SELECT rank_id, rank_title FROM ".$db->prefix("ranks")." WHERE rank_special = 1";
$ret    = array();
$result = $db->query($sql);

while ( $myrow = $db->fetch_array($result) ) {
	$ret[$myrow['rank_id']] = $myts->makeTboxData4Show($myrow['rank_title']);
}

return $ret;
}

// To retrieve each file in the given dir...
static function &getFilesListAsArray($dirname, $prefix="", $include_indexhtml=false) {

$filelist = array();

if ($handle = @opendir($dirname)) {
	while (false !== ($file = readdir($handle))) {
		if ( $include_indexhtml == false ) {
			if ( $file != "index.html" && $file != "index.htm" ) {
				if ( $file != "." && $file != ".." ) {
					$file = $prefix.$file;
					$filelist[$file] = $file;
				}
			}
		} else {
			if ( $file != "." && $file != ".." ) {
				$file = $prefix.$file;
				$filelist[$file] = $file;
			}
		}			
	}

	closedir($handle);
	asort($filelist);
	reset($filelist);
}

return $filelist;
}

} // END RCXLISTS
}
?>
