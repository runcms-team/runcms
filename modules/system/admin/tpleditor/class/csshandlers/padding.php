<?php

/**
 * Enter description here...
 *
 */
class RcxPaddingCss extends RcxCssHandler {

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {

        $padding_arr = preg_split('/\s+/', $this->p_value);
        $count_padding = count($padding_arr);


        switch ($count_padding) {
            case 1:

                $paddings = array('padding-top' => $padding_arr[0],
                'padding-right' => $padding_arr[0],
                'padding-bottom' => $padding_arr[0],
                'padding-left' => $padding_arr[0]);

                break;

            case 2:

                $paddings = array('padding-top' => $padding_arr[0],
                'padding-right' => $padding_arr[1],
                'padding-bottom' => $padding_arr[0],
                'padding-left' => $padding_arr[1]);

                break;

            case 3:

                $paddings = array('padding-top' => $padding_arr[0],
                'padding-right' => $padding_arr[1],
                'padding-bottom' => $padding_arr[2],
                'padding-left' => $padding_arr[1]);

                break;

            case 4:

                $paddings = array('padding-top' => $padding_arr[0],
                'padding-right' => $padding_arr[1],
                'padding-bottom' => $padding_arr[2],
                'padding-left' => $padding_arr[3]);

                break;

            default:
                return parent::getFormEle($form);

        }

        $ele_tray = new RcxFormElementTray($this->p_name, "<br /><br />");

        foreach ($paddings as $key => $value) {
            $ele = new RcxFormText($key, $this->ele_name . '[' . $key . ']', 5, 20, $value);
            $ele_tray->addElement($ele);
        }


        $form->addElement($ele_tray);

        return $form;

    }
}

?>