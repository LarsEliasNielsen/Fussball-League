<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache');

  // Get PDO.
  include('php/pdo.php');
  // Establish database connetion.
  $db = DB::getDatabase('fussball');

  // Get parameters.
  $game_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

  // Get game data from database.
  $game_query = "SELECT game.game_id, game.winner_team, game.timestamp, player_game.player_id, player_game.team, player_game.game_id, player.name, player.player_score
    FROM game
    LEFT JOIN player_game
    ON game.game_id = player_game.game_id
    LEFT JOIN player
    ON player_game.player_id = player.player_id
    WHERE game.game_id = :gameId";
  $statement = $db->prepare($game_query);
  $statement->bindParam(':gameId', $game_id);
  $statement->execute();
  $rows = $statement->fetchAll();

  // Output structure.
  $game = array(
    'fetched' => null,
    'game' => array(
      'id' => null,
      'team' => array(
        'red' => array(),
        'blue' => array(),
      ),
      'winner_team' => null,
      'timestamp' => null
    )
  );

  // Go through each joined row.
  foreach($rows as $row) {
    $game['fetched'] = time();
    $game['game']['id'] = intval($row['game_id']);
    $game['game']['winner_team'] = $row['winner_team'];
    $game['game']['timestamp'] = strtotime($row['timestamp']);

    $player = array(
      'id' => intval($row['player_id']),
      'name' => $row['name'],
      'score' => intval($row['player_score'])
    );

    if ($row['team'] == 'red') {
      array_push($game['game']['team']['red'], $player);
    } else {
      array_push($game['game']['team']['blue'], $player);
    }
  }

  // Print score.
  echo json_encode($game);

?>