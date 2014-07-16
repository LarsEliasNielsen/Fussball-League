CREATE TABLE `player` (
  `player_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_danish_ci DEFAULT NULL,
  `player_score` int(11) NOT NULL DEFAULT '1500',
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;