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


// Welcome Screen
define("_INSTALL_W_WELCOME"   , "Добро пожаловать в программу установки %s");
define("_INSTALL_W_CHOOSE"    , "Укажите необходимое действие (установка/обновление):");
define("_INSTALL_W_CHOOSELANG", "Укажите язык, который будет использован в процессе установки");

// Server Tests
define("_INSTALL_ST_TESTS"       , "Результаты тестирования сервера:");
define("_INSTALL_ST_MAINFILE_OK" , "<img src='images/check.gif' /> <b>mainfile.php</b> доступен для записи.");
define("_INSTALL_ST_MAINFILE_BAD", "<img src='images/failed.gif' /> <b>mainfile.php</b> в основной директории портала должен иметь права доступа 0666 Unix / read-write Win32");
define("_INSTALL_ST_MYSQL_OK"    , "<img src='images/check.gif' /> MySQL %s.");
define("_INSTALL_ST_MYSQL_BAD"   , "<img src='images/failed.gif' /> MySQL %s.");
define("_INSTALL_ST_MYSQL_BAD2"  , "Невозможно определить версию MySQL. Поддерживаемые версии начинаются с 3.23.xx.");
define("_INSTALL_ST_GLOBALS_OK"  , "<img src='images/check.gif' /> Register Globals включен.");
define("_INSTALL_ST_GLOBALS_BAD" , "<img src='images/question.gif' /> Register Globals выключен (это не влияет на функционирование портала).");
define("_INSTALL_ST_PHP_OK"      , "<img src='images/check.gif' /> PHP %s.");
define("_INSTALL_ST_PHP_BAD"     , "<img src='images/failed.gif' /> PHP %s.");
define("_INSTALL_ST_NEXT"        , "Если результаты проверки не содержат ошибок, можно продолжить установку.");
define("_INSTALL_PHPINFO"        , "Информация о PHP");

// DBFORM
define("_INSTALL_DF_DB"          ,"База данных");
define("_INSTALL_DF_DB1"         ,"<i>Укажите тип базы данных (на данный момент, только MySql)</i>");
define("_INSTALL_DF_HOST"        ,"Имя или IP-адрес сервера базы данных");
define("_INSTALL_DF_HOST1"       ,"<i>Доменное имя или IP-адрес сервера на котором расположена база данных. <br /><br />Для локального сервера (например пакета 'Денвер') как правило <b>localhost</b></i>");
define("_INSTALL_DF_UNAME"       ,"Имя пользователя базы данных");
define("_INSTALL_DF_UNAME1"      ,"<i>Имя пользователя (логин) для доступа к базе данных. <br /><br />Для локального сервера (например пакета 'Денвер') как правило <b>root</b></i>");
define("_INSTALL_DF_PASS"        ,"Пароль к базе данных");
define("_INSTALL_DF_PASS1"       ,"<i>Пароль пользователя для доступа к базе данных. <br /><br />Для локального сервера (например пакета 'Денвер') пароль, как правило, не установлен</i>");
define("_INSTALL_DF_DBNAME"      ,"Имя базы данных");
define("_INSTALL_DF_DBNAME1"     ,"<i>Программа установки попробует создать новую базу данных, если база данных с указанным именем не существует</i>");
define("_INSTALL_DF_PREFIX"      ,"Префикс таблиц");
define("_INSTALL_DF_PREFIX1"     ,"<i>Префикс генерируется случайным образом. Можно использовать свой вариант. <br /><br />Данный префикс будет добавлен ко всем создаваемым таблицам, чтобы исключить конфликты с другими таблицами базы данных</i>");
define("_INSTALL_DF_PCONNECT"    ,"Установить постоянное соединение с сервером базы данных");
define("_INSTALL_DF_PCONNECT1"   ,"<i>Укажите 'Нет' если не уверены в результате. <br /><br />При 'постоянном соединении', соединение с сервером базы данных не закрывается по окончании выполнения работы скрипта</i>");
define("_INSTALL_DF_PATH"        ,"Физический путь (Корневая директория)");
define("_INSTALL_DF_PATH1"       ,"<i>Физический (реальный) путь к основной (корневой) директории RUNCMS (<b>без закрывающего слеша</b>). <br /><br />В большинстве случаев редактировать не требуется, так как определяется автоматически. <br /><br />При инсталляции в WINDOWS не забудьте указать имя диска, например <b>c:/моя_папка</b></i>");
define("_INSTALL_DF_URL"         ,"HTTP адрес (URL)");
define("_INSTALL_DF_URL1"        ,"<i>HTTP адрес (URL адрес) корневой директории RUNCMS (<b>без закрывающего слеша</b>). <br /><br />В большинстве случаев редактировать не требуется, так как определяется автоматически. <br /><br />Например <b>http://www.мойсайт.ru</b> или <b>http://www.мойсайт.ru/моя_папка</b></i>");
define("_INSTALL_DF_PLEASE_ENTER","Укажите правильные данные для поля: \"%s\"");
define("_INSTALL_DF_ERRORS"      , "Возникли следующие ошибки:");
define("_INSTALL_DF_BADROOT"     , "Физический путь указан неверно.");
define("_INSTALL_DF_BADDB"       , "Невозможно соединиться или создать базу данных по информации которую Вы указали.");
define("_INSTALL_DF_OK"          , "Все введенные данные прошли проверку, можно продолжить установку.");
define("_INSTALL_LANG"           , "Язык установки.");


// Mainfile setup
define("_INSTALL_MF_FAILOPEN" ,"Нет доступа к mainfile.php. Проверьте распределения прав и попробуйте снова.");
define("_INSTALL_MF_FAILWRITE","Нет доступа к mainfile.php. Свяжитесь с вашим системным администратором для выяснения причин.");
define("_INSTALL_MF_WRITEOK"  ,"Данные конфигурации были успешно записаны в файл <i>mainfile.php</i>");

// Admin Setup
define("_INSTALL_AD_MSG"     , "Создаем учетную запись администратора:");
define("_INSTALL_AD_UNAME"   , "Имя (логин) администратора:");
define("_INSTALL_AD_EMAIL"   , "E-mail администратора:");
define("_INSTALL_AD_PASS"    , "Пароль для авторизации на сайте:");
define("_INSTALL_AD_BADPASS" , "Пароль должен содержать более %s символов");
define("_INSTALL_AD_BADUNAME", "В имени пользователя используйте только цифры и латинские символы без пробелов");
define("_INSTALL_AD_BADEMAIL", "Неправильно задан формат E-mail");

// DB CREATION
define("_INSTALL_DB_DBERROR" , "Создание базы данных не удалось. Неправильные таблицы были удалены.");
define("_INSTALL_DB_TRYAGAIN", "Нажмите <a href='%s'>сюда</a> чтобы пройти процесс установки еще раз.");

// Finish
define("_INSTALL_F_CONGRAT" , "Вы можете перейти на главную страницу Вашего сайта нажав на ссылку указанную ниже"); // Поздравляем! Установка <b>RUNCMS</b> закончена.
define("_INSTALL_F_CHMOD"   , "Проверьте, что права на доступ к файлам выставлены:");
define("_INSTALL_F_CHMODMSG", "Можно попробовать специальный скрипт для распределения прав на доступ к файлам");
define("_INSTALL_F_VISIT"   , "Вы можете перейти на ваш сайт нажав <a href='%s/'><b>здесь</b></a>.");

// Some general stuff
define("_INSTALL_G_TITLE" , "Установка");
define("_INSTALL_U_CHOOSE", "Укажите пакет для апдейта:");
define("_INSTALL_U_NOTE"  , "ЗАМЕЧАНИЕ: старый файл mainfile.php должен быть на месте и содержать правильную информацию");
define("_INSTALL_U_README", "Нажмите <a href='%s' target='_blank'>сюда</a> для того чтобы посмотреть <b>README</b>.");

define("_INSTALL_W"    , "Установка ---->:");

// index.php //
define("_MI_DOCHMOD_TEXT", "Чтобы автоматически настроить права доступа (CHMOD) к файлам и папкам сайта, заполните нижерасположенную форму, указав необходимые данные, для доступа к Вашему FTP-серверу.<br /><br />Скрипт изменит права доступа к файлам и папкам (CHMOD) сайта на нужные значения и сохранит Ваше время:");
define("_MI_DOCHMOD_MANUAL", "Если вы хотите установить права доступа (CHMOD) вручную, используйте FTP-клиент.<br /><br />Ниже Вы увидите список файлов с неправильными значениями CHMOD, и значения CHMOD, которые они должны иметь.<br /><br /> Используя FTP-клиент, установите правильные значения CHMOD<br /><br /> Обновив страницу, Вы увидите, какие файлы Вы пропустили<br /><br />Если все права доступа установлены правильно, Вы увидите ссылку на вновь установленный сайт.");
define("_MI_DOCHMOD_FTPDOMAIN","FTP сервер (например: ftp.yoursite.com)");
define("_MI_DOCHMOD_FTPUSER","Учетная запись:");
define("_MI_DOCHMOD_FTPPASS","Пароль:");
define("_MI_DOCHMOD_FTPPATH","Имя корневой папки, где расположен файл mainfile.php (например: httpdocs/ , domainname/, /,  ...)");
define("_MI_DOCHMOD_BUTTON","Соединиться");
define("_MI_DOCHMOD_BROWSETOMAINFILE","Откройте директорию, в которой расположен файл <b>mainfile.php</b>");
define("_MI_DOCHMOD_HASMAINFILEPHP"," Файл <b>mainfile.php</b> обнаружен, начать установку прав доступа (CHMOD) к файлам и папкам сайта?");
define("_MI_DOCHMOD_ERRORS"," %s  ошибок.");
define("_MI_DOCHMOD_COMPLETE","Список прав доступа к файлам и папкам (CHMOD):");
define("_MI_DOCHMOD_TITLEERROR", "<b>ОШИБКА!</b>");
define("_MI_DOCHMOD_CONNERROR1","Ошибка соединения. Соединиться с FTP-сервером не удалось. Попробуйте снова.");
define("_MI_DOCHMOD_CONNERROR2","Учетная запись");
define("_MI_DOCHMOD_CONNERROR3","НАЗАД");
define("_MI_DOCHMOD_CONNERROR4","FTP ОШИБКА! Файл mainfile.php не найден!.");
define("_MI_DOCHMOD_OKTITLE","<b>Поздравляем! Установка <b>RUNCMS</b> закончена.</b><br />"); // <b>Вот и все!</b>
define("_MI_DOCHMOD_OKDESCRIPTION","НЕ ЗАБУДЬТЕ ДЛЯ БЕЗОПАСНОСТИ ВАШЕГО САЙТА УДАЛИТЬ папку /_install/<br />НЕ ЗАБУДЬТЕ ДЛЯ БЕЗОПАСНОСТИ ВАШЕГО САЙТА установить права доступа <br />к файлу /mainfile.php - только чтение (CHMOD = 444)<br />");
define("_FILEMISSINGUPLOADTHISAGAIN","Файл отсутствует, загрузите его повторно");

?>