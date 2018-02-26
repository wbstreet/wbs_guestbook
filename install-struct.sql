DROP TABLE IF EXISTS `{TABLE_PREFIX}mod_wbs_guestbook`;
CREATE TABLE `{TABLE_PREFIX}mod_wbs_guestbook` (
  `guestbook_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `obj_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rate_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`guestbook_id`)
){TABLE_ENGINE=MyISAM};

DROP TABLE IF EXISTS `{TABLE_PREFIX}mod_wbs_guestbook_rates`;
CREATE TABLE `{TABLE_PREFIX}mod_wbs_guestbook_rates` (
  `rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `rate_name` varchar(255) NOT NULL,
  `rate_is_active` int(11) NOT NULL DEFAULT 1,
  `rate_position` int(11) NOT NULL,
  PRIMARY KEY (`rate_id`)
){TABLE_ENGINE=MyISAM};