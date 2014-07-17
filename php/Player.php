<?php
/**
 * @file Player
 *
 * @author Lars Nielsen <lars@lndesign.dk>
 */

class Player {

  public $db;

  private function __contruct() {

    // Get PDO.
    include('pdo.php');
    // Establish database connetion.
    $db = DB::getDatabase('fussball');

    return $db;

  }

  public function getPlayers() {

    // Get PDO.
    include('pdo.php');
    // Establish database connetion.
    $db = DB::getDatabase('fussball');

    $players = array();

    // Get players match score from database.
    $players_query = "SELECT
                        player_id,
                        name,
                        player_score,
                        modified
                        FROM player";
    $statement = $db->prepare($players_query);
    $statement->execute();
    $players_rows = $statement->fetchAll();

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

    return $players;

  }

  public function getPlayersAsOptions($players_array) {

    $player_options = '';

    foreach($players_array as $player) {
      $player_options .= '<option value="' . $player['id'] . '">' . $player['name'] . ' (' . $player['score'] . ')</option>' . "\n";
    }

    return $player_options;

  }

}

?>