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
    <link rel="stylesheet" href="css/fussball.main.css">
  </head>

  <body>
    <h1>Register a game</h1>

    <!-- Teams -->
    <div class="row">

      <!-- Red team -->
      <div class="small-6 columns red-team">
        <h3>Red</h3>
        <select id="red-player-1" class="player-select">
          <option value="">Select red player</option>
          <?php
            echo $player_options;
          ?>
        </select>
        <div id="red-player-1-data">
          <div class="player-image"></div>
          <div class="player-name"></div>
          <div class="game-score">
            <div class="win"></div>
            <div class="lose"></div>
          </div>
        </div>

        <select id="red-player-2" class="player-select">
          <option value="">Select red player</option>
          <?php
            echo $player_options;
          ?>
        </select>
        <div id="red-player-2-data">
          <div class="player-image"></div>
          <div class="player-name"></div>
          <div class="game-score">
            <div class="win"></div>
            <div class="lose"></div>
          </div>
        </div>
      </div>

      <!-- Blue team -->
      <div class="small-6 columns blue-team">
        <h3>Blue</h3>
        <select id="blue-player-1" class="player-select">
          <option value="">Select blue player</option>
          <?php
            echo $player_options;
          ?>
        </select>
        <div id="blue-player-1-data">
          <div class="player-image"></div>
          <div class="player-name"></div>
          <div class="game-score">
            <div class="win"></div>
            <div class="lose"></div>
          </div>
        </div>

        <select id="blue-player-2" class="player-select">
          <option value="">Select blue player</option>
          <?php
            echo $player_options;
          ?>
        </select>
        <div id="blue-player-2-data">
          <div class="player-image"></div>
          <div class="player-name"></div>
          <div class="game-score">
            <div class="win"></div>
            <div class="lose"></div>
          </div>
        </div>
      </div>

    </div>

    <!-- Win state -->
    <div class="row">

      <div class="small-6 columns">
        <input type="radio" name="win-state" value="Red" id="red-win-state"><label for="red-win-state">Red</label>
      </div>
      <div class="small-6 columns">
        <input type="radio" name="win-state" value="Blue" id="blue-win-state"><label for="blue-win-state">Blue</label>
      </div>

    </div>

    <div class="row">
      
    <div class="small-12 columns">
      <a href="#" id="submit-button" class="button expand">Submit game</a>
    </div>

    </div>

  <script src="js/vendor/jquery.js"></script>
  <script src="js/foundation.min.js"></script>
  <script src="js/fussball.jquery.js"></script>
  <script>
    $(document).foundation();
  </script>
  </body>
</html>