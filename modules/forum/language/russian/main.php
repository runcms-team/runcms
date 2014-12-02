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


if(!define('_FULLDATE', " d.m.Y - H:i:s")) define("_FULLDATE"," d.m.Y - H:i:s");


//functions.php
define("_MD_NOPOSTS","Сообщений нет");
define("_MD_SELFORUM","Выбрать форум");
define("_MD_POSTED_BY","Отправил"); // Posted by

//auth.php
define("_MD_BANNED","Вы забанены на этом Форуме. Если у Вас есть вопросы, то свяжитесь с администрацией.");

//index.php
define("_MD_FORUM","Форум");
define("_MD_SUBFORUM", "Под-Форум");
define("_MD_WELCOME","Добро пожаловать на форум сайта %s! ");
define("_MD_TOPICS","Тем");
define("_MD_POSTS","Сообщений");
define("_MD_LASTPOST","Обновление");
define("_MD_MODERATOR","Модераторы");
define("_MD_ADMINISTRATOR","Администраторы");
define("_MD_NEWPOSTS","Есть новые сообщения");
define("_MD_NONEWPOSTS","Нет новых сообщений");
define("_MD_BY","От"); // Posted by
define("_MD_TOSTART","<br />Если при просмотре форума нет сообщений, то стоит попробовать сортировку 'по началу открытия'.<br />Для того чтобы не ждать когда в интересующую вас тему ответят используйте функцию 'уведомление почтой'.");
define("_MD_TOTALTOPICSC","Всего тем: ");
define("_MD_TOTALPOSTSC","Сообщений: ");
define("_MD_TIMENOW","Время сейчас: %s");
define("_MD_LASTVISIT","Ваш последний визит: %s");
define("_MD_ADVSEARCH","Расширенный поиск");
define("_MD_VIEW", "Просмотр:");
define("_MD_SUBFORUMS","Суб-форумы:");
define("_MD_MARK_READ_ALL","отметить все форумы прочитаными");
define("_MD_MSG_MARK_READ_ALL","Все форумы были отмечены как прочитанные.");

//page_header.php
define("_MD_MODERATEDBY","Модераторы");
define("_MD_SEARCH","Поиск");
define("_MD_SEARCHRESULTS","Результаты поиска");
define("_MD_FORUMINDEX","Список форумов");
define("_MD_POSTNEW","Создать новое сообщение");
define("_MD_REGTOPOST","Зарегистрироваться");

//search.php
define("_MD_KEYWORDS","Ключевые слова:");
define("_MD_SEARCHANY","Искать КАЖДОЕ из условий (По умолчанию)");
define("_MD_SEARCHALL","Искать при ВСЕХ условиях");
define("_MD_SEARCHALLFORUMS","Искать во всех Форумах");
define("_MD_FORUMC","Форум:");
define("_MD_AUTHORC","Автор:");
define("_MD_SORTBY","Сортировка:");
define("_MD_DATE","Обновления");
define("_MD_TOPIC","Тема");
define("_MD_USERNAME","Ник");
define("_MD_SEARCHIN","Искать в:");
define("_MD_SUBJECT","Название");
define("_MD_BODY","Самом сообщении");
define("_MD_NOMATCH","Записей, удовлетворяющих запросу не найдено. Расширьте ваш поиск.");
define("_MD_POSTTIME","Время сообщения");

//viewforum.php
define("_MD_REPLIES","Ответы");
define("_MD_POSTER","Автор");
define("_MD_VIEWS","Просмотры");
define("_MD_GOTOPAGE","Перейти к странице");
define("_MD_MORETHAN","Новое сообщение (популярная тема)");
define("_MD_MORETHAN2","Нет новых сообшеий (популярная тема)");
define("_MD_NOTOPICS","В этом форуме нет сообщений. Вы можете создать первое.");
define("_MD_TOPICSTICKY","Пришпиленное администрацией сообщение");
define("_MD_TOPICLOCKED","Данная тема закрыта");
define("_MD_NEXTPAGE","Следующая страница");
define("_MD_PREVPAGE","Предыдущая страница");
define("_MD_SORTEDBY","Отсортировать по");
define("_MD_TOPICTITLE","названию Темы");
define("_MD_NUMBERREPLIES","количеству ответов");
define("_MD_NUMBERVIEWS","количеству просмотров");
define("_MD_TOPICPOSTER","авторам сообщения");
define("_MD_LASTPOSTTIME","по времени обновления");
define("_MD_ASCENDING","возрастание");
define("_MD_DESCENDING","убывание");
define("_MD_FROMLASTDAYS","последним %s дням");
define("_MD_LASTDAY","последнему дню");
define("_MD_THELASTYEAR","последнему году");
define("_MD_BEGINNING","началу открытия");
define("_MD_POST_DENIED","Вам не разрешено оставлять сообщения в этом форуме.");
define("_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST","Прикрепленные к сообщению файлы");
define("_MD_HITS","Просмотров");
define("_MD_FILETYPE","Тип файла");
define("_MD_FILESIZE","Размер файла: <b>%.2f</b> Кб");

define("_MD_CAN_POST", "Вы <b>можете</b> начинать темы.<br />");
define("_MD_CANNOT_POST", "Вы <b>не можете</b> начинать темы.<br />");
define("_MD_CAN_REPLY", "Вы <b>можете</b> отвечать на сообщения.<br />");
define("_MD_CANNOT_REPLY", "Вы <b>не можете</b> отвечать на сообщения.<br />");
define("_MD_CAN_EDIT", "Вы <b>можете</b> редактировать свои сообщения.<br />");
define("_MD_CANNOT_EDIT", "Вы <b>не можете</b> редактировать свои сообщения.<br />");
define("_MD_CAN_DELETE", "Вы <b>можете</b> удалять свои сообщения.<br />");
define("_MD_CANNOT_DELETE", "Вы <b>не можете</b> удалять свои сообщения.<br />");
define("_MD_CAN_ADDPOLL", "Вы <b>можете</b> создавать опросы.<br />");
define("_MD_CANNOT_ADDPOLL", "Вы <b>не можете</b> создавать опросы.<br />");
define("_MD_CAN_VOTE", "Вы <b>можете</b> голосовать.<br />");
define("_MD_CANNOT_VOTE", "Вы <b>не можете</b> голосовать.<br />");
define("_MD_CAN_ATTACH", "Вы <b>можете</b> вкладывать файлы в сообщения.<br />");
define("_MD_CANNOT_ATTACH", "Вы <b>не можете</b> вкладывать файлы в сообщения.<br />");

define("_MD_MSG_MARK_READ_TOPICS","Все темы в этом форуме были помечены как прочитанные.");

//viewtopic.php
define("_MD_AUTHOR","Автор");
define("_MD_LOCKTOPIC","Закрыть эту тему");
define("_MD_UNLOCKTOPIC","Открыть эту тему");
define("_MD_STICKYTOPIC","Пришпилить эту тему");
define("_MD_UNSTICKYTOPIC","Отшпилить эту тему");
define("_MD_MOVETOPIC","Переместить эту тему");
define("_MD_DELETETOPIC","Удалить эту тему");
define("_MD_TOP","Наверх");
define("_MD_PARENT","К началу");
define("_MD_EMAILDEMAND","Ваш запрос был сохранен");
define("_MD_ACTIVEMAIL","Активировать уведомление почтой");
define("_MD_DESACTIVEMAIL","Деактивировать уведомление почтой");
define("_MD_QUICK_REPLY", "Быстрый ответ в эту тему");
define("_MD_PRINT_TOPIC", "Распечатать топик");
define("_MD_PREV_TOPIC", "Предыдущая тема");
define("_MD_NEXT_TOPIC", "Следующая тема");

// print.php
define("_MD_PRINT_TOPIC_LINK", "URL этой темы");

// Edit Poll
define("_MD_BACK_TO_TOPIC","Вернуться в тему");

//forumform.inc
define("_MD_ABOUTPOST","О сообщении");
define("_MD_ANONCANPOST","<b>Анонимные пользователи</b> могут создавать новые сообщения и отвечать в них.");
define("_MD_REGCANPOST","Только <b>Зарегистрированные пользователи</b> могут создавать новые сообщения и отвечать в них.");
define("_MD_MODSCANPOST","Только <b>Модераторы и Администраторы</b> могут создавать новые сообщения и отвечать в них.");
define("_MD_QUOTE","Цитата");
define("_MD_ADDEDITED","Добавить когда редактировали?");
define("_MD_ALLOWED_EXTENSIONS","Допустимые файлы");
define("_MD_POLL","Голосование");
define("_MD_POLLQUESTION","Голосование");
define("_MD_POLLOPTIONS","Пункт");
define("_MD_ADDPOLLOPTION","Добавить");
define("_MD_POLLEXPIRETIME","Заканчивается");
define("_MD_DAYS","дней");

// ERROR messages
define("_MD_ERRORFORUM","ОШИБКА: Не выбран форум!");
define("_MD_ERRORPOST","ОШИБКА: Не выбрано сообщение!");
define("_MD_NORIGHTTOPOST","Вы не имеете права оставлять сообщения в этом форуме.");
define("_MD_NORIGHTTOACCESS","У вас нет прав доступа на этот форум.");
define("_MD_NORIGHTTOATTACH","У вас нет прав прикреплять файлы в этом форуме.");
define("_MD_ERRORTOPIC","ОШИБКА: Не выбрана тема!");
define("_MD_ERRORCONNECT","ОШИБКА: Невозможно соединиться с базой данных форума.");
define("_MD_ERROREXIST","ОШИБКА: Форума, который вы выбрали, не существует. Вернитесь и попытайтесь снова.");
define("_MD_CANTGETFORUM","Невозможно получить данные о форуме.");
define("_MD_FORUMNOEXIST","Ошибка - выбранного вами форума/сообщения не существует. Вернитесь и попытайтесь снова.");
define("_MD_USERNOEXIST","Такого пользователя не существует.  Вернитесь и поищите ещё.");
define("_MD_COULDNOTREMOVE","Ошибка - невозможно удалить сообщения из базы данных!");
define("_MD_COULDNOTREMOVETXT","Ошибка - невозможно удалить текст сообщений!");
define("_MD_ERRORMESSAGE","Ошибка - Пустое сообщение!");
define("_MD_ERROR_UNAPPROVED", "Эта тема закрыта и ждёт подтверждения модератора.");
define("_MD_TOPICNOEXIST","Ошибка - Тема которую вы выбрали не существет.");

//reply.php
define("_MD_ON","в");
define("_MD_USERWROTE","%s пишет:");

//post.php
define("_MD_EDITNOTALLOWED","Вам не разрешено редактировать это сообщение!");
define("_MD_EDITEDBY","Отредактировано");
define("_MD_ANONNOTALLOWED","Анонимные пользователи не могут создавать новые сообщения<br />Зарегистрируйтесь.");
define("_MD_THANKSSUBMIT","Благодарим за ваше сообщение!");
define("_MD_REPLYPOSTED","На ваше сообщение ответили.");
define("_MD_HELLO","Здравствуйте, %s,");
define("_MD_URRECEIVING","Вы получили этот e-mail потому, что на ваше сообщение на форуме %s был получен ответ.");
define("_MD_CLICKBELOW","Щёлкните по указанной ниже ссылке, чтобы просмотреть сообщение:");
define("_MD_MAILTITRETOPIC","Тема раздела - %s");
define("_MD_POSTAUTEUR","Автор ответа - %s");
define("_MD_URRECEIVING2", "Вы получили это сообщение, так как на тему, которую Вы отметили на форуме сайта %s, был получен ответ.");//  %s is your site name

//forumform.inc
define("_MD_YOURNAME","Ваше имя:");
define("_MD_LOGOUT","Выход");
define("_MD_REGISTER","Регистрация");
define("_MD_SUBJECTC","Тема сообщения:");
define("_MD_MESSAGEICON","Картинка к сообщению:");
define("_MD_MESSAGEC","Сообщение:");
define("_MD_CHECKMESSAGE","показать длину сообщения");
define("_MD_ALLOWEDHTML","[ Допустимые HTML теги ]");
define("_MD_OPTIONS","Настройки сообщения:");
define("_MD_POSTANONLY","Послать это сообщение анонимно?");
define("_MD_EMAILNOTIFY","Отправить вам уведомление по почте когда будет получен ответ?");
define("_MD_ATTACHSIG","Добавить свою подпись?");

// forumuserpost.php
define("_MD_JOINEDC","Дата регистрации:");
define("_MD_POSTSC","Сообщений:");
define("_MD_FROMC","Из:");
define("_MD_LOGGED","Войти");
define("_MD_PROFILE","Профайл");
define("_MD_SENDEMAIL","Послать e-mail пользователю %s");
define("_MD_SENDPM","Отправить приватное сообщение к %s");
define("_MD_VISITSITE","Посетить сайт пользователя");
define("_MD_ADDTOLIST","Добавить в список контактов");
define("_MD_EDITTHISPOST","Отредактировать это сообщение");
define("_MD_REPLY","Ответить");
define("_MD_DELETEPOST","Удалить это сообщение");
define("_MD_ATTACHMENT","Добавить файл:");

// topicmanager.php
define("_MD_YANTMOTFTYCPTF","Вы не модератор этого форума, поэтому вы не можете выполнять эти функции.");
define("_MD_TTHBRFTD","Это сообщение было удалено из базы данных.");
define("_MD_RETURNTOTHEFORUM","Вернуться на форум");
define("_MD_RTTFI","Вернуться к списку форумов");
define("_MD_EPGBATA","Ошибка - вернитесь и попытайтесь снова.");
define("_MD_TTHBM","Тема была перемещена.");
define("_MD_VTUT","Просмотреть обновленное сообщение");
define("_MD_TTHBL","Тема закрыта.");
define("_MD_TTHBS","Тема пришпилена.");
define("_MD_TTHBUS","Тема отшпилена.");
define("_MD_VIEWTHETOPIC","Просмотреть сообщение");
define("_MD_TTHBU","Тема открыта.");
define("_MD_ENSUOPITD","Ошибка - в базе данных нет ни одного пользователя и ни одного сообщения.");
define("_MD_UIAAI","IP пользователей и информация о профиле");
define("_MD_USERIP","IP пользователя:");

define("_MD_OYPTDBATBOTFTTY","Для <b>НЕМЕДЛЕННОГО</b> удаления выбраной темы и ВСЕХ ответов на нее нажмите кнопку ниже.");
define("_MD_OYPTMBATBOTFTTY","Для перемещения темы в выбраный Вами форум выфберите раздел форума и нажмите кнопку \"Переместить\".");
define("_MD_OYPTLBATBOTFTTY","Для закрытия темы нажмите кнопку ниже.");
define("_MD_OYPTUBATBOTFTTY","Для открытия выбраной темы нажмите кнопку ниже.");
define("_MD_OYPTSBATBOTFTTY","Для закрепления темы вверху форума нажмите кнопку ниже.");
define("_MD_OYPTTBATBOTFTTY","Для отмены закрепления темы нажмите кнопку ниже.");

define("_MD_VTUIA","Посмотреть IP этого пользователя.");
define("_MD_MOVETOPICTO","Переместить тему в:");
define("_MD_NOFORUMINDB","Форумов нет в БД");
define("_MD_DATABASEERROR","Ошибка базы данных");
define("_MD_DELTOPIC","Удалить тему");
define("_MD_VIEWIP","Посмотреть IP");
define("_MD_TTHBAPPR","Сообщение одобрено.");
define("_MD_TTHBUNAPPR","Сообщение не одобрено.");
define("_MD_AYS_APPROVE","Вы уверены что хотите одобрить это сообщение?");
define("_MD_AYS_UNAPPROVE","Вы уверены что хотите не одобрять это сообщение?");

// delete.php
define("_MD_DELNOTALLOWED","Извините, но у вас нет разрешения удалять это сообщение.");
define("_MD_AREUSUREDEL","Вы действительно хотите удалить это сообщение?");
define("_MD_POSTSDELETED","Выбранное сообщение стерто.");

define("_MD_FORUM_VSTFRM"," Посетить форум");
define("_MD_FORUM_TOP"," %s тем форума");
define("_MD_FORUM_MVIEWED","самых рассматриваемых");
define("_MD_FORUM_MACTIVE","с наибольшей активностью");
define("_MD_FORUM_MRECENT","самых новых");

// dl_attachment.php
define("_MD_NO_SUCH_FILE","Файл не существует");

define("_PL_VOTE", "Голосовать");
define("_PL_RESULTS", "Результаты");
define("_PL_TOTALVOTES", "Всего голосов: %s");
define("_PL_TOTALVOTERS", "Всего проголосовало: %s");
define("_PL_THANKSFORVOTE", "Спасибо за ваш голос!");
define("_PL_ALREADYVOTED", "Вы уже голосовали!");
define("_PL_ENDSAT","Заканчивается %s");
define("_PL_ENDEDAT","Закончилось %s");
define("_PL_POLL","Голосование:");

// class.whosonline.php
define("_MD_USERS_ONLINE", "Пользователи");
define("_MD_REGISTERED_USERS", "Зарегистрированные пользователи");
define("_MD_TOTAL_ONLINE","Всего пользователей: %d");

// User Levels
define("_MD_LEVEL", "Уровень");

// Archive.php
define("_MD_FORUM_ARCHIVE", "Архив форума");
define("_MD_ARCHIVE_POPUP", "[открыть в окне с возможностью для печати]");

// attachmanager.php
define("_MD_ATTACH_MANAGER", "Менеджер прикрепленных файлов");
define("_MD_APPROVE", "Одобрить");
define("_MD_UNAPPROVE", "Не одобрять");
define("_MD_FILE_NAME", "Имя файла");
define("_MD_FILE_SIZEC", "Размер файла");
define("_MD_ISAPPROVED", "Одобрен?");
define("_MD_ACTIONS", "Действия");
define("_MD_ATTACHMENTS","Прикрепленные файлы:");
define("_MD_ADD_ATTACHMENT","Добавить файл:");

//  Tabs / Block Headers
define("_MD_SIMILAR_THREADS","Похожие темы");
define("_MD_TAB_LEGEND","Легенда");
define("_MD_TAB_PERMISSIONS","Права");
define("_MD_TAB_MODLEGEND","Мод. легенда");
define("_MD_TAB_UNAPPR_POSTS","Тема содержит неутвержденные сообщения.");
define("_MD_TAB_UNAPPR_ATTACH","Тема содержит неутвержденные файлы.");
define("_MD_TAB_UNAPPR_BOTH","Тема содержит неутвержденные сообщения и файлы.");

// Toolbar
define("_MD_FORUM_TOOLS","Инструменты");
define("_MD_NEW_TOPIC","Новая тема");
define("_MD_MARK_READ","Отм. прочитанными");
define("_MD_SUBSCRIBE","Подписаться");
define("_MD_UNSUBSCRIBE","Отписка");

define("_MD_TOPIC_TOOLS","Инструменты");
define("_MD_EMAIL_TOPIC","Письмо другу");
define("_MD_DISPLAY_MODES","Форма показа");
define("_MD_FLAT","Список");
define("_MD_FLAT_NEWFIRST","Новые первыми");
define("_MD_FLAT_OLDFIRST","Старые первыми");
define("_MD_THREADED","Дерево");

define("_MD_MAIL_TOPIC_SUBJECT","Интересное сообщение на форуме сайта %s"); // %s is your site name
define("_MD_MAIL_TOPIC_BODY","Привет! Ниже расположена ссылка на интересное сообщение с форума сайта %s"); // %s is your site name

define("_MD_REPLYPOSTED2", "Ответ в форуме, %s");

define("_MD_ERROROCCURED","Произошла ошибка");
define("_MD_COULDNOTQUERY","Не удалось выполнить запрос к базе данных");
define("_MD_UOUTPFTIAPC","Логины пользователей, создавшие сообщения с этого IP + количество сообщений");
define("_MD_ANONYMOUS_USERS", "Анонимные пользователи");
define("_MD_BROWSING_FORUM",", на этом форуме:");
define("_MD_BROWSING_ALL",", подробнее:");
define("_MD_PAGEOF","из ");
define("_MD_PAGE","страница ");

// ADDED 
define("_MD_DONT_FORGET","Не забывайте отмечать темы как прочитанные");
define("_MD_FORUM_LAST","20 последних сообщений");



?>