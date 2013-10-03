$(document).ready(function(){
  $('.pagination ul').addClass('pagination');
});

$(window).bind('page:change', function() {
  $('.pagination ul').addClass('pagination');
});