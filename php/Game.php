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

    $red_player_1 = $game_info['red']['player_1'];
    $red_player_2 = $game_info['red']['player_2'];

    $blue_player_1 = $game_info['blue']['player_1'];
    $blue_player_2 = $game_info['blue']['player_2'];

    // $winner_team = $game_info['winner_team'];

    $red_team_score = $red_player_1['score'] + $red_player_2['score'];
    $blue_team_score = $blue_player_1['score'] + $blue_player_2['score'];

    // Teams average score is used to calculate team performance rating.
    $red_team_average_score = $red_team_score / 2;
    $blue_team_average_score = $blue_team_score / 2;

    // Calculate team performance rating.
    $red_team_performance_rating_win = self::calculatePerformanceRating($blue_team_average_score, $red_team_average_score);
    $red_team_performance_rating_lose = self::calculatePerformanceRating($red_team_average_score, $blue_team_average_score);
    $blue_team_performance_rating_win = self::calculatePerformanceRating($red_team_average_score, $blue_team_average_score);
    $blue_team_performance_rating_lose = self::calculatePerformanceRating($blue_team_average_score, $red_team_average_score);

    // Write team performance rating to array.
    $game_info['red']['performance_rating_win'] = $red_team_performance_rating_win;
    $game_info['red']['performance_rating_lose'] = $red_team_performance_rating_lose;
    $game_info['blue']['performance_rating_win'] = $blue_team_performance_rating_win;
    $game_info['blue']['performance_rating_lose'] = $blue_team_performance_rating_lose;

    // Red team.
    if ($red_player_1['score'] > $red_player_2['score']) {
      // Win.
      $red_player_1_performance_rating_win = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
      $red_player_2_performance_rating_win = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
      // Lose.
      $red_player_1_performance_rating_lose = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
      $red_player_2_performance_rating_lose = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
    } else {
      // Win.
      $red_player_1_performance_rating_win = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
      $red_player_2_performance_rating_win = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
      // Lose.
      $red_player_1_performance_rating_lose = self::calculatePerformanceRating($red_player_2['score'], $red_player_1['score']);
      $red_player_2_performance_rating_lose = self::calculatePerformanceRating($red_player_1['score'], $red_player_2['score']);
    }
    // Blue team.
    if ($blue_player_1['score'] > $blue_player_2['score']) {
      // Win.
      $blue_player_1_performance_rating_win = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
      $blue_player_2_performance_rating_win = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
      // Lose.
      $blue_player_1_performance_rating_lose = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
      $blue_player_2_performance_rating_lose = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
    } else {
      // Win.
      $blue_player_1_performance_rating_win = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
      $blue_player_2_performance_rating_win = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
      // Lose.
      $blue_player_1_performance_rating_lose = self::calculatePerformanceRating($blue_player_1['score'], $blue_player_2['score']);
      $blue_player_2_performance_rating_lose = self::calculatePerformanceRating($blue_player_2['score'], $blue_player_1['score']);
    }

    // Write players performance rating to array.
    // Red team.
    $game_info['red']['player_1']['performance_rating_win'] = $red_player_1_performance_rating_win;
    $game_info['red']['player_2']['performance_rating_win'] = $red_player_2_performance_rating_win;
    $game_info['red']['player_1']['performance_rating_lose'] = $red_player_1_performance_rating_lose;
    $game_info['red']['player_2']['performance_rating_lose'] = $red_player_2_performance_rating_lose;
    // Blue team.
    $game_info['blue']['player_1']['performance_rating_win'] = $blue_player_1_performance_rating_win;
    $game_info['blue']['player_2']['performance_rating_win'] = $blue_player_2_performance_rating_win;
    $game_info['blue']['player_1']['performance_rating_lose'] = $blue_player_1_performance_rating_lose;
    $game_info['blue']['player_2']['performance_rating_lose'] = $blue_player_2_performance_rating_lose;

    // Calculate team game scores.
    $red_score_win = 24 * (1 - $red_team_performance_rating_win);
    $red_score_lose = 24 * (0 - $red_team_performance_rating_lose);
    $blue_score_win = 24 * (1 - $blue_team_performance_rating_win);
    $blue_score_lose = 24 * (0 - $blue_team_performance_rating_lose);

    // Calculate player game score.
    $red_player_1_game_score_win = round($red_score_win * $red_player_1_performance_rating_win);
    $red_player_2_game_score_win = round($red_score_win * $red_player_2_performance_rating_win);
    $red_player_1_game_score_lose = round($red_score_lose * $red_player_1_performance_rating_lose);
    $red_player_2_game_score_lose = round($red_score_lose * $red_player_2_performance_rating_lose);

    $blue_player_1_game_score_win = round($blue_score_win * $blue_player_1_performance_rating_win);
    $blue_player_2_game_score_win = round($blue_score_win * $blue_player_2_performance_rating_win);
    $blue_player_1_game_score_lose = round($blue_score_lose * $blue_player_1_performance_rating_lose);
    $blue_player_2_game_score_lose = round($blue_score_lose * $blue_player_2_performance_rating_lose);

    // Write actual team game score in array.
    // Unrounded team game score if found in $red_score and $blue_score.
    $game_info['red']['game_score_win'] = intval($red_player_1_game_score_win + $red_player_2_game_score_win);
    $game_info['red']['game_score_lose'] = intval($red_player_1_game_score_lose + $red_player_2_game_score_lose);
    $game_info['blue']['game_score_win'] = intval($blue_player_1_game_score_win + $blue_player_2_game_score_win);
    $game_info['blue']['game_score_lose'] = intval($blue_player_1_game_score_lose + $blue_player_2_game_score_lose);

    // Write players game score in array.
    // Red team.
    $game_info['red']['player_1']['game_score_win'] = intval($red_player_1_game_score_win);
    $game_info['red']['player_2']['game_score_win'] = intval($red_player_2_game_score_win);
    $game_info['red']['player_1']['game_score_lose'] = intval($red_player_1_game_score_lose);
    $game_info['red']['player_2']['game_score_lose'] = intval($red_player_2_game_score_lose);
    // Blue team.
    $game_info['blue']['player_1']['game_score_win'] = intval($blue_player_1_game_score_win);
    $game_info['blue']['player_2']['game_score_win'] = intval($blue_player_2_game_score_win);
    $game_info['blue']['player_1']['game_score_lose'] = intval($blue_player_1_game_score_lose);
    $game_info['blue']['player_2']['game_score_lose'] = intval($blue_player_2_game_score_lose);

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