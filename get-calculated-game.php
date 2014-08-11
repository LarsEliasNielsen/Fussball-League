<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache');

  include('php/Game.php');

  $game_info = array(
    'red' => array(
      '1' => array(
        'id' => 1,
        'name' => 'larn',
        'score' => 1500
      ),
      '2' => array(
        'id' => 2,
        'name' => 'klan',
        'score' => 1600
      ),
    ),
    'blue' => array(
      '1' => array(
        'id' => 3,
        'name' => 'kazi',
        'score' => 1580
      ),
      '2' => array(
        'id' => 4,
        'name' => 'jepf',
        'score' => 1600
      ),
    ),
    'winner_team' => 'red'
  );

  $game = new Game();
  $calculated_game = $game->calculateGameAsJSON($game_info);

  echo $calculated_game;

?>