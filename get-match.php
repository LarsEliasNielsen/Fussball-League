<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache');

  // Get PDO.
  include('php/pdo.php');
  // Establish database connetion.
  $db = DB::getDatabase('fussball');

  // Get parameters.
  $game_id = isset($_GET['id']) ? $_GET['id'] : 0;

  // Get game data from database.
  $game_query = "SELECT
                      game_id,
                      winner_team,
                      timestamp
                      FROM game WHERE game_id = :gameId";
  $statement = $db->prepare($game_query);
  $statement->bindParam(':gameId', $game_id);
  $statement->execute();
  $game_row = $statement->fetch();

  $game = array();

  $game = array(
    'fetched' => time(),
    'game' => array(
      'id' => intval($game_row['game_id']),
      'team' => array(
        'red' => array(),
        'blue' => array(),
      ),
      'winner_team' => $game_row['winner_team'],
      'timestamp' => strtotime($game_row['timestamp']),
    ),
  );

  // Get player data from database,
  $player_game = "SELECT
                      player,
                      team
                      FROM player_game WHERE game = :gameId";
  $statement = $db->prepare($player_game);
  $statement->bindParam(':gameId', $game_id);
  $statement->execute();
  $player_game_rows = $statement->fetchAll();

  foreach($player_game_rows as $row) {
    $team = $row['team'];

    $player = array(
      'id' => intval($row['player'])
    );

    if ($team == 'red') {
      array_push($game['game']['team']['red'], $player);
    } else {
      array_push($game['game']['team']['blue'], $player);
    }
  }

  // Print score.
  echo json_encode($game);

?>