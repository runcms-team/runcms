# --------------------------------------------------------

#
# Table structure for table `links_broken`
#

CREATE TABLE links_broken (
  reportid mediumint(8) unsigned NOT NULL auto_increment,
  lid mediumint(8) unsigned NOT NULL default '0',
  sender mediumint(8) unsigned NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  PRIMARY KEY  (reportid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `links_cat`
#

CREATE TABLE links_cat (
  cid mediumint(8) unsigned NOT NULL auto_increment,
  pid mediumint(8) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL default '',
  imgurl varchar(255) NOT NULL default '',
  description text,
  PRIMARY KEY  (cid),
  KEY idx (pid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `links_links`
#

CREATE TABLE links_links (
  lid mediumint(8) unsigned NOT NULL auto_increment,
  cid mediumint(8) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL default '',
  description text NOT NULL,
  url varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  logourl varchar(255) NOT NULL default '',
  submitter mediumint(8) unsigned NOT NULL default '0',
  status tinyint(1) unsigned NOT NULL default '0',
  date int(10) unsigned NOT NULL default '0',
  hits mediumint(8) unsigned NOT NULL default '0',
  rating float(3,2) unsigned NOT NULL default '0.00',
  votes smallint(5) unsigned NOT NULL default '0',
  comments smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (lid),
  KEY idx (status,cid)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `links_mod`
#

CREATE TABLE links_mod (
  requestid mediumint(8) unsigned NOT NULL auto_increment,
  lid mediumint(8) unsigned NOT NULL default '0',
  cid mediumint(8) unsigned NOT NULL default '0',
  title varchar(60) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  logourl varchar(255) NOT NULL default '',
  description text NOT NULL,
  modifysubmitter mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (requestid)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `links_votedata`
#

CREATE TABLE links_votedata (
  ratingid mediumint(8) unsigned NOT NULL auto_increment,
  lid mediumint(8) unsigned NOT NULL default '0',
  ratinguser mediumint(8) unsigned NOT NULL default '0',
  rating float(3,2) unsigned NOT NULL default '0.00',
  ratinghostname varchar(15) NOT NULL default '',
  ratingtimestamp int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY idx (lid)
) ENGINE=MyISAM;
