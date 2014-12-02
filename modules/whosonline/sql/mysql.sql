# --------------------------------------------------------

#
# Table structure for table `lastseen`
#

CREATE TABLE lastseen (
  uid mediumint(8) unsigned NOT NULL default '0',
  username varchar(30) NOT NULL default '',
  time int(10) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  online tinyint(1) unsigned NOT NULL default '0',
  KEY idx (uid,online)
) ENGINE=MyISAM;

