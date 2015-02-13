<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

// check if the user is authorised
if ( $rcxUser->isAdmin($rcxModule->mid()) ) {

include_once(RCX_ROOT_PATH."/class/form/formselectmodule.php");

$modules = new RcxFormSelectModule('', 'bcmodule', false);


/**
* Description
*
* @param type $var description
* @return type description
*/
function list_blocks($mid=0) {
global $rcxUser;

$rcx_token = & RcxToken::getInstance();

OpenTable();
echo "<h4 style='text-align:left;'>"._AM_BADMIN."</h4>";
global $modules;
$modules->setValue($mid);
?>
<br /><div align="right">
<form action='admin.php' name='blockadmin' id='blockadmin' method='post' style='position:relative;z-index:3'>
<?php echo _AM_SHOWOMB;?>
<?php echo $modules->render();?>
<input type='hidden' name='fct' value='blocksadmin' />
<input type='hidden' name='op' value='list' />
<input type='submit' name='submit' value='<?php echo _SUBMIT;?>' />
</form>
</div>
<?php
//modified by EsseBe for templates block
echo "
<form action='admin.php' name='blockadmin' id='blockadmin' method='post' style='position:relative;z-index:3'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr valign='middle' class='sysbg3'>
<td width='20%'><b>"._AM_NAME."</b></td>
<td width='20%'><b>"._AM_TITLE."</b></td>
<td><b>"._AM_SIDE."</b></td>
<td align='center'><b>"._AM_TEMPLATE."</b></td>
<td align='center'><b>"._AM_WEIGHT."</b></td>
<td align='center'><b>"._AM_VISIBLE."</b></td>
<td align='right'><b>"._ACTION."</b></td></tr>

<tr><td colspan='7' class='sysbg1'>&nbsp;</td></tr>
<tr><td colspan='7' class='sysbg3'><b>"._AM_LSIDEBADMIN."</b></td></tr>";
// Show xxx blocks
$arr =& RcxBlock::getAllBlocks("object", RCX_SIDEBLOCK_LEFT, NULL, "side ASC, visible DESC, weight ASC", 1, $mid);

foreach ( $arr as $ele ) {
  show_block($ele);
}

// Show xxx blocks
echo "<tr><td colspan='7' class='sysbg3'><b>"._AM_TCENTERBADMIN."</b></td></tr>";
$arr =& RcxBlock::getAllBlocks("object", RCX_CENTERBLOCK_TOPALL, NULL, "visible DESC, weight ASC, side ASC", 1, $mid);
foreach($arr as $ele) {
  show_block($ele);
}

// Show xxx blocks
echo "<tr><td colspan='7' class='sysbg3'><b>"._AM_BCENTERBADMIN."</b></td></tr>";
$arr =& RcxBlock::getAllBlocks("object", RCX_CENTERBLOCK_BOTTOMALL, NULL, "visible DESC, weight ASC, side ASC", 1, $mid);
foreach($arr as $ele) {
  show_block($ele);
}

// Show xxx blocks
echo "<tr><td colspan='7' class='sysbg3'><b>"._AM_RSIDEBADMIN."</b></td></tr>";
$arr =& RcxBlock::getAllBlocks("object", RCX_SIDEBLOCK_RIGHT, NULL, "side ASC, visible DESC, weight ASC", 1, $mid);
foreach ( $arr as $ele ) {
  show_block($ele);
}

echo "
</table></td></tr></table><br />
<input type='hidden' name='fct' value='blocksadmin' />
<input type='hidden' name='op' value='order' />
" . $rcx_token->getTokenHTML() . "
<center><input type='submit' name='submit' value='"._SUBMIT."' /></center>
</form>";
CloseTable();

  /**
         * Show 'add a new block'
         */
OpenTable();

echo "
<h4 style='text-align:left;'>" ._AM_ADDBLOCK."</h4>
<form action='admin.php' method='post' enctype='multipart/form-data'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr align='left' valign='top'>

<td class='sysbg3' width='30%'>
<b>"._AM_BLKPOS."</b>
</td><td class='sysbg1'>
<select name='bside' class='select'>
<option value='".RCX_SIDEBLOCK_LEFT."'>"._AM_SBLEFT."</option>
<option value='".RCX_SIDEBLOCK_RIGHT."'>"._AM_SBRIGHT."</option>
<option value='".RCX_CENTERBLOCK_TOPLEFT."'>"._AM_TCBLEFT."</option>
<option value='".RCX_CENTERBLOCK_TOPCENTER."'>"._AM_TCBCENTER."</option>
<option value='".RCX_CENTERBLOCK_TOPRIGHT."'>"._AM_TCBRIGHT."</option>
<option value='".RCX_CENTERBLOCK_BOTTOMLEFT."'>"._AM_BCBLEFT."</option>
<option value='".RCX_CENTERBLOCK_BOTTOMCENTER."'>"._AM_BCBCENTER."</option>
<option value='".RCX_CENTERBLOCK_BOTTOMRIGHT."'>"._AM_BCBRIGHT."</option>
</select>
</td>

</tr>
<!--added by EsseBe for blocks templates-->
<tr align='left' valign='top'>

<td class='sysbg3'>
<b>"._AM_TEMPLATE."</b>
</td>";
            $selectbox = '<select name="bshow_template" class="select">';
            foreach ( s_template() as $value ) {
                                
                $selectbox .= "<option name='".$value."'>".$value."</option>";
            }
            $selectbox .= '</select>';
            echo "
                <td class='bg1'>".$selectbox."</td>
                </tr>
                
                
                <tr align='left' valign='top'>

    <td class='sysbg3'>
    <b>"._AM_MODULE."</b>
    </td><td class='sysbg1'>
    <select name='bcmodule[]' class='select'  multiple='multiple' size='5'>";

              $temp = RcxModule :: getAllModulesList();
              $mods['-1'] = "--"._NONE."--";
              $mods['0'] = "--"._ALL."--";
              foreach ( $temp as $tid => $tname ) {
                  $mods[$tid]  = $tname;
              }
              foreach ( $mods as $bcmodule => $mod ) {
                
                if($bcmodule !== 1){                
                  echo "<option value='$bcmodule' selected>$mod</option>";
          }
              }
              echo "
                </select>
    </td>
    </tr>
    
                
    <tr align='left' valign='top'>

    <td class='sysbg3'>
    <b>"._AM_WEIGHT."</b>
    </td><td class='sysbg1'>
    <input type='text' class='text' name='bweight' size='2' maxlength='2' />
    </td>

    </tr><tr align='left' valign='top'>

    <td class='sysbg3'>
    <b>"._AM_VISIBLE."</b>
    </td><td class='sysbg1'>
    <select name='bvisible' class='select'>
    <option value='0'>" ._NO."</option>
    <option value='1' selected='selected'>" ._YES."</option>
    </select>
    </td>

    </tr><tr align='left' valign='top'>

    <td class='sysbg3'>
    <b>"._AM_TITLE."</b>
    </td><td class='sysbg1'>
    <input type='text' class='text' name='btitle' size='60' maxlength='60' />
    </td>

    </tr><tr align='left' valign='top'>

    <td class='sysbg3'>
    <b>"._AM_CONTENT."</b><br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_USEFULTAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>".sprintf(_AM_BLOCKTAG1, "{X_SITEURL}", RCX_URL."/")."</span>
    </td><td class='sysbg1'>
    <textarea name='bcontent' class='textarea' cols='60' rows='10'></textarea>
    </td>

    </tr><tr align='left' valign='top'>

    <td class='sysbg3'>
    <b>"._AM_CTYPE."</b>
    </td><td class='sysbg1'>
    <select name='bctype' class='select'>
    <option value='H'>"._AM_HTML."</option>
    <option value='P'>"._AM_PHP."</option>
    <option value='S'>"._AM_AFWSMILE."</option>
    <option value='T' selected='selected'>"._AM_AFNOSMILE."</option>
    </select>
    </td>

    </tr><tr align='left' valign='top'>

    <td class='sysbg3'>&nbsp;</td>
    <td class='sysbg1'>
    <input type='hidden' name='fct' value='blocksadmin' />
    <input type='hidden' name='op' value='save' />
    " . $rcx_token->getTokenHTML() . "
    <input type='submit' value='"._SUBMIT."' />
    </td>

    </tr></table></td>
    </tr></table>
    </form>";
CloseTable();
}

/**
* @return array the templates
* @desc Function for show the templates files in a selest form
*/
        function s_template()
        {
            global $b_template;
            if ($b_template) {
                return $b_template;
            }
            $dir = RCX_ROOT_PATH."/themes/".getTheme()."/template/";
            if (is_dir($dir)) {
            $handle = opendir($dir);
            $values = array();
            array_push($values, 'standard');
            while ( false !== ($file = readdir($handle)) ) {
                if ( @is_file($dir.$file) ) {
                    array_push($values, $file);
                  }
          }
           closedir($handle);
        }else{
        $values = array();
        array_push($values, 'standard');}
        
            return $b_template = $values;
        }

/**
* Description
*
* @param type $var description
* @return type description
*/
function show_block($ele) {

$sel0 = $sel1 = $ssel0 = $ssel1 = $ssel2 = $ssel3 = $ssel4 = $ssel5 = $ssel6 = $ssel7 = "";

if ( $ele->getVar("visible") == 1 ) {
  $sel1 = " selected='selected'";
  } else {
    $sel0 = " selected='selected'";
  }

if ( $ele->getVar("side") == RCX_SIDEBLOCK_LEFT) {
  $ssel0 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_SIDEBLOCK_RIGHT ) {
    $ssel1 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_CENTERBLOCK_TOPLEFT ) {
    $ssel2 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_CENTERBLOCK_TOPCENTER ) {
    $ssel3 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_CENTERBLOCK_TOPRIGHT ) {
    $ssel4 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_CENTERBLOCK_BOTTOMLEFT ) {
    $ssel5 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_CENTERBLOCK_BOTTOMCENTER ) {
    $ssel6 = " selected='selected'";

  } elseif ( $ele->getVar("side") == RCX_CENTERBLOCK_BOTTOMRIGHT ) {
    $ssel7 = " selected='selected'";
  }

  $title = $ele->getVar("title") ? $ele->getVar("title") : $ele->getVar("name");

  
echo "
<tr valign='top' class='sysbg1'>
<td>".$ele->getVar("name")."</td>

<td align=left>&nbsp;&nbsp;".$title."</td>
<td>
<select name='side[]' class='select'>
<option value='".RCX_SIDEBLOCK_LEFT."'$ssel0>"._AM_SBLEFT."</option>
<option value='".RCX_SIDEBLOCK_RIGHT."'$ssel1>"._AM_SBRIGHT."</option>

<option value='".RCX_CENTERBLOCK_TOPLEFT."'$ssel2>"._AM_TCBLEFT."</option>
<option value='".RCX_CENTERBLOCK_TOPCENTER."'$ssel3>"._AM_TCBCENTER."</option>
<option value='".RCX_CENTERBLOCK_TOPRIGHT."'$ssel4>"._AM_TCBRIGHT."</option>

<option value='".RCX_CENTERBLOCK_BOTTOMLEFT."'$ssel5>"._AM_BCBLEFT."</option>
<option value='".RCX_CENTERBLOCK_BOTTOMCENTER."'$ssel6>"._AM_BCBCENTER."</option>
<option value='".RCX_CENTERBLOCK_BOTTOMRIGHT."'$ssel7>"._AM_BCBRIGHT."</option>
</select>
</td>";

//added by EsseBe for blocks templates
            $selectbox = '<select name="bshow_template[]" class="select">';
            foreach ( s_template() as $value ) {
                $selector = '';
                if ( $ele->getVar("show_template") == $value ) {
                    $selector =  " selected='selected'";
                }
                $selectbox .= "<option name='".$value."'".$selector.">".$value."</option>";
            }
            $selectbox .= '</select>';
 //end of add
            echo "
                <td align='center'>".$selectbox."</td>

<td align='center'><input type='text' class='text' name='weight[]' value='".$ele->getVar("weight")."' size='5' maxlength='5' /></td>
<td align='center'>
<select name='visible[]' class='select'>
<option value='0'$sel0>"._NO."</option>
<option value='1'$sel1>"._YES."</option>
</select>
</td>


<td align='right' nowrap>";

if ( $ele->isCustom() || $ele->getVar('iscopy') == 1 ) {
  echo "<a href='admin.php?fct=blocksadmin&amp;op=delete&amp;bid=".$ele->getVar("bid")."'><img src='".RCX_URL."/images/editor/delete.gif' alt='"._DELETE."' border='0' /></a>";
}



echo "
<a href='admin.php?fct=blocksadmin&amp;op=copy&amp;bid=".$ele->getVar("bid")."'><img src='".RCX_URL."/images/editor/copy.gif' alt='"._COPY."' border='0' /></a>
<a href='admin.php?fct=blocksadmin&amp;op=edit&amp;bid=".$ele->getVar("bid")."'><img src='".RCX_URL."/images/editor/edit.gif' alt='"._EDIT."' border='0' /></a>


<input type='hidden' name='oldside[]' value='".$ele->getVar("side")."' />
<input type='hidden' name='oldweight[]' value='".$ele->getVar("weight")."' />
<input type='hidden' name='oldvisible[]' value='".$ele->getVar("visible")."' />
<input type='hidden' name='oldbcmodule[]' value='".$ele->getVar("show_mid")."' />
<input type='hidden' name='oldb_template[]' value='".$ele->getVar("show_template")."' />
<input type='hidden' name='bid[]' value='".$ele->getVar("bid")."' />
</td></tr>";
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function save_block($bside, $bweight, $bvisible, $btitle, $bcontent, $bctype, $bcmodule, $bshow_template) {

$myblock = new RcxBlock();
$myblock->setVar("side"    , $bside);
$myblock->setVar("weight"  , $bweight);
$myblock->setVar("visible" , $bvisible);
$myblock->setVar("weight"  , $bweight);
$myblock->setVar("title"   , $btitle);
$myblock->setVar("content" , $bcontent);
$myblock->setVar("c_type"  , $bctype);

//added by EsseBe for blocks templates
$myblock->setVar("show_template", $bshow_template);
$myblock->setVar("type"    , "C");

if (!empty($_POST['page_style'])) {
    $sum = 0;
    foreach ($_POST['page_style'] as $value) {
      $sum += $value;
    }
  } else {
    $sum = 15;
  }

  $myblock->setVar("page_style", $sum);

switch ($bctype) {
case "H":
  $name = _AM_CUSTOMHTML;
  break;

case "P":
  $name = _AM_CUSTOMPHP;
  break;

case "S":
  $name = _AM_CUSTOMSMILE;
  break;

default:
  $name = _AM_CUSTOMNOSMILE;
  break;
  }

$myblock->setVar("name", $name);

  if( in_array('0', $bcmodule)) {
                        $show_mid = '0';
                    }else{
                    $all = true;
                    $mods = RcxModule :: getAllModulesList();
                    foreach ( $mods as $id => $name ) {
                      if( !in_array($id, $bcmodule)||!in_array('-1', $bcmodule)) {
                          $all = False;
                        }
                  }
                    if ($all) {
                    $show_mid = '0';}else{
                    $show_mid = implode('|',$bcmodule);
                }
                    }
  $myblock->setVar("show_mid", $show_mid);      

if ( !$myblock->store() ) {
  rcx_cp_header();
  $myblock->getErrors();
  rcx_cp_footer();
  exit();
}

redirect_header("admin.php?fct=blocksadmin", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function copy_block($bid) {

$myblock = new RcxBlock($bid);

if (intval($_POST['bid']) != $bid) {
  rcx_cp_header();
  OpenTable();
  echo "<h4 style='text-align:left;'>".sprintf(_AM_RUSURECOP, $myblock->getVar("name"))."</h4>";
  echo "<table><tr><td>";
  echo myTextForm("admin.php?fct=blocksadmin&op=copy&bid=".$myblock->getVar("bid") , _YES, true);
  echo "</td><td>";
  echo myTextForm("admin.php?fct=blocksadmin" , _NO);
  echo "</td></tr></table>";
  CloseTable();
  rcx_cp_footer();
  exit();
}

$rcx_token = & RcxToken::getInstance();
  
if ( !$rcx_token->check() ) {
    redirect_header('admin.php?fct=blocksadmin', 3, $rcx_token->getErrors(true));
    exit();
}

$myblock->setVar('bid'   , 0);
$myblock->setVar('iscopy', 1);

$name = $myblock->getVar('title') ? $myblock->getVar('title', 'N') : $myblock->getVar('name', 'N');
$name = _COPY.': '.$name;

$myblock->setVar('name' , $name);
$myblock->setVar('title', $name);

if ( !$myblock->store() ) {
  rcx_cp_header();
  $myblock->getErrors();
  rcx_cp_footer();
  exit();
}

redirect_header("admin.php?fct=blocksadmin", 1, _UPDATED);
exit();

}

/**
* Description
*
* @param type $var description
* @return type description
*/
function edit_block($bid, $op='') {

$myblock = new RcxBlock($bid);

if ($op == 'preview') {
  global $api, $myts;

  $btitle   = $myts->oopsStripSlashesGPC($_POST['btitle']);
  $bcontent = $myts->oopsStripSlashesGPC($_POST['bcontent']);

  $myblock->setVar("side"     , $_POST['bside']);
  $myblock->setVar("weight"   , $_POST['bweight']);
  $myblock->setVar("position" , $_POST['bposition']);
  $myblock->setVar("visible"  , $_POST['bvisible']);
  $myblock->setVar("weight"   , $_POST['bweight']);
  $myblock->setVar("c_type"   , $_POST['bctype']);
  $myblock->setVar("show_template"   , $_POST['bshow_template']);
  $myblock->setVar("title"    , $btitle);
  $myblock->setVar("content"  , $bcontent);

  if (!empty($_POST['page_style']))
  {
    foreach ($_POST['page_style'] as $value) {
      $sum += $value;
    }
    $myblock->setVar("page_style", $sum);
  }

  if (isset($_POST['options'])) {
    
    $options_count = count($_POST['options']);
    
    if ($options_count > 0) {

        // Start support multiple options

        for ( $i = 0; $i < $options_count; $i++ ) {
            if (is_array($_POST['options'][$i])) {
                $_POST['options'][$i] = implode(',', $_POST['options'][$i]);
            }
        }

        // End support multiple options  
    
        $options = implode('|', $_POST['options']);
    $myblock->setVar("options", $options);
  }
}

    global $modules;
    $modules->setValue($_POST['bcmodule']);
    } else {
      global $modules;
      $modules->setValue($myblock->getVar("show_mid"));
    }



OpenTable();

echo "
<h4><a href='".RCX_URL."/modules/system/admin.php?fct=blocksadmin'>"._MAIN."</a>: "._AM_EDITBLOCK."</h4>
<form action='admin.php?fct=blocksadmin' enctype='multipart/form-data' method='post' >

<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td class='sysbg2'>
<table width='100%' border='0' cellpadding='4' cellspacing='1'><tr align='left' valign='top'>

<td class='sysbg3' width='30%'>
<b>"._AM_NAME."</b></td><td class='sysbg1'>".$myblock->getVar("name")."</td>

</tr><tr align='left' valign='top'>

<td class='sysbg3'>
<b>"._AM_BLKPOS."</b></td>
<td class='sysbg1'>
<select name='bside' class='select'>

<option value='".RCX_SIDEBLOCK_LEFT."'";
if ( $myblock->getVar("side") == RCX_SIDEBLOCK_LEFT ) echo " selected='selected'";
echo ">"._AM_SBLEFT."</option>

<option value='".RCX_SIDEBLOCK_RIGHT."'";
if ( $myblock->getVar("side") == RCX_SIDEBLOCK_RIGHT ) echo " selected='selected'";
echo ">"._AM_SBRIGHT."</option>

<option value='".RCX_CENTERBLOCK_TOPLEFT."'";
if ( $myblock->getVar("side") == RCX_CENTERBLOCK_TOPLEFT ) echo " selected='selected'";
echo ">"._AM_TCBLEFT."</option>

<option value='".RCX_CENTERBLOCK_TOPCENTER."'";
if ( $myblock->getVar("side") == RCX_CENTERBLOCK_TOPCENTER ) echo " selected='selected'";
echo ">" ._AM_TCBCENTER."</option>

<option value='".RCX_CENTERBLOCK_TOPRIGHT."'";
if ( $myblock->getVar("side") == RCX_CENTERBLOCK_TOPRIGHT ) echo " selected='selected'";
echo ">"._AM_TCBRIGHT."</option>

<option value='".RCX_CENTERBLOCK_BOTTOMLEFT."'";
if ( $myblock->getVar("side") == RCX_CENTERBLOCK_BOTTOMLEFT ) echo " selected='selected'";
echo ">"._AM_BCBLEFT."</option>

<option value='".RCX_CENTERBLOCK_BOTTOMCENTER."'";
if ( $myblock->getVar("side") == RCX_CENTERBLOCK_BOTTOMCENTER ) echo " selected='selected'";
echo ">"._AM_BCBCENTER."</option>

<option value='".RCX_CENTERBLOCK_BOTTOMRIGHT."'";
if ( $myblock->getVar("side") == RCX_CENTERBLOCK_BOTTOMRIGHT ) echo " selected='selected'";
echo ">"._AM_BCBRIGHT."</option>

</select>
</td>

</tr>

<!--added by EsseBe for blocks templates-->
<tr align='left' valign='top'>

<td class='sysbg3'>
<b>"._AM_TEMPLATE."</b>
</td>";

            $selectbox = '<select name="bshow_template" class="select">';
            foreach ( s_template() as $value ) {
                $selector   = ($myblock->getVar("show_template")==$value) ? ' selected="selected"' : '';
                $selectbox .= '<option value="'.$value.'"'.$selector.'>'.$value.'</option>'."\n";
            }
            $selectbox .= '</select>'."\n";
            
            echo "
           
                <td class='sysbg1'>".$selectbox."</td></tr>

<tr align='left' valign='top'>

<td class='sysbg3'>
<b>"._AM_MODULE."</b>
</td><td class='sysbg1'>
<select name='bcmodule[]' class='select'  multiple='multiple' size='10'>";

            $temp = RcxModule :: getAllModulesList();
            $mods['-1'] = "--"._NONE."--";
            $mods['0'] = "--"._ALL."--";
            foreach ( $temp as $tid => $tname ) {
                $mods[$tid]  = $tname;
            }
            foreach ( $mods as $bcmodule => $mod ) {
              if($bcmodule !== 1){                
                 $selector='';
                if ($myblock->getVar('show_mid')=='0') {
                    $selector =' selected="selected"';
                } elseif (in_array($bcmodule, explode('|', $myblock->getVar('show_mid')))) {
                    $selector = "selected='selected'";
                }
                echo "<option value='$bcmodule' $selector>$mod</option>";
        }
            }
            echo "
                </select>
</td>

</tr>


<tr align='left' valign='top'>";
if ($myblock->getVar("page_style") & 1) {
  $chk1 = "checked ";
}
if ($myblock->getVar("page_style") & 2) {
  $chk2 = "checked ";
}
if ($myblock->getVar("page_style") & 4) {
  $chk3 = "checked ";
}
if ($myblock->getVar("page_style") & 8) {
  $chk4 = "checked ";
}

?>
<td class='sysbg3'>
<b><?php echo _AM_PGTYPE;?></b>
</td><td class='sysbg1'>
<?php echo _AM_START;?>:<input type="checkbox" value="1" name="page_style[]" <?php echo $chk1;?>/>
<?php echo _AM_INDEX;?>:<input type="checkbox" value="2" name="page_style[]" <?php echo $chk2;?>/>
<?php echo _AM_OTHER;?>:<input type="checkbox" value="4" name="page_style[]" <?php echo $chk3;?>/>
<?php echo _AM_SPECIAL;?>:<input type="checkbox" value="8" name="page_style[]" <?php echo $chk4;?>/>
</td>
<?php

echo "
</tr><tr align='left' valign='top'>

<td class='sysbg3'>
<b>"._AM_WEIGHT."</b>
</td><td class='sysbg1'>
<input type='text' name='bweight' class='text' size='2' maxlength='2' value='";
echo $myblock->getVar("weight");
echo "' />
</td>

</tr><tr align='left' valign='top'>

<td class='sysbg3'>
<b>"._AM_VISIBLE."</b></td><td class='sysbg1'>
<select name='bvisible' class='select'>

<option value='0'";
if ( $myblock->getVar("visible") == 0 ) echo " selected='selected'";
echo ">" ._NO."</option>

<option value='1'";
if ( $myblock->getVar("visible") == 1 ) echo " selected='selected'";
echo ">" ._YES."</option>";

echo "</select>
</td>

</tr><tr align='left' valign='top'><td class='sysbg3'>

<b>" ._AM_TITLE."</b></td><td class='sysbg1'>
<input type='text' class='text' name='btitle' size='60' maxlength='60' value='";
echo $myblock->getVar("title") ? $myblock->getVar("title", "E") : $myblock->getVar("name", "E");
echo "' />
</td>

</tr><tr align='left' valign='top'><td class='sysbg3'>

<b>"._AM_CONTENT."</b><br /><br /><span style='font-size:x-small;font-weight:bold;'>"._AM_USEFULTAGS."</span><br /><span style='font-size:x-small;font-weight:normal;'>".sprintf(_AM_BLOCKTAG1, "{X_SITEURL}", RCX_URL."/")."</span></td><td class='sysbg1'>
<textarea name='bcontent' class='textarea' cols='60' rows='10'>";
echo $myblock->getContent("E");
echo "</textarea>

</td></tr>";

if ( !$myblock->isCustom() ) {
  echo "<tr align='left' valign='top'><td class='sysbg3'>
  <b>" ._AM_POSCONTT."</b></td><td class='sysbg1'>
  <select name='bposition' class='select'>

  <option value='0'";
  if ( $myblock->getVar("position") == 0) echo " selected='selected'";
  echo ">" ._AM_ABOVEORG."</option>

  <option value='1'";
  if ( $myblock->getVar("position") == 1) echo " selected='selected'";
  echo ">" ._AM_AFTERORG."</option>

  </select>
  </td></tr>";
}

echo "<tr align='left' valign='top'><td class='sysbg3'>
<b>" ._AM_CTYPE."</b></td><td class='sysbg1'>
<select name='bctype' class='select'>

<option value='H'";
if ( $myblock->getVar("c_type") == "H") echo " selected='selected'";
echo ">" ._AM_HTML."</option>

<option value='P'";
if ( $myblock->getVar("c_type") == "P") echo " selected='selected'";
echo ">" ._AM_PHP."</option>

<option value='S'";
if ( $myblock->getVar("c_type") == "S") echo " selected='selected'";
echo ">" ._AM_AFWSMILE."</option>

<option value='T'";
if ( $myblock->getVar("c_type") == "T") echo " selected='selected'";
echo ">" ._AM_AFNOSMILE."</option>

</select>
</td></tr>";

$edit_form = $myblock->getOptions();

if ( $edit_form != false ) {
  echo "<tr align='left' valign='top'><td class='sysbg3'><b>"._AM_OPTIONS."</b></td><td class='sysbg1'>";
  echo $edit_form;
  echo "</td></tr>";
}


// 
global $db, $_POST;
include_once(RCX_ROOT_PATH."/class/form/formselectgroup.php");

if ( $op == 'preview' && !empty($_POST['read_access']) ) {
  $groups_read = $_POST['read_access'];
} else {
  $sql    = 'SELECT groupid, type FROM '.RC_GRP_BLOCK_LINK_TBL.' WHERE block_id='.$myblock->getVar("bid").'';
  $result = $db->query($sql);
  while (list($groupid, $type) = $db->fetch_row($result)) {
    if ($type == 'A') {
      $groups_admin[] = $groupid;
      } elseif ($type == 'R') {
        $groups_read[] = $groupid;
    }
  }
}
?>
<tr align="left" valign="top">
<td class='sysbg3'><b><?php echo _AM_VIEW_ACCESS;?></b></td>
<td class='sysbg1'>
<?php
$read_access = new RcxFormSelectGroup('', 'read_access', true, $groups_read, 5, true);
echo $read_access->render();
?>
</td></tr>
<?php
//

$rcx_token = & RcxToken::getInstance();

echo "
<tr align='left' valign='top'><td class='sysbg3'>&nbsp;</td>
<td class='sysbg1'>
<select name='op' class='select'>
<option value='preview' selected>"._PREVIEW."</option>
<option value='update'>"._SAVE."</option>
</select>
<input type='hidden' name='bid' value='".$myblock->getVar("bid")."' />
<input type='hidden' name='name' value='".$myblock->getVar("name")."' />
" . $rcx_token->getTokenHTML() . "
<input type='submit' value='"._UPDATE."' />&nbsp;
<input type='button' onclick='location=\"admin.php?fct=blocksadmin\"' value='" ._CANCEL."' />
</td></tr></table></td></tr></table>
</form>";

CloseTable();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function update_block($bid, $bside, $bweight, $bposition, $bvisible, $btitle, $bcontent, $bctype, $options="", $bcmodule, $rights, $bshow_template) {
global $db, $myts;

$myblock = new RcxBlock($bid);
$myblock->setVar("side"    , $bside);
$myblock->setVar("weight"  , $bweight);
$myblock->setVar("position", $bposition);
$myblock->setVar("visible" , $bvisible);
$myblock->setVar("weight"  , $bweight);

if ( strlen(trim($btitle)) > 0 ) {
  $myblock->setVar("title"   , $btitle);
} else {
  $myblock->setVar("title"   , "");
}
$myblock->setVar("content" , $bcontent);


if (!empty($_POST['page_style'])) {

    $sum = 0;
    foreach ($_POST['page_style'] as $value) {
      $sum += $value;
    }

  $myblock->setVar("page_style", $sum);

}

if (isset($options)) {
    
    $options_count = count($options);
    
    if ($options_count > 0) {

        // Start support multiple options

        for ( $i = 0; $i < $options_count; $i++ ) {
            if (is_array($options[$i])) {
                $options[$i] = implode(',', $options[$i]);
            }
        }

        // End support multiple options
    
  $options = implode('|', $options);
  $myblock->setVar("options", $options);
}
}

$myblock->setVar("c_type", $bctype);

if ($myblock->getVar("type") == "C") {
  switch ($bctype) {
    case "H":
      $name = _AM_CUSTOMHTML;
      break;

    case "P":
      $name = _AM_CUSTOMPHP;
      break;

    case "S":
      $name = _AM_CUSTOMSMILE;
      break;

    default:
      $name = _AM_CUSTOMNOSMILE;
      break;
  }
  $myblock->setVar("name", $name);
  
}

  
  if( in_array('0', $bcmodule)) {
                        $show_mid = '0';
                    }else{
                    $all = true;
                    $mods = RcxModule :: getAllModulesList();
                    foreach ( $mods as $id => $name ) {
                      if( !in_array($id, $bcmodule)||!in_array('-1', $bcmodule)) {
                          $all = False;
                        }
                  }
                    if ($all) {
                    $show_mid = '0';}else{
                    $show_mid = implode('|',$bcmodule);
                }
                    }
  $myblock->setVar("show_mid", $show_mid);   
  $myblock->setVar("show_template"  , $bshow_template);                 
                    
$myblock->store();

// Block permission settings

if ( isset($rights) && !empty($rights) ) {
  $db->query("DELETE FROM ".RC_GRP_BLOCK_LINK_TBL." WHERE block_id=$bid");
  $wm_included = false;
  foreach ( $rights as $groupright ) {
    if ( $groupright == 1 ) { $wm_included = true; }
    $db->query("INSERT INTO ".RC_GRP_BLOCK_LINK_TBL." SET groupid=$groupright, block_id=$bid, type='R'");
  }

  if ( $wm_included == false ) {
    $db->query("INSERT INTO ".RC_GRP_BLOCK_LINK_TBL." SET groupid=1, block_id=$bid, type='R'");
  }
}



redirect_header("admin.php?fct=blocksadmin&op=edit&bid=$bid", 1, _UPDATED);
exit();
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function delete_block($bid) {

$myblock = new RcxBlock($bid);

if ( ($myblock->getVar("type") == "S") && ($myblock->getVar('iscopy') == 0) ) {
  $message = _AM_SYSTEMCANT;
  redirect_header("admin.php?fct=blocksadmin", 4, $message);
  exit();
  } elseif ( ($myblock->getVar("type") == "M") && ($myblock->getVar('iscopy') == 0) ) {
    $message = _AM_MODULECANT;
    redirect_header("admin.php?fct=blocksadmin", 4, $message);
    exit();
    } elseif (intval($_POST['bid']) == $bid) {
        
      $rcx_token = & RcxToken::getInstance();
      
      if ( !$rcx_token->check() ) {
          redirect_header('admin.php?fct=maintenanc', 3, $rcx_token->getErrors(true));
          exit();
      }  
        
      $myblock->delete();
      redirect_header("admin.php?fct=blocksadmin", 1, _UPDATED);
      exit();
      } else {
        rcx_cp_header();
        OpenTable();
        echo "<h4 style='text-align:left;'>".sprintf(_AM_RUSUREDEL, $myblock->getVar("title"))."</h4>";
        echo "<table><tr><td>";
        echo myTextForm("admin.php?fct=blocksadmin&op=delete&bid=".$myblock->getVar("bid") , _YES, true);
        echo "</td><td>";
        echo myTextForm("admin.php?fct=blocksadmin" , _NO);
        echo "</td></tr></table>";
        CloseTable();
        rcx_cp_footer();
        exit();
      }
}

/**
* Description
*
* @param type $var description
* @return type description
*/
function order_block($bid, $weight, $visible, $side, $show_template) {

$myblock = new RcxBlock($bid);
$myblock->setVar("weight"  , $weight);
$myblock->setVar("visible" , $visible);
$myblock->setVar("side"    , $side);
$myblock->setVar("show_template"  , $show_template);

$myblock->store();
}


/**
* Description
*
* @param type $var description
* @return type description
*/
function preview_cblock($bid, $btitle, $bcontent, $bctype, $bposition, $options, $bshow_template, $bside) {
global $rcxOption, $myts;

$btitle   = $myts->oopsStripSlashesGPC($btitle);
$bcontent = $myts->oopsStripSlashesGPC($bcontent);
$side = $side;

$myblock = new RcxBlock($bid);
$myblock->setVar("title"   , $btitle);
$myblock->setVar("side"   , $bside);
$myblock->setVar("content" , $bcontent);
$myblock->setVar("c_type"  , $bctype);
$myblock->setVar("position", $bposition);
$myblock->setVar("show_template", $bshow_template);
$myblock->setVar("show_mid", 0);

if (isset($options)) {
    
    $options_count = count($options);
    
    if ($options_count > 0) {

        // Start support multiple options

        for ( $i = 0; $i < $options_count; $i++ ) {
            if (is_array($options[$i])) {
                $options[$i] = implode(',', $options[$i]);
            }
        }

        // End support multiple options
    
        $options = implode('|', $options);
  $myblock->setVar("options", $options);
  }
}  

$block = $myblock->buildBlock($myblock);

?>

<h4><?php echo _AM_BPREVIEW;?></h4>

<?php
echo "<center>";

echo $myblock->showBlock($bside, $block['title'], $block['content']);
echo "<center><br />";
}
  } else {
    echo "Access Denied";
  }
?>
