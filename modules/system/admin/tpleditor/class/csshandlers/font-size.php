<?php

/**
 * Enter description here...
 *
 */
class RcxFontSizeCss extends RcxCssHandler {

    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $options = array("xx-small" => "xx-small", "x-small" => "x-small", "small" => "small", "medium" => "medium", "large" => "large", "x-large" => "x-large", "xx-large" => "xx-large", "9px" => "9px", "11px" => "11px", "13px" => "13px", "15px" => "15px", "17px" => "17px", "8pt" => "8pt", "10pt" => "10pt", "12pt" => "12pt", "14pt" => "14pt", "16pt" => "16pt", "18pt" => "18pt");

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {
        if (!array_key_exists($this->p_value, $this->options)) {
            $this->options[$this->p_value] = $this->p_value;
        }

        return parent::getFormSelectEle($form);

    }
}

?>