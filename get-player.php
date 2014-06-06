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
                      id,
                      name,
                      match_score,
                      modified
                      FROM player WHERE name = :playerName";
  $statement = $db->prepare($player_query);
  $statement->bindParam(':playerName', $player_name);
  $statement->execute();
  $row = $statement->fetch();

  $player = array();

  $player = array(
    'fetched' => time(),
    'player' => array(
      'id' => intval($row['id']),
      'name' => $row['name'],
      'match_score' => intval($row['match_score']),
      'modified' => strtotime($row['modified']),
    ),
  );

  // Print score.
  echo json_encode($player);

?>