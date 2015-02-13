<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: Proprietary
*
*/



if ( !preg_match("/admin\.php/i", $_SERVER['PHP_SELF']) ) {
  exit();
  }

if ( $rcxUser->isAdmin($rcxModule->mid()) ) {

if (!empty($_POST['submit']) && in_array($_POST['submit'], array(_AM_MERGE, _AM_UPDATE, "<---", "--->", _AM_REMOVE))) {
    
    $rcx_token = & RcxToken::getInstance();
    
    if ( !$rcx_token->check() ) {
        redirect_header('admin.php?fct=meta-generator', 3, $rcx_token->getErrors(true));
        exit();
    }
}    
    
rcx_cp_header();


function make_menu() {
global $myts;

$rcx_token = & RcxToken::getInstance();

include("./cache/meta.php");
OpenTable();
?>

<div align="center">
<h3><u><?php echo _MI_MTG_NAME;?></u></h3>
</div>

<hr size="1" noshade="noshade" />

<form name="settings" action="./admin.php?fct=meta-generator" method="post">
<table align="center"><tr>

<td colspan="2">
<h3><?php echo _AM_MTITLE;?>:</h3>
</td>

</tr><tr>

<td><?php echo _AM_TITLE;?>:</td>
<td><input type="text" class="text" name="Xtitle" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['title']);?>" size="32" /></td>

</tr><tr>

<td><?php echo _AM_AUTHOR;?>:</td>
<td><input type="text" class="text" name="Xauthor" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['author']);?>" size="32" /></td>

</tr><tr>

<td><?php echo _AM_COPY;?>:</td>
<td><input type="text" class="text" name="Xcopyright" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['copyright']);?>" size="32" /></td>

</tr><tr>

<td><?php echo _AM_SLOGAN;?>:</td>
<td><input type="text" class="text" name="Xslogan" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['slogan']);?>" size="65" /></td>

</tr><tr>

<td><?php echo _AM_KEYW;?>:<br />(<?php echo _AM_COMMA;?>)</td>
<td><input type="text" class="text" name="Xkeywords" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['keywords']);?>" size="65" /></td>

</tr><tr>

<td><?php echo _AM_DESC;?>:</td>
<td><input type="text" class="text" name="Xdescription" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['description']);?>" size="65" /></td>

</tr><tr>

<td><?php echo _AM_RAT;?>:</td>
<td>
<select class="select" name="Xrating">
<option value="general"><?php echo _AM_RATGEN;?></option>
<option value="14 years"><?php echo _AM_RAT14Y;?></option>
<option value="restricted"><?php echo _AM_RATRES;?></option>
<option value="mature"><?php echo _AM_RATMAT;?></option>
</select>
</td>

</tr><tr>

<td><?php echo _AM_P3P;?>:</td>
<td>
<input type="text" class="text" name="Xp3p" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['p3p']);?>" size="34" />
</td>

</tr><tr>

<td><?php echo _AM_ROB;?>:</td>
<td>
<select class="select" name="Xindex">
<option value="index" selected><?php echo _AM_ROBIND;?></option>
<option value="noindex"><?php echo _AM_ROBNOI;?></option>
</select>
 &nbsp;
<select class="select" name="Xfollow">
<option value="follow" selected><?php echo _AM_ROBFOL;?></option>
<option value="nofollow"><?php echo _AM_ROBNOF;?></option>
</select>
</td>

</tr><tr>

<td><?php echo _AM_PRAGMA;?>:</td>
<td>
<input type="checkbox" class="checkbox" name="Xpragma" value="1" <?php if ($meta['pragma'] == 1) { echo " checked='checked'"; }?> />
</td>

</tr><tr>

<td><?php echo _AM_BOOK;?>:<br />(<?php echo _AM_REL;?>)</td>
<td>
<input type="text" class="text" name="Xicon" value="<?php echo $myts->makeTboxData4PreviewInForm($meta['icon']);?>" size="34" />
</td>

</tr></table>

<hr size="1" noshade="noshade" />

<div align="center">
<h3><?php echo _AM_HTITLE;?>:</h3>
<textarea class="textarea" name="header" rows="6" cols="80">
<?php readfile("./cache/header.php");?>
</textarea>
</div>

<hr size="1" noshade="noshade" />

<div align="center">
<h3><?php echo _AM_FTITLE;?>:</h3>
<textarea class="textarea" name="footer" rows="6" cols="80">
<?php readfile("./cache/footer.php");?>
</textarea>
</div>

<hr size="1" noshade="noshade" />

<a name="keywords"></a>
<h3><?php echo _AM_KTITLE;?>:</h3>

<table width="99%" border="0" cellspacing="5" cellpadding="5">
<tr>
<td colspan="2"><hr size="1" noshade="noshade" /></td>
<td colspan="2" rowspan="5" align="center" valign="top"><table border="0" align="center" cellspacing="5">
<tr>

<td align="center"><?php echo _AM_WANTED;?></td>
<td colspan="2">&nbsp;</td>
<td align="center"><?php echo _AM_UNWANTED;?></td>
</tr>
<tr>

<td align="center" rowspan="3">
<select class="select" id="wanted" name="Xwanted[]" multiple="multiple" size="10" onfocus="document.settings.Add.value='';">
<?php
include("./cache/wanted.php");
natsort($wanted);
while (list($var, $value) = @each($wanted)) {
  echo "<option value=\"$value\">$value</option>";
}
?>
</select>
<br />
<script type="text/javascript">
document.write("(<b>" + document.settings.wanted.options.length + "</b>)");
</script>
<br />
</td>
<td align="center" colspan="2" valign="top">
<input type="text" class="text" name="Add" size="10" />
</td>
<td align="center" rowspan="3">
<select class="select" id="unwanted" name="Xunwanted[]" multiple="multiple" size="10" onfocus="document.settings.Add.value='';">
<?php
include("./cache/unwanted.php");
natsort($unwanted);
while (list(,$val) = @each($unwanted)) {
  echo "<option value=\"$val\">$val</option>";
}
?>
</select>
<br />
<script type="text/javascript">
document.write("(<b>" + document.settings.unwanted.options.length + "</b>)");
</script>
<br />
</td>
</tr>
<tr>

<td align="center" valign="middle">
<input type="submit" class="button" name="submit" value="<---" />
</td>
<td align="center" valign="middle">
<input type="submit" class="button" name="submit" value="--->" />
</td>
</tr>
<tr>

<td align="center" colspan="2" valign="top">
<input type="submit" class="button" name="submit" value="<?php echo _AM_REMOVE;?>" />
</td>
</tr>
</table></td>
</tr>
<tr>
<td><?php echo _AM_EXTRACTOR;?></td>
<td>
<?php echo _ON;?>:
<input type="radio" class="radio" name="Xextractor" value="1" <?php if ($meta["extractor"] == 1) { echo " checked='checked'"; };?>/>
<?php echo _OFF;?>:
<input type="radio" class="radio" name="Xextractor" value="0" <?php if ($meta["extractor"] == 0) { echo " checked='checked'"; };?>/>
</td>
</tr>
<tr>
<td><?php echo _AM_CLOAKING;?></td>
<td>
<?php echo _ON;?>:
<input type="radio" class="radio" name="Xcloaking" value="1" <?php if ($meta["cloaking"] == 1) { echo " checked='checked'"; };?>/>
<?php echo _OFF;?>:
<input type="radio" class="radio" name="Xcloaking" value="0" <?php if ($meta["cloaking"] == 0) { echo " checked='checked'"; };?>/></td>
</tr>
<tr>
<td colspan="2"><hr size="1" noshade="noshade" /></td>
</tr>
<tr>
<td><?php echo _AM_MDEPTH;?></td>
<td><select class="select" name="Xmax_depth">
<option value="5" selected="selected">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
</select></td>
</tr>
<tr>
<td><?php echo _AM_MWORDS;?></td>
<td><select class="select" name="Xmax_words">
<option value="15">15</option>
<option value="25">25</option>
<option value="50" selected="selected">50</option>
<option value="75">75</option>
<option value="100">100</option>
</select></td>
<td colspan="2"><?php echo _AM_AGENTS;?>:
<input type="text" class="text" name="Xuser_agents" value="<?php echo $meta["user_agents"];?>" size="50" /></td>
</tr>
<tr align="center" valign="middle">
<td colspan="4"><?php echo $rcx_token->getTokenHTML();?><input type="submit" class="button" name="submit" value="<?php echo _AM_UPDATE;?>" /></td>

</tr></form></table>

<hr size="1" noshade="noshade" />

<div align="center">
<form name="import" method="post" action="./admin.php?fct=meta-generator" enctype="multipart/form-data">
<h3><?php echo _AM_WTITLE;?>:</h3>
<?php echo _AM_WANTED;?>: <input type="radio" class="radio" name="which" value="wanted">
<?php echo _AM_UNWANTED;?>: <input type="radio" class="radio" name="which" value="unwanted"><br />
<input type="file" class="file" name="merge">
<?php echo $rcx_token->getTokenHTML();?>
<input type="submit" class="button" name="submit" value="<?php echo _AM_MERGE;?>">
</form>
</div>

<script type="text/javascript">
document.settings.Xrating.value = "<?php echo $meta['rating'];?>";
document.settings.Xindex.value = "<?php echo $meta['index'];?>";
document.settings.Xfollow.value = "<?php echo $meta['follow'];?>";

document.settings.Xmax_words.value = "<?php echo $meta['max_words'];?>";
document.settings.Xmax_depth.value = "<?php echo $meta['max_depth'];?>";

</script>
<?php
CloseTable();
}

function merge($merge, $which) {
global $myts;

include("./cache/wanted.php");
include("./cache/unwanted.php");


$before = count(${$which});

$keywords = file($merge);
$keywords = implode(" ", $keywords);
$keywords = strtolower($keywords);

// Remove html tags & "
$keywords = strip_tags($keywords);
$keywords = str_replace('"', "", $keywords);

// Convert all html characters back to acii characters
$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
$trans = array_flip($trans);
$keywords = strtr($keywords, $trans);

// Find this:
$search = array(
    "/[^\x30-\x39\x41-\x5A\x61-\x7A\xC0-\xFF_'-]/",
    "/--/",
    "/__/",
    "/\s+/",
    "/ (.{1,3}),/",
    "/(, )$/"
    );

// And replace with this:
$replace = array(
    " ",
    "",
    "",
    ", ",
    "",
    ""
    );
$keywords = preg_replace($search, $replace, $keywords);

// Put words into an array
$keywords = explode(", ", $keywords);

// Merge new words with old ones
$keywords = array_merge($keywords, ${$which});

// Remove all doubles from the array
$keywords = array_unique($keywords);

// Always make sur we don't accidentaly add wanted words eventually present in a
// import file to the unwanted list. Not really needed, but cleaner practice.
if ($which == "unwanted") { $keywords = array_diff($keywords, $wanted); }

natsort($keywords);

$after = "0";
$content  = "<?php\n";
$content .= "\${$which} = array(\n";

while (list($key, $value) = @each($keywords)) {
  if ($value) {
    $content .= '"'.$value.'"'.",\n";
    $after++;
  }
}

$content = substr($content, 0, -2);
$content .= "\n);\n?>";

write_file($which, $content, 'w');

echo "<center><u><b>".($after-$before)."</b></u>: "._AM_MERGED.". <u><b>$after</b></u>: "._AM_MIN." $which "._AM_MLINST.".</center>";
}
function write_file($file, $content, $mode='wb') {

$file = fopen('./cache/'.$file.'.php', $mode);
fwrite($file, trim($content) );
fclose($file);
}
function write_meta() {
global $_POST, $myts;

$content  = "<?php\n";
$content .= "\$meta['title'] = \"".clean_text($_POST["Xtitle"])."\";\n";
$content .= "\$meta['author'] = \"".clean_text($_POST["Xauthor"])."\";\n";
$content .= "\$meta['copyright'] = \"".clean_text($_POST["Xcopyright"])."\";\n";
$content .= "\$meta['slogan'] = \"".clean_text($_POST["Xslogan"])."\";\n";
$content .= "\$meta['keywords'] = \"".clean_text($_POST["Xkeywords"])."\";\n";
$content .= "\$meta['rating'] = \"".$_POST["Xrating"]."\";\n";

$p3p = preg_replace("/([^a-z0-9 ]|cp\=|p3p:)/i", "", $_POST["Xp3p"]);

$content .= "\$meta['p3p'] = \"".trim($p3p)."\";\n";
$content .= "\$meta['index'] = \"".$_POST["Xindex"]."\";\n";
$content .= "\$meta['follow'] = \"".$_POST["Xfollow"]."\";\n";
$content .= "\$meta['pragma'] = \"".$_POST["Xpragma"]."\";\n";
$content .= "\$meta['icon'] = \"".$myts->oopsAddSlashesGPC($_POST["Xicon"])."\";\n";
$content .= "\$meta['description'] = \"".clean_text($_POST["Xdescription"])."\";\n";

$content .= "\$meta['extractor'] = \"".$_POST["Xextractor"]."\";\n";
$content .= "\$meta['cloaking'] = \"".$_POST["Xcloaking"]."\";\n";
$content .= "\$meta['max_words'] = \"".$_POST["Xmax_words"]."\";\n";
$content .= "\$meta['max_depth'] = \"".$_POST["Xmax_depth"]."\";\n";
$content .= "\$meta['user_agents'] = \"".clean_text($_POST["Xuser_agents"])."\";\n";
$content .= "?>";

write_file("meta", $content, "w");

$content = $myts->oopsStripSlashesGPC($_POST["header"]);
$content = $myts->stripPHP($content);
write_file("header", $content, "wb");

$content = $myts->oopsStripSlashesGPC($_POST["footer"]);
$content = $myts->stripPHP($content);
write_file("footer", $content, "wb");
}
function clean_text($text) {
global $myts;

$text = $myts->oopsStripSlashesGPC($text);
$text = str_replace('"', "", $text);
return $text;

}
function write_words($words, $which) {
global $myts;

$content  = "<?php\n";

if (count($words) == 0) {
    $content .= "\${$which} = array();\n";
} else {
    $Acontent = "\${$which} = array(\n";
    while (list($key, $value) = @each($words)) {
        if ($value) {
            $value = clean_text($value);
            $Acontent .= "\"".strtolower($value)."\",\n";
        }
    } // END WHILE
    
    $content .= substr($Acontent, 0, -2);
    $content .= "\n);\n";
}

$content .= "?>";

write_file($which, $content, "w");
}
function clean_array($array) {
global $myts;

if ( is_array($array) ) {
foreach ($array as $key => $value) {
$result[] = $myts->oopsStripSlashesGPC($value);
}
} else {
$result[] = $myts->oopsStripSlashesGPC($array);
}

return $result;
}
function move_keywords($what) {
global $_POST, $myts;

include("./cache/wanted.php");
include("./cache/unwanted.php");

if ($what == "left" && $_POST["Add"]) {
$wanted = array_merge( clean_array($_POST["Add"]), $wanted);
$wanted = array_unique($wanted);
natsort($wanted);
write_words($wanted, "wanted");

} elseif ($what == "right" && $_POST["Add"]) {
$unwanted = array_merge( clean_array($_POST["Add"]), $unwanted);
$unwanted = array_unique($unwanted);
$unwanted = array_diff($unwanted ,$wanted); // Can't add wanted word to unwanted list.
natsort($unwanted);
write_words($unwanted, "unwanted");

} elseif ($what == "left" && $_POST["Xunwanted"]) {
$wanted = array_merge( clean_array($_POST["Xunwanted"]), $wanted);
$wanted = array_unique($wanted);
natsort($wanted);
write_words($wanted, "wanted");

$unwanted = array_diff($unwanted, clean_array($_POST["Xunwanted"]) );
$unwanted = array_unique($unwanted);
natsort($unwanted);
write_words($unwanted, "unwanted");

} elseif ($what == "right" && $_POST["Xwanted"]) {
$unwanted = array_merge( clean_array($_POST["Xwanted"]), $unwanted);
$unwanted = array_unique($unwanted);
natsort($unwanted);
write_words($unwanted, "unwanted");

$wanted = array_diff($wanted, clean_array($_POST["Xwanted"]) );
$wanted = array_unique($wanted);
natsort($wanted);
write_words($wanted, "wanted");

} elseif ($what == "remove" && $_POST["Xwanted"]) {
$wanted = array_diff($wanted, clean_array($_POST["Xwanted"]) );
$wanted = array_unique($wanted);
natsort($wanted);
write_words($wanted, "wanted");

} elseif ($what == "remove" && $_POST["Xunwanted"]) {
$unwanted = array_diff($unwanted, clean_array($_POST["Xunwanted"]) );
$unwanted = array_unique($unwanted);
natsort($unwanted);
write_words($unwanted, "unwanted");
}

}
switch($_POST[submit]) {

case _AM_MERGE:
if ($_POST["which"] && $_FILES["merge"]["name"] && preg_match("/text\/plain/i", $_FILES["merge"]["type"])) {
  if (function_exists('move_uploaded_file')) {
    $copymode = 'move_uploaded_file';
    } else {
      $copymode = 'copy';
    }
  $copymode($_FILES["merge"]["tmp_name"], RCX_ROOT_PATH.'/modules/system/cache/merge.tmp');
  merge(RCX_ROOT_PATH.'/modules/system/cache/merge.tmp', $_POST["which"]);
  @unlink(RCX_ROOT_PATH.'/modules/system/cache/merge.tmp');
}

make_menu();
break;

case _AM_UPDATE:
write_meta();
make_menu();
break;

case "<---":
move_keywords("left");
make_menu();
break;

case "--->":
move_keywords("right");
make_menu();
break;

case _AM_REMOVE:
move_keywords("remove");
make_menu();
break;

default:
make_menu();
break;
}
rcx_cp_footer();
  } else {
    echo "Access Denied";
  }
?>
