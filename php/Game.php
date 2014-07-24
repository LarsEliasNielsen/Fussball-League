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
   * TODO Move dublicate calculations to seperate methods.
   *
   * @param $players - Array containing players, teams and player points.
   */
  public function calculatePlayerPoints($players) {

    $red_player_1 = $players['red']['1'];
    $red_player_2 = $players['red']['2'];

    $blue_player_1 = $players['blue']['1'];
    $blue_player_2 = $players['blue']['2'];

    $winner_team = $players['winner_team'];

    $red_team_score = $red_player_1['score'] + $red_player_2['score'];
    $blue_team_score = $blue_player_1['score'] + $blue_player_2['score'];

    echo '<p>red points: ' . $red_team_score . ', blue points: ' . $blue_team_score . '</p>';
    echo '<br />';

    $red_team_performance_rating = (1 / (1 + pow(10, ($blue_team_score/2 - $red_team_score/2) / 400)));
    $blue_team_performance_rating = (1 / (1 + pow(10, ($red_team_score/2 - $blue_team_score/2) / 400)));

    echo '<p>red rating: ' . $red_team_performance_rating . ', blue rating: ' . $blue_team_performance_rating . '</p>';
    echo '<br />';

    // If red team wins, low red player get most points, and high blue player looses most points.
    // This means that high red player get less points, and that low blue player looses less points.
    // TODO Clean this mess up.
    if ($winner_team == 'red') {

      if ($red_player_1['score'] > $red_player_2['score']) {
        $red_player_1_performance_rating = (1 / (1 + pow(10, ($red_player_2['score'] - $red_player_1['score']) / 400)));
        $red_player_2_performance_rating = (1 / (1 + pow(10, ($red_player_1['score'] - $red_player_2['score']) / 400)));
      } else {
        $red_player_1_performance_rating = (1 / (1 + pow(10, ($red_player_1['score'] - $red_player_2['score']) / 400)));
        $red_player_2_performance_rating = (1 / (1 + pow(10, ($red_player_2['score'] - $red_player_1['score']) / 400)));
      }

      if ($blue_player_1['score'] > $blue_player_2['score']) {
        $blue_player_1_performance_rating = (1 / (1 + pow(10, ($blue_player_1['score'] - $blue_player_2['score']) / 400)));
        $blue_player_2_performance_rating = (1 / (1 + pow(10, ($blue_player_2['score'] - $blue_player_1['score']) / 400)));
      } else {
        $blue_player_1_performance_rating = (1 / (1 + pow(10, ($blue_player_2['score'] - $blue_player_1['score']) / 400)));
        $blue_player_2_performance_rating = (1 / (1 + pow(10, ($blue_player_1['score'] - $blue_player_2['score']) / 400)));
      }

    } else {

      if ($red_player_1['score'] > $red_player_2['score']) {
        $red_player_1_performance_rating = (1 / (1 + pow(10, ($red_player_1['score'] - $red_player_2['score']) / 400)));
        $red_player_2_performance_rating = (1 / (1 + pow(10, ($red_player_2['score'] - $red_player_1['score']) / 400)));
      } else {
        $red_player_1_performance_rating = (1 / (1 + pow(10, ($red_player_2['score'] - $red_player_1['score']) / 400)));
        $red_player_2_performance_rating = (1 / (1 + pow(10, ($red_player_1['score'] - $red_player_2['score']) / 400)));
      }

      if ($blue_player_1['score'] > $blue_player_2['score']) {
        $blue_player_1_performance_rating = (1 / (1 + pow(10, ($blue_player_2['score'] - $blue_player_1['score']) / 400)));
        $blue_player_2_performance_rating = (1 / (1 + pow(10, ($blue_player_1['score'] - $blue_player_2['score']) / 400)));
      } else {
        $blue_player_1_performance_rating = (1 / (1 + pow(10, ($blue_player_1['score'] - $blue_player_2['score']) / 400)));
        $blue_player_2_performance_rating = (1 / (1 + pow(10, ($blue_player_2['score'] - $blue_player_1['score']) / 400)));
      }

    }

    echo '<p>red 1 rating: ' . $red_player_1_performance_rating . ', red 2 rating: ' . $red_player_2_performance_rating . '</p>';
    echo '<p>blue 1 rating: ' . $blue_player_1_performance_rating . ', blue 2 rating: ' . $blue_player_2_performance_rating . '</p>';
    echo '<br />';

    // TODO Move this to seperate method.
    $red_win_status = 0;
    $blue_win_status = 0;
    switch($winner_team) {
      case 'red':
        $red_win_status = 1;
        $blue_win_status = 0;
        break;
      case 'blue':
        $red_win_status = 0;
        $blue_win_status = 1;
        break;
      default:
        $red_win_status = 0;
        $blue_win_status = 0;
        break;
    }

    $red_score = 24 * ($red_win_status - $red_team_performance_rating);
    $blue_score = 24 * ($blue_win_status - $blue_team_performance_rating);

    echo '<p>red score: ' . $red_score . ', blue score: ' . $blue_score . '</p>';
    echo '<br />';

    $red_player_1_game_score = round($red_score * $red_player_1_performance_rating);
    $red_player_1_new_score = $red_player_1['score'] + $red_player_1_game_score;
    $red_player_2_game_score = round($red_score * $red_player_2_performance_rating);
    $red_player_2_new_score = $red_player_2['score'] + $red_player_2_game_score;

    $blue_player_1_game_score = round($blue_score * $blue_player_1_performance_rating);
    $blue_player_1_new_score = $blue_player_1['score'] + $blue_player_1_game_score;
    $blue_player_2_game_score = round($blue_score * $blue_player_2_performance_rating);
    $blue_player_2_new_score = $blue_player_2['score'] + $blue_player_2_game_score;

    echo '<p>red 1 score: ' . $red_player_1['score'] . ' => ' . $red_player_1_new_score . ' (' . $red_player_1_game_score . '), red 2 score: ' . $red_player_2['score'] . ' => ' . $red_player_2_new_score . ' (' . $red_player_2_game_score . ')</p>';
    echo '<p>blue 1 score: ' . $blue_player_1['score'] . ' => ' . $blue_player_1_new_score . ' (' . $blue_player_1_game_score . '), blue 2 score: ' . $blue_player_2['score'] . ' => ' . $blue_player_2_new_score . ' (' . $blue_player_2_game_score . ')</p>';
    echo '<br />';

  }

}

?>