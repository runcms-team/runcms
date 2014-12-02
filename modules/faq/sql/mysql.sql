#
# Table structure for table `faq_categories`
#

CREATE TABLE faq_categories (
  category_id mediumint(8) unsigned NOT NULL auto_increment,
  category_title varchar(60) NOT NULL default '',
  category_order smallint(3) NOT NULL default '0',
  PRIMARY KEY  (category_id)
) ENGINE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `faq_contents`
#

CREATE TABLE faq_contents (
  contents_id mediumint(8) unsigned NOT NULL auto_increment,
  category_id mediumint(8) unsigned NOT NULL default '0',
  contents_title varchar(255) NOT NULL default '',
  contents_contents text NOT NULL,
  contents_time int(10) unsigned NOT NULL default '0',
  contents_order smallint(3) NOT NULL default '0',
  contents_visible tinyint(1) unsigned NOT NULL default '1',
  allow_html tinyint(1) unsigned NOT NULL default '0',
  allow_smileys tinyint(1) unsigned NOT NULL default '0',
  allow_bbcode tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (contents_id),
  KEY idx (category_id,contents_visible)
) ENGINE=MyISAM;
