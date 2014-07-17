CREATE TABLE `player_game` (
  `player_game_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(11) unsigned NOT NULL,
  `team` varchar(128) COLLATE utf8_danish_ci NOT NULL DEFAULT '',
  `game_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`player_game_id`),
  KEY `player_relation` (`player`),
  KEY `game_relation` (`game`),
  CONSTRAINT `game_relation` FOREIGN KEY (`game`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `player_relation` FOREIGN KEY (`player`) REFERENCES `player` (`player_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;