# --------------------------------------------------------

#
# Table structure for table `stories`
#

CREATE TABLE stories (
  storyid mediumint(8) unsigned NOT NULL auto_increment,
  uid mediumint(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
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
  type enum('admin','user') NOT NULL default 'user',
  topicdisplay tinyint(1) unsigned NOT NULL default '0',
  topicalign enum('R','L','0') NOT NULL default '0',
  comments smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (storyid),
  KEY idx (topicid,published,ihome,created)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `topics`
#

CREATE TABLE topics (
  topic_id mediumint(8) unsigned NOT NULL auto_increment,
  topic_pid mediumint(8) unsigned NOT NULL default '0',
  topic_imgurl varchar(255) NOT NULL default '',
  topic_title varchar(255) NOT NULL default '',
  PRIMARY KEY  (topic_id),
  KEY idx (topic_pid)
) ENGINE=MyISAM;
