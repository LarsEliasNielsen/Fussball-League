<?php

  // Respond to JSON header.
  header('Content-Type: application/json');
  header('Cache-Control: no-cache');

  include('php/Game.php');

  $game_info = array(
    'red' => array(
      'player_1' => array(
        'id' => 1,
        'name' => 'larn',
        'score' => 1500
      ),
      'player_2' => array(
        'id' => 2,
        'name' => 'klan',
        'score' => 1600
      ),
      'win_state' => 1,
    ),
    'blue' => array(
      'player_1' => array(
        'id' => 3,
        'name' => 'kazi',
        'score' => 1580
      ),
      'player_2' => array(
        'id' => 4,
        'name' => 'jepf',
        'score' => 1600
      ),
      'win_state' => 0,
    )
  );

  $game = new Game();
  $calculated_game = $game->calculateGameAsJSON($game_info);

  echo $calculated_game;

?>