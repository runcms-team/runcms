<?php

define("_AM_FILTERSETTINGS","Filters/Banning");

define("_AM_BADWORDS","Prohibited: Words");
define("_AM_ENTERWORDS","Words that should be censored in user posts.<br /><br />Format: word|replacement<br /><br />Enter one word per line, case insensitive.");

define("_AM_BADIPS","Prohibited: IP Addresses");
define("_AM_ENTERIPS","IP addresses that should be banned out from the site.<br /><br /><li>One IP per line, case insensitive.<br /><li>(Uses <a href='http://www.php.net/manual/en/ref.pcre.php' target='_blank'>Regular Expressions</a>)<br />");
define("_AM_BADIPSTART", "^aaa\.bbb\.ccc will match IP\'s that start with aaa.bbb.ccc");
define("_AM_BADIPEND", "aaa\.bbb\.ccc$ will match IP\'s that end with aaa.bbb.ccc");
define("_AM_BADIPCONTAIN", "aaa\.bbb\.ccc will match IP\'s that contain aaa.bbb.ccc");

define("_AM_BADUNAMES","Prohibited: User Names");
define("_AM_ENTERUNAMES","Names that should not be selected as a username.<br />One name per line, case insensitive. <br />(Uses <a href='http://www.php.net/manual/en/ref.pcre.php' target='_blank'>Regular Expressions</a>)<br />");

define("_AM_BADEMAILS","Prohibited: Emails");
define("_AM_ENTEREMAILS","Emails that are not allowed to be used in user accounts.<br />One email per line, case insensitive. <br />(Uses <a href='http://www.php.net/manual/en/ref.pcre.php' target='_blank'>Regular Expressions</a>)<br />");

define("_AM_BADAGENTS","Prohibited: User_Agents");
define("_AM_ENTERAGENTS","Agents that are not allowed to access your site, such as email crawling spam-bots.<br /><br /><li>One user_agent per line, case insensitive.<br /><li>(Uses <a href='http://www.php.net/manual/en/ref.pcre.php' target='_blank'>Regular Expressions</a>)<br />");
define("_AM_BADAGENTSSTART", "^aaa\.bbb\.ccc will match Agents that start with aaa.bbb.ccc");
define("_AM_BADAGENTSEND", "aaa\.bbb\.ccc$ will match Agents that end with aaa.bbb.ccc");
define("_AM_BADAGENTSCONTAIN", "aaa\.bbb\.ccc will match Agents that contain aaa.bbb.ccc");

/**
 * @since 2.2.3.0
 */

define("_AM_GOODURL", "Friendly URL");
define("_AM_GOODURL_DESC", "Websites-exclusion (friendly sites) which are not placed redirect when converting the BB-Code [url] [/url] in the HTML link");
?>