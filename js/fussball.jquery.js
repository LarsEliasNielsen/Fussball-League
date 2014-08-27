(function($) {

  // Global variables.
  var redPlayerOne = 0;
  var redPlayerTwo = 0;
  var bluePlayerOne = 0;
  var bluePlayerTwo = 0;

  // Disable selected players from options.
  $('#red-player-1').change(function() {
    var thisVal = parseInt($(this).val());
    $('.player-select option[value='+redPlayerOne+']').attr('disabled', false);
    $('.player-select option[value='+thisVal+']').attr('disabled', true);
    redPlayerOne = thisVal;
  });
  $('#red-player-2').change(function() {
    var thisVal = parseInt($(this).val());
    $('.player-select option[value='+redPlayerTwo+']').attr('disabled', false);
    $('.player-select option[value='+thisVal+']').attr('disabled', true);
    redPlayerTwo = thisVal;
  });
  $('#blue-player-1').change(function() {
    var thisVal = parseInt($(this).val());
    $('.player-select option[value='+bluePlayerOne+']').attr('disabled', false);
    $('.player-select option[value='+thisVal+']').attr('disabled', true);
    bluePlayerOne = thisVal;
  });
  $('#blue-player-2').change(function() {
    var thisVal = parseInt($(this).val());
    $('.player-select option[value='+bluePlayerTwo+']').attr('disabled', false);
    $('.player-select option[value='+thisVal+']').attr('disabled', true);
    bluePlayerTwo = thisVal;
  });

  
  $('.player-select').change(function() {

    // Check that players are selected.
    if ($('#red-player-1 option:selected').val().length > 0 && 
        $('#red-player-2 option:selected').val().length > 0 &&
        $('#blue-player-1 option:selected').val().length > 0 &&
        $('#blue-player-2 option:selected').val().length > 0) {

      $.ajax({
        type: 'get',
        url: 'get-calculated-game.php',
        data: {
          red_player_1: $('#red-player-1 option:selected').text(),
          red_player_2: $('#red-player-2 option:selected').text(),
          blue_player_1: $('#blue-player-1 option:selected').text(),
          blue_player_2: $('#blue-player-2 option:selected').text()
        },
        beforeSend: function(xhr) {
          $('.player-select').hide();
          $('#red-player-1-data, #red-player-2-data, #blue-player-1-data, #blue-player-2-data').show();
        }
      }).done(function(data) {

        console.log(data);

        // $('#red-player-1-data .player-image').append('<img src="http://lorempixel.com/100/100/people/1/" />');
        $('#red-player-1-data .player-name').text(data.red.player_1.name);
        $('#red-player-1-data .game-score .win').text(data.red.player_1.game_score_win + ' points if you win.');
        $('#red-player-1-data .game-score .lose').text(data.red.player_1.game_score_lose + ' points if you lose.');

        // $('#red-player-2-data .player-image').append('<img src="http://lorempixel.com/100/100/people/2/" />');
        $('#red-player-2-data .player-name').text(data.red.player_2.name);
        $('#red-player-2-data .game-score .win').text(data.red.player_2.game_score_win + ' points if you win.');
        $('#red-player-2-data .game-score .lose').text(data.red.player_2.game_score_lose + ' points if you lose.');

        // $('#blue-player-1-data .player-image').append('<img src="http://lorempixel.com/100/100/people/3/" />');
        $('#blue-player-1-data .player-name').text(data.blue.player_1.name);
        $('#blue-player-1-data .game-score .win').text(data.blue.player_1.game_score_win + ' points if you win.');
        $('#blue-player-1-data .game-score .lose').text(data.blue.player_1.game_score_lose + ' points if you lose.');

        // $('#blue-player-2-data .player-image').append('<img src="http://lorempixel.com/100/100/people/4/" />');
        $('#blue-player-2-data .player-name').text(data.blue.player_2.name);
        $('#blue-player-2-data .game-score .win').text(data.blue.player_2.game_score_win + ' points if you win.');
        $('#blue-player-2-data .game-score .lose').text(data.blue.player_2.game_score_lose + ' points if you lose.');

      });
    }

    // if ($('#red-player-1 option:selected').val().length > 0 && 
    //     $('#red-player-2 option:selected').val().length > 0 &&
    //     $('#blue-player-1 option:selected').val().length > 0 &&
    //     $('#blue-player-2 option:selected').val().length > 0 &&
    //     $('input[name=win-state]:checked').val()) {
    //   $('#submit-button').removeClass('disabled');
    // }
  });

  $('#submit-button').click(function() {

    console.log('Clicked');

  });

})(jQuery);