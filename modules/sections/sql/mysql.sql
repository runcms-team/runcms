# --------------------------------------------------------

#
# Table structure for table `nseccont`
#

CREATE TABLE nseccont (
  artid mediumint(8) unsigned NOT NULL auto_increment,
  secid mediumint(8) unsigned NOT NULL default '0',
  groupid varchar(100) NOT NULL default '1 2 3',
  title varchar(60) NOT NULL default '',
  byline varchar(255) NOT NULL default '',
  author mediumint(8) unsigned NOT NULL default '0',
  date int(10) unsigned NOT NULL default '0',
  content text NOT NULL,
  allow_html tinyint(1) NOT NULL default '1',
  allow_smileys tinyint(1) NOT NULL default '1',
  allow_bbcode tinyint(1) NOT NULL default '1',
  counter mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (artid),
  KEY idx (secid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `nsections`
#

CREATE TABLE nsections (
  secid mediumint(8) unsigned NOT NULL auto_increment,
  groupid varchar(100) NOT NULL default '1 2 3',
  secname varchar(60) NOT NULL default '',
  image varchar(255) NOT NULL default '',
  secdesc text,
  PRIMARY KEY  (secid)
) ENGINE=MyISAM;


