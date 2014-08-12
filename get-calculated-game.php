<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache, must-revalidate');

  include('php/Core.php');
  include('php/Game.php');

  // Get parameters.
  $red_player_1 = isset($_GET['red_player_1']) ? $_GET['red_player_1'] : '';
  $red_player_2 = isset($_GET['red_player_2']) ? $_GET['red_player_2'] : '';
  $blue_player_1 = isset($_GET['blue_player_1']) ? $_GET['blue_player_1'] : '';
  $blue_player_2 = isset($_GET['blue_player_2']) ? $_GET['blue_player_2'] : '';

  $player_query = "SELECT player_id, name, player_score
                    FROM player
                    WHERE name IN (:redPlayer1, :redPlayer2, :bluePlayer1, :bluePlayer2)
                    ORDER BY FIELD(name, :redPlayer1, :redPlayer2, :bluePlayer1, :bluePlayer2)";

  try {
    $core = Core::getInstance();
    $statement = $core->dbh->prepare($player_query);
    $statement->bindParam(':redPlayer1', $red_player_1, PDO::PARAM_STR);
    $statement->bindParam(':redPlayer2', $red_player_2, PDO::PARAM_STR);
    $statement->bindParam(':bluePlayer1', $blue_player_1, PDO::PARAM_STR);
    $statement->bindParam(':bluePlayer2', $blue_player_2, PDO::PARAM_STR);

    if ($statement->execute()) {

      $player_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

      $game_info = array(
        'red' => array(
          'player_1' => array(
            'id' => $player_rows[0]['player_id'],
            'name' => $player_rows[0]['name'],
            'score' => intval($player_rows[0]['player_score'])
          ),
          'player_2' => array(
            'id' => $player_rows[1]['player_id'],
            'name' => $player_rows[1]['name'],
            'score' => intval($player_rows[1]['player_score'])
          ),
        ),
        'blue' => array(
          'player_1' => array(
            'id' => $player_rows[2]['player_id'],
            'name' => $player_rows[2]['name'],
            'score' => intval($player_rows[2]['player_score'])
          ),
          'player_2' => array(
            'id' => $player_rows[3]['player_id'],
            'name' => $player_rows[3]['name'],
            'score' => intval($player_rows[3]['player_score'])
          )
        )
      );

      $game = new Game();
      $calculated_game = $game->calculateGameAsJSON($game_info);

      echo $calculated_game;

    }
  } catch (PDOException $pe) {
    trigger_error('Could not connect to MySQL database: ' . $pe->getMessage() , E_USER_ERROR);
  }

?>
