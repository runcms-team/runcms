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

define("_MD_AM_CACHETIME","Время HTML кэширования страниц, мин.");
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

define("_MD_AM_CLICKABLE","Включить автоматическое преобразование URL в HTML ссылку: <br /><br /><span style='font-size:x-small;font-weight:normal;'><i>Только для текста где разрешен HTML (в текстах с запрещенным HTML преобразование не делается по умолчанию)</i><br /><br />Текст вида <br /><br />http://ссылка.ru <br /><br />будет преобразован в HTML код <br /><br />&lt;a href=\"http://ссылка.ru\" target=\"_blank\"&gt;</span>");

define("_MD_AM_SITE_SETTINGS","Настройки сайта");
define("_MD_AM_MAIL_SETTINGS","Настройки почты");
define("_MD_AM_USER_SETTINGS","Настройки пользователей");
define("_MD_AM_REGISTER_SETTING","Настройки регистрации");
define("_MD_AM_AUTH_SETTINGS","Настройки аутентификации");
define("_MD_AM_COMMENT_SETTINGS","Настройки комметариев");
define("_MD_AM_LIB_SETTINGS","Настройки библиотеки изображений");

define("_MD_AM_TEXT_PROCESSING","Обработка текста");

define("_MD_AM_USE_AUTH_ADMIN","Включить отдельную авторизацию для администратора");
define("_MD_AM_HIDE_EXTERNAL_LINKS","Скрывать внешние ссылки (через редирект)<br /><br /><span style='font-size:x-small;font-weight:normal;'><i>Ссылки размещенные посредством BB-кода</i><br /><br />В комментариях, в профиле пользователя, ссылки на сайт пользователя и т.д.</span>");

define("_MD_AM_COOKIE_HTTPONLY","Установить доступ к cookies <u>аутентификации</u> только через HTTP протокол (на другие cookies это не будет действовать)<br /><br /><span style='font-size:x-small;font-weight:normal;'>Это означает, что cookies не будет доступна через скриптовые языки, такие как JavaScript. Данная настройка позволяет эффективно защитить от XSS атак (эта функция поддерживается не всеми старыми версиями браузеров)</span>");
define("_MD_AM_USE_ONLY_COOKIES","Запретить использовать идентификатор сессии в URL<br /><br /><span style='font-size:x-small;font-weight:normal;'>Определяет, будет ли PHP использовать только cookies для хранения идентификатора сессии на стороне клиента. Включение этого параметра предотвращает атаки с использованием идентификатора сессии, размещенного в URL.</span>");

define("_MD_AM_BAN_PROFILE_VIEWER","Запретить доступ незарегистрированным посетителям к профилям пользователей");

define("_MD_AM_NO_SMILE","Отключить смайлики<br /><br /><span style='font-size:x-small;font-weight:normal;'>Коды смайликов не будут преобразовываться в соответсвующие иконки и будут отключены в DHTML редакторе. Глобальная опция, для всего сайта. </span>");

define("_MD_AM_NOBBCODE_USERSIG","Отключить BB-код в подписи пользователя");


define("_MD_USE_CAPTCHA_FOR_ADMIN","Включить капчу при входе в панель администрирования<br /><br /><span style='font-size:x-small;font-weight:normal;'>Только если включена <u>отдельная авторизация для администратора</u></span>");
define("_MD_ADMIN_LOGIN_NOTIFY","Отсылать на e-mail администратора оповещения о входах в панель администрирования<br /><br /><span style='font-size:x-small;font-weight:normal;'>Только если включена <u>отдельная авторизация для администратора</u></span>");

define("_MD_CHECK_BRUTEFORCE_LOGIN","Включить защиту от подбора пароля при авторизации<br /><br /><span style='font-size:x-small;font-weight:normal;'>После N (устанавливается ниже) неудачных попыток ввода пароля, IP посетителя блокируется на X (устанавливается ниже) минут.</span>");
define("_MD_COUNT_FAILED_AUTH", "Количество неудачных попыток входа.<br /><br /><span style='font-size:x-small;font-weight:normal;'>После превышения этого числа, IP посетителя будет заблокирован на установленное время.<br /><br /><u>Должна быть включена защита от подбора пароля.</u></span>");
define("_MD_FAILED_LOCK_TIME", "Время (в мин.), на которое, будет заблокирован IP посетителя.<br /><br /><span style='font-size:x-small;font-weight:normal;'>После превышения установленного количества неудачных попыток входа.<br /><br /><u>Должна быть включена защита от подбора пароля.</u></span>");
define("_MD_ADMIN_BRUTEFORCE_NOTIFY", "Отсылать на e-mail администратора оповещения о попытке подбора пароля.<br /><br /><span style='font-size:x-small;font-weight:normal;'>При достижении установленного количества неудачных попыток входа.<br /><br /><u>Должна быть включена защита от подбора пароля.</u></span>");

define("_MD_AM_USE_SESSION_REGENERATE_ID", "Включить смену идентификатора сессии.<br /><br /><span style='font-size:x-small;font-weight:normal;'>Идентификатор сесии меняется через указанный ниже интервал времени. Усложняет и делает малоэффективным его перехват.</span>");
define("_MD_AM_SESSION_REGENERATE_ID_LIFETIME", "Время жизни идентификатора сесии (в секундах)<br /><br /><span style='font-size:x-small;font-weight:normal;'>Промежуток времени, через который идентификатор сессии будет обновлен.<br /><br /><u>Должна быть включена смена идентификатора сессии.</u></span>");

define("_MD_AM_SECURITY_SETTINGS","Настройки безопасности");

define("_MD_AM_X_FRAME_OPTIONS", "Защита от кликджекинга - запретить загрузку страниц вашего сайта во фрейм (HTML-элемент FRAME или IFRAME) на другом сайте.<br /><br /><span style='font-size:x-small;font-weight:normal;'>Загрузка страницы во фрейм разрешена только в том случае, если фрейм расположен на странице того же сайта, что и загружаемая в него страница.<br /><br /><u>ВНИМАНИЕ! При включении этой опции могут перестать работать некоторые счетчики и рекламные скрипты подгружающие контент через фреймы.</u></span>");

define("_MD_AM_X_XSS_PROTECTION", "Включить встроенную в браузер защиту от XSS-атак (только для Internet Explorer 8 и выше).");

define("_MD_AM_X_CONTENT_TYP_OPTIONS_NOSNIFF", "Отключить MIME сниффинг в браузере (только для Internet Explorer 8 и выше).");


define("_MD_AM_BD_SET_NAMES", "Установить свою кодировку соединения с сервером базы данных<br /><br /><span style='font-size:x-small;font-weight:normal;'>Например, если страницы сайта некорректно отображаются (\"крякозябры\", знаки вопроса вместо символов и т.д.).</span>");
define("_MD_AM_BD_CHARSET_NAME", "Кодировка для соединения с сервером базы данных");


define("_MD_AM_CACHE_SETTINGS", "Настройки кэширования");
define("_MD_AM_USE_HTTP_CACHING", "Включить HTTP кэширование<br /><br /><span style='font-size:x-small;font-weight:normal;'>Использование HTTP заголовка If-Modified-Since</span>");
define("_MD_AM_HTTP_CACHING_USER_AGENT", "USER AGENT для которых включено HTTP кэширование<br /><br /><span style='font-size:x-small;font-weight:normal;'>Используйте регулярные выражения и не забывайте экранировать служебные символы, иначе это может привести к ошибке<br /><br />В частности не забывайте экренировать точку, должно быть: <b>\.</b></span>");
define("_MD_AM_HTTP_CACHE_TIME", "Время HTTP кеширования страниц, мин.");

define("_MD_AM_NO_REDIRECT", "Отключить редирект с главной страницы");

?>
