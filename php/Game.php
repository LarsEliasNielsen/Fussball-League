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
   * @param $game_info - Array containing players, teams and player points.
   */
  public function calculateGame($game_info) {

    $red_player_1 = $game_info['red']['1'];
    $red_player_2 = $game_info['red']['2'];

    $blue_player_1 = $game_info['blue']['1'];
    $blue_player_2 = $game_info['blue']['2'];

    $winner_team = $game_info['winner_team'];

    $red_team_score = $red_player_1['score'] + $red_player_2['score'];
    $blue_team_score = $blue_player_1['score'] + $blue_player_2['score'];

    // Teams average score is used to calculate team performance rating.
    $red_team_average_score = $red_team_score / 2;
    $blue_team_average_score = $blue_team_score / 2;
    // Calculate team performance rating.
    $red_team_performance_rating = self::calculatePerformanceRating($blue_team_average_score, $red_team_average_score);
    $blue_team_performance_rating = self::calculatePerformanceRating($red_team_average_score, $blue_team_average_score);

    // Write team performance rating to array.
    $game_info['red']['performance_rating'] = $red_team_performance_rating;
    $game_info['blue']['performance_rating'] = $blue_team_performance_rating;

    // If red team wins, low red player get most points, and high blue player looses most points.
    // This means that high red player get less points, and that low blue player looses less points.
    if ($winner_team == 'red') {

      if ($red_player_1['score'] > $red_player_2['score']) {
        $red_player_1_performance_rating = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
        $red_player_2_performance_rating = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
      } else {
        $red_player_1_performance_rating = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
        $red_player_2_performance_rating = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
      }

      if ($blue_player_1['score'] > $blue_player_2['score']) {
        $blue_player_1_performance_rating = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
        $blue_player_2_performance_rating = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
      } else {
        $blue_player_1_performance_rating = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
        $blue_player_2_performance_rating = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
      }

    } else {

      if ($red_player_1['score'] > $red_player_2['score']) {
        $red_player_1_performance_rating = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
        $red_player_2_performance_rating = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
      } else {
        $red_player_1_performance_rating = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
        $red_player_2_performance_rating = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
      }

      if ($blue_player_1['score'] > $blue_player_2['score']) {
        $blue_player_1_performance_rating = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
        $blue_player_2_performance_rating = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
      } else {
        $blue_player_1_performance_rating = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
        $blue_player_2_performance_rating = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
      }

    }

    // Write players performance rating to array.
    $game_info['red']['1']['performance_rating'] = $red_player_1_performance_rating;
    $game_info['red']['2']['performance_rating'] = $red_player_2_performance_rating;
    $game_info['blue']['1']['performance_rating'] = $blue_player_1_performance_rating;
    $game_info['blue']['2']['performance_rating'] = $blue_player_2_performance_rating;

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

    // Calculate team game scores.
    $red_score = 24 * ($red_win_status - $red_team_performance_rating);
    $blue_score = 24 * ($blue_win_status - $blue_team_performance_rating);

    // Calculate player game score and new player score.
    $red_player_1_game_score = round($red_score * $red_player_1_performance_rating);
    $red_player_1_new_score = $red_player_1['score'] + $red_player_1_game_score;
    $red_player_2_game_score = round($red_score * $red_player_2_performance_rating);
    $red_player_2_new_score = $red_player_2['score'] + $red_player_2_game_score;

    $blue_player_1_game_score = round($blue_score * $blue_player_1_performance_rating);
    $blue_player_1_new_score = $blue_player_1['score'] + $blue_player_1_game_score;
    $blue_player_2_game_score = round($blue_score * $blue_player_2_performance_rating);
    $blue_player_2_new_score = $blue_player_2['score'] + $blue_player_2_game_score;

    // Write actual team game score in array.
    // Unrounded team game score if found in $red_score and $blue_score.
    $game_info['red']['game_score'] = intval($red_player_1_game_score + $red_player_2_game_score);
    $game_info['blue']['game_score'] = intval($blue_player_1_game_score + $blue_player_2_game_score);

    // Write players game score in array.
    $game_info['red']['1']['game_score'] = intval($red_player_1_game_score);
    $game_info['red']['2']['game_score'] = intval($red_player_2_game_score);
    $game_info['blue']['1']['game_score'] = intval($blue_player_1_game_score);
    $game_info['blue']['2']['game_score'] = intval($blue_player_2_game_score);

    // Write players new score in array.
    $game_info['red']['1']['new_score'] = $red_player_1_new_score;
    $game_info['red']['2']['new_score'] = $red_player_2_new_score;
    $game_info['blue']['1']['new_score'] = $blue_player_1_new_score;
    $game_info['blue']['2']['new_score'] = $blue_player_2_new_score;

    // Return array with calculations.
    return $game_info;

  }

  public function calculateGameAsJSON($game_info) {

    $json_game_info = json_encode(self::calculateGame($game_info));

    return $json_game_info;

  }

  /**
   * Calculate performance rating.
   * Calculates the performance rating for team/player with score 1 against 
   * team/player with score 2.
   *
   * @param $score_1 - Score for team/player 1.
   * @param $score_2 - Score for team/palyer 2.
   *
   * @return $performance_rating - Performance rating for team/player with score 1.
   */
  private function calculatePerformanceRating($score_1, $score_2) {

    $performance_rating = (1 / (1 + pow(10, ($score_1 - $score_2) / 400)));

    return $performance_rating;

  }


}

?>