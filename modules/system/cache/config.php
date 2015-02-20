<?php
/*********************************************************************
Запомните chmod 666 этого файла для разрешения записи.
Если не можете изменить права доступа, отредактируйте файл вручную.
*********************************************************************/

// Защита от кликджекинга - запретить загрузку страниц вашего сайта во фрейм (HTML-элемент FRAME или IFRAME) на другом сайте.<br /><br /><span style='font-size:x-small;font-weight:normal;'>Загрузка страницы во фрейм разрешена только в том случае, если фрейм расположен на странице того же сайта, что и загружаемая в него страница.<br /><br /><u>ВНИМАНИЕ! При включении этой опции могут перестать работать некоторые счетчики и рекламные скрипты подгружающие контент через фреймы.</u></span> (1=Да 0=Нет)
$rcxConfig['x_frame_options'] = 0;
    
// Включить встроенную в браузер защиту от XSS-атак (только для Internet Explorer 8 и выше). (1=Да 0=Нет)
$rcxConfig['x_xss_protection'] = 0;
    
// Отключить MIME сниффинг в браузере (только для Internet Explorer 8 и выше). (1=Да 0=Нет)
$rcxConfig['x_content_typ_options_nosniff'] = 0;

// E-Mail администратора
$rcxConfig['adminmail'] = "admin@mysite.com";

// Почтовая функция
$rcxConfig['mail_function'] = "mail";

// Количество приватных сообщений посылаемых в одном пакете (до паузы):
$rcxConfig['pm_atonce'] = "300";

// Количество E-mail сообщений посылаемых в одном пакете (до паузы):
$rcxConfig['ml_atonce'] = "20";

// Пауза (в сек.) между пакетами сообщений (приватных или E-mail):
$rcxConfig['send_pause'] = "1";

// SMTP Хост:
$rcxConfig['smtp_host'] = "localhost";

// SMTP Логин:
$rcxConfig['smtp_uname'] = "";

// SMTP Пароль:
$rcxConfig['smtp_pass'] = "";
    
// SMTP Порт:
$rcxConfig['smtp_port'] = "25";

// Язык по умолчанию
$rcxConfig['language'] = "russian";

// Модуль стартовой страницы
$rcxConfig['startpage'] = "news";

// Скин по умолчанию
$rcxConfig['default_theme'] = "runcms2";

// Позволить пользователям менять скины? (1=Да 0=Нет)
$rcxConfig['allow_theme'] = 0;

// Ник для анонимных гостей
$rcxConfig['anonymous'] = "Anonyme";

// Минимальная длина пароля
$rcxConfig['minpass'] = 5;

// Позволить анонимам оставлять комментарии? (1=Да 0=Нет)
$rcxConfig['anonpost'] = 0;

// Максимум входящих сообщений для пользователя. 0=неограниченно
$rcxConfig['max_pms'] = 100;

// Включить автоматическое преобразование URL в HTML ссылку: <br /><br /><span style='font-size:x-small;font-weight:normal;'><i>Только для текста где разрешен HTML (в текстах с запрещенным HTML преобразование не делается по умолчанию)</i><br /><br />Текст вида <br /><br />http://ссылка.ru <br /><br />будет преобразован в HTML код <br /><br />&lt;a href="http://ссылка.ru" target="_blank"&gt;</span> (1=Да 0=Нет)
$rcxConfig['clickable'] = 0;

// Разрешить HTML-теги в комментариях? (1=Да 0=Нет)
$rcxConfig['allow_html'] = 0;

// Разрешить использование библиотеки изображений? (1=Да 0=Нет)
$rcxConfig['allow_library'] = 0;

// Разрешить участникам закачивать изображения в библиотеку? (1=Да 0=Нет)
$rcxConfig['lib_allow_upload'] = 0;

// Ширина закачиваемой картинки
$rcxConfig['lib_width'] = 140;

// Высота закачиваемой картинки
$rcxConfig['lib_height'] = 140;

// Размер элемента библиотеки (байт)
$rcxConfig['lib_maxsize'] = 3072;

// Показывать внешние картинки в сообщениях, комментариях и подписях? (1=Да 0=Нет)
$rcxConfig['allow_image'] = 0;

// Разрешить регистрацию на сайте? (1=Да 0=Нет)
$rcxConfig['allow_register'] = 1;

// Включить защиту от спама? Нужно будет вводить дополнительный графический код. Требуется GD! (1=Да 0=Нет)
$rcxConfig['img_verify'] = 1;

// Автоматически активировать новых пользователей при регистрации? (1=Да 0=Нет)
$rcxConfig['auto_register'] = 0;

// Уведомлять о новой регистрации? (1=Да 0=Нет)
$rcxConfig['new_user_notify'] = 1;

// Уведомить группу:
$rcxConfig['new_user_notify_group'] = 1;

// Позволить пользователям удалять аккаунт? (1=Да 0=Нет)
$rcxConfig['self_delete'] = 0;

// Показывать картинку загрузки? (1=Да 0=Нет)
$rcxConfig['display_loading_img'] = 0;

// Использовать gzip-сжатие? Для PHP версии 4.0.5 или выше. У Вас установлена версия 5.4.29 (1=Да 0=Нет)
$rcxConfig['gzip_compression'] = 1;

// Как строго отслеживать разрешенные символы в никах?  (Строго (только буквы и цифры)=0 Средне=1 Легко (рекомендуется для многобайтных символов)=2)
$rcxConfig['uname_test_level'] = 0;

// Имя для cookies, в котором будет сохраняется ник пользователя в течение года. Если cookie есть, ник будет автоматически подставлен в поле логина.
$rcxConfig['cookie_name'] = "rc2_user";

// Имя сессии/cookies. Дает пользователю возможность остаться в системе, пока время сессии/cookies не истекло.
$rcxConfig['session_name'] = "rc2_sess";

// Время нахождения на сайте (в секундах) перед автоматическим исключением пользователя из системы.
$rcxConfig['session_expire'] = 2678400;

// Использовать для авторизации сессии вместо cookies?
$rcxConfig['use_sessions'] = 0;

// Часовой пояс сервера
$rcxConfig['server_TZ'] = "4";

// Часовой пояс по умолчанию
$rcxConfig['default_TZ'] = "1";

// Активировать баннерную систему на сайте? (1=Да 0=Нет)
$rcxConfig['banners'] = 1;

// Уровень отладки: многоуровневый режим.
$rcxConfig['debug_mode'] = 1;

// Время HTML кэширования страниц, мин.
$rcxConfig['cache_time'] = 0;

// Способ отображения комментариев по умолчанию (0=Нет комментариев flat=В виде ленты thread=В виде дерева)
$rcxConfig['com_mode'] = "flat";

// Порядок отображения комментариев по умолчанию (0=Старые первыми 1=Новые первыми)
$rcxConfig['com_order'] = 0;

// Разрешить загрузку своих аватаров? (1=Да 0=Нет)
$rcxConfig['avatar_allow_upload'] = 0;

// Ширина аватара
$rcxConfig['avatar_width'] = 75;

// Высота аватара
$rcxConfig['avatar_height'] = 100;

// Размер аватара (байт)
$rcxConfig['avatar_maxsize'] = 4000;

// HTML-теги, которые админы могут использовать в сообщениях (где разрешено)
$rcxConfig['admin_html'] = "a|abbr|acronym|address|applet|area|b|bdo|big|blockquote|br|button|caption|center|cite|code|col|colgroup|dd|del|dfn|dir|div|dl|dt|em|embed|fieldset|font|form|frameset|h1|h2|h3|h4|h5|h6|hr|i|iframe|img|input|ins|kbd|label|legend|li|map|menu|noscript|object|ol|optgroup|option|p|param|pre|q|s|samp|script|select|small|span|strike|strong|sub|sup|table|tbody|td|textarea|tfoot|th|thead|tr|tt|u|ul|var";

// HTML-теги, которые пользователи могут использовать в сообщениях (где разрешено)
$rcxConfig['user_html'] = "br";

// Закрыть/Открыть сайт
$rcxConfig['maintenance'] = 0;

// Включить отдельную авторизацию для администратора (1=Да 0=Нет)
$rcxConfig['use_auth_admin'] = 0;

// Включить смену идентификатора сессии.<br /><br /><span style='font-size:x-small;font-weight:normal;'>Идентификатор сесии меняется через указанный ниже интервал времени. Усложняет и делает малоэффективным его перехват.</span> (1=Да 0=Нет)
$rcxConfig['use_session_regenerate_id'] = 0;

// Время жизни идентификатора сесии (в секундах)<br /><br /><span style='font-size:x-small;font-weight:normal;'>Промежуток времени, через который идентификатор сессии будет обновлен.<br /><br /><u>Должна быть включена смена идентификатора сессии.</u></span> (1=Да 0=Нет)
$rcxConfig['session_regenerate_id_lifetime'] = 60;

// Включить капчу при входе в панель администрирования<br /><br /><span style='font-size:x-small;font-weight:normal;'>Только если включена <u>отдельная авторизация для администратора</u></span> (1=Да 0=Нет)
$rcxConfig['use_captcha_for_admin'] = 0;

// Отсылать на e-mail администратора оповещения о входах в панель администрирования<br /><br /><span style='font-size:x-small;font-weight:normal;'>Только если включена <u>отдельная авторизация для администратора</u></span> (1=Да 0=Нет)
$rcxConfig['admin_login_notify'] = 0;

// Включить защиту от подбора пароля при авторизации<br /><br /><span style='font-size:x-small;font-weight:normal;'>После N (устанавливается ниже) неудачных попыток ввода пароля, IP посетителя блокируется на X (устанавливается ниже) минут.</span> (1=Да 0=Нет)
$rcxConfig['check_bruteforce_login'] = 1;

// Количество неудачных попыток входа.<br /><br /><span style='font-size:x-small;font-weight:normal;'>После превышения этого числа, IP посетителя будет заблокирован на установленное время.<br /><br /><u>Должна быть включена защита от подбора пароля.</u></span>
$rcxConfig['count_failed_auth'] = "5";

// Время (в мин.), на которое, будет заблокирован IP посетителя.<br /><br /><span style='font-size:x-small;font-weight:normal;'>После превышения установленного количества неудачных попыток входа.<br /><br /><u>Должна быть включена защита от подбора пароля.</u></span>
$rcxConfig['failed_lock_time'] = "15";

// Отсылать на e-mail администратора оповещения о попытке подбора пароля.<br /><br /><span style='font-size:x-small;font-weight:normal;'>При достижении установленного количества неудачных попыток входа.<br /><br /><u>Должна быть включена защита от подбора пароля.</u></span> (1=Да 0=Нет)
$rcxConfig['admin_bruteforce_notify'] = 0;

// Скрывать внешние ссылки (через редирект)<br /><br /><span style='font-size:x-small;font-weight:normal;'><i>Ссылки размещенные посредством BB-кода</i><br /><br />В комментариях, в профиле пользователя, ссылки на сайт пользователя и т.д.</span> (1=Да 0=Нет)
$rcxConfig['hide_external_links'] = 0;

// Установить доступ к cookies <u>аутентификации</u> только через HTTP протокол (на другие cookies это не будет действовать)<br /><br /><span style='font-size:x-small;font-weight:normal;'>Это означает, что cookies не будет доступна через скриптовые языки, такие как JavaScript. Данная настройка позволяет эффективно защитить от XSS атак (эта функция поддерживается не всеми старыми версиями браузеров)</span> (1=Да 0=Нет)
$rcxConfig['cookie_httponly'] = 0;

// Запретить использовать идентификатор сессии в URL<br /><br /><span style='font-size:x-small;font-weight:normal;'>Определяет, будет ли PHP использовать только cookies для хранения идентификатора сессии на стороне клиента. Включение этого параметра предотвращает атаки с использованием идентификатора сессии, размещенного в URL.</span> (1=Да 0=Нет)
$rcxConfig['use_only_cookies'] = 0;

// Запретить доступ незарегистрированным посетителям к профилям пользователей (1=Да 0=Нет)
$rcxConfig['ban_profile_viewer'] = 0;

// Отключить смайлики<br /><br /><span style='font-size:x-small;font-weight:normal;'>Коды смайликов не будут преобразовываться в соответсвующие иконки и будут отключены в DHTML редакторе. Глобальная опция, для всего сайта. </span> (1=Да 0=Нет)
$rcxConfig['no_smile'] = 0;

// Отключить BB-код в подписи пользователя (1=Да 0=Нет)
$rcxConfig['no_bbcode_user_sig'] = 0;
    
// Установить свою кодировку соединения с сервером базы данных<br /><br /><span style='font-size:x-small;font-weight:normal;'>Например, если страницы сайта некорректно отображаются ("крякозябры", знаки вопроса вместо символов и т.д.).</span> (1=Да 0=Нет)
$rcxConfig['bd_set_names'] = 0;
    
// Кодировка для соединения с сервером базы данных
$rcxConfig['bd_charset_name'] = "cp1251";
    
// Включить HTTP кэширование<br /><br /><span style='font-size:x-small;font-weight:normal;'>Использование HTTP заголовка If-Modified-Since</span> (1=Да 0=Нет)
$rcxConfig['use_http_caching'] = 0;
    
// Время HTTP кеширования страниц, мин.
$rcxConfig['http_cache_time'] = "10080";
    
// USER AGENT для которых включено HTTP кэширование<br /><br /><span style='font-size:x-small;font-weight:normal;'>Используйте регулярные выражения и не забывайте экранировать служебные символы, иначе это может привести к ошибке<br /><br />В частности не забывайте экренировать точку, должно быть: <b>\.</b></span>
$rcxConfig['http_caching_user_agent'] = "Yandex|Googlebot|Yahoo|msnbot|StackRambler|WebAlta Crawler|aport|Mail\.Ru";
    
// Отключить редирект с главной страницы (1=Да 0=Нет)
$rcxConfig['no_redirect'] = 0;

?>