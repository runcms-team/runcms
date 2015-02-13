<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined("RCX_MYTEXTSANITIZER_INCLUDED")) {
        define("RCX_MYTEXTSANITIZER_INCLUDED", 1);

/**
* Description
*/
class MyTextSanitizer {

        var $smileys      = array();
        var $allowImage   = false;
        var $allowLibrary = false;
        var $clickable    = true;
        var $type         = 'user';

/**
* 0: Off, 1: Local Only, 2: Local & Distant
*
* @param type $var description
* @return type description
*/
function setAllowImage($value=0) {
        $this->allowImage = intval($value);
}

/**
* 0: Off, 1: Local Only, 2: Local & Distant
*
* @param type $var description
* @return type description
*/
function setAllowLibrary($value=0) {
        $this->allowLibrary = intval($value);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setClickable($value=true) {
        $this->clickable = (bool)$value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function setType($value='user') {
        $this->type = $value;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function smiley($message) {
global $db, $rcxConfig;

if ($rcxConfig['no_smile']) {
	return $message;
}

if (count($this->smileys) == 0) {
        if ( $getsmiles = $db->query("SELECT code, smile_url FROM ".$db->prefix("smiles")) ) {
                while ($smiles = $db->fetch_array($getsmiles)) {
                        $message = str_replace($smiles['code'], '<img src="'.formatURL(RCX_URL.'/images/smilies/', $smiles['smile_url']).'" alt="'.$smiles['code'].'" />', $message);
                        array_push($this->smileys, $smiles);
                }
        }
        } else {
                foreach ($this->smileys as $smiles) {
                        $message = str_replace($smiles['code'], '<img src="'.formatURL(RCX_URL.'/images/smilies/', $smiles['smile_url']).'" alt="'.$smiles['code'].'" />', $message);
                }
        }

return $message;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function desmile($message) {
global $db;

if (count($this->smileys) == 0) {
        if ( $getsmiles = $db->query("SELECT * FROM ".$db->prefix("smiles")) ) {
                while ($smiles = $db->fetch_array($getsmiles)) {
                        $message = str_replace("<img src='".formatURL(RCX_URL.'/images/smilies/', $smiles['smile_url'])."' />", $smiles['code'], $message);
                        array_push($this->smileys, $smiles);
                }
        }
        } else {
                foreach ($this->smileys as $smiles) {
                        $message = str_replace("<img src='".formatURL(RCX_URL.'/images/smilies/', $smiles['smile_url'])."' />", $smiles['code'], $message);
                }
        }

return $message;
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function makeClickable($text) {

$find    = array();
$replace = array();
$text    = " ".$text;

$find[]    = "/([\n ])([a-z]+?):\/\/([^, \n\r]+)/i";
$replace[] = "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>";

$find[]    = "/([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.~]+)((?:\/[^, \n\r]*)?)/i";
$replace[] = "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>";

$find[]    = "/([\n ])ftp\.([a-z0-9\-]+)\.([a-z0-9\-.~]+)((?:\/[^, \n\r]*)?)/i";
$replace[] = "\\1<a href=\"ftp://ftp.\\2.\\3\\4\" target=\"_blank\">ftp.\\2.\\3\\4</a>";

$find[]    = "/([\n ])([a-z0-9\-_.]+?)@([^, \n\r]+)/i";
$replace[] = "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>";

$text = preg_replace($find, $replace, $text);

return trim($text);
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function rcxCodeDecode($text, $allow_html=0) {

global $rcxConfig;
    
$patterns     = array();
$replacements = array();


$replacement  = "'"._CODEC."<div class=\"rcxCode\">'.";

if ($allow_html == 1) {
        $patterns[]     = "/\[enc_code](.*)\[\/enc_code\]/esU";
        $replacement   .= "htmlspecialchars(base64_decode('\\1'), ENT_QUOTES)";
        } else {
                $patterns[]     = "/\[enc_code](.*)\[\/enc_code\]/esU";
                $replacement   .= "base64_decode('\\1')";
        }

$replacement   .= ".'</div>'";
$replacements[] = $replacement;


$patterns[]     = "/\[quote]/sU";
$replacements[] = '<b>'._QUOTEC.'</b><div class="rcxQuote"><br>';

$patterns[]     = "/\[\/quote\]/sU";
$replacements[] = '<br></div>';

if ($rcxConfig['hide_external_links']) {
	$patterns[]     = "/\[url=(['\"]?)(http[s]?:\/\/[^\"']*)\\1](.*)\[\/url\]/esU";
	$replacements[] = "\$this->checkGoodUrl('$2', '$3')";
	
    $patterns[]     = "/\[url=(['\"]?)([^\"']*)\\1](.*)\[\/url\]/esU";
    $replacements[] = "\$this->checkGoodUrl('http://$2', '$3')";
} else {
	$patterns[]     = "/\[url=(['\"]?)(http[s]?:\/\/[^\"']*)\\1](.*)\[\/url\]/sU";
	$replacements[] = '<a href="\\2" target="_blank">\\3</a>';

	$patterns[]     = "/\[url=(['\"]?)([^\"']*)\\1](.*)\[\/url\]/sU";
	$replacements[] = '<a href="http://\\2" target="_blank">\\3</a>';
}

$patterns[]     = "/\[color=(['\"]?)([^\"']*)\\1](.*)\[\/color\]/sU";
$replacements[] = '<span style="color: #\\2;">\\3</span>';

$patterns[]     = "/\[size=(['\"]?)([^\"']*)\\1](.*)\[\/size\]/sU";
$replacements[] = '<span style="font-size: \\2;">\\3</span>';

$patterns[]     = "/\[font=(['\"]?)([^\"']*)\\1](.*)\[\/font\]/sU";
$replacements[] = '<span style="font-family: \\2;">\\3</span>';

$patterns[]     = "/\[email]([^\"']*)\[\/email\]/sU";
$replacements[] = '<a href="mailto:\\1">\\1</a>';

$patterns[]     = "/\[b](.*)\[\/b\]/sU";
$replacements[] = '<b>\\1</b>';

$patterns[]     = "/\[i](.*)\[\/i\]/sU";
$replacements[] = '<i>\\1</i>';

$patterns[]     = "/\[u](.*)\[\/u\]/sU";
$replacements[] = '<u>\\1</u>';

// Tool Box

$patterns[]     = "/\[s](.*)\[\/s\]/sU";
$replacements[] = '<strike>\\1</strike>';

$patterns[]     = "/\[o](.*)\[\/o\]/sU";
$replacements[] = '<span style="text-decoration: overline">\\1</span>';

$patterns[]     = "/\[list](.*)\[\/list\]/sU";
$replacements[] = '<li>\\1</li>';

$patterns[]     = "/\[hr]/sU";
$replacements[] = '<hr>';

$patterns[]     = "/\[right](.*)\[\/right\]/sU";
$replacements[] = '<div align="right">\\1</div>';

$patterns[]     = "/\[center](.*)\[\/center\]/sU";
$replacements[] = '<div align="center">\\1</div>';

$patterns[]     = "/\[left](.*)\[\/left\]/sU";
$replacements[] = '<div align="left">\\1</div>';

$patterns[]     = "/\[justify](.*)\[\/justify\]/sU";
$replacements[] = '<div align="justify">\\1</div>';

$patterns[]     = "/\[marqd](.*)\[\/marqd\]/sU";
$replacements[] = '<marquee direction="down">\\1</marquee>';

$patterns[]     = "/\[marqu](.*)\[\/marqu\]/sU";
$replacements[] = '<marquee direction="up">\\1</marquee>';

$patterns[]     = "/\[marql](.*)\[\/marql\]/sU";
$replacements[] = '<marquee direction="left">\\1</marquee>';

$patterns[]     = "/\[marqr](.*)\[\/marqr\]/sU";
$replacements[] = '<marquee direction="right">\\1</marquee>';

$patterns[]     = "/\[marqh](.*)\[\/marqh\]/sU";
$replacements[] = '<marquee behavior="alternate">\\1</marquee>';

$patterns[]     = "/\[marqv](.*)\[\/marqv\]/sU";
$replacements[] = '<marquee behavior="alternate" direction="up">\\1</marquee>';

// Tool Box
if ( $this->allowImage == true || ($this->type == 'admin') ) {
        $patterns[] = "/\[img align=(['\"]?)(left|right)\\1]([^\"\(\)\?\&']*)\[\/img\]/sU";
        $replacements[] = '<img src="\\3" align="\\2" alt="" />';

        $patterns[] = "/\[img]([^\"\(\)\?\&']*)\[\/img\]/sU";
        $replacements[] = '<img src="\\1" alt="" />';
        } else {
                $patterns[]     = "/\[img align=(['\"]?)(left|right)\\1]([^\"\(\)\?\&']*)\[\/img\]/esU";
                
                if ($rcxConfig['hide_external_links']) {
                    $replacements[] = "\$this->checkGoodUrl('$3', basename('$3'))";
                } else {
                	$replacements[] = "'<a href=\"\\3\" target=\"_blank\">'.basename('\\3').'</a>'";
                }

                $patterns[]     = "/\[img]([^\"\(\)\?\&']*)\[\/img\]/esU";
                
                if ($rcxConfig['hide_external_links']) {
                    $replacements[] = "\$this->checkGoodUrl('$1', basename('$1'))";
                } else {
                	$replacements[] = "'<a href=\"\\1\" target=\"_blank\">'.basename('\\1').'</a>'";
                }            
        }

if ( ($this->allowLibrary == true) || ($this->type == 'admin') ) {
        $patterns[]     = "/\[lib align=(['\"]?)(left|right)\\1]([^\"\(\)\?\&']*)\[\/lib\]/esU";
        $replacements[] = "'<img src=\"'.formatURL(RCX_URL.'/images/library/', '\\3').'\" align=\"\\2\" alt=\"\" border=\"0\" />'";

        $patterns[]     = "/\[lib]([^\"\(\)\?\&']*)\[\/lib\]/esU";
        $replacements[] = "'<img src=\"'.formatURL(RCX_URL.'/images/library/', '\\1').'\" alt=\"\" border=\"0\" />'";
}

$text = preg_replace($patterns, $replacements, $text);

return $text;
}

/**
 * Enter description here...
 *
 */
function checkGoodUrl($url, $text, $clean_text = true)
{
	$url = strip_tags($url);
	if ($clean_text) $text = strip_tags($text);
	
	$good_url = file_get_contents(RCX_ROOT_PATH . '/modules/system/cache/goodurl.php');
    
    $rcx_parsed_url = parse_url(RCX_URL);
    $parsed_link = parse_url($url);
    
    if (preg_match('/' . preg_quote($rcx_parsed_url['host']) . '/is', $url) || preg_match('/' . preg_quote($parsed_link['host']) . '/is', $good_url)) {
    	$link_html = "<a href=\"" . $url . "\" target=\"_blank\">" . $text . "</a>";
    } else {
    	$link_html = "<noindex><a rel=\"nofollow\" href=\"" . RCX_URL . "/go.php?url=" . base64_encode($url) . "\" target=\"_blank\">" . $text . "</a></noindex>";
    }
    
	return $link_html;
}

/**
* Replaces banned words in a string with their replacements
*/



function censorString($text='') {
global $rcxBadWords;

if ( !empty($text) && is_array($rcxBadWords) && !empty($rcxBadWords) ) {
        foreach ($rcxBadWords as $pattern) {
                $words = @explode('|', $pattern);


                $find  = trim($words[0]);
                $repl  = trim($words[1]);
                if ( !empty($find) && !empty($repl)) {
                $text = preg_replace("~$find~i", $repl, $text);
                        // i- for latin regist
                        // for unix setlocale())

                }
        }
}

return $text;
}

/**
* Filters both textbox and textarea form data before display
* For internal use
*/
function sanitizeForDisplay($text, $allow_html=0, $allow_smileys=1, $allow_bbcode=1) {

$text = $this->oopsStripSlashesRT($text);

if ($allow_html == 0) {
        $text = $this->oopsHtmlSpecialChars($text);
        if ($allow_bbcode == 1) {
                $search[]  = "/\[code](.*)\[\/code\]/esU";
                $replace[] = "'[enc_code]'.base64_encode(stripslashes('\\1')).'[/enc_code]'";
        }
        $search[]  = "/&amp;/i";
        $replace[] = "&";
        $text      = preg_replace($search, $replace, $text);
        } else {
                if ($allow_bbcode == 1) {
                        $search[]  = "/\[code](.*)\[\/code\]/esU";
                        $replace[] = "'[enc_code]'.base64_encode(stripslashes('\\1')).'[/enc_code]'";
                        $text      = preg_replace($search, $replace, $text);
                }
                $text = $this->escapeTags($text, $this->type);
        }

if ($allow_html != 0 && $this->clickable) {
        $text = $this->makeClickable($text);
}

if ($allow_smileys == 1) {
        $text = $this->smiley($text);
}

if ($allow_bbcode == 1) {
        $text = $this->rcxCodeDecode($text, $allow_html);
}

if ($allow_html != 2) {
        $text = $this->oopsNl2Br($text);
}

$text = $this->censorString($text);

$this->setType('user');
return $text;
}

/**
* Filters both textbox and textarea form data before preview
* For internal use
*/
function sanitizeForPreview($text, $allow_html=0, $allow_smileys=1, $allow_bbcode=1) {
global $rcxConfig, $rcxUser;

$text = $this->oopsStripSlashesGPC($text);

if ($allow_html == 0) {
        $text = $this->oopsHtmlSpecialChars($text);
        if ($allow_bbcode == 1) {
                $search[]  = "/\[code](.*)\[\/code\]/esU";
                $replace[] = "'[enc_code]'.base64_encode(stripslashes('\\1')).'[/enc_code]'";
        }
        $search[]  = "/&amp;/i";
        $replace[] = "&";
        $text      = preg_replace($search, $replace, $text);
        } else {
                if ($allow_bbcode == 1) {
                        $search[]  = "/\[code](.*)\[\/code\]/esU";
                        $replace[] = "'[enc_code]'.base64_encode(stripslashes('\\1')).'[/enc_code]'";
                        $text      = preg_replace($search, $replace, $text);
                }
                $text      = $this->escapeTags($text, $this->type);
        }

if ($allow_html != 0 && $this->clickable) {
        $text = $this->makeClickable($text);
}

if ($allow_smileys == 1) {
        $text = $this->smiley($text);
}

if ($allow_bbcode == 1) {
        $text = $this->rcxCodeDecode($text, $allow_html);
}

if ($allow_html != 2) {
        $text = $this->oopsNl2Br($text);
}

$this->setType('user');
return $text;
}
/**
* Called before displaying textarea form data from DB
*/
function makeTareaData4Show($text, $allow_html=1, $allow_smileys=0, $allow_bbcode=0) {
$text = $this->sanitizeForDisplay($text, $allow_html, $allow_smileys, $allow_bbcode);
return $text;
}

/**
*  Used for displaying textbox form data from DB.
*  Smilies can also be used.
*/
function makeTboxData4Show($text, $allow_smileys=0) {
$text = $this->sanitizeForDisplay($text, 0, $allow_smileys, 0);
return $text;
}

/**
* Called when previewing textarea data which was submitted via an html form
*/
function makeTareaData4Preview($text, $allow_html=1, $allow_smileys=0, $allow_bbcode=0) {
$text = $this->sanitizeForPreview($text, $allow_html, $allow_smileys, $allow_bbcode);
return $text;
}

/**
*  Called when previewing textbox form data submitted from a form.
*  Smilies can be used if needed
*  Use makeTboxData4PreviewInForm when textbox data is to be previewed in textbox again
*/
function makeTboxData4Preview($text, $allow_smileys=0) {
$text = $this->sanitizeForPreview($text, 0, $allow_smileys, 0);
return $text;
}

/**
*  Called when previewing textarea data whih was submitted via an html form.
*  This time, text area data is inserted into textarea again
*/
function makeTboxData4PreviewInForm($text) {
$text = $this->oopsStripSlashesGPC($text);
$text = $this->oopsHtmlSpecialChars($text);

return $text;
}
/**
* Depracted (Reason: double entry)
* Use: makeTboxData4PreviewInForm();
*/
function makeTareaData4PreviewInForm($text) {
$text = $this->makeTboxData4PreviewInForm($text);
return $text;
}

/**
*  Called before saving first-time or editted textarea
*  data into DB
*  Used for saving textbox form data.
*  Adds slashes if magic_quotes_gpc is off.
*/
function makeTboxData4Save($text) {
$text = $this->oopsAddSlashesGPC($text);
return $text;
}
/**
* Depracted (Reason: double entry)
* Use: makeTboxData4Save();
*/
function makeTareaData4Save($text) {
$text = $this->makeTboxData4Save($text);
return $text;
}

//---------------------------------------------------------------------------------------//
/**
*  Use this function when you need to output textarea value inside
*  quotes. For example, meta keywords are saved as textarea value
*  but it is displayed inside <meta> tag keywords attribute with
*  quotes around it. This can be also used for textbox values.
*  Called when textarea data in DB is to be editted in html form
*  Used when textbox data in DB is to be editted in html form.
*  "&amp;" must be converted back to "&" to maintain the correct
*  ISO encoding values, which is needed for some multi-bytes chars.
*/
function makeTboxData4Edit($text) {
$text = $this->oopsHtmlSpecialChars($text);
return $text;
}
/**
* Depracted (Reason: double entry)
* Use: makeTboxData4Edit();
*/
function makeTareaData4InsideQuotes($text) {
$text = $this->makeTboxData4Edit($text);
return $text;
}
/**
* Depracted (Reason: double entry)
* Use: makeTboxData4Edit();
*/
function makeTareaData4Edit($text) {
$text = $this->makeTboxData4Edit($text);
return $text;
}

/**
* if magic_quotes_gpc is off, add back slashes
*/
function oopsAddSlashesGPC($text) {

if ( !get_magic_quotes_gpc() ) {
        $text = addslashes($text);
}

return $text;
}
/**
* Depracted (Reason: Misleading because no GPC in name)
* Use: oopsAddSlashesGPC() / oopsAddSlashesRT depending on need
*/
function oopsAddSlashes($text) {
$text = $this->addslashesGPC($text);
return $text;
}

/**
* if magic_quotes_gpc is on, strip back slashes
*/
function oopsStripSlashesGPC($text) {

if ( get_magic_quotes_gpc() ) {
        $text = stripslashes($text);
}

return $text;
}

/**
* If magic_quotes_runtime is on, strip back slashes
* This is pretty much a php legacy feature
*/
function oopsStripSlashesRT($text) {

if ( get_magic_quotes_runtime() ) {
        $text = stripslashes($text);
}

return $text;
}

/**
* If magic_quotes_runtime is off, add back slashes
* This is pretty much a php legacy feature,
* But can be usefull when copying data from 1 db table to another
*/
function oopsAddSlashesRT($text) {

if ( !get_magic_quotes_runtime() ) {
        $text = addslashes($text);
}

return $text;
}

/**
* Converts newlines to br's
*
* @param type $var description
* @return type description
*/
function oopsNl2Br($text) {

$find[]    = "/(\015\012)|(\015)|(\012)/";
$replace[] = "<br />";
$text      = preg_replace($find, $replace, $text);

return $text;
}

/**
* Takes a string, and does the reverse of the PHP standard function
* HtmlSpecialChars().
* Original Name : undo_htmlspecialchars
*/
function undoHtmlSpecialChars($text) {

$text = preg_replace("/&amp;/i" , "&", $text);
$text = preg_replace("/&gt;/i"  , ">", $text);
$text = preg_replace("/&lt;/i"  , "<", $text);
$text = preg_replace("/&quot;/i", '"', $text);
$text = str_replace("&#039;"    , "'", $text);

return $text;
}

/**
*  htmlspecialchars will not convert single quotes by default,
*  so i made this function.
*/
function oopsHtmlSpecialChars($text) {
$text = htmlspecialchars($text, ENT_QUOTES, RCX_ENT_ENCODING);
return $text;
}

/**
* Escapes non-allowed html tags
*
* @param string $text Text to be processed
* @param string $type Which types of tags to allow
* @return string Escaped text
*/
function escapeTags($text, $type='user') {
global $rcxConfig;

if ($type == 'admin') {
        $html_tags = $rcxConfig['admin_html'];
        } else {
                $html_tags = $rcxConfig['user_html'];
        }

$search[]  = "'(<)+(/?\S+>?)'U";
$replace[] = "&lt;\\2";

if ( !empty($html_tags) ) {
        $search[]  = "'(&lt;)+(/?\b(($html_tags){1})\b>?)'i";
        $replace[] = "<\\2";
}

$text = preg_replace($search, $replace, $text);

return $text;
}

function stripPHP($t)
{
    $t = str_replace("<?php", '', $t);
    $t = str_replace("<?", '', $t);
    $t = str_replace("?>", '', $t);
    return $t;
 }

} // END TEXTSANTISIZER
}

?>