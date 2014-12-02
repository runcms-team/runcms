# phpMyAdmin MySQL-Dump
# version 2.3.0-rc3
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Oct 23, 2003 at 04:23 PM
# Server version: 3.23.49
# PHP Version: 4.3.2
# Database : `ercx`
# --------------------------------------------------------

#
# Table structure for table `forum_categories`
#

CREATE TABLE forum_categories (
  cat_id mediumint(8) unsigned NOT NULL auto_increment,
  cat_title varchar(60) NOT NULL default '',
  cat_order smallint(3) NOT NULL default '0',
  PRIMARY KEY  (cat_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_forum_access`
#

CREATE TABLE forum_forum_access (
  forum_id mediumint(8) unsigned NOT NULL default '0',
  user_id mediumint(8) unsigned NOT NULL default '0',
  can_view tinyint(1) unsigned NOT NULL default '0',
  can_post tinyint(1) unsigned NOT NULL default '0',
  can_reply tinyint(1) unsigned NOT NULL default '0',
  can_edit tinyint(1) unsigned NOT NULL default '0',
  can_delete tinyint(1) unsigned NOT NULL default '0',
  can_addpoll tinyint(1) unsigned NOT NULL default '0',
  can_vote tinyint(1) unsigned NOT NULL default '0',
  can_attach tinyint(1) unsigned NOT NULL default '0',
  autoapprove_post TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
  autoapprove_attach TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_forum_group_access`
#

CREATE TABLE forum_forum_group_access (
  forum_id mediumint(8) unsigned NOT NULL default '0',
  group_id mediumint(8) unsigned NOT NULL default '0',
  can_view tinyint(1) unsigned NOT NULL default '0',
  can_post tinyint(1) unsigned NOT NULL default '0',
  can_reply tinyint(1) unsigned NOT NULL default '0',
  can_edit tinyint(1) unsigned NOT NULL default '0',
  can_delete tinyint(1) unsigned NOT NULL default '0',
  can_addpoll tinyint(1) unsigned NOT NULL default '0',
  can_vote tinyint(1) unsigned NOT NULL default '0',
  can_attach tinyint(1) unsigned NOT NULL default '0',
  autoapprove_post TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
  autoapprove_attach TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_forum_mods`
#

CREATE TABLE forum_forum_mods (
  forum_id mediumint(8) unsigned NOT NULL default '0',
  user_id mediumint(8) unsigned NOT NULL default '0'
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_forums`
#

CREATE TABLE forum_forums (
  forum_id mediumint(8) unsigned NOT NULL auto_increment,
  forum_name varchar(60) NOT NULL default '',
  forum_desc text,
  parent_forum int(10) NOT NULL default '0',
  forum_topics mediumint(8) unsigned NOT NULL default '0',
  forum_posts mediumint(8) unsigned NOT NULL default '0',
  forum_last_post_id mediumint(8) unsigned NOT NULL default '0',
  cat_id mediumint(8) unsigned NOT NULL default '0',
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_sig tinyint(1) unsigned NOT NULL default '0',
  posts_per_page tinyint(3) unsigned NOT NULL default '20',
  hot_threshold tinyint(3) unsigned NOT NULL default '10',
  topics_per_page tinyint(3) unsigned NOT NULL default '20',
  allow_attachments tinyint(1) unsigned NOT NULL default '0',
  attach_maxkb int(10) NOT NULL default '1000',
  attach_ext text NOT NULL,
  allow_polls tinyint(1) unsigned NOT NULL default '0',
  forum_order smallint(3) NOT NULL default '0',
  PRIMARY KEY  (forum_id),
  KEY idx (cat_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_poll_desc`
#

CREATE TABLE forum_poll_desc (
  poll_id mediumint(8) unsigned NOT NULL auto_increment,
  question varchar(255) NOT NULL default '',
  description tinytext NOT NULL,
  user_id int(5) unsigned NOT NULL default '0',
  start_time int(10) unsigned NOT NULL default '0',
  end_time int(10) unsigned NOT NULL default '0',
  votes smallint(5) unsigned NOT NULL default '0',
  voters smallint(5) unsigned NOT NULL default '0',
  multiple tinyint(1) unsigned NOT NULL default '0',
  display tinyint(1) unsigned NOT NULL default '0',
  weight smallint(5) unsigned NOT NULL default '0',
  mail_status tinyint(1) unsigned NOT NULL default '0',
  topic_id int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (poll_id),
  KEY end_time (end_time),
  KEY display (display)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_poll_log`
#

CREATE TABLE forum_poll_log (
  log_id int(10) unsigned NOT NULL auto_increment,
  poll_id mediumint(8) unsigned NOT NULL default '0',
  option_id int(10) unsigned NOT NULL default '0',
  ip char(15) NOT NULL default '',
  user_id int(5) unsigned NOT NULL default '0',
  time int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (log_id),
  KEY poll_id_user_id (poll_id,user_id),
  KEY poll_id_ip (poll_id,ip)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_poll_option`
#

CREATE TABLE forum_poll_option (
  option_id int(10) unsigned NOT NULL auto_increment,
  poll_id mediumint(8) unsigned NOT NULL default '0',
  option_text varchar(255) NOT NULL default '',
  option_count smallint(5) unsigned NOT NULL default '0',
  option_color varchar(25) NOT NULL default '',
  PRIMARY KEY  (option_id),
  KEY poll_id (poll_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_posts`
#

CREATE TABLE forum_posts (
  post_id mediumint(8) unsigned NOT NULL auto_increment,
  pid mediumint(8) unsigned NOT NULL default '0',
  topic_id mediumint(8) unsigned NOT NULL default '0',
  forum_id mediumint(8) unsigned NOT NULL default '0',
  post_time int(10) unsigned NOT NULL default '0',
  uid mediumint(8) unsigned NOT NULL default '0',
  poster_ip varchar(15) NOT NULL default '',
  subject varchar(60) NOT NULL default '',
  post_text text NOT NULL,
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_smileys tinyint(1) unsigned NOT NULL default '0',
  allow_bbcode tinyint(1) unsigned NOT NULL default '1',
  type enum('admin','user') NOT NULL default 'user',
  icon varchar(255) NOT NULL default '',
  attachsig tinyint(1) unsigned NOT NULL default '0',
  has_attachment TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
  is_approved TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
  anon_uname VARCHAR( 64 ) NOT NULL DEFAULT '',
  PRIMARY KEY  (post_id),
  KEY idx (topic_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_topics`
#

CREATE TABLE forum_topics (
  topic_id mediumint(8) unsigned NOT NULL auto_increment,
  topic_title varchar(60) NOT NULL default '',
  topic_poster mediumint(8) unsigned NOT NULL default '0',
  topic_time int(10) unsigned NOT NULL default '0',
  topic_views mediumint(8) unsigned NOT NULL default '0',
  topic_replies mediumint(8) unsigned NOT NULL default '0',
  topic_last_post_id mediumint(8) unsigned NOT NULL default '0',
  forum_id mediumint(8) unsigned NOT NULL default '0',
  topic_status tinyint(1) unsigned NOT NULL default '0',
  topic_notify tinyint(1) unsigned NOT NULL default '0',
  topic_sticky tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (topic_id),
  KEY idx (forum_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_topics_mail`
#

CREATE TABLE forum_topics_mail (
  email_notify tinyint(1) NOT NULL default '1',
  topic_id int(5) NOT NULL default '0',
  usernotif_id int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (topic_id,usernotif_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `forum_whosonline`
#

CREATE TABLE forum_whosonline (
  forum_id int(10) NOT NULL default '0',
  user_id int(10) NOT NULL default '0',
  user_ip varchar(32) NOT NULL default '',
  timestamp int(10) NOT NULL default '0',
  uname varchar(30) NOT NULL default '',
  user_type enum('ADMIN','MOD','REG','ANON') NOT NULL default 'ANON'
) ENGINE=MyISAM;

#
# Table structure for table `forum_attachments`
#

CREATE TABLE forum_attachments (
  attach_id int(10) unsigned NOT NULL auto_increment,
  post_id int(10) unsigned NOT NULL default '0',
  file_name varchar(255) NOT NULL default '',
  file_pseudoname varchar(255) NOT NULL default '',
  file_size int(10) unsigned NOT NULL default '0',
  file_hits int(10) unsigned NOT NULL default '0',
  is_approved TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (attach_id)
) ENGINE=MyISAM;