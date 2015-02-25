<?php

// +-------------------------------------------------------------+
// | Russian Support RunCms                                      |
// +-------------------------------------------------------------+
// | Copyright (c) 2006 Ruscms.RU development group              |
// +-------------------------------------------------------------+
// | For the full copyright and license information please, view |
// | the license.txt file that was distributed with this source  |
// | code. If the license.txt file is missing, please visit the  |
// | RusCms homepage: http://www.ruscms.ru                       |
// +-------------------------------------------------------------+
/**
 * 
 * @version $Id$
 * @package modules
 * @copyright (C) 2006 Ruscms.RU development group. All rights reserved.
 * @copyright (C) 2006 Vladislav Balnov (LARK) <balnov@kaluga.net>. All rights reserved.
 * @link http://www.ruscms.ru
 * @author Vladislav Balnov (LARK) <balnov@kaluga.net>
 */
class UpgradeMessage
{

    /**
     *
     * @var type 
     */
    var $errors = array();

    /**
     *
     * @var type 
     */
    var $message = array();

    function addErrors($value)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $this->errors[] = trim($val);
            }
        }

        $this->errors[] = trim($value);
    }

    /**
     * 
     * @param type $value
     */
    function addMessage($value)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $this->message[] = trim($val);
            }
        }

        $this->message[] = trim($value);
    }

    /**
     * 
     * @return string
     */
    function getErrors()
    {
        $ret = "<h4>" . _UPGRADE_ERRORS . "</h4>";

        if (count($this->errors) != 0) {
            $ret .="<blockquote><ol>";
            foreach ($this->errors as $error) {
                $ret .= "<li><font color='#FF0000'>" . $error . "</font></li>";
            }
            $ret .="</ol></blockquote>";
        } else {
            $ret .= "<center><p><font color='#006600'>" . _UPGRADE_NOERRORS . "</font></p></center>";
        }

        return $ret;
    }

    /**
     * 
     * @return string
     */
    function getMessage()
    {
        $ret = "<h4>" . _UPGRADE_MESSAGES . "</h4>";
        if (count($this->message) != 0) {
            $ret .="<blockquote><ol>";
            foreach ($this->message as $ms) {
                $ret .= "<li><font color='#006600'>" . $ms . "</font></li>";
            }
            $ret .="</ol></blockquote>";
        } else {
            $ret .= "<center><p><font color='#FF0000'>" . _UPGRADE_MESSAGES2 . "</font></p></center>";
        }
        return $ret;
    }
}

?>