<?php
/*********************************************************************
Установите chmod 666 для этого файла, чтобы разрешить запись в этот файл.
Если не можете изменить права доступа, отредактируйте файл вручную.
*********************************************************************/

# KCAPTCHA configuration file
$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!

# symbols used to draw CAPTCHA
$allowed_symbols = "23456789abcdefghkmnpqrstuvxyz"; #alphanumeric without similar symbols (o=0, 1=l, i=j)

# folder with fonts
$fontsdir = 'fonts2';

# CAPTCHA string length
$length = mt_rand(5,6);
$captionmask = 56;

# CAPTCHA image size (you do not need to change it, whis parameters is optimal)
$width = 120;
$height = 50;

# symbol's vertical fluctuation amplitude divided by 2
$fluctuation_amplitude = 8;

#noise
$white_noise_density = 1/6;
$black_noise_density = 1/30;

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