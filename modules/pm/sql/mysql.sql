
CREATE TABLE pm_msgs (
  msg_id mediumint(8) unsigned NOT NULL auto_increment,
  msg_image varchar(255) NOT NULL default '',
  msg_attachment varchar(255) NOT NULL default '',
  subject varchar(60) NOT NULL default '',
  from_userid mediumint(8) unsigned NOT NULL default '0',
  to_userid mediumint(8) unsigned NOT NULL default '0',
  msg_time int(10) unsigned NOT NULL default '0',
  msg_text text NOT NULL,
  read_msg tinyint(1) unsigned NOT NULL default '0',
  type enum('admin','user') NOT NULL default 'user',
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_smileys tinyint(1) unsigned NOT NULL default '0',
  allow_bbcode tinyint(1) unsigned NOT NULL default '0',
  msg_replay tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY (msg_id),
  KEY idx (to_userid)
) ENGINE=MyISAM;

CREATE TABLE pm_msgs_config (
  msg_uid mediumint(4) unsigned NOT NULL default '0',
  msg_mail tinyint (1)unsigned NOT NULL default '0',
  msg_disclaimer text NOT NULL,
  msg_showdisc tinyint (1) NOT NULL default '0',
  msg_showsend tinyint (1) NOT NULL default '0'
 ) ENGINE=MyISAM;
