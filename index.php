<?php

  include('php/Player.php');

  $player = new Player;

  $players = $player->getPlayers();
  $player_options = $player->getPlayersAsOptions($players);

  // print_r($players);

?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register game</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/foundation.css">
    <style>
      * { margin: 0; padding: 0; }
      .columns { border: 1px solid gray; }
    </style>
  </head>

  <body>
    <h1>Register a game</h1>

    <div class="row">

      <div class="small-6 columns">
        <h3>Red</h3>
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

      <div class="small-6 columns">
        <h3>Blue</h3>
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

  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
  </body>
</html>