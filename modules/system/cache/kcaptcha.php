<?php
/*********************************************************************
Remember to chmod 666 this file in order to let the system write to it properly.
If you can't change the permissions you can edit the rest of this file by hand.
*********************************************************************/

# KCAPTCHA configuration file
$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!

# symbols used to draw CAPTCHA
$allowed_symbols = "0123456789"; #digits

# folder with fonts
$fontsdir = 'fonts';

# CAPTCHA string length
$length = 6;

# CAPTCHA image size (you do not need to change it, whis parameters is optimal)
$width = 120;
$height = 50;

# symbol's vertical fluctuation amplitude divided by 2
$fluctuation_amplitude = 3;

# increase safety by prevention of spaces between symbols
$no_spaces = true;

# show credits
$show_credits = false;
$credits = 'www.captcha.ru';

# CAPTCHA image colors (RGB, 0-255)
//$foreground_color = array(0, 0, 0);
//$background_color = array(220, 230, 255);
$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));

# JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)
$jpeg_quality = 80;
?>