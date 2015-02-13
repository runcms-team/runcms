<?php

/**
 * Enter description here...
 *
 */
class RcxCssHandler {

    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $options = array();
    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $p_name;
    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $p_value;
    /**
     * Enter description here...
     *
     * @var unknown_type
     */
    var $ele_name;

    /**
     * Enter description here...
     *
     * @param unknown_type $p_name
     * @param unknown_type $p_value
     * @param unknown_type $ele_name
     * @param unknown_type $s_i
     * @return RcxCssHandler
     */
    function RcxCssHandler($p_name, $p_value, $ele_name) {
        $this->p_name = $p_name;
        $this->p_value = $p_value;
        $this->ele_name = $ele_name;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {
        $ele_tray = new RcxFormElementTray($this->p_name, "&nbsp;");
        $ele = new RcxFormText("", $this->ele_name, 35, 255, $this->p_value);
        $ele_tray->addElement($ele);
        $form->addElement($ele_tray);

        return $form;
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormSelectEle($form)
    {
        $ele = new RcxFormSelect($this->p_name, $this->ele_name, $this->p_value);
        $ele->addOptionArray($this->options);
        $form->addElement($ele);

        return $form;
    }
}

/**
 * Enter description here...
 *
 */
class RcxCssSelect extends RcxCssHandler {

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {
        return parent::getFormSelectEle($form);
    }
}

?>