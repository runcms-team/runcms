<?php

/**
 * Enter description here...
 *
 */
class RcxMarginCss extends RcxCssHandler {

    /**
     * Enter description here...
     *
     * @param unknown_type $form
     * @return unknown
     */
    function getFormEle($form)
    {

        $margin_arr = preg_split('/\s+/', $this->p_value);
        $count_margin = count($margin_arr);


        switch ($count_margin) {
            case 1:

                $margins = array('margin-top' => $margin_arr[0],
                'margin-right' => $margin_arr[0],
                'margin-bottom' => $margin_arr[0],
                'margin-left' => $margin_arr[0]);

                break;

            case 2:

                $margins = array('margin-top' => $margin_arr[0],
                'margin-right' => $margin_arr[1],
                'margin-bottom' => $margin_arr[0],
                'margin-left' => $margin_arr[1]);

                break;

            case 3:

                $margins = array('margin-top' => $margin_arr[0],
                'margin-right' => $margin_arr[1],
                'margin-bottom' => $margin_arr[2],
                'margin-left' => $margin_arr[1]);

                break;

            case 4:

                $margins = array('margin-top' => $margin_arr[0],
                'margin-right' => $margin_arr[1],
                'margin-bottom' => $margin_arr[2],
                'margin-left' => $margin_arr[3]);

                break;

            default:
                return parent::getFormEle($form);

        }

        $ele_tray = new RcxFormElementTray($this->p_name, "<br /><br />");

        foreach ($margins as $key => $value) {
            $ele = new RcxFormText($key, $this->ele_name . '[' . $key . ']', 5, 20, $value);
            $ele_tray->addElement($ele);
        }


        $form->addElement($ele_tray);

        return $form;

    }
}

?>