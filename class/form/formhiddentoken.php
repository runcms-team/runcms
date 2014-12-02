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
 * @subpackage      form
 * @since           2.0.0
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @author          John Neill <catzwolf@xoops.org>
 * @version         $Id: formhiddentoken.php 3295 2009-07-01 02:26:05Z beckmi $
 */
defined('RCX_ROOT_PATH') or die('Restricted access');

include_once(RCX_ROOT_PATH."/class/form/formhidden.php");

/**
 * A hidden token field
 *
 * @author 		Kazumi Ono <onokazu@xoops.org>
 * @author 		John Neill <catzwolf@xoops.org>
 * @copyright   The XOOPS Project http://sourceforge.net/projects/xoops/ 
 * @package 	kernel
 * @subpackage 	form
 * @access 		public
 */
class RcxFormHiddenToken extends RcxFormHidden
{
    /**
     * Constructor
     *
     * @param string $name "name" attribute
     */
    function RcxFormHiddenToken($name = 'RCX_TOKEN', $timeout = 0)
    {
        $rcx_token = & RcxToken::getInstance();
        $this->RcxFormHidden($name . '_REQUEST', $rcx_token->createToken($timeout, $name));
    }
}

?>