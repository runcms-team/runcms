<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if ( !defined("RCX_HTMLFORM_INCLUDED") ) {
	define("RCX_HTMLFORM_INCLUDED",1);

class RcxHtmlForm {
	/**
	 * create a text area form element
	 *
	 * @param $name       field name
	 * @param $value      field value
	 * @param $cols       column width
	 * @param $rows       row count
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function textarea($name, $value='', $cols=40, $rows=5, $extraArgs = '') {
		/**  wrap="virtual" is not part of any W3C HTML standard; at least 
		**  up to 4.01, but nearly any decent browser knows it, and if 
		**  it doesn't oh well.   It is too nice to not include here. **/
		$buf = "<textarea wrap='virtual' name='". htmlspecialchars($name). "' id='". htmlspecialchars($name) ."' rows='". $rows ."' cols='". $cols ."' $extraArgs>$value</textarea>";
		return $buf;
	}

	/**
	 * create a hidden form element
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $extraArgs  additional arguments
	 * @returns string
	*/
	function input_hidden($name, $value, $extraArgs = '') {
		$buf = "<input type='hidden' name='". htmlspecialchars($name) ."' id='". htmlspecialchars($name) ."' value='". htmlspecialchars($value) ."' $extraArgs />";
		return $buf;
	}

	/**
	 * create a radio button form element
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $checked   if checked
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function input_radio($name, $value, $checked=FALSE, $extraArgs = '') {
		/**  The following allows for making sure that no two radio buttons
		 **  of the same name can ever be checked.  Once one is checked, no
		 **  subsequent ones will be allowed to be checked.  I used md5 just because it
		 **  produces a unique hash where all characters are valid for a variable
		 **  name in PHP and which is then made into the static variable
		 **  which is where the state is saved.  
		 **  ChangeLog.  
		 **  Had to use 'global' instead of static.  Static was erroring out 
		 **  for some reason.  
		 **/
		$namesum = md5($name);
		$state = 'radio_' . $namesum;
		global $$state;
		$tmp = '';
		if ( $checked && !$$state ) { 
			$$state = TRUE;
			$tmp = " checked='checked'";
		}
		$buf = "<input type='radio' name='". htmlspecialchars($name) ."' id='". htmlspecialchars($name) ."' value='". htmlspecialchars($value) ."' $tmp $extraArgs />";
		unset($tmp);
		unset($state);
		return $buf;
	}

	/**
	 * create a checkbox form element
	 * It assumes that the checkbox value will be "Y" for true
	 * and anything else for false.
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $checked   if checked
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function input_checkbox($name, $value, $checked="", $extraArgs = '') {
		$tmp = '';
		if ( $checked == $value ) {
			$tmp = "checked='checked'";
		}      
		$buf = "<input type='checkbox' name='". htmlspecialchars($name) ."' id='". htmlspecialchars($name) ."' value='". htmlspecialchars($value) ."' $tmp $extraArgs />";
		return $buf;
	}

	/**
	 * create a input text form element
	 *
	 * @param $name       field name
	 * @param $value      field value
	 * @param $size       size
	 * @param $maxlength  max lenght
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function input_text($name, $value='', $size=20, $maxlength=100, $extraArgs = '') {
		if ( $size > $maxlength ) {
			$size = $maxlength;
		}
		if ( strlen($value) > $maxlength ) {
			$value = substr($value, 0, $maxlength);
		}
		$buf = "<input type='text' name='". htmlspecialchars($name) ."' value='$value' id='". htmlspecialchars($name) ."' size='$size' maxlength='$maxlength' $extraArgs />";
		return $buf;
	}

	/**
	 * create a file form element
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $size      size
	 * @param $maxlength max lenght
	 * @param $extraArgs additional arguments
	 * @returns string
	 */
	function input_file($name, $value='', $size=20, $maxlength=100, $extraArgs = '') {
		if ( $size > $maxlength ) {
			$size = $maxlength;
		}
		if ( strlen($value) > $maxlength ) {
			$value = substr($value, 0, $maxlength);
		}
		$buf = "<input type='file' name='". htmlspecialchars($name) ."' value='". htmlspecialchars($value) ."' size='$size' maxlength='$maxlength' $extraArgs />";
		return $buf;
	}

	/**
	 * create a password form element
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $size      size
	 * @param $maxlength max lenght
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function input_password($name, $value='', $size=20, $maxlength=100, $extraArgs = '') {
		if ( $size > $maxlength ) {
			$size = $maxlength;
		}
		if ( strlen($value) > $maxlength ) {
			$value = substr($value, 0, $maxlength);
		}
		$buf = "<input type='password' name='". htmlspecialchars($name) ."' value='". htmlspecialchars($value) ."' size='$size' maxlength='$maxlength' $extraArgs />";
		return $buf;
	}

	/**
	 * create a submit form element
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function input_submit( $value=' GO ', $name='button', $extraArgs = '') {
		$buf = "<input type='submit' name='". htmlspecialchars($name) ."' value='". htmlspecialchars($value) ."' $extraArgs />";
		return $buf;
	}

	/**
	 * create a reset form element
	 *
	 * @param $name      field name
	 * @param $value     field value
	 * @param $extraArgs  additional arguments
	 * @returns string
	 */
	function input_reset($value=' CANCEL ', $extraArgs = '') {
		$buf = "<input type='reset' value='". htmlspecialchars($value) ."' $extraArgs />";
		return $buf;
	}

	/**
	 * create a select form element
	 *
	 * @param $name                field name
	 * @param $valueDescription    associate array of list items
	 * @param $valueSelected       selected entry, comma seperated string or array
	 * @param $size                rows to display
	 * @param $multiple            allow multiple selects
	 * @param $extraArgs           additional arguments
	 * @param $selectByValue       valueSelected contains values, (default is keys)s
	 * @returns string
	 */
	function select($name, $valueDescription_array, $valueSelected='', $size=1, $multiple=FALSE, $extraArgs='', $selectByValue = false) {
		if( gettype($valueSelected) == "array" ) {
			$selected_array = $valueSelected;
		} else {
			$selected_array = explode(",",$valueSelected);
		}

		$num_elements = count($valueDescription_array);
		if ( $size > $num_elements ) {
			$size = $num_elements;
		}
		$multi_array = "";
		$mul = '';
		if ( $multiple ) {
			if ( $num_elements > 1 ) {
				$mul = ' multiple';
			} 
			$multi_array = "[]";
		}
		$buf = "<select id='". htmlspecialchars($name)."' name='". htmlspecialchars($name).$multi_array. 
             "' size='$size' $mul $extraArgs>\n";
		while ( list($key, $val) = each($valueDescription_array) ) {
			$selected = "";
			while ( list($k,$v) = each($selected_array) ) {
				if ( (!$selectByValue && "$key" == "$v" && $v != "") || ($selectByValue && "$val" == "$v" && $v != "") ) {
					$selected = " selected='selected'";
					break;
				}
			}
			$buf .= "<option value='". htmlspecialchars($key) ."' $selected>$val</option>\n";
			reset($selected_array);
		}
		unset($mul);
		$buf .= "</select>";
		return $buf;
	}

	/**
	 * create a select form element
	 *
     * @param $name                	field name
	 * @param $yes           	the name for item with value 1
	 * @param $no			the name for item with value 0
	 * @param $checked		value that will be checked
	 * @param $extraArgs           	additional arguments
	 * @returns string
	 */
	function input_radio_YN($name,$yes="Yes",$no="No",$checked=1,$extraArgs="") {
		$buf = "<input type='radio' id='". htmlspecialchars($name) ."' name='" .htmlspecialchars($name). "' value='1'";
		if ( $checked == 1 ) {
			$buf .= " checked='checked'";
		}
		if ( $extraArgs != "" ) {
			$buf .= " ".$extraArgs;
		}
		$buf .= " />&nbsp;".$yes."<input type='radio' id='". htmlspecialchars($name) ."' name='" .htmlspecialchars($name)."' value='0'";
		if ( $checked == 0 ) {
			$buf .= " checked='checked'";
		}
		if ( $extraArgs != "" ) {
			$buf .= " ".$extraArgs;
		} 
		$buf .= " />&nbsp;".$no."";
		return $buf;
	}

	/**
     * create a select form element
     *
	 * @param $name                field name
	 * @param $valueDescription    associate array of list items
     * @param $valueSelected       selected entry, comma seperated string or array
	 * @param $multiple            allow multiple checks
	 * @param $size		  number of checkboxes/radiobuttons in one row
	 * @param $extraArgs           additional arguments
	 * @param $selectByValue       valueSelected contains values, (default is keys)s
	 * @param $reverse		if true, checked/unchecked are reversed
	 * @returns string
	 */
	function input_check_radio($name, $valueDescription_array, $valueSelected='', $multiple=FALSE, $size=5, $extraArgs='', $selectByValue = false, $reverse = false) {
		if ( gettype($valueSelected) == "array" ) {
			$selected_array = $valueSelected;
		} else {
			$selected_array = explode(",",$valueSelected);
		}
		$multi_array = "";
		$mul = '';
     		$type = "radio";
     		if ( $multiple ) {
			$type = "checkbox";
        		$multi_array = "[]";
     		}
     		$buf = "";
		$count = 1;
     		while ( list($key, $val) = each($valueDescription_array) ) {
			if ( !$reverse ) {
				$checked = "";
			} else {
				$checked = " checked='checked'";
			}
       			while ( list($k,$v) = each($selected_array) ) {
				if ( !$reverse ) {
					if ( (!$selectByValue && "$key" == "$v" && $v != "") || ($selectByValue && "$val" == "$v" && $v != "") ) {
						$checked = " checked='checked'";
	   					break;
					}
	 			} else {
					if ( (!$selectByValue && "$key" == "$v" && $v != "") || ($selectByValue && "$val" == "$v" && $v != "") ) {
						$checked = "";
	   					break;
					}
				}
       			}
       			$buf .= "<input type='".$type."' name='".htmlspecialchars($name).$multi_array."' id='". htmlspecialchars($name) ."' value='". htmlspecialchars($key). "'".$checked." />" .$val. "\n";
			$count++;
			if ( $size == $count ) {
				$buf .= "<br />";
				$count = 1;
			}
			reset($selected_array);
		}
     		unset($mul);
     		return $buf;
	}
}

}
?>