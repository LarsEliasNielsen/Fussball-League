<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache');

  require_once('php/Core.php');

  // Get parameters.
  $player_name = isset($_GET['name']) ? $_GET['name'] : '';

  // Get players match score from database.
  $player_query = "SELECT
                      player_id,
                      name,
                      player_score,
                      modified
                      FROM player WHERE name = :playerName";

  try {
    $core = Core::getInstance();
    $statement = $core->dbh->prepare($player_query);
    $statement->bindParam(':playerName', $player_name, PDO::PARAM_STR);

    if ($statement->execute()) {

      $player_row = $statement->fetch(PDO::FETCH_ASSOC);

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

    }
  } catch (PDOException $pe) {
    trigger_error('Could not connect to MySQL database: ' . $pe->getMessage() , E_USER_ERROR);
  }

?>