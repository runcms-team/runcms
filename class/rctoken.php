<?php
/*
You may not change or alter any portion of this comment or credits
of supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit authors.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *  Xoops Form Class Elements
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @subpackage      Class
 * @since           2.0.0
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @author          Jan Pedersen <mithrandir@xoops.org>
 * @author          John Neill <catzwolf@xoops.org>
 * @version         $Id: xoopssecurity.php 3749 2009-10-17 14:23:04Z trabis $
 */
defined('RCX_ROOT_PATH') or die('Restricted access');

/**
 * Security Token Class
 *
 * @author Kazumi Ono <onokazu@xoops.org>
 * @author Jan Pedersen <mithrandir@xoops.org>
 * @author John Neill <catzwolf@xoops.org>
 * @copyright copyright (c) XOOPS.org
 * @package kernel
 * @subpackage Class
 * @access public
 */
class RcxToken
{
    var $errors = array();

    /**
     * Constructor
     *
     **/
    function RcxToken()
    {
        if(!isset($_SESSION)) session_start();
    }


    /**
     * Enter description here...
     *
     * @return unknown
     */
    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new RcxToken();
        }
        return $instance;
    }

    /**
     * Check if there is a valid token in $_REQUEST[$name . '_REQUEST'] - can be expanded for more wide use, later (Mith)
     *
     * @param bool   $clearIfValid whether to clear the token after validation
     * @param string $token token to validate
     * @param string $name session name
     *
     * @return bool
     */
    function check($clearIfValid = true, $token = false, $name = 'RCX_TOKEN')
    {
        return $this->validateToken($token, $clearIfValid, $name);
    }

    /**
     * Create a token in the user's session
     *
     * @param int $timeout time in seconds the token should be valid
     * @param string $name session name
     *
     * @return string token value
     */
    function createToken($timeout = 0, $name = 'RCX_TOKEN')
    {
        global $rcxConfig;

        $this->garbageCollection($name);
        if ($timeout == 0) {
            $expire = @ini_get('session.gc_maxlifetime');
            $timeout = ($expire > 0) ? $expire : 900;
        }
        $token_id = rc_shatool(uniqid(rand(), true));
        // save token data on the server
        if (!isset($_SESSION[$name . '_SESSION'])) {
            $_SESSION[$name . '_SESSION'] = array();
        }
        $token_data = array(
        'id' => $token_id ,
        'expire' => time() + intval($timeout));
        array_push($_SESSION[$name . '_SESSION'], $token_data);
        return rc_shatool($token_id . $_SERVER['HTTP_USER_AGENT'] . $rcxConfig['prefix']);
    }

    /**
     * Check if a token is valid. If no token is specified, $_REQUEST[$name . '_REQUEST'] is checked
     *
     * @param string $token token to validate
     * @param bool   $clearIfValid whether to clear the token value if valid
     * @param string $name session name to validate
     *
     * @return bool
     **/
    function validateToken($token = false, $clearIfValid = true, $name = 'RCX_TOKEN')
    {
        global $rcxConfig;

        $token = ($token !== false) ? $token : (isset($_REQUEST[$name . '_REQUEST']) ? $_REQUEST[$name . '_REQUEST'] : '');
        if (empty($token) || empty($_SESSION[$name . '_SESSION'])) {
            $this->setErrors('No valid token found in request/session');
            return false;
        }
        $validFound = false;
        $token_data = & $_SESSION[$name . '_SESSION'];
        foreach (array_keys($token_data) as $i) {
            if ($token === rc_shatool($token_data[$i]['id'] . $_SERVER['HTTP_USER_AGENT'] . $rcxConfig['prefix'])) {
                if ($this->filterToken($token_data[$i])) {
                    if ($clearIfValid) {
                        // token should be valid once, so clear it once validated
                        unset($token_data[$i]);
                    }
                    $validFound = true;
                } else {
                    $this->setErrors('Valid token expired');
                }
            }
        }
        if (!$validFound) {
            $this->setErrors('No valid token found');
        }
        $this->garbageCollection($name);
        return $validFound;
    }

    /**
     * Clear all token values from user's session
     *
     * @param string $name session name
     **/
    function clearTokens($name = 'RCX_TOKEN')
    {
        $_SESSION[$name . '_SESSION'] = array();
    }

    /**
     * Check whether a token value is expired or not
     *
     * @param string $token
     *
     * @return bool
     **/
    function filterToken($token)
    {
        return (!empty($token['expire']) && $token['expire'] >= time());
    }

    /**
     * Perform garbage collection, clearing expired tokens
     *
     * @param string $name session name
     *
     * @return void
     **/
    function garbageCollection($name = 'RCX_TOKEN')
    {
        if (isset($_SESSION[$name . '_SESSION']) && count($_SESSION[$name . '_SESSION']) > 0) {
            $_SESSION[$name . '_SESSION'] = array_filter($_SESSION[$name . '_SESSION'], array(
            $this ,
            'filterToken'));
        }
    }

    /**
     * Get the HTML code for a XoopsFormHiddenToken object - used in forms that do not use XoopsForm elements
     *
     * @return string
     **/
    function getTokenHTML($name = 'RCX_TOKEN')
    {
        require_once RCX_ROOT_PATH . '/class/rcxformloader.php';
        $token = new RcxFormHiddenToken($name);
        return $token->render();
    }

    /**
     * Add an error
     *
     * @param   string  $error
     **/
    function setErrors($error)
    {
        $this->errors[] = trim($error);
    }

    /**
     * Get generated errors
     *
     * @param    bool    $ashtml Format using HTML?
     *
     * @return    array|string    Array of array messages OR HTML string
     */
    function &getErrors($ashtml = false)
    {
        if (!$ashtml) {
            return $this->errors;
        } else {
            $ret = '';
            if (count($this->errors) > 0) {
                foreach ($this->errors as $error) {
                    $ret .= $error . '<br />';
                }
            }
            return $ret;
        }
    }
}
?>