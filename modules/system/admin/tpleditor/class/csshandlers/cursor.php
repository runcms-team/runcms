<?php

/**
 * Enter description here...
 *
 */
class RcxCursorCss extends RcxCssHandler {
    
    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $options = array("auto" => "auto", "default" => "default", "crosshair" => "crosshair", "help" => "help", "move" => "move", "pointer" => "pointer" , "progress" => "progress" , "text" => "text" , "wait" => "wait" , "n-resize" => "n-resize" , "ne-resize" => "ne-resize" , "e-resize" => "e-resize" , "se-resize" => "se-resize", "s-resize" => "s-resize" , "sw-resize" => "sw-resize" , "w-resize" => "w-resize" , "nw-resize" => "nw-resize" , "inherit" => "inherit" );

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {
        if (!preg_match('/url/', $p_value)) {
            return parent::getFormSelectEle($form);
        } else {
            return parent::getFormEle($form);
        }

    }
}

?>