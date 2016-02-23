/**
 * Created by khaled on 2/21/16.
 */
$(document).ready(function() {
  $('#map').usmap({
    stateStyles: {fill:'yellow'},
    click: function(event, data) {
      $('#clicked-state')
       .text('You clicked: '+data.name)
       .parent().effect('highlight', {color: '#C7F464'}, 2000);
    }
  });
  $(window).resize(function() {
    $('#map').children('svg').css('width', ($('.tbb-page').width() - 10)+"px");
    $('#map').children('svg').css('height', ($('.tbb-page').width() - 10)+"px");
  });
  $('#map').children('svg').css('width', ($('.tbb-page').width() - 10)+"px");
  $('#map').children('svg').css('height', ($('.tbb-page').width() - 10)+"px");

  var pullfollowers = function() {
    var jsonRequest = $.ajax({
      url: "/app/twitterconnect.php?callaction=followers",
      processData: false,
      dataType: "json"
    });
    jsonRequest.done(function(msg){

    });
  };
});