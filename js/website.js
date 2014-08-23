$(document).ready(function(){

  $(function () {
    $.nette.init();
  });

  $(function() {
    $( "#tell-a-friend" ).dialog({
      autoOpen: false,
      width: '400px'
    });

    $( "#tell-a-friend-button" ).click(function() {
      $( "#tell-a-friend" ).dialog( "open" );
    });
  });

});
