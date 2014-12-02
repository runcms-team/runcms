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

function file_edit()
{
    global $rcxConfig, $db;

    $module = !empty($_GET['module']) ? $_GET['module'] : $_POST['module'];
    $tpl = !empty($_GET['tpl']) ? $_GET['tpl'] : $_POST['tpl'];
    $type = !empty($_GET['type']) ? $_GET['type'] : $_POST['type'];

    if (check_theme($tpl) == false || check_type($type) == false) {
        redirect_header('admin.php?fct=tpleditor', 3, _NOPERM);
        exit();
    }

    if (!empty($module)) {

        if (check_module($module) == false) {
            redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3, _MODULENOEXIST);
            exit();
        }

        include_once(RCX_ROOT_PATH . '/modules/' . $module . '/language/' . $rcxConfig['language'] . '/modinfo.php');
        include_once(RCX_ROOT_PATH . '/modules/' . $module . '/include/rcxv.php');
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

    $dir = RCX_ROOT_PATH . "/themes/" . $tpl . "/";
    $block = !empty($_GET['block']) ? $_GET['block'] : (!empty($_POST['block'])?$_POST['block']:false);

    if (!empty($block)) {
        $file = basename($block . '.html');
        $blocks_list = get_tpl_block_list($dir);
        if (!in_array($file, $blocks_list)) {
            redirect_header('admin.php?fct=tpleditor', 5, sprintf(_TE_NO_FILE2, $file));
            exit();
        }
        $file_path = $dir . $file;
        $description = _TE_TPL_BLOCK;
    } else {
        $fid = !empty($_GET['file']) ? $_GET['file'] : $_POST['file'];
        $file = $tpl_files[$type][$fid]['name'];
        $description = $tpl_files[$type][$fid]['description'];
        $file_path = $dir . $file;
    }

    if (!empty($_POST['submit'])) {

        $rcx_token = & RcxToken::getInstance();

        if ( !$rcx_token->check() ) {
            redirect_header('admin.php?fct=tpleditor&op=tpl_edit&tpl=' . $tpl, 3, $rcx_token->getErrors(true));
            exit();
        }

        $f_open = fopen($file_path, "w");
        fwrite($f_open, $GLOBALS['myts']->oopsStripSlashesGPC($_POST['content']));
        fclose($f_open);
        redirect_header("admin.php?fct=tpleditor&op=tpl_edit&tpl=" . $tpl, 3, sprintf(_TE_WRITTEN_FILE, basename($file)));
        exit();
    } else {
        include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");

        $contents = file_get_contents($file_path);
        $filectime = date("m.d.y, H:i:s", filemtime($file_path));
        clearstatcache();
        rcx_cp_header();
        OpenTable();

        $formname = get_main_link() . get_tpl_link($tpl);
        if (!empty($module)) $formname .= get_tpl_mod_link($tpl, $module);
        $formname .= sprintf(_TE_FILE_EDITOR, basename($file));

        $form = new ThemeForm($formname, "themeform", "admin.php?fct=tpleditor", true, "post", true);
        $form->addElement(new RcxFormLabel(_TE_FILE_NAME, "<b>" . basename($file) . "</b>"));
        $form->addElement(new RcxFormLabel(_TE_FILE_CHANGE, $filectime));
        $form->addElement(new RcxFormLabel(_TE_DESCRIPTION, $description));
        $form->addElement(new RcxFormTextArea(_TE_CONTENT, 'content', $GLOBALS['myts']->makeTboxData4PreviewInForm($contents), 25, 120));

        if ($type == 'tpl') {
            include_once(RCX_ROOT_PATH . '/modules/system/admin/tpleditor/language/' . $rcxConfig['language'] . '/tagsdef.php');

            if (!empty($module)) {
                if (is_file(RCX_ROOT_PATH . '/modules/' . $module . '/language/' . $rcxConfig['language'] . '/tagsdef.php')) {
                    include_once(RCX_ROOT_PATH . '/modules/' . $module . '/language/' . $rcxConfig['language'] . '/tagsdef.php');
                    $tags_def = array_merge($tags_def, $mod_tags_def);
                }
            }

            preg_match_all('/\{((?!L_)[A-Z0-9_\/=\.]+)\}/', $contents, $base_tags);
            $unique_base_tags = array_unique($base_tags[0]);

            if (count($unique_base_tags) > 0) {
                $form->addElement(new FormHeadingRow(_TE_BASE_TAGS));

                foreach($unique_base_tags as $k => $name) {
                    $value = $base_tags[1][$k];
                    if ($tags_def[$value]) {
                        $tagsdef = $tags_def[$value];
                    } else {
                        $tagsdef = _TE_NO_DESCRIPTION;
                    }

                    $form->addElement(new RcxFormLabel($name, $tagsdef));
                }
            }

            preg_match_all('/\{L(_[A-Z0-9_]+)\}/', $contents, $lng_tags);
            $unique_lng_tags = array_unique($lng_tags[0]);

            if (count($unique_lng_tags) > 0) {
                $form->addElement(new FormHeadingRow(_TE_LANGUAGE_TAGS));
                $lng_path = RCX_ROOT_PATH . '/themes/' . $tpl . '/language/';
                if (is_file($lng_path . 'lang-' . $rcxConfig['language'] . '.php')) {
                    include_once($lng_path . 'lang-' . $rcxConfig['language'] . '.php');
                } elseif (is_file($lng_path . 'lang-english.php')) {
                    $form->addElement(new FormHeadingRow(sprintf(_TE_NO_FILE3, "lang-" . $rcxConfig['language'] . ".php"), "center", "bg3"));
                    include_once($lng_path . 'lang-english.php');
                } else {
                    $form->addElement(new FormHeadingRow(_TE_NO_LANGUAGE_FILES, "center", "bg3"));
                }
                foreach($unique_lng_tags as $k => $name) {
                    $value = $lng_tags[1][$k];
                    if (defined($value)) {
                        $constant = sprintf(_TE_REPLACED, constant($value));
                    } else {
                        $constant = _TE_NO_CONFORMITY;
                    }
                    $form->addElement(new RcxFormLabel($name, $constant));
                }
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
        $form->addElement(new RcxFormHidden("op", "file_edit"));
        $form->addElement(new RcxFormHidden("file", $fid));
        $form->addElement(new RcxFormHidden("tpl", $tpl));
        $form->addElement(new RcxFormHidden("block", $block));
        $form->addElement(new RcxFormHidden("type", $type));
        if (!empty($module)) $form->addElement(new RcxFormHidden("module", $module));

        $form->display();
        CloseTable();
        inc_function('show_copyright');
        rcx_cp_footer();
    }
}

?>