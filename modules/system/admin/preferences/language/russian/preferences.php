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

//%%%%%%  Admin Module Name  AdminGroup   %%%%%
define("_MD_AM_SITEPREF","Основные настройки сайта");
define("_MD_AM_SITENAME","Имя сайта");
define("_MD_AM_ADMINML","E-Mail администратора");
define("_MD_AM_MAILFUNC","Почтовая функция");
define("_MD_AM_LANGUAGE","Язык по умолчанию");
define("_MD_AM_STARTPAGE","Модуль стартовой страницы");
define("_MD_AM_SERVERTZ","Часовой пояс сервера");
define("_MD_AM_DEFAULTTZ","Часовой пояс по умолчанию");
define("_MD_AM_DTHEME","Скин по умолчанию");
define("_MD_AM_ANONNAME","Ник для анонимных гостей");
define("_MD_AM_ANONPOST","Позволить анонимам оставлять комментарии?");
define("_MD_AM_MAXPMS","Максимум входящих сообщений для пользователя. 0=неограниченно");
define("_MD_AM_MINPASS","Минимальная длина пароля");
define("_MD_AM_NEWUNOTIFY","Уведомлять о новой регистрации?");
define("_MD_AM_SELFDELETE","Позволить пользователям удалять аккаунт?");
define("_MD_AM_LOADINGIMG","Показывать картинку загрузки?");
define("_MD_AM_USEGZIP","Использовать gzip-сжатие? Для PHP версии 4.0.5 или выше. У Вас установлена версия %s");

define("_MD_AM_UNAMELVL","Как строго отслеживать разрешенные символы в никах?");
define("_MD_AM_STRICT","Строго (только буквы и цифры)");
define("_MD_AM_MEDIUM","Средне");
define("_MD_AM_LIGHT","Легко (рекомендуется для многобайтных символов)");
define("_MD_AM_USERCOOKIE","Имя для cookies, в котором будет сохраняется ник пользователя в течение года. Если cookie есть, ник будет автоматически подставлен в поле логина.");
define("_MD_AM_SESSCOOKIE","Имя сессии/cookies. Дает пользователю возможность остаться в системе, пока время сессии/cookies не истекло.");
define("_MD_AM_SESSEXPIRE","Время нахождения на сайте (в секундах) перед автоматическим исключением пользователя из системы.");
define("_MD_AM_SESSUSE","Использовать для авторизации сессии вместо cookies?");
define("_MD_AM_BANNERS","Активировать баннерную систему на сайте?");

define("_MD_AM_DEFHTML","HTML-теги, которые администраторы и пользователи могут использовать на сайте: (где разрешено)");
define("_MD_AM_ADMHTML","HTML-теги, которые админы могут использовать в сообщениях (где разрешено)");
define("_MD_AM_ADMTAGS","Администраторы:");
define("_MD_AM_USRHTML","HTML-теги, которые пользователи могут использовать в сообщениях (где разрешено)");
define("_MD_AM_USRTAGS","Пользователи:");

define("_MD_AM_INVLDMINPASS","Неверное значение минимальной длины пароля.");
define("_MD_AM_INVLDUCOOK","Неверное значение для cookie_name.");
define("_MD_AM_INVLDSCOOK","Неверное значение для session_name.");
define("_MD_AM_INVLDSEXP","Неверное значение для времени истечения сессии.");
define("_MD_AM_ADMNOTSET","Почта не установлена.");
define("_MD_AM_DONTCHNG","Не изменять!");
define("_MD_AM_REMEMBER","Запомните chmod 666 этого файла для разрешения записи.");
define("_MD_AM_IFUCANT","Если не можете изменить права доступа, отредактируйте файл вручную.");


define("_MD_AM_COMMODE","Способ отображения комментариев по умолчанию");
define("_MD_AM_COMORDER","Порядок отображения комментариев по умолчанию");
define("_MD_AM_ALLOWHTML","Разрешить HTML-теги в комментариях?");

define("_MD_AM_ALLOW_REGISTER","Разрешить регистрацию на сайте?");
define("_MD_AM_VERIFY_IMG","Включить защиту от спама? Нужно будет вводить дополнительный графический код. Требуется GD!");
define("_MD_AM_AUTOREGISTER","Автоматически активировать новых пользователей при регистрации?");

define("_MD_AM_DEBUGMODE","Уровень отладки: многоуровневый режим.");
define("_MD_AM_DBGERR","Ошибки");
define("_MD_AM_DBGTIME","Время");
define("_MD_AM_DBGINFO","Инфо");
define("_MD_AM_DBGLOG","Инфо & Лог");
define("_MD_AM_DBGVIS","Визуальные данные");

define("_MD_AM_CACHETIME","Время кеширования страниц, мин.");
define("_MD_AM_INVLDMAILFUNC","Внимание, %s() не существует!");
define("_MD_AM_AVATARALLOW","Разрешить загрузку своих аватаров?");
define("_MD_AM_AVATARW","Ширина аватара");
define("_MD_AM_AVATARH","Высота аватара");
define("_MD_AM_AVATARMAX","Размер аватара (байт)");
define("_MD_AM_AVATARCONF","Настройки аватара");
define("_MD_AM_CHNGUTHEME","Изменить для всех участников");
define("_MD_AM_NOTIFYTO","Уведомить группу:");
define("_MD_AM_ALLOWTHEME","Позволить пользователям менять скины?");
define("_MD_AM_ALLOWIMAGE","Показывать внешние картинки в сообщениях, комментариях и подписях?");

define("_MD_AM_LIBCONF","Опции библиотеки изображений:");
define("_MD_AM_LIBUSE","Разрешить использование библиотеки изображений?");
define("_MD_AM_LIBUPLOAD","Разрешить участникам закачивать изображения в библиотеку?");
define("_MD_AM_LIBW","Ширина закачиваемой картинки");
define("_MD_AM_LIBH","Высота закачиваемой картинки");
define("_MD_AM_LIBMAX","Размер элемента библиотеки (байт)");
define("_MD_AM_MAINTENANCE","Закрыть/Открыть сайт");
// SMTP addon by SVL
define("_MD_AM_PMATONCE","Количество приватных сообщений посылаемых в одном пакете (до паузы):");
define("_MD_AM_MLATONCE","Количество E-mail сообщений посылаемых в одном пакете (до паузы):");
define("_MD_AM_SLEEP","Пауза (в сек.) между пакетами сообщений (приватных или E-mail):");
define("_MD_AM_SMTPH","SMTP Хост:");
define("_MD_AM_SMTPU","SMTP Логин:");
define("_MD_AM_SMTPP","SMTP Пароль:");

?>
