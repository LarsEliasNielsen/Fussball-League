<?php
/**
 * @file Player
 *
 * @author Lars Nielsen <lars@lndesign.dk>
 */

class Player {

  public $db;

  public function __construct() {

    // Constructor.
    require_once('Core.php');

  }

  /**
   * Creating a new player.
   *
   * @param $player_name - Name of player as string.
   */
  public function createPlayer($player_name) {}

  /**
   * Update player information.
   *
   * @param $player_id - Player id from database.
   */
  public function updatePlayer($player_id) {}

  /**
   * Getting players from database as array.
   *
   * @return $players - Players as array.
   */
  private function getPlayers() {

    $players = array();
    // Query for getting all players.
    $players_query = "SELECT
                        player_id,
                        name,
                        player_score,
                        modified
                        FROM player";

    try {
      $core = Core::getInstance();
      $statement = $core->dbh->prepare($players_query);

      if ($statement->execute()) {

        $players_rows = $statement->fetchAll();
        // blablabla....
        foreach($players_rows as $row) {

          // Get the player id.
          $player_id = intval($row['player_id']);

          // Create player array.
          $player = array(
            'id' => $player_id,
            'name' => $row['name'],
            'score' => $row['player_score']
          );

          // Add player to array of players.
          $players[$player_id] = $player;
        }
      }
    } catch (PDOException $pe) {
      trigger_error('Could not connect to MySQL database. ' . $pe->getMessage() , E_USER_ERROR);
    }

    return $players;

  }

  /**
   * Getting players as options (select input).
   *
   * @param $players_array - Players as array from getPlayers().
   * @return $player_options - Player options as string.
   */
  public function getPlayersAsOptions($players_array) {

    $player_options = '';

    foreach($players_array as $player) {
      $player_options .= '<option value="' . $player['id'] . '">' . $player['name'] . ' (' . $player['score'] . ')</option>' . "\n";
    }

    return $player_options;

  }

}

?>