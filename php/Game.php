<?php
/**
 * @file Game
 *
 * @author Lars Nielsen <lars@lndesign.dk>
 */

require_once('Config.php');

class Game {

  /**
   * Creating a game and storing data.
   *
   * @param $players - Array containing players, teams and player points.
   */
  public function createGame($players, $winner) {}

  /**
   * Getting game from database.
   *
   * @param $game_id - Game id from database.
   */
  public function getGame($game_id) {}

  /**
   * Getting all players games.
   *
   * @param $player_id - Player id from database.
   */
  public function getPlayerGames($player_id) {}

  /**
   * Calculating new player point according to rating system.
   * Elo rating system is used to calculate point according to opponents.
   * Elo rating system: http://en.wikipedia.org/wiki/Elo_rating_system
   * Common MMO rating: http://www.mmo-champion.com/threads/720492-Guide-Match-Making-Rating-(MMR)
   *
   * @param $players - Array containing players, teams and player points.
   */
  private function calculatePlayerPoints($players) {

    $red_player_1 = $players['red'][1];
    $red_player_2 = $players['red'][2];

    $blue_player_1 = $players['blue'][1];
    $blue_player_2 = $players['blue'][2];

    $winner_team = $players['winner_team'];

    $red_team_score = $red_player_1['score'] + $red_player_2['score'];
    $blue_team_score = $blue_player_1['score'] + $blue_player_2['score'];

    $red_team_performance_rating = 1 / (1 + 10 ($blue_team_score - $red_team_score) / 400);
    $blue_team_performance_rating = 1 / (1 + 10 ($red_team_score - $blue_team_score) / 400);

  }

}

?>