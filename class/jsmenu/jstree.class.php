<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/


if ( !isset($treejsincluded) ) $treejsincluded = FALSE;
class jstree {
    var $js_menu_array;
    var $orientation;
    var $name;
    var $design;
    var $design_array;
    var $css;
    var $css_parsed;

    function jstree($name, $array, $orientation='vertical_bottom_right') 
    {
        $this->js_menu_array = $array;
        $this->name = $name;
        switch ($orientation) {
            case 'vertical_bottom_right':
            $this->orientation = 'vbr';
            break;
            case 'vertical_bottom_left':
            $this->orientation = 'vbl';
            break;
            case 'vertical_top_right':
            $this->orientation = 'vur';
            break;
            case 'vertical_top_left':
            $this->orientation = 'vul';
            break;
            case 'horizontal_bottom_right':
            $this->orientation = 'hbr';
            break;
            case 'horizontal_bottom_left':
            $this->orientation = 'hbl';
            break;
            case 'horizontal_top_right':
            $this->orientation = 'hur';
            break;
            case 'horizontal_top_left':
            $this->orientation = 'hul';
            break;
        }
    }

    function setDesign($design='') {
        $this->design = $design;
    }

    function setCSS($css='') {
        $this->css =$css;
    }


    function gen_js_menu_array($what='') {
        $array = (!$what) ? $this->js_menu_array : $what;
        foreach ($array as $key => $node) {
            $menu .= '[';
            if (!$node['title']) $node['title'] = $node['name'];
            $menu .= "'".$node['image']."','".$node['title']."','".$node['link']."','','".$node['name']."'";
            if (is_array($node['leaves'])) {
                $menu .= ', ';
                $menu .= $this->gen_js_menu_array($node['leaves']);
            }
            $menu .= ']';
            if ($key+1 != count ($array)) $menu .=', ';
        }
        return $menu;
    }

    function gen_theme_var() {
        if ($this->design == '') {
                $this->design = array(
                'mainFolderRight' => "'&nbsp;'",
                'mainItemLeft'    => "'&nbsp;'",
                'mainItemRight'   => "'&nbsp;'",
                'folderLeft'      => "''",
                'folderRight'      => "''",
                'itemLeft'          => "''",
                'itemRight'          => "''",
                'mainSpacing'      => "0",
                'subSpacing'      => "0",
                'delay'              => "500"
            );
        }
        $i = 0;
        $theme_var = 'var '.$this->name.'_theme = {'."\n";
        foreach ($this->design as $attribute => $value) {
            $i++;
            $theme_var .= $attribute.': '.$value;
            if ($i!=count($this->design)) $theme_var .= ",\n";
        }
        $theme_var .= '};'."\n";
        $theme_var .= 'var '.$this->name.'_themeHSplit = [_cmNoAction, '."'".'<td class="jsmenu_MenuItemLeft"><\/td><td colspan="2"><div class="jsmenu_MenuSplit"><\/div><\/td>'."'".'];'."\n";
        $theme_var .= 'var '.$this->name.'_themeMainHSplit = [_cmNoAction, '."'".'<td class="jsmenu_MainItemLeft"><\/td><td colspan="2"><div class="jsmenu_MenuSplit"><\/div><\/td>'."'".'];'."\n";
        $theme_var .= 'var '.$this->name.'_themeMainVSplit = [_cmNoAction, '."'".'|'."'".'];'."\n";
        $this->design_array = $theme_var;
    }

    function gen_css () {
        if ($this->css == '') {
            $this->css = RCX_URL.'/themes/'.getTheme().'/style/style.css';
        }
    }

    function render() {
        global $treejsincluded;
        $this->gen_js_menu_array();
        $this->js_menu_array = '['.$this->gen_js_menu_array().']';
        $this->gen_theme_var();
        $this->gen_css();
        $tree_code  = '<script type="text/javascript" language="JavaScript"><!--'."\n var ".$this->name.' = '.$this->js_menu_array.";\n".'--></script>';
        if (!$treejsincluded) {
            $tree_code .= '<script type="text/javascript" language="JavaScript" src="'.RCX_URL.'/class/jsmenu/menu.js"></script>';
            $treejsincluded = TRUE;
        }
// giver fejl
//        $tree_code .= '<link rel="stylesheet" href="'.$this->css.'" type="text/css">';
        $tree_code .= '<script type="text/javascript" language="JavaScript"><!--'."\n ".$this->design_array."\n".'--></script>';
        $tree_code .= '<div id="'.$this->name.'"></div>';
        $tree_code .= '<script type="text/javascript" language="JavaScript"><!--'."\n"."cmDraw ('".$this->name."', ".$this->name.", '".$this->orientation."', ".$this->name."_theme, 'jsmenu_');\n--></script>";
        return $tree_code;
    }
}
?>
