<?php

/**
 * Enter description here...
 *
 */
class RcxBackgroundCss extends RcxCssHandler {

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {
        
        if (preg_match('/^#[0-9a-z]+?$/i', $this->p_value)) {

            $form->addElement(new FormColorTray($this->p_name, $this->ele_name, 10, 7, $this->p_value, crc32($this->ele_name . $this->p_name)));

            return $form;

        } else {
            return parent::getFormEle($form);
        }
    }
}

?>