CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%answers` (
  `ID` int(7) NOT NULL auto_increment,
  `ticket` int(6) default '0',
  `message` text,
  `rep` int(5) NOT NULL default '0',
  `reference` int(7) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%attachments` (
  `ID` int(7) NOT NULL auto_increment,
  `ticket` int(6) NOT NULL default '0',
  `ref` int(7) NOT NULL default '0',
  `filename` varchar(100) NOT NULL default '',
  `type` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%banlist` (
  `value_id` int(11) NOT NULL auto_increment,
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`value_id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%categories` (
  `ID` int(5) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `pophost` varchar(200) NOT NULL default '',
  `popuser` varchar(200) NOT NULL default '',
  `poppass` varchar(200) NOT NULL default '',
  `email` varchar(200) NOT NULL default '',
  `signature` text NOT NULL,
  `hidden` int(1) NOT NULL default '0',
  `reply_method` varchar(7) NOT NULL default 'url',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%groups` (
  `ID` int(10) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `pref` int(1) NOT NULL default '0',
  `mail` int(1) NOT NULL default '0',
  `cat` int(1) NOT NULL default '0',
  `rep` int(1) NOT NULL default '0',
  `user_group` int(1) NOT NULL default '0',
  `banlist` int(1) NOT NULL default '0',
  `db` int(1) NOT NULL default '0',
  `cat_access` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%messages` (
  `ID` int(7) NOT NULL auto_increment,
  `ticket` int(6) NOT NULL default '0',
  `message` text,
  `headers` text,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%privmsg` (
  `ID` int(10) NOT NULL auto_increment,
  `rep` int(10) NOT NULL default '0',
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ticket` int(6) NOT NULL default '0',
  `attachment` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `ticket` (`ticket`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%reps` (
  `ID` int(5) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `username` varchar(50) NOT NULL default '',
  `password` varchar(255) default NULL,
  `signature` text NOT NULL,
  `user_group` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_PREFIX%settings`(
  `ID` int(5) NOT NULL auto_increment,
  `group` varchar(255) NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `GROUP` (`GROUP`),
  KEY `VALUE` (`KEY`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `%TICKET_TABLE%` (
  `subject` varchar(255) NOT NULL default '[No Subject]',
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `phone` varchar(20) default NULL,
  `status` enum('new','onhold','custreplied','awaitingcustomer','reopened','closed') NOT NULL default 'new',
  `ID` int(6) NOT NULL default '0',
  `cat` int(5) NOT NULL default '0',
  `rep` int(5) default '0',
  `priority` tinyint(1) NOT NULL default '2',
  `ip` varchar(255) NOT NULL default '',
  `trans_msg` varchar(255) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM;

INSERT INTO `%TICKET_PREFIX%banlist` (`value_id`, `value`) VALUES (1, '[SPAM]');
INSERT INTO `%TICKET_PREFIX%groups` VALUES (1, 'Administrator', 1, 1, 1, 1, 1, 1, 1, 'all');