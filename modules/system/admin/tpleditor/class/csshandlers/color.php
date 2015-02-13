<?php

/**
 * Enter description here...
 *
 */
class RcxColorCss extends RcxCssHandler {

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {
        
        $form->addElement(new FormColorTray($this->p_name, $this->ele_name, 10, 7, $this->p_value, crc32($this->ele_name . $this->p_name)));
        
        return $form;

    }
}

?>