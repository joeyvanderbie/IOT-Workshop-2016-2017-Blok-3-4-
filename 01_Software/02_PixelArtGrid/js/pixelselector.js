for (var i = 1; i <=36; i++) {
  $('#'+i).hover(function() {
    $( this ).addClass( 'pixel-hover' );
  }, function() {
    $( this ).removeClass( 'pixel-hover');
  });
}

