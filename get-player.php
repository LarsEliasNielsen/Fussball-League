<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache');

  // Get PDO.
  include('php/pdo.php');
  // Establish database connetion.
  $db = DB::getDatabase('fussball');

  // Get parameters.
  $player_name = isset($_GET['name']) ? $_GET['name'] : '';

  // Get players match score from database.
  $player_query = "SELECT
                      player_id,
                      name,
                      player_score,
                      modified
                      FROM player WHERE name = :playerName";
  $statement = $db->prepare($player_query);
  $statement->bindParam(':playerName', $player_name);
  $statement->execute();
  $player_row = $statement->fetch();

  $player = array();

  $player = array(
    'fetched' => time(),
    'player' => array(
      'id' => intval($player_row['player_id']),
      'name' => $player_row['name'],
      'match_score' => intval($player_row['player_score']),
      'modified' => strtotime($player_row['modified']),
    ),
  );

  // Print score.
  echo json_encode($player);

?>