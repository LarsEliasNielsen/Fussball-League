<?php
/**
 * @file Player
 *
 * @author Lars Nielsen <lars@lndesign.dk>
 */

require_once('Core.php');

class Player {

  public $db;

  /**
   * Creating a new player.
   *
   * @param $player_name - Name of player as string.
   */
  public function createPlayer($player_name) {

    $new_player_query = "INSERT INTO player (name, modified) VALUES (:playerName, CURRENT_TIMESTAMP)";

    try {
      $core = Core::getInstance();
      $statement = $core->dbh->prepare($new_player_query);
      $statement->bindParam(':playerName', $player_name, PDO::PARAM_STR);

      if ($statement->execute()) {

        // echo '<div>New player [' . $player_name . '] was created.</div>';

      }
    } catch (PDOException $pe) {
      trigger_error('Could not connect to MySQL database: ' . $pe->getMessage() , E_USER_ERROR);
    }

  }

  /**
   * Update player information.
   *
   * @param $player_id - Player id from database.
   */
  public function updatePlayer($player_id) {}

  /**
   * Get player by id.
   *
   * @param $player_id - Player id from database.
   */
  public function getPlayer($player_id) {
    $player = array();
    $player_query = "SELECT player_id, name, player_score FROM player WHERE player_id = :playerId";

    try {
      $core = Core::getInstance();
      $statement = $core->dbh->prepare($player_query);
      $statement->bindParam(':playerId', $player_id, PDO::PARAM_INT);

      if ($statement->execute()) {
        $player_row = $statement->fetch();

        $this_player = array(
          'player_id' => $player_row['player_id'],
          'name' => $player_row['name'],
          'player_score' => $player_row['player_score']
        );

        $player[$player_id] = $this_player;
      }
    } catch (PDOException $pe) {
      trigger_error('Could not connect to MySQL database: ' . $pe->getMessage() , E_USER_ERROR);
    }

    return $player;
  }

  /**
   * Getting players from database as array.
   *
   * @return $players - Players as array.
   */
  public function getPlayers() {

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

        foreach($players_rows as $row) {

          // Get the player id.
          $player_id = intval($row['player_id']);

          $players[$player_id] = array(
            'player_id' => $player_id,
            'name' => $row['name'],
            'score' => $row['player_score']
          );
        }
      }
    } catch (PDOException $pe) {
      trigger_error('Could not connect to MySQL database: ' . $pe->getMessage() , E_USER_ERROR);
    }

    return $players;

  }

}

?>