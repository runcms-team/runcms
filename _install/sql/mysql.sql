CREATE TABLE cpsession (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uname` varchar(30) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `mid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`time`),
  KEY `idx` (`uid`,`hash`)
) ENGINE=MyISAM;

CREATE TABLE login_log (
  `id` mediumint(8) unsigned NOT NULL,
  `uname` varchar(30) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL,
  `status` enum('success','fail') NOT NULL DEFAULT 'fail',
  `type` enum('admin','user') NOT NULL DEFAULT 'admin',
  `reason` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE comments (
  comment_id mediumint(8) unsigned NOT NULL auto_increment,
  pid mediumint(8) unsigned NOT NULL default '0',
  item_id mediumint(8) unsigned NOT NULL default '0',
  `date` int(10) unsigned NOT NULL default '0',
  user_id mediumint(8) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  `subject` varchar(60) NOT NULL default '',
  `comment` text NOT NULL,
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_smileys tinyint(1) unsigned NOT NULL default '0',
  allow_bbcode tinyint(1) unsigned NOT NULL default '0',
  `type` enum('admin','user') NOT NULL default 'user',
  icon varchar(255) NOT NULL default '',
  attachsig tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (comment_id),
  KEY idx (item_id)
) ENGINE=MyISAM;


CREATE TABLE contact (
  contact_text text,
  contact_options varchar(5) NOT NULL default '1|1|1',
  contact_reasons varchar(255) NOT NULL default '',
  about_text text,
  about_options varchar(5) NOT NULL default '1|1|1',
  policy_text text,
  policy_options varchar(5) NOT NULL default '1|1|1',
  intro_text text NOT NULL,
  intro_options varchar(5) NOT NULL default '1|1|1',
  text_alt varchar(255) NOT NULL default '',
  text_caption varchar(255) NOT NULL default '',
  text_custom text,
  button_alt varchar(255) NOT NULL default '',
  button_img varchar(255) NOT NULL default '',
  button_custom text,
  logo_alt varchar(255) NOT NULL default '',
  logo_img varchar(255) NOT NULL default '',
  logo_custom text,
  banner_alt varchar(255) NOT NULL default '',
  banner_img varchar(255) NOT NULL default '',
  banner_custom text
) ENGINE=MyISAM;

INSERT INTO contact (contact_text, contact_options, contact_reasons, about_text, about_options, policy_text, policy_options, intro_text, intro_options, text_alt, text_caption, text_custom, button_alt, button_img, button_custom, logo_alt, logo_img, logo_custom, banner_alt, banner_img, banner_custom) VALUES ('', '1|1|1', 'Другое|Поддержка|Предложения', '', '1|1|1', '', '1|1|1', '', '1|1|1', '', '', '', '', '', '', '', '', '', '', '', '');

CREATE TABLE groups (
  groupid mediumint(8) unsigned NOT NULL auto_increment,
  name varchar(30) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  `type` enum('Admin','User','Anonymous','Custom') NOT NULL default 'Custom',
  PRIMARY KEY  (groupid),
  KEY idx (`type`)
) ENGINE=MyISAM;

INSERT INTO groups (groupid, name, description, type) VALUES (1, 'Администрация', 'Администрация сайта', 'Admin');
INSERT INTO groups (groupid, name, description, type) VALUES (2, 'Пользователи', 'Пользователи, прошедшие регистрацию на сайте', 'User');
INSERT INTO groups (groupid, name, description, type) VALUES (3, 'Анонимные пользователи', 'Анонимные пользователи, не прошедшие регистрацию', 'Anonymous');

CREATE TABLE groups_blocks_link (
  groupid mediumint(8) unsigned NOT NULL default '0',
  block_id mediumint(8) unsigned NOT NULL default '0',
  `type` char(1) NOT NULL default ''
) ENGINE=MyISAM;

INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 8, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 7, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 10, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 10, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 4, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 3, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 2, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 9, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 6, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 5, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 2, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 9, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 6, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 5, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 2, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 10, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (3, 1, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 1, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 9, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 17, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 6, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 5, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 1, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (2, 8, 'R');
INSERT INTO groups_blocks_link (groupid, block_id, type) VALUES (1, 8, 'R');

CREATE TABLE groups_modules_link (
  groupid mediumint(8) unsigned NOT NULL default '0',
  mid mediumint(8) unsigned NOT NULL default '0',
  `type` char(1) NOT NULL default ''
) ENGINE=MyISAM;

INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 2, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 2, 'A');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 1, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 1, 'A');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (2, 2, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (2, 1, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (3, 2, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (3, 1, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 3, 'A');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 3, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 7, 'A');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (1, 7, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (2, 3, 'R');
INSERT INTO groups_modules_link (groupid, mid, type) VALUES (3, 3, 'R');

CREATE TABLE groups_users_link (
  groupid mediumint(8) unsigned NOT NULL default '0',
  uid mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM;

INSERT INTO groups_users_link (groupid, uid) VALUES (1, 1);
INSERT INTO groups_users_link (groupid, uid) VALUES (2, 1);

CREATE TABLE lastseen (
  uid mediumint(8) unsigned NOT NULL default '0',
  username varchar(30) NOT NULL default '',
  `time` int(10) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  online tinyint(1) unsigned NOT NULL default '0',
  KEY idx (uid,online)
) ENGINE=MyISAM;

INSERT INTO lastseen (uid, username, time, ip, online) VALUES (1, 'admin', 1173135717, '127.0.0.1', 1);

CREATE TABLE modules (
  mid mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  version float(3,2) unsigned NOT NULL default '1.00',
  last_update int(10) unsigned NOT NULL default '0',
  weight smallint(3) NOT NULL default '0',
  isactive tinyint(1) unsigned NOT NULL default '0',
  dirname varchar(30) NOT NULL default '',
  config text,
  hasmain tinyint(1) unsigned NOT NULL default '0',
  hasadmin tinyint(1) unsigned NOT NULL default '0',
  hassearch tinyint(1) unsigned NOT NULL default '0',
  haswaiting tinyint(1) unsigned NOT NULL default '0',
  sidebar tinyint(1) unsigned NOT NULL default '3',
  PRIMARY KEY  (mid),
  KEY dirname (dirname)
) ENGINE=MyISAM;

INSERT INTO `modules` VALUES (1, 'Администрирование', 2.00, 1265920620, 0, 1, 'system', '', 0, 1, 0, 0, 3);
INSERT INTO `modules` VALUES (2, 'Новости', 2.01, 1265920620, 1, 1, 'news', '', 1, 1, 1, 1, 3);
INSERT INTO `modules` VALUES (3, 'Информация', 2.00, 1265920620, 7, 1, 'contact', '', 1, 1, 0, 0, 3);
INSERT INTO `modules` VALUES (7, 'Кто сейчас на сайте', 2.01, 1265920620, 0, 1, 'whosonline', '', 0, 0, 0, 0, 3);

CREATE TABLE newblocks (
  bid mediumint(8) unsigned NOT NULL auto_increment,
  mid mediumint(8) unsigned NOT NULL default '0',
  func_num tinyint(3) unsigned NOT NULL default '0',
  options varchar(255) NOT NULL default '',
  name varchar(60) NOT NULL default '',
  position tinyint(1) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL default '',
  content text,
  side tinyint(3) unsigned NOT NULL default '0',
  weight smallint(3) NOT NULL default '0',
  visible tinyint(1) unsigned NOT NULL default '0',
  `type` char(1) NOT NULL default 'C',
  c_type char(1) NOT NULL default '',
  isactive tinyint(1) unsigned NOT NULL default '0',
  iscopy tinyint(1) unsigned NOT NULL default '0',
  dirname varchar(30) NOT NULL default '',
  func_file varchar(30) NOT NULL default '',
  show_func varchar(30) NOT NULL default '',
  show_mid varchar(255) NOT NULL default '0',
  show_template varchar(40) NOT NULL default 'standard',
  page_style tinyint(2) unsigned NOT NULL default '3',
  edit_func varchar(30) NOT NULL default '',
  PRIMARY KEY  (bid),
  KEY idx (mid,isactive,side,visible)
) ENGINE=MyISAM;

INSERT INTO `newblocks` VALUES (1, 1, 1, '', 'Блок пользователей', 1, 'User Menu', '', 0, 0, 1, 'S', 'H', 1, 0, 'system', 'system_user.php', 'b_system_user_show', '0', 'standard', 15, '');
INSERT INTO `newblocks` VALUES (2, 1, 2, '', 'Блок логина', 1, '', '', 1, 1, 1, 'S', '', 1, 0, 'system', 'system_login.php', 'b_system_login_show', '0', 'standard', 3, '');
INSERT INTO `newblocks` VALUES (3, 1, 3, '', 'Блок поиска', 1, '', '', 0, 0, 0, 'S', '', 1, 0, 'system', 'system_search.php', 'b_system_search_show', '0', 'standard', 3, '');
INSERT INTO `newblocks` VALUES (4, 1, 4, '', 'Блок ожидающего контента', 1, 'Waiting Contents', '', 1, 1, 1, 'S', 'H', 1, 0, 'system', 'system_waiting.php', 'b_system_waiting_show', '2', 'standard', 1, '');
INSERT INTO `newblocks` VALUES (5, 1, 5, '1', 'Блок главного меню', 0, 'Main menu', '', 0, 2, 1, 'S', 'H', 1, 0, 'system', 'system_menu.php', 'b_system_main_dynshow', '0', 'standard', 15, 'b_system_main_edit');
INSERT INTO `newblocks` VALUES (6, 1, 6, '320|250|button.gif|1', 'Блок информации', 0, 'Site Info', '', 0, 3, 1, 'S', 'H', 1, 0, 'system', 'system_info.php', 'b_system_info_show', '0', 'standard', 15, 'b_system_info_edit');
INSERT INTO `newblocks` VALUES (7, 2, 1, '', 'Разделы новостей', 0, '', '', 0, 0, 0, 'M', '', 1, 0, 'news', 'news_topics.php', 'b_news_topics_show', '0', 'standard', 3, '');
INSERT INTO `newblocks` VALUES (8, 2, 2, '', 'Блок "Новая статья"', 0, 'Top Historie', '', 1, 5, 0, 'M', 'H', 1, 0, 'news', 'news_bigstory.php', 'b_news_bigstory_show', '2', 'standard', 1, '');
INSERT INTO `newblocks` VALUES (9, 2, 3, 'counter|0|19|5|0', 'Самые читаемые новости', 0, 'Top Nyhed', '', 4, 1, 0, 'M', 'H', 1, 0, 'news', 'news_top.php', 'b_news_top_show', '2', 'standard', 1, 'b_news_top_edit');
INSERT INTO `newblocks` VALUES (10, 2, 4, 'published|0|19|5|0', 'Последние новости', 0, 'Latest News', '', 3, 2, 0, 'M', 'H', 1, 0, 'news', 'news_top.php', 'b_news_top_show', '2', 'standard', 1, 'b_news_top_edit');
INSERT INTO `newblocks` VALUES (11, 2, 6, '0|1|19|5', 'Лента новостей', 0, 'Short News', '', 0, 0, 0, 'M', 'H', 1, 0, 'news', 'news_comments.php', 'b_news_comments_show', '0', 'standard', 3, 'b_news_comments_edit');
INSERT INTO `newblocks` VALUES (12, 7, 1, '1|10|20', 'Блок кто сейчас на сайте.', 0, 'Whos online?', '', 0, 4, 1, 'M', 'H', 1, 0, 'whosonline', 'whosonline.php', 'b_whosonline_show', '0', 'standard', 15, 'b_whosonline_edit');
INSERT INTO `newblocks` VALUES (13, 1, 7, '1|1', 'День рождения', 0, '', '', 0, 0, 0, 'M', '', 1, 0, 'system', 'bnewscal.php', 'birthday_show', '0', 'standard', 3, '');
INSERT INTO `newblocks` VALUES (14, 2, 5, 'published|0|99|5|0', 'Последние комментарии', 0, '', '', 0, 0, 0, 'M', '', 1, 0, 'news', 'news_kort.php', 'b_news_kort_show', '0', 'standard', 3, 'b_news_kort_edit');
INSERT INTO `newblocks` VALUES (15, 2, 7, '15|25|50', 'Бегущие новости', 0, '', '', 0, 0, 0, 'M', '', 1, 0, 'news', 'news_lysavis.php', 'b_LysAvis_show', '0', 'standard', 3, 'b_LysAvis_edit');
     


CREATE TABLE ranks (
  rank_id mediumint(8) unsigned NOT NULL auto_increment,
  rank_title varchar(60) NOT NULL default '',
  rank_min int(10) NOT NULL default '0',
  rank_max int(10) NOT NULL default '0',
  rank_special tinyint(1) unsigned NOT NULL default '0',
  rank_image varchar(255) NOT NULL default '',
  PRIMARY KEY  (rank_id)
) ENGINE=MyISAM;

INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (2, 'Пока еще застенчивый', 0, 20, 0, '');
INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (3, 'Помаленьку вникаю', 21, 40, 0, 'rank1.gif');
INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (4, 'Младший пользователь', 41, 70, 0, 'rank2.gif');
INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (5, 'Полноправный пользователь', 71, 150, 0, 'rank3.gif');
INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (6, 'Уважаемый пользователь', 151, 10000, 0, 'rank4.gif');
INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (7, 'Администратор', -1, -1, 1, 'webmaster.gif');
INSERT INTO ranks (rank_id, rank_title, rank_min, rank_max, rank_special, rank_image) VALUES (8, 'Модератор', -1, -1, 1, 'moderator.gif');

CREATE TABLE session (
  uid mediumint(8) unsigned NOT NULL default '0',
  uname varchar(30) NOT NULL default '',
  `time` int(10) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  mid mediumint(8) unsigned NOT NULL default '0',
  `hash` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`time`),
  KEY idx (uid,`hash`)
) ENGINE=MyISAM;

INSERT INTO session (uid, uname, time, ip, mid, hash) VALUES (1, 'admin', 1173135717, '127.0.0.1', 2, '24402c51dd9a2aff8cb9831cf1b6e9b519026f37');

CREATE TABLE smiles (
  id mediumint(8) unsigned NOT NULL auto_increment,
  `code` varchar(30) NOT NULL default '',
  smile_url varchar(255) NOT NULL default '',
  emotion varchar(60) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM;

INSERT INTO smiles (id, code, smile_url, emotion) VALUES (1, ':-D', 'icon_biggrin.gif', 'Куда еще лучше');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (2, ':-)', 'icon_smile.gif', 'Улыба');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (3, ':-(', 'icon_frown.gif', 'Грустно господа');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (4, ':-o', 'icon_eek.gif', 'Удивительно');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (5, ':-?', 'icon_confused.gif', 'Ничего не понял!');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (6, '8-)', 'icon_cool.gif', 'Холосо');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (7, ':lol:', 'icon_lol.gif', 'Смеюсь');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (8, ':-x', 'icon_mad.gif', 'Безумный');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (9, ':-P', 'icon_razz.gif', 'Наверно непристойно');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (10, ':oops:', 'icon_redface.gif', 'Креатив');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (11, ':cry:', 'icon_cry.gif', 'Грущу (очень)');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (12, ':evil:', 'icon_evil.gif', 'И злой и противный');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (13, ':roll:', 'icon_rolleyes.gif', 'После сеанса NLP');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (14, ';-)', 'icon_wink.gif', 'Мигаю');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (15, ':pint:', 'icon_drink.gif', 'Пью пиво');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (16, ':hammer:', 'icon_hammer.gif', 'Трудоголик');
INSERT INTO smiles (id, code, smile_url, emotion) VALUES (17, ':idea:', 'icon_idea.gif', 'А у меня идея!');


CREATE TABLE stories (
  storyid mediumint(8) unsigned NOT NULL auto_increment,
  uid mediumint(8) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL default '',
  created int(10) unsigned NOT NULL default '0',
  published int(10) unsigned NOT NULL default '0',
  hostname varchar(15) NOT NULL default '',
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_smileys tinyint(1) unsigned NOT NULL default '0',
  allow_bbcode tinyint(1) unsigned NOT NULL default '1',
  hometext text NOT NULL,
  bodytext text,
  counter mediumint(8) unsigned NOT NULL default '0',
  topicid mediumint(8) unsigned NOT NULL default '1',
  ihome tinyint(1) unsigned NOT NULL default '0',
  notifypub tinyint(1) unsigned NOT NULL default '0',
  `type` enum('admin','user') NOT NULL default 'user',
  topicdisplay tinyint(1) unsigned NOT NULL default '0',
  topicalign enum('R','L','0') NOT NULL default '0',
  comments smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (storyid),
  KEY idx (topicid,published,ihome,created)
) ENGINE=MyISAM;


INSERT INTO stories (storyid, uid, title, created, published, hostname, allow_html, allow_smileys, allow_bbcode, hometext, bodytext, counter, topicid, ihome, notifypub, type, topicdisplay, topicalign, comments) VALUES (1, 1, 'Добро пожаловать на Ваш новый сайт!', 1030894461, 1030894461, '150.0.0.0', 2, 1, 1, 'Поздравляем Вас! Теперь Вы можете перейти к администрированию портала. Для этого авторизуйтесь, используя логин и пароль, которые Вы указали в процессе установки портала.\r\n\r\nЕсли вы не производили инсталляцию портала, а использовали дамп базы данных (_install/sql/dumpversion/mysql.sql), то авторизоваться Вы должны, используя логин [b]Admin[/b] и пароль [b]admin[/b] (регистр важен). После этого измените пароль и логин на нужные Вам.\r\n\r\nЕсли во время установки вы не использовали дополнительный дамп MySql, авторизуйтесь используя данные которые вы ввели на последнем этапе установки системы.\r\n\r\nНе забудьте изменить chmod файла [b]mainfile.php[/b] на 0444 (для unix), и удалить папку [b]_install[/b]. Это необходимо из соображений безопасности.\r\n\r\nТак же, нужно иметь в виду, что chmod всех папок под названием [b]/cache[/b] должен быть равен 0777, а для файлов находящихся в этих папках 0666, кроме файлов index.htm.\r\n\r\nУдачи в использовании системы.\r\n\r\nВся необходимая информация для работы с портальной системой RunCms, новости и дополнительные модули доступны на сайте [url=http://www.runcms.ru]runcms.ru[/url].', '', 1, 1, 0, 0, 'admin', 1, 'R', 0);


CREATE TABLE topics (
  topic_id mediumint(8) unsigned NOT NULL auto_increment,
  topic_pid mediumint(8) unsigned NOT NULL default '0',
  topic_imgurl varchar(255) NOT NULL default '',
  topic_title varchar(60) NOT NULL default '',
  PRIMARY KEY  (topic_id),
  KEY idx (topic_pid)
) ENGINE=MyISAM;


INSERT INTO topics (topic_id, topic_pid, topic_imgurl, topic_title) VALUES (1, 0, 'runcms.gif', 'Новости');


CREATE TABLE users (
  uid mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  uname varchar(30) NOT NULL default '',
  email varchar(60) NOT NULL default '',
 address varchar(150) NOT NULL default '',
  town varchar(60) NOT NULL default '',
  zip_code varchar(7) NOT NULL default '',
  phone varchar(15) NOT NULL default '',
  birthday varchar(8) NOT NULL default '',
  birthyear varchar(4) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  user_avatar varchar(255) NOT NULL default '',
  user_regdate int(10) unsigned NOT NULL default '0',
  user_icq varchar(15) NOT NULL default '',
  user_from varchar(60) NOT NULL default '',
  user_sig varchar(255) NOT NULL default '',
  user_viewemail tinyint(1) unsigned NOT NULL default '0',
  actkey varchar(8) NOT NULL default '',
  user_aim varchar(60) NOT NULL DEFAULT '',
  user_yim varchar(60) NOT NULL DEFAULT '',
  user_msnm varchar(60) NOT NULL default '',
  pass varchar(40) NOT NULL default '',
  posts smallint(5) unsigned NOT NULL default '0',
  attachsig tinyint(1) unsigned NOT NULL default '0',
  rank int(5) NOT NULL default '0',
  `level` int(5) NOT NULL default '1',
  theme varchar(30) NOT NULL default '',
  timezone_offset tinyint(2) NOT NULL default '0',
  last_login int(10) unsigned NOT NULL default '0',
  umode enum('flat','thread','0') NOT NULL default 'flat',
  uorder tinyint(1) unsigned NOT NULL default '0',
  user_occ varchar(60) NOT NULL default '',
  bio varchar(255) NOT NULL default '',
  user_intrest varchar(255) NOT NULL default '',
  user_mailok tinyint(1) unsigned NOT NULL default '1',
  `language` varchar(32) NOT NULL default '$lang',
  regip varchar(15) NOT NULL default '',
  pwdsalt varchar(4) NOT NULL default '',
  PRIMARY KEY  (uid),
  UNIQUE KEY uname (uname),
  KEY email (email),
  KEY uiduname (uid,uname),
  KEY unamepass (uname,pass)
) ENGINE=MyISAM;

INSERT INTO users (uid, name, uname, email, address, town, zip_code, phone, birthday, birthyear, url, user_avatar, user_regdate, user_icq, user_from, user_sig, user_viewemail, actkey, user_aim, user_yim, user_msnm, pass, posts, attachsig, rank, level, theme, timezone_offset, last_login, umode, uorder, user_occ, bio, user_intrest, user_mailok, language, regip, pwdsalt) VALUES (1, '', 'admin', 'webmaster@mysite.com', '', '', '', '', '', '', 'http://localhost', '001.gif', 1173134684, '', '', '', 1, '97e7fe22', '', '', '', 'dd94709528bb1c83d08f3088d4043f4742891f4f', 0, 0, 7, 5, 'runcms', 0, 1173135647, 'flat', 0, '', '', '', 1, 'english', '', 'b06a');