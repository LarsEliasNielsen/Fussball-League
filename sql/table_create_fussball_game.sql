CREATE TABLE `game` (
  `game_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `winner_team` varchar(128) COLLATE utf8_danish_ci NOT NULL DEFAULT '',
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;