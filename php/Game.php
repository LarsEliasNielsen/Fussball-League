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
  private function calculatePlayerPoints($players) {}

}

?>