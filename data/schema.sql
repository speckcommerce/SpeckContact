CREATE TABLE IF NOT EXISTS `contact` (
  `contact_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `contact_addresses` (
  `contact_id` int(11) unsigned NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `address_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`contact_id`,`address_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `contact_email` (
  `contact_id` int(11) unsigned NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `contact_phone` (
  `contact_id` int(11) unsigned NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `contact_url` (
  `contact_id` int(11) unsigned NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB;
