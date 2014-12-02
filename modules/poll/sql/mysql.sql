
CREATE TABLE poll_option (
  option_id mediumint(8) unsigned NOT NULL auto_increment,
  poll_id mediumint(8) unsigned NOT NULL default '0',
  option_text varchar(60) NOT NULL default '',
  option_count smallint(5) unsigned NOT NULL default '0',
  option_color varchar(255) NOT NULL default '',
  PRIMARY KEY  (option_id),
  KEY idx (poll_id)
) ENGINE=MyISAM;


INSERT INTO poll_option VALUES (1, 1, 'Excellent', 0, 'pink.gif');
INSERT INTO poll_option VALUES (2, 1, 'Cool', 0, 'yellow.gif');
INSERT INTO poll_option VALUES (3, 1, 'Hmm..not bad', 0, 'green.gif');
INSERT INTO poll_option VALUES (4, 1, 'what is this?', 0, 'red.gif');


CREATE TABLE poll_desc (
  poll_id mediumint(8) unsigned NOT NULL auto_increment,
  question varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  user_id mediumint(8) unsigned NOT NULL default '0',
  start_time int(10) unsigned NOT NULL default '0',
  end_time int(10) unsigned NOT NULL default '0',
  votes smallint(5) unsigned NOT NULL default '0',
  voters smallint(5) unsigned NOT NULL default '0',
  multiple tinyint(1) unsigned NOT NULL default '0',
  display tinyint(1) unsigned NOT NULL default '0',
  weight smallint(3) NOT NULL default '0',
  mail_status tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (poll_id),
  KEY idx (end_time,display)
) ENGINE=MyISAM;

INSERT INTO poll_desc VALUES (1, 'What do you think about RUNCMS?', 'A simple survey about the content management script used on this site.', 1, 1020447898, 1243088864, 0, 0, 0, 1, 0, 0);

CREATE TABLE poll_log (
  log_id mediumint(8) unsigned NOT NULL auto_increment,
  poll_id mediumint(8) unsigned NOT NULL default '0',
  option_id mediumint(8) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  user_id mediumint(8) unsigned NOT NULL default '0',
  time int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (log_id),
  KEY idx (poll_id,option_id)
) ENGINE=MyISAM;


CREATE TABLE pollcomments (
  comment_id mediumint(8) unsigned NOT NULL auto_increment,
  pid mediumint(8) unsigned NOT NULL default '0',
  item_id mediumint(8) unsigned NOT NULL default '0',
  date int(10) unsigned NOT NULL default '0',
  user_id mediumint(8) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  subject varchar(60) NOT NULL default '',
  comment text NOT NULL,
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_smileys tinyint(1) unsigned NOT NULL default '0',
  allow_bbcode tinyint(1) unsigned NOT NULL default '0',
  type enum('admin','user') NOT NULL default 'user',
  icon varchar(255) NOT NULL default '',
  PRIMARY KEY  (comment_id)
) ENGINE=MyISAM;

