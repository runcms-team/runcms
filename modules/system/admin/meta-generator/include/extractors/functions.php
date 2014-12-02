<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/


function build_data($result) {
global $meta;

// Data to build the keywords from
$meta_text  = $result['title'] . ',';
$meta_text .= $result['keywords'] . ',';
$meta_text .= $meta['title'] . ',';
$meta_text .= $meta['slogan'] . ',';
$meta_text .= $meta['keywords'] . ',';
$meta_text .= $result['description']. ','; 
$meta_text .= $meta['description'];

// Remove html tags & "
$htmlless = strip_tags($meta_text);
$htmlless = str_replace('"', '', $htmlless);

// Convert all html characters back to acii characters
$trans    = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
$trans    = array_flip($trans);
$htmlless = strtr($htmlless, $trans);

// Find this:
$search = array(
                "/[^\x30-\x39\x41-\x5A\x61-\x7A\xC0-\xFF_'-]/",
                '/--/',
                '/__/',
                '/\s+/',
                '/ (.{1,3}),/',
                '/(, )$/'
                );

// And replace with this:
$replace = array(
                ' ',
                '',
                '',
                ', ',
                '',
                ''
                );

// Search n replace the above
$metatags = preg_replace($search, $replace, $htmlless);

// Put words into an array
$metatags = explode(', ', strtolower($metatags));

// Grab the wanted/unwanted list
include_once(RCX_ROOT_PATH.'/modules/system/cache/unwanted.php');
include_once(RCX_ROOT_PATH.'/modules/system/cache/wanted.php');

// Remove unwanted words
$metatags = array_diff($metatags, $unwanted);

// Add wanted keywords to the array
$metatags = array_merge($wanted, $metatags);

// Remove all doubles from the array
$metatags = array_unique($metatags);

// Shuffle the words in the array
shuffle($metatags);

// Reduce the array to the maximum no. of allowed keywords.
/*$max_words = intval($meta['max_words']); 
while (count($metatags) > $max_words) array_pop($metatags);
*/
$metatags = array_slice($metatags, 0, $meta['max_words']);

// Put the array back into a string
$metatags = implode(', ', $metatags);

// Fixes a lil slip
$metatags = preg_replace('/, , /', ', ', $metatags);

// And build the actual title/meta tags
return ucwords($metatags);
}
// ----------------------------------------------------------------------------------------//

global $rcxModule;

// ----------------------------------------------------------------------------------------//

// See if a module dir is set & if so which
if ( !empty($rcxModule) ) {
$module_dir = $rcxModule->dirname() . '/';

@$module = $rcxModule->name;
$chek = false;
$path = RCX_ROOT_PATH.'/modules/system/admin/meta-generator/include/extractors/'.$module_dir;

if ( @is_dir($path) ) {
// See if that modules extractors directory has any exctration plugins
if ($handle = @opendir($path)) {
        while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                        $extractors[] = preg_replace('/\.php/i', '', $file);
                }
        }
closedir($handle);
}

// If we found any plugins, we see if a matching variable was set, and process the data if so.
foreach ($extractors as $value) {
        if ( isset($_GET[$value]) ) {
                if ( @is_file(RCX_ROOT_PATH.'/modules/system/admin/meta-generator/include/extractors/'.$module_dir.$value.'.php') ) {
                        include_once(RCX_ROOT_PATH.'/modules/system/admin/meta-generator/include/extractors/'.$module_dir.$value.'.php');
                        $result = get_meta(intval($_GET[$value]), intval($meta['max_depth']));

                // echo "Found file: $value.php";
                // The actual keywords & title, if buil_data returns a emtpty data, we use the defaut one.

                $meta['keywords'] = build_data($result);
                $meta['title']    = $result['title'] . ' : ' .$module. ' : ' .$meta['title'];
                $description=$result['description'];
                $description= str_replace('"','',$description);
                $meta['description']= substr($description ." ".$meta['description'],0,255); 

                $chek = true;
                }
        break;
        }
} // End foreach
} // End is_dir
if (!$chek) {
$meta['title'] = $module.' : '.$meta['title'];
}
} // End module check
// ----------------------------------------------------------------------------------------//
?>
