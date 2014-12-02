<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
    if (!defined("GALL_FORMCOLORSELECT_INCLUDED")) {
      define("ERCX_SPXFORMSELECT_INCLUDED", 1);
    
        include_once(RCX_ROOT_PATH."/class/form/formelement.php");
    
        class GallFormColorSelect extends RcxFormElement {
        
          var $size;
            var $value;
            var $farbe;
          var $options  = array();
        
          function GallFormColorSelect($caption, $name, $value="", $farbe="", $size=1) {
            $this->setCaption($caption);
            $this->setName($name);
            $this->size     = intval($size);
            $this->setValue($value);
                $this->setFarbe($farbe);
          }
        
            function getSize() {
              return $this->size;
            }
            
            function getValue() {
              return $this->value;
            }

            function addOption($value, $name="") {
                 if ( $name != "" ) {
                  $this->options[$value] = $name;
              } else {
                $this->options[$value] = $value;
              }
            }
            
            function setValue($value) {
                $this->value = $value;
            }
            
            function setFarbe($farbe) {
                $this->farbe = $farbe;
            }
            
            function addOptionArray($arr) {
                if ( is_array($arr) ) {
                  foreach ($arr as $k=>$v) {
                    $this->addOption($k, $v);
                  }
                }
            }
            
            function getOptions() {
              return $this->options;
            }
            
            function render() {
                $colorarray = array("00", "33", "66", "99", "CC", "FF");
            $ret .= "<select name='".$this->getName()."' id='".$this->getName()."'>\n";
            $ret .= "<option value='".$this->farbe."'>"._COLOR."</option>\n";
            foreach ( $colorarray as $color1 ) {
              foreach ( $colorarray as $color2 ) {
                foreach ( $colorarray as $color3 ) {
                  $ret .= "<option value='".$color1.$color2.$color3."' style='background-color:#".$color1.$color2.$color3.";color:#".$color1.$color2.$color3.";'";
                            if ($this->value == $color1.$color2.$color3){
                                $ret .= " selected='selected'";
                            }
                            $ret .= ">#".$color1.$color2.$color3."</option>\n";
                }
              }
            }
            $ret .= "</select>\n";
                return $ret;
            }
        } 
    } 
?>
