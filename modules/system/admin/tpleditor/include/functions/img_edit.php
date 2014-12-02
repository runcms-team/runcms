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

function img_edit()
{
    $tpl = !empty($_GET['tpl']) ? $_GET['tpl'] : $_POST['tpl'];

    if (check_theme($tpl) == false) {
        redirect_header('admin.php?fct=tpleditor', 3, _NOPERM);
        exit();
    }

    $img_dir = RCX_ROOT_PATH . "/themes/" . $tpl . "/images/";
    $img_url = RCX_URL . "/themes/" . $tpl . "/images/";

    if (!empty($_POST['submit'])) {

        $rcx_token = & RcxToken::getInstance();

        if (!empty($_FILES['image']['name'])) {

            if ( !$rcx_token->check() ) {
                redirect_header('admin.php?fct=tpleditor&op=img_edit&tpl=' . $tpl, 3, $rcx_token->getErrors(true));
                exit();
            }

            include_once(RCX_ROOT_PATH . "/class/fileupload.php");
            $upload = new fileupload();
            $upload->set_upload_dir($img_dir, 'image');
            $upload->set_accepted('gif|jpg|jpeg|png', 'image');
            $upload->set_max_image_height(0, 'image');
            $upload->set_max_image_width(0, 'image');
            $upload->set_max_file_size(0, 'image');
            $upload->set_overwrite(1, 'image');
            $result = $upload->upload();
            $filename = $result['image']['filename'];
            if (!$result) {
                redirect_header('admin.php?fct=tpleditor&op=img_edit&tpl=' . $tpl, 5, $upload->errors());
                exit();
            }
        }
    }

    if ($_GET["delete"] && preg_match("'[a-z0-9_/-]+\.(gif|jpg|jpeg|png)$'i", $_GET["delete"])) {
        if ($_GET['ok'] == 1) {

            $rcx_token = & RcxToken::getInstance();

            if ( !$rcx_token->check() ) {
                redirect_header('admin.php?fct=tpleditor&op=img_edit&tpl=' . $tpl, 3, $rcx_token->getErrors(true));
                exit();
            }

            if (@file_exists($img_dir . $_GET["delete"]) && getimagesize($img_dir . $_GET["delete"])) {
                unlink($img_dir . $_GET["delete"]);
                redirect_header("admin.php?fct=tpleditor&op=img_edit&tpl=" . $tpl, 3, sprintf(_TE_IMG_DELETED, $_GET["delete"]));
                exit();
            }
        } else {
            rcx_cp_header();
            OpenTable();
            echo "<h4>" . sprintf(_TE_DEL_WARNING, $_GET["delete"]) . "</h4><br><table><tr><td>";
            echo myTextForm("admin.php?fct=tpleditor&op=img_edit&tpl=" . $tpl . "&delete=" . $_GET["delete"] . "&ok=1", _YES, true);
            echo "</td><td>";
            echo myTextForm("admin.php?fct=tpleditor&op=img_edit&tpl=" . $tpl, _NO);
            echo "</td></tr></table>";
            CloseTable();
            inc_function('show_copyright');
            rcx_cp_footer();
            exit();
        }
    }

    include_once(RCX_ROOT_PATH . "/modules/system/admin/tpleditor/include/formloader.inc.php");
    rcx_cp_header();
    OpenTable();

    $values = array();
    $handle = opendir($img_dir);
    $i = 1;
    while (false !== ($file = readdir($handle))) {
        if (($file != ".") && ($file != "..") && (preg_match("/\.(gif|jpg|jpeg|png)$/i", $file)) && !@is_dir($img_dir . $file)) {
            $size = getimagesize($img_dir . $file);
            $filesize = filesize($img_dir . $file);
            $values[$i]['filename'] = $file;
            $values[$i]['imagesize'] = $size[0] . " X " . $size[1];
            $values[$i]['filesize'] = $filesize;
            clearstatcache();
        }
        $i++;
    }
    closedir($handle);
    $form = new ThemeForm(get_main_link() . get_tpl_link($tpl) . sprintf(_TE_IMAGES_MANAGER2, $tpl), "upload", "admin.php?fct=tpleditor", true, "post", true);
    $form->setExtra("enctype='multipart/form-data'");

    $form->addElement(new FormHeadingRow(_TE_PREVIEW_IMG));
    if ($filename) {
        $filename = $img_url . $filename;
    } else {
        $filename = RCX_URL . "/images/pixel.gif";
    }
    $preview = "<img src='" . $filename . "' id='preview' name='preview'/>&nbsp;";
    $form->addElement(new FormHeadingRow($preview, "center", "bg3"));

    foreach($values as $value) {
        $form->addElement(new FormHeadingRow($value['filename']));
        $img_linc1 = "<img src='" . $img_url . $value['filename'] . "' height='15'>";
        $img_linc2 = $value['imagesize'] . " | " . $value['filesize'] . " " . _TE_BYTE;
        $img_linc2 .= " | <img src='" . RCX_URL . "/modules/system/admin/tpleditor/images/find.gif' id='" . $img_url . $value['filename'] . "' alt='" . _PREVIEW . "' title='" . _PREVIEW . "' style='cursor:hand;' onclick='javascript:rcxGetElementById(\"preview\").src=this.id;'>";
        $img_linc2 .= " | <a href='" . RCX_URL . "/modules/system/admin.php?fct=tpleditor&op=img_edit&tpl=" . $tpl . "&delete=" . $value['filename'] . "'><img src='" . RCX_URL . "/modules/system/admin/tpleditor/images/delete.gif' border='0' alt='" . _DELETE . "'  title='" . _DELETE . "'></a>";

        $form->addElement(new RcxFormLabel($img_linc1, $img_linc2));
    }

    $form->addElement(new FormHeadingRow(sprintf(_TE_FORMATS_FILE, "gif|jpg|jpeg|png")));
    $form->addElement(new RcxFormFile(_TE_LOAD_IMAGE, "image", 600000));
    $form_buttons = new RcxFormElementTray('<b>' . _ACTION . '</b>', "&nbsp;");
    $submit_button = new RcxFormButton("", "submit",  _TE_LOAD , "submit");
    $form_buttons->addElement($submit_button);
    $cancel_button = new RcxFormButton("", "cancel", _CANCEL, "button");
    $cancel_button->setExtra("onclick='javascript:history.go(-1)'");
    $form_buttons->addElement($cancel_button);
    $form->addElement($form_buttons);
    $form->addElement(new RcxFormHidden("op", "img_edit"));
    $form->addElement(new RcxFormHidden("tpl", $tpl));

    $form->display();

    CloseTable();
    inc_function('show_copyright');
    rcx_cp_footer();
}

?>