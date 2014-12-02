# --------------------------------------------------------

#
# Table structure for table `banner`
#

CREATE TABLE banner_items (
  bid mediumint(8) unsigned NOT NULL auto_increment,
  cid mediumint(8) unsigned NOT NULL default '0',
  imptotal mediumint(8) unsigned NOT NULL default '0',
  impmade mediumint(8) unsigned NOT NULL default '0',
  clicks mediumint(8) unsigned NOT NULL default '0',
  imageurl varchar(255) NOT NULL default '',
  imagealt varchar(60) NOT NULL default '',
  clickurl varchar(255) NOT NULL default '',
  datestart int(10) unsigned NOT NULL default '0',
  dateend int(10) unsigned NOT NULL default '0',
  display varchar(10) NOT NULL default 'N',
  custom text,
  PRIMARY KEY  (bid),
  KEY idx (dateend,display)
) ENGINE=MyISAM;

INSERT INTO banner_items VALUES (1, 1, 0, 0, 0, 'runcmsbanner.jpg', 'RUNCMS', 'http://www.runcms.org', 1030487127, 0, 'N', '');



# --------------------------------------------------------

#
# Table structure for table `bannerclient`
#

CREATE TABLE banner_clients (
  cid mediumint(8) unsigned NOT NULL auto_increment,
  name varchar(30) NOT NULL default '',
  contact varchar(30) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  login varchar(10) NOT NULL default '',
  passwd varchar(32) NOT NULL default '',
  extrainfo varchar(255) NOT NULL default '',
  PRIMARY KEY  (cid)
) ENGINE=MyISAM;

INSERT INTO banner_clients VALUES (1, 'RUNCMS', 'RUNCMS', 'noreply@nowhere.com', 'RUNCMS', 'ae2b1fca515949e5d54fb22b8ed95575', 'Sample Banners');
