<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!preg_match("/admin\.php/i", $_SERVER['PHP_SELF']))
{
  exit();
}

if ($rcxUser->isAdmin($rcxModule->mid()))
{
//  include_once(RCX_ROOT_PATH."/class/rcxformloader.php");
//  global $rcxConfig, $myts, $_POST,$_GET;

  // ----------------------------------------------------------------------------------------//
  function make_menu()
  {
    include_once(RCX_ROOT_PATH."/class/rcxformloader.php"); 

    rcx_cp_header();
    
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fbund">
    <tr>
        <td class="KPindex">
            <div class="KPstor" >'._AM_CAPTCHACONF.'</div>
            <br />
            <br />';

    OpenTable();
    include("./cache/kcaptcha.php");
    
    // start tcaptcha hack by LARK
    
    include("./cache/tcaptcha.php");
    
    // end tcaptcha hack by LARK

    if (strstr($allowed_symbols, '012'))
    {
      $allowsym = 1;
    }
    elseif (strstr($allowed_symbols, '89ab'))
    {
      $allowsym = 3;
    }
    elseif (strstr($allowed_symbols, 'abcd'))
    {
      $allowsym = 2;
    }
    else
    {
      $allowsym = 1;
    }
    
    session_start();
    $example = new RcxFormLabel(_AM_EXAMPLE, '<img src="'.RCX_URL.'/class/kcaptcha/kcaptcha.php?'.session_name().'='.session_id().'">');
    
    $symbols = new RcxFormSelect(_AM_SYMBOLS, "symbols", $allowsym);
    $symbols->addOptionArray(array(1 => _AM_DIGITS, 2 => _AM_ALPHABET, 3 => _AM_ALPHANUM));

    //$caplen = new RcxFormSelect(_AM_CAPLENGTH, "caplen", (int)$length);
    $caplen = new RcxFormSelect(_AM_CAPLENGTH, "caplen", $captionmask);
    $caplen->addOptionArray(array(4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8',
                                  45 => '4-5', 46 => '4-6', 56 => '5-6', 57 => '5-7'));

    $cap_width = new RcxFormText(_AM_CAPWIDTH, "width", 3, 3, $width);
    $cap_height = new RcxFormText(_AM_CAPHEIGHT, "height", 3, 2, $height);
    
    $fluctuation = new RcxFormText(_AM_FLUCTUATION, "fluctuation", 3, 2, $fluctuation_amplitude);
    
    $white_noise = new RcxFormText(_AM_WHITE_NOISE, "white_noise", 3, 2, ($white_noise_density == 0) ? 0 : 1/$white_noise_density);
    $black_noise = new RcxFormText(_AM_BLACK_NOISE, "black_noise", 3, 2, ($black_noise_density == 0) ? 0 : 1/$black_noise_density);  
    
    $no_spaces = new RcxFormRadioYN(_AM_NOSPACES, "no_spaces", $no_spaces, _YES,_NO);

    $show_credits = new RcxFormRadioYN(_AM_SHOWCREDITS, "show_credits", $show_credits, _YES,_NO);

    $credits = new RcxFormText(_AM_CREDITS, "credits", 24, 24, $credits);

    $jpeg_quality = new RcxFormSelect(_AM_JPGQUALITY, "jpeg_quality", $jpeg_quality);
    $jpeg_quality->addOptionArray(array(60 => '60', 65 => '65', 70 => '70', 75 => '75', 80 => '80',
                                  85 => '85', 90 => '90', 95 => '95', 100 => '100'));
    $copy= new RcxFormLabel('', '<a hr'.'ef="ht'.'tp://ww'.'w.cap'.'tcha.ru/" tar'.'get="_bla'.'nk">KCAP'.'TCHA</a> by <a href="htt'.'p://w'.'ww.prop'.'an-soc'.'hi.ru/" tar'.'get="_bla'.'nk">S'.'V'.'L</a> and Text Captcha hack by <a href="http://www.runcms.ru/" target="_blank">LARK</a>');
    $copy->setColspan();
//    $blnk= new RcxFormLabel('', _AM_CAPTCHA);
//    $blnk->setColspan();
    $op_hidden     = new RcxFormHidden("op", "save");
    $submit_button = new RcxFormButton("", "button", _UPDATE, "submit");

    $form = new RcxThemeForm("", "editor_form", "admin.php?fct=captcha", "post", true);
    $form->addElement($example);
    $form->addElement($symbols);
    $form->addElement($caplen);
    $form->addElement($cap_width);
    $form->addElement($cap_height);
    $form->addElement($fluctuation);
    $form->addElement($white_noise);
    $form->addElement($black_noise);
    $form->addElement($no_spaces);
    $form->addElement($show_credits);
    $form->addElement($credits);
    $form->addElement($jpeg_quality);
    
    // start tcaptcha hack by LARK (http://www.runcms.ru)
    
    $form->addElement(new FormHeadingRow(_AM_SETTINGTCAPTCHA));
    $form->addElement(new RcxFormRadioYN(_AM_ENABLETCAPTCHA, "use_tc", $tcaptcha['use_tc'], _YES,_NO));
    $form->addElement(new RcxFormTextArea(_AM_QUESTIONSANDANSWERS, 'tc_qq', stripslashes($tcaptcha['tc_qq']), 10));
    
    // end tcaptcha hack
    
    
    $form->addElement($op_hidden);
    $form->addElement($submit_button);
//    $form->addElement($blnk);
    $form->addElement($copy);
    $form->display();

    CloseTable();
    unset($_SESSION['captcha_keystring']);
    
    
echo "                        
        </td>
    </tr>
</table>";    
    
    rcx_cp_footer();
  }
  // ----------------------------------------------------------------------------------------//
  
  // start tcaptcha hack by LARK (http://www.runcms.ru)
  
  function save_maint($content, $filename = 'kcaptcha.php') {
  
    $filename = RCX_ROOT_PATH . "/modules/system/cache/" . $filename;
    
    if ($file = fopen($filename, "w")) {
        
      fwrite($file, $content);
      fclose($file);
      
      return true;
      
    } else {
      return false;
    }
  }
  
  // end tcaptcha hack
  
  // ----------------------------------------------------------------------------------------//

  $op = $_REQUEST['op'];

  switch($op)
  {
    case "save":
      global $myts;
      
      $rcx_token = & RcxToken::getInstance();
  
      if ( !$rcx_token->check() ) {
          redirect_header('admin.php?fct=captcha', 3, $rcx_token->getErrors(true));
          exit();
      }
      
      $symbols = (int)$_REQUEST['symbols'];
      switch($symbols)
      {
        case 2:
            $allowsymbols = '$allowed_symbols = "abcdefghkmnpqrstuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j)';
          break;
        
        case 3;
            $allowsymbols = '$allowed_symbols = "23456789abcdefghkmnpqrstuvxyz"; #alphanumeric without similar symbols (o=0, 1=l, i=j)';
          break;
        
        default:
            $allowsymbols = '$allowed_symbols = "0123456789"; #digits';
          break;
      }

      $caplen = (int)$_REQUEST['caplen'];
      if ( $caplen > 9 && $caplen < 89)
      {
        $captionlenght = '$length = mt_rand('.wordWrap($caplen, 1, ',', 1).');';
      }
      else if ($caplen > 0 && $caplen <= 9)
      {
        $captionlenght = '$length = '.(int)$_REQUEST['caplen'].';';
      }
      else
      {
        $captionlenght = '$length = mt_rand(4,6);';
      }
      $credits = $myts->makeTboxData4PreviewInForm($_REQUEST['credits']);

      $content = "<?php\n";
      $content .= "/*********************************************************************\n";
      $content .= _AM_REMEMBER."\n";
      $content .= _AM_IFUCANT."\n";
      $content .= "*********************************************************************/\n\n";
      $content .= "# KCAPTCHA configuration file\n";
      $content .= '$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!'."\n\n";
      $content .= "# symbols used to draw CAPTCHA\n";
      $content .= $allowsymbols."\n\n";
      $content .= "# folder with fonts\n";
      $content .= '$fontsdir = \'fonts2\';'."\n\n";
      $content .= "# CAPTCHA string length\n";
      //$content .= $captionlenght."\n\n# CAPTCHA image size (you do not need to change it, whis parameters is optimal)\n";
      $content .= $captionlenght."\n".'$captionmask = '.$caplen.";\n\n# CAPTCHA image size (you do not need to change it, whis parameters is optimal)\n";  
      $content .= '$width = '.(int)$_REQUEST['width'].";\n";
      $content .= '$height = '.(int)$_REQUEST['height'].";\n\n";
      $content .= "# symbol's vertical fluctuation amplitude divided by 2\n";
      $content .= '$fluctuation_amplitude = '.(int)$_REQUEST['fluctuation'].";\n\n";
      $content .= "#noise\n";
      $content .= '$white_noise_density = '.(($_REQUEST['white_noise'] == 0) ? "0" : "1/".$_REQUEST['white_noise']).";\n";
      $content .= '$black_noise_density = '.(($_REQUEST['black_noise'] == 0) ? "0" : "1/".$_REQUEST['black_noise']).";\n\n";     
      $content .= "# increase safety by prevention of spaces between symbols\n";
      $content .= '$no_spaces = ';
      $content .= ((int)$_REQUEST['no_spaces'] == 1) ? "true;\n\n" : "false;\n\n";
      $content .= "# show credits\n";
      $content .= '$show_credits = ';
      $content .= ((int)$_REQUEST['show_credits']) ? "true;\n" : "false;\n";
      $content .= '$credits = ';
      $content .= ($credits !='') ? "'".$credits."';\n\n" : "'';\n\n";
      $content .= "# CAPTCHA image colors (RGB, 0-255)\n";
      $content .= '//$foreground_color = array(0, 0, 0);'."\n";
      $content .= '//$background_color = array(220, 230, 255);'."\n";
      $content .= '$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));'."\n";
      //$content .= '$foreground_color = array(mt_rand(130,180), mt_rand(130,180), mt_rand(130,180));'."\n";
      $content .= '$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));'."\n\n";
      $content .= "# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)\n";
      $content .= '$jpeg_quality = '.(int)$_REQUEST['jpeg_quality'].";\n";
      $content .= '?>';
      
      // start tcaptcha hack by LARK (http://www.runcms.ru)

      if (save_maint($content, 'kcaptcha.php') == false) {
          redirect_header("admin.php?fct=captcha", 3, _NOTUPDATED);
          exit();
      }
      
      $tc_qq = $myts->stripPHP($_REQUEST['tc_qq']);

      $content = "<?php\n\n";
      $content .= '$tcaptcha[\'use_tc\'] = ' . (int)$_REQUEST['use_tc'] . ";\n";
      $content .= '$tcaptcha[\'tc_qq\'] = \'' . trim($myts->oopsAddSlashesGPC($tc_qq)) . '\''. ";\n";
      $content .= '?>';
      
      if (save_maint($content, 'tcaptcha.php') == false) {
          redirect_header("admin.php?fct=captcha", 3, _NOTUPDATED);
          exit();
      }
      
      // end tcaptcha hack
      
      redirect_header("admin.php?fct=captcha", 3, _UPDATED);
      exit();

      break;

    default:
      make_menu();
      break;
  }
}
else
{
  echo "Access Denied";
}
?>