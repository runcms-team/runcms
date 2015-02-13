<?php
// +----------------------------------------------------------------------+
// | Language files for RUNCMS 2.2                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2010 runcms.ru team                                    |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to:                           |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// | Language: Russian                                                    |
// | Version of the translation: 4.3                                      |
// | Last modification: 2010-07-15                                        |
// | Translated by: See /language/russian/credits.txt                     |
// | Homepage: http://www.runcms.ru                                       |
// +----------------------------------------------------------------------+

define("_AM_FILTERSETTINGS","Настройка фильтров/Бан");

define("_AM_BADWORDS","Запрет: Слова");
define("_AM_ENTERWORDS","Слова, которые будут искаться в сообщениях.<br /><br />Формат: слово|замена<br /><br />Одно слово на строку без учета регистра.");

define("_AM_BADIPS","Запрет: IP-адреса");
define("_AM_ENTERIPS","IP-адреса, с которых будет запрещен доступ к сайту.<br /><br /><li>Один IP на строку без учета регистра.<br /><li>(Использйте <a href=\"http://www.php.net/manual/en/ref.pcre.php\" target=\"_blank\">регулярные выражения</a>)<br />");
define("_AM_BADIPSTART","^aaa\.bbb\.ccc соответствует IP, начинающимся на aaa.bbb.ccc");
define("_AM_BADIPEND","aaa\.bbb\.ccc$ соответствует IP, оканчивающимся на aaa.bbb.ccc");
define("_AM_BADIPCONTAIN","aaa\.bbb\.ccc соответствует IP, содержащим aaa.bbb.ccc");

define("_AM_BADUNAMES","Запрет: Имя пользователей");
define("_AM_ENTERUNAMES","Запрещенные имена.<br />Одно имя на строку без учета регистра. <br />(Использйте <a href=\"http://www.php.net/manual/en/ref.pcre.php\" target=\"_blank\">регулярные выражения</a>)<br />");

define("_AM_BADEMAILS","Запрет: E-mail");
define("_AM_ENTEREMAILS","E-mail, которые нельзя использовать в аккаунтах.<br />Один адрес на строку без учета регистра. <br />(Использйте <a href=\"http://www.php.net/manual/en/ref.pcre.php\" target=\"_blank\">регулярные выражения</a>)<br />");

define("_AM_BADAGENTS","Запрет: User_Agents");
define("_AM_ENTERAGENTS","Агенты, которым будет запрещен доступ к сайту, например, спамерские боты.<br /><br /><li>Один агент на строку без учета регистра.<br /><li>(Использйте <a href=\"http://www.php.net/manual/en/ref.pcre.php\" target=\"_blank\">регулярные выражения</a>)<br />");
define("_AM_BADAGENTSSTART","^aaa\.bbb\.ccc соответствует агенту, начинающемуся на aaa.bbb.ccc");
define("_AM_BADAGENTSEND","aaa\.bbb\.ccc$ соответствует агенту, оканчивающемуся на aaa.bbb.ccc");
define("_AM_BADAGENTSCONTAIN","aaa\.bbb\.ccc соответствует агенту, содержащему aaa.bbb.ccc");

define("_AM_GOODURL","Дружественные URL");
define("_AM_GOODURL_DESC","Cайты-исключения (дружественные сайты) на которые не ставиться редирект при преобразовании BB-кода [url][/url] в HTML ссылку");
?>
