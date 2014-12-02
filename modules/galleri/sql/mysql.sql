#
# Tabele `galli_category`
#

CREATE TABLE galli_category (
  cid int(11) NOT NULL auto_increment,
  scid int(11) NOT NULL default '0',
  cname varchar(40) NOT NULL default '',
  img varchar(40) NOT NULL default '',
  coment varchar(50) NOT NULL default '',
  button varchar(40) NOT NULL default '',
  date timestamp NOT NULL,
  PRIMARY KEY  (cid),
  KEY scid (scid),
  KEY cname (cname)
) ENGINE=MyISAM;

#
# Tabele `galli_coadmin`
#

CREATE TABLE galli_coadmin (
  id int(11) NOT NULL auto_increment,
  cid int(5) NOT NULL default '0',
  uid int(5) NOT NULL default '0',
  KEY id (id)
) ENGINE=MyISAM;

#
# Tabele `galli_conf`
#

CREATE TABLE galli_conf (
  id int(11) NOT NULL auto_increment,
  parm1 int(1) NOT NULL default '0',
  parm2 int(1) NOT NULL default '0',
  parm3 int(1) NOT NULL default '0',
  parm4 int(1) NOT NULL default '0',
  parm5 int(1) NOT NULL default '0',
  parm6 int(1) NOT NULL default '0',
  parm7 int(4) default '0',
  parm8 int(4) default '0',
  parm9 varchar(50) default NULL,
  parm10 varchar(40) default NULL,
  parm11 varchar(6) default NULL,
  parm12 varchar(6) default NULL,
  parm13 varchar(40) default NULL,
  parm14 varchar(20) default NULL,
  parm15 varchar(20) NOT NULL default '0',
  parm16 int(4) NOT NULL default '0',
  parm17 int(10) NOT NULL default '0',
  parm18 varchar(255) default NULL,
  parm19 double(4,2) NOT NULL default '0.00',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) ENGINE=MyISAM;


#
# Tabele `galli_conf`
#

INSERT INTO galli_conf VALUES (1, 1, 1, 1, 1, 1, 1, 1, 131, '0', '0', '', '', '', '', '0', 80, 0, '', '');
INSERT INTO galli_conf VALUES (2, 1, 2, 0, 4, 0, 0, 9, 6, NULL, 'detail.php', NULL, 'D9E2ED', 'galleri_logo.png', 'titre ASC', 'titre ASC', 3, 2, '', '');
INSERT INTO galli_conf VALUES (3, 0, 0, 0, 20, 0, 1, 600, 800, 'png|jpg|jpeg|wbmp|gif|wmv|mov|mpg|mpeg|avi|asf|swf', '', 'img', '000000', '', '', '0', 400, 1, '', '');
INSERT INTO galli_conf VALUES (4, 2, 5, 3, 3, 3, 5, 2, 150, 'RAND()', '993300', '00CC00', 'FFFFFF', 'CCCC00', NULL, '0', 0, 0, '', '');
INSERT INTO galli_conf VALUES (5, 0, 0, 0, 0, 0, 3, 1, 1, '', '993300', '6699FF', 'FFFFFF', 'F5F5F5', 'bg1', '0', 0, 0, '', '');
INSERT INTO galli_conf VALUES (6, 5, 1, 0, 2, 0, 0, 255, 200, '2007 (c) by ', '', '', '', '', '', '0', 255, 0, '', '');
INSERT INTO galli_conf VALUES (7, 5, 0, 0, 2, 2, 0, 255, 255, '2007 (c) by ', '', '', '', '', '', '0', 255, 0, '', '');
INSERT INTO galli_conf VALUES (8, 1, 0, 0, 1, 0, 0, 600, 800, '', '', '', '', '', '', '0', 700, 0, '', '');

#
# Tabele `galli_img`
#

CREATE TABLE galli_img (
  id int(11) NOT NULL auto_increment,
  cid int(11) NOT NULL default '0',
  nom varchar(30) NOT NULL default '',
  email varchar(50) default NULL,
  cname varchar(40) NOT NULL default '',
  titre varchar(40) NOT NULL default '',
  img varchar(40) NOT NULL default '',
  coment text NOT NULL,
  clic int(11) NOT NULL default '0',
  rating double(6,2) NOT NULL default '0.00',
  vote int(11) unsigned NOT NULL default '0',
  free int(1) NOT NULL default '0',
  copy int(1) NOT NULL default '0',
  new_img int(1) NOT NULL default '0',
  date int(10) NOT NULL default '0',
  byte int(10) NOT NULL default '0',
  size varchar(100) NOT NULL default '',
  thumbCorr tinyint(1) NOT NULL default '0',
  alt varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  UNIQUE KEY img (img),
  UNIQUE KEY id (id),
  KEY cid (cid)
) ENGINE=MyISAM;


#
# Tabele `galli_mail`
#

CREATE TABLE galli_mail (
  id int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  nom1 varchar(40) default NULL,
  nom2 varchar(40) default NULL,
  email1 varchar(40) default NULL,
  email2 varchar(40) default NULL,
  sujet varchar(50) default NULL,
  actkey varchar(20) default NULL,
  message text,
  image varchar(250) default NULL,
  music varchar(100) default NULL,
  body varchar(6) default NULL,
  border varchar(6) default NULL,
  color varchar(6) default NULL,
  poli varchar(20) default NULL,
  tail varchar(20) default NULL,
  date int(10) NOT NULL default '0',
  status tinyint(1) NOT NULL default '0',
  date_vers int(10) NOT NULL default '0',
  visit int(5) NOT NULL default '0',
  date_gelesen int(10) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
) ENGINE=MyISAM;


#
# Tabele `galli_user`
#

CREATE TABLE galli_user (
  id int(11) NOT NULL auto_increment,
  cid int(5) NOT NULL default '0',
  uid int(5) NOT NULL default '0',
  KEY id (id)
) ENGINE=MyISAM;

#
# Tabele `galli_vote`
#

CREATE TABLE galli_vote (
  ratingid int(11) unsigned NOT NULL auto_increment,
  id int(8) unsigned NOT NULL default '0',
  ratinguser int(5) unsigned NOT NULL default '0',
  rating tinyint(3) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname),
  KEY ratingtimestamp (ratingtimestamp)
) ENGINE=MyISAM;

#
# Tabele `galli_comments`
#

CREATE TABLE galli_comments (
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
  attachsig tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (comment_id),
  KEY idx (item_id)
) ENGINE=MyISAM;
