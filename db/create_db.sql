CREATE DATABASE /*!32312 IF NOT EXISTS*/ `temps` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `temps`;

CREATE TABLE `device` (
    `id` bigint(10) NOT NULL AUTO_INCREMENT,
    `date_created` DATETIME DEFAULT NOW(),
    `date_updated` DATETIME ON UPDATE CURRENT_TIMESTAMP,
    `device_name` text DEFAULT NULL,
    `display_name` text DEFAULT NULL,
    `deleted` BOOLEAN DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `temp` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `date_created` DATETIME DEFAULT NOW(),
  `date_updated` DATETIME ON UPDATE CURRENT_TIMESTAMP,
  `device_id` bigint(10) NOT NULL,
  `temp` float DEFAULT NULL,
  `hum` int(11) DEFAULT NULL,
  `battery` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` BOOLEAN DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE USER 'tempuser'@'%' IDENTIFIED BY '#v5$$BjKzVy2YuS4m2P!rGER';
GRANT ALL PRIVILEGES ON temps.* TO 'tempuser'@'%';
