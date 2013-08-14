# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Aug 14, 2006 at 09:14 PM
# Server version: 4.00.00
# PHP Version: 4.2.3
# Database : `db_ajax`
# --------------------------------------------------------

#
# Table structure for table `city`
#

CREATE TABLE city (
  id tinyint(4) NOT NULL auto_increment,
  city varchar(50) default NULL,
  countryid tinyint(4) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `city`
#

INSERT INTO city VALUES (1, 'Los Angales', 1);
INSERT INTO city VALUES (2, 'New York', 1);
INSERT INTO city VALUES (3, 'Toranto', 2);
INSERT INTO city VALUES (4, 'Vancovour', 2);

# --------------------------------------------------------

#
# Table structure for table `country`
#

CREATE TABLE country (
  id tinyint(4) NOT NULL auto_increment,
  country varchar(20) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `country`
#

INSERT INTO country VALUES (1, 'USA');
INSERT INTO country VALUES (2, 'Canada');

