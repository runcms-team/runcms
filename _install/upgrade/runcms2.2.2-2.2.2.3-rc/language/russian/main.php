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

define("_UPGRADE_TITLE", "RUNCMS 2.2.2 -> RUNCMS 2.2.3.0 RC");

define("_UPGRADE_FOOTER","
<br /><br />
При обновлении системы на новую версию должно произойти автоматическое обновление всех ваших модулей. Если этого не произошло:
Вы должны войти в раздел администрирования сайтом, и самостоятельно обновить ВСЕ ваши модули.<br /><br/>

<b>1.</b> Зайдите в раздел администрирования модулями и обновите все установленные модули<br />
<b>2.</b> Зайдите в раздел основных настроек сайта - убедитесь, что значения опций данного раздела установлены верно<br />
<b>3.</b> Зайдите в раздел администрирования групп - убедитесь, что необходимые права доступа для каждой группы установлены верно<br />
<b>4.</b> Финиш. Можете переходить к эксплуатации сайта. Желаем удачи!<br /><br />
<br />
<a href='../user.php' ><b><i>Вход на сайт!</i></b></a><br /><br />");

define("_UPGRADE_SAVE_CONFIG", "Конфигурационный файл сайта успешно перезаписан");
define("_UPGRADE_NO_SAVE_CONFIG", "Не удалось перезаписать конфигурационный файл сайта");

define("_UPGRADE_SAVE_META", "Файл настроек мета-тегов успешно перезаписан");
define("_UPGRADE_NO_SAVE_META", "Не удалось перезаписать файл настроек мета-тегов");

define("_UPGRADE_MODULE_UPDATE", "Модуль \"%s\" обновлен");
define("_UPGRADE_NO_MODULE_UPDATE", "Не удалось обновить модуль \"%s\"");

define("_UPGRADE_CONGRAT" , "Обновление завершено! Обязательно удалите папку ");

define("_UPGRADE_RMDIR", "Директория \"%s\" удалена");
define("_UPGRADE_NO_RMDIR", "Не удалось удалить директорию \"%s\"");


$message[0]['noerror'] = "Тип поля title в таблице stories был изменен на VARCHAR( 255 )";
$message[0]['error'] = "Тип поля title в таблице stories не был изменен на VARCHAR( 255 )";

$message[1]['noerror'] = "Тип поля topic_title в таблице topics был изменен на VARCHAR( 255 )";
$message[1]['error'] = "Тип поля topic_title в таблице topics не был изменен на VARCHAR( 255 )";

$message[2]['noerror'] = "Тип поля title в таблице nseccont был изменен на VARCHAR( 255 )";
$message[2]['error'] = "Тип поля title в таблице nseccont не был изменен на VARCHAR( 255 )";

$message[3]['noerror'] = "Тип поля secname в таблице nsections был изменен на VARCHAR( 255 )";
$message[3]['error'] = "Тип поля secname в таблице nsections не был изменен на VARCHAR( 255 )";

$message[4]['noerror'] = "В таблице session был удален индекс PRIMARY";
$message[4]['error'] = "В таблице session не был удален индекс PRIMARY";

$message[5]['noerror'] = "Таблица cpsession создана";
$message[5]['error'] = "Таблица cpsession не создана";

$message[6]['noerror'] = "Таблица login_log создана";
$message[6]['error'] = "Таблица login_log не создана";

?>