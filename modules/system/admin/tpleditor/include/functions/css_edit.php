<?php 
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* converted to Runcms2 serie by Farsus Design www.farsus.dk
*
* Original Author: LARK (balnov@kaluga.net)
* Support of the module : http://www.runcms.ru
* License Type : ATTENTION! See /LICENSE.txt
* Copyright: (C) 2005 Vladislav Balnov. All rights reserved
*
*/ 
defined( 'RCX_ROOT_PATH' ) or exit( '<h1>Forbidden</h1> You don\'t have permission to access' );

include_once(RCX_ROOT_PATH . '/modules/system/admin/tpleditor/class/csshandler.php');

function cssEditCallback($matches)
{
    return ucfirst($matches[2]);; 
}

function css_edit()
{
    global $db;

    $module = $_GET['module'];
    $file_id = !empty($_GET['file']) ? $_GET['file'] : $_POST['file'];
    $tpl = !empty($_GET['tpl']) ? $_GET['tpl'] : $_POST['tpl'];

    if (check_theme($tpl) == false) {
        redirect_header('admin.php?fct=tpleditor', 3, _NOPERM);
        exit();
    }

    if (!empty($module)) {

        if (check_module($module) == false) {
            redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3, _MODULENOEXIST);
            exit();
        }

        include_once(RCX_ROOT_PATH . "/modules/" . $module . "/rcxv.php");
        if (empty($modversion['tpl'])) {
            redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3, sprintf(_TE_NO_DATA_ON_TPL, $module));
            exit();
        }
        $tpl_files['tpl'] = $modversion['tpl'];
        $tpl_files['css'] = $modversion['css'];
        unset($modversion);
    } else {
        include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/tpl_files_config.php");
    }

    $file = $tpl_files['css'][$file_id]['name'];
    $css_path = RCX_ROOT_PATH . '/themes/' . $tpl . '/' . $file;

    if (!empty($_POST['submit'])) {
        $css = '';

        $rcx_token = & RcxToken::getInstance();

        if ( !$rcx_token->check() ) {
            redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3, $rcx_token->getErrors(true));
            exit();
        }

        if (!empty($_POST['import'])) {
            foreach($_POST['import'] as $filename) {
                $css .= '@import url(' . $filename . ');' . "\r\n";
            }
        }


        $css .= "\r\n";
        foreach($_POST['css'] as $name => $selectors) {
            $css .= $name . ' {' . "\r\n";

            if (is_array($selectors)) {
                foreach($selectors as $property => $value) {

                    if (is_array($value)) {
                        $value = implode(' ', $value);
                    }

                    $css .= "\t" . $property . ": " . $value . ';' . "\r\n";
                }
            }

            $css .= '}' . "\r\n\r\n";
        }

        $f_open = fopen($css_path, "w");
        fwrite($f_open, $css);
        fclose($f_open);
        redirect_header("admin.php?fct=tpleditor&op=tpl_edit&tpl=" . $tpl, 3, sprintf(_TE_WRITTEN_FILE, basename($file)));
        exit();
    } else {
        include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");

        rcx_cp_header();
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._MD_AM_THEMEEDITOR.'</div>
            <br />
            ';
        OpenTable();

        $formname = get_main_link() . get_tpl_link($tpl);
        if (!empty($module)) $formname .= get_tpl_mod_link($tpl, $module);
        $formname .= sprintf(_TE_CLASSES_MANAGER2, basename($file));

        $form = new ThemeForm($formname , "themeform", "admin.php?fct=tpleditor", true, "post", true);

        $css_content = file_get_contents($css_path);

        preg_match_all("/import url\((.+?)\)/i", $css_content, $matches);
        if ($matches[1]) {
            $form->addElement(new FormHeadingRow("<font color='#339933'>"._TE_IMPORT_CSS."</font>"));
            foreach($matches[1] as $k => $import) {
                $import_element = new RcxFormElementTray("import url", "&nbsp;");
                $element_value = new RcxFormText("", "import[]", 35, 255, $import);
                $import_element->addElement($element_value);
                $form->addElement($import_element);
            }
            unset($matches);
        }

        $css_content = preg_replace("#/\*.+?\*/#s", "", $css_content);
        preg_match_all("/([\:\.\#\w\s,]+)\{(.*?)\}/s", $css_content, $selectors);
        $s_count = count($selectors[0]);

        for ($i = 0; $i < $s_count; $i++) {
            $selector_name = trim($selectors[1][$i]);

            $properties = trim($selectors[2][$i]);
            $properties_arr = array();

            if (!empty($properties)) {
                $properties_arr = explode(';', trim($selectors[2][$i]));
            }

            $form->addElement(new FormHeadingRow("<font color='#339933'>" . $selector_name . "</font>"));

            if (!empty($properties_arr) && count($properties_arr) > 0) {

                foreach($properties_arr as $property) {
                    $property = trim($property);
                    if ($property != "") {
                        list($p_name, $p_value) = explode(":", $property, 2);
                        $p_name = trim($p_name);
                        $p_value = trim($p_value);
                        $element_name = 'css[' . $selector_name . '][' . $p_name . ']';

                        //$class_name = 'Rcx' . preg_replace('/(([a-z]+)-*)/e', "ucfirst('$2');", $p_name) . 'Css';
                        
                        $class_name = 'Rcx' . preg_replace_callback('/(([a-z]+)-*)/', 'cssEditCallback', $p_name) . 'Css';
                        
                        $class_file_path = RCX_ROOT_PATH . '/modules/system/admin/tpleditor/class/csshandlers/' . $p_name . '.php';

                        if (file_exists($class_file_path)) {
                            include_once($class_file_path);
                            $css_obj = new $class_name($p_name, $p_value, $element_name);
                        } else {
                            $css_obj = new RcxCssHandler($p_name, $p_value, $element_name);
                        }

                        $form = $css_obj->getFormEle($form);

                    }
                }
            } else {

                $form->addElement(new FormHeadingRow('<div align="center"> --- </div>', 'center', 'bg3'));
                $form->addElement(new RcxFormHidden('css[' . $selector_name . ']', ''));
            }
        }

        $form->addElement(new FormHeadingRow("&nbsp;"));
        $form_buttons = new RcxFormElementTray(_ACTION, "&nbsp;");
        $submit_button = new RcxFormButton("", "submit", _TE_EDIT, "submit");
        $form_buttons->addElement($submit_button);
        $cancel_button = new RcxFormButton("", "cancel", _CANCEL, "button");
        $cancel_button->setExtra("onclick='javascript:history.go(-1)'");
        $form_buttons->addElement($cancel_button);
        $form->addElement($form_buttons);
        $form->addElement(new RcxFormHidden("op", "css_edit"));
        $form->addElement(new RcxFormHidden("file", $file_id));
        $form->addElement(new RcxFormHidden("tpl", $tpl));
        $form->display();
        CloseTable();
        inc_function('show_copyright');
        rcx_cp_footer();
        echo "                        
        </td>
    </tr>
</table>";
    }
}

?>