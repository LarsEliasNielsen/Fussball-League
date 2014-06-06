CREATE TABLE `match` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `player` int(11) unsigned NOT NULL,
  `win` tinyint(1) NOT NULL DEFAULT '0',
  `team_player` int(11) unsigned NOT NULL,
  `team` varchar(11) COLLATE utf8_danish_ci DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `TEAM_RELATION` (`team_player`),
  UNIQUE KEY `PLAYER_RELATION` (`player`),
  CONSTRAINT `player_relation` FOREIGN KEY (`player`) REFERENCES `player` (`id`),
  CONSTRAINT `team_relation` FOREIGN KEY (`team_player`) REFERENCES `player` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;