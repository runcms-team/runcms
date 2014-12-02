# --------------------------------------------------------

#
# Table structure for table `partners`
#

CREATE TABLE partners (
  id mediumint(8) unsigned NOT NULL auto_increment,
  weight smallint(3) NOT NULL default '0',
  hits mediumint(8) unsigned NOT NULL default '0',
  url varchar(255) NOT NULL default '',
  image varchar(255) NOT NULL default '',
  title varchar(60) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  status tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (id),
  KEY idx (status)
) ENGINE=MyISAM;

INSERT INTO partners VALUES (1, 0, 0, 'http://www.runcms.org', 'runcms.gif', 'RUNCMS', 'Sample Partner', 1);
