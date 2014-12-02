# --------------------------------------------------------
#
# Table structure for table `contact`
#

CREATE TABLE contact (
  contact_text text,
  contact_options varchar(5) NOT NULL default '1|1|1',
  contact_reasons varchar(255) NOT NULL default '',
  about_text text,
  about_options varchar(5) NOT NULL default '1|1|1',
  policy_text text,
  policy_options varchar(5) NOT NULL default '1|1|1',
  intro_text text NOT NULL,
  intro_options varchar(5) NOT NULL default '1|1|1',
  text_alt varchar(255) NOT NULL default '',
  text_caption varchar(255) NOT NULL default '',
  text_custom text,
  button_alt varchar(255) NOT NULL default '',
  button_img varchar(255) NOT NULL default '',
  button_custom text,
  logo_alt varchar(255) NOT NULL default '',
  logo_img varchar(255) NOT NULL default '',
  logo_custom text,
  banner_alt varchar(255) NOT NULL default '',
  banner_img varchar(255) NOT NULL default '',
  banner_custom text
) ENGINE=MyISAM;

#
# Dumping data for table `contact`
#

INSERT INTO contact VALUES ('', '1|1|1', 'Other|Support|Proposal', '', '1|1|1', '', '1|1|1', '', '1|1|1', '', '', '', '', '', '', '', '', '', '', '', '');
