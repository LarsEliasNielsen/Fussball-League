<?php

  include('php/Player.php');

  $player = new Player;

  $players = $player->getPlayers();
  $player_options = $player->getPlayersAsOptions($players);

  // print_r($players);

?>

<html>
  <head>
    <title>Register game</title>
  </head>

  <body>
    <h1>Register a game</h1>

    <div>
      <div id="red" class="team team-red">
        <select id="red-palyer-1">
          <option>Select red player</option>
          <?php
            echo $player_options;
          ?>
        </select>
        <select id="red-palyer-2">
          <option>Select red player</option>
          <?php
            echo $player_options;
          ?>
        </select>
      </div>
      <div id="blue" class="team team-blue">
        <select id="blue-palyer-1">
          <option>Select blue player</option>
          <?php
            echo $player_options;
          ?>
        </select>
        <select id="blue-palyer-2">
          <option>Select blue player</option>
          <?php
            echo $player_options;
          ?>
        </select>
      </div>
    </div>

  </body>
</html>