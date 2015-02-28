<?php

define("_AM_CAPTCHACONF", "CAPTCHA configuration");
define("_AM_EXAMPLE", "CAPTCHA Example");
define("_AM_SYMBOLS", "Allowed Symbols");
define("_AM_DIGITS", "Digits");
define("_AM_ALPHABET", "Alphabet");
define("_AM_ALPHANUM", "Alphanumeric");
define("_AM_CAPLENGTH", "CAPTCHA string length");
define("_AM_CAPWIDTH", "CAPTCHA Image Width");
define("_AM_CAPHEIGHT", "CAPTCHA Image Height");
define("_AM_FLUCTUATION", "Symbol's Vertical Fluctuation Amplitude Divided By 2");
define("_AM_NOSPACES", "Increase Safety By Prevention Of Spaces Between Symbols");
define("_AM_SHOWCREDITS", "Show Credits<br />set to \"No\" to remove credits line. Credits adds 12 pixels to image height");
define("_AM_CREDITS", "If empty, HTTP_HOST Will Be Shown");
define("_AM_JPGQUALITY", "JPEG quality of CAPTCHA image (bigger is better quality, but larger file size)");
define("_AM_CAPTCHA", "CAPTCHA = Completely Automated Public Turing Test to Tell Computers and Humans Apart");
define("_AM_REMEMBER","Remember to chmod 666 this file in order to let the system write to it properly.");
define("_AM_IFUCANT","If you can't change the permissions you can edit the rest of this file by hand.");

/**
 * @since 2.2.3.0
 */

define("_AM_WHITE_NOISE", "The number of white noise (0 if not needed)");
define("_AM_BLACK_NOISE", "The number of black noise (0 if not needed)");
define("_AM_SETTINGTCAPTCHA", "Settings captcha text (additional questions and answers at registration)");
define("_AM_ENABLETCAPTCHA", "Captcha text to activate");
define("_AM_QUESTIONSANDANSWERS", "Enter a set of question and answer (s) <u> per line </u>. <br /> <br /> <span style=\"font-weight: normal;\"> First comes the question, then, after the vertical line, answer or multiple answers, separated by a vertical bar. <br /> <br /> Format: question|response <br /> <br /> or <br /> <br /> question|reply1|Answer2|Answer3 <br /> <br /> <b> Example: </b> <br /> <br /> <span class=\"rcxCode\"> Please type the word without quotation marks \"Dormedont\"|Dormedont <br /> How many eyes Cyclops?|one|1</span> <br /> <br /> <u> Note that the answers are not case sensitive </u>. </span>");

?>