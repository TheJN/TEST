
jQuery(document).ready(function($) {
    var alterClass = function() {
      var ww = document.body.clientWidth;
      if (ww < 800) {
        $('.navigation').removeClass('show min-vh-100');
        $('.bi').addClass('fa-xs');
        $('.btn-outline-danger').addClass('btn-sm');
      } else if (ww >= 801) {
        $('.navigation').addClass('show min-vh-100');
        $('.bi').removeClass('fa-xs');
        $('.btn-outline-danger').removeClass('btn-sm');
      };
      if (ww > 801) {
        $('.navigation_page').addClass('show');
      } else if (ww <= 800) {
        $('.navigation_page').removeClass('show');
      };


    };
    $(window).resize(function(){
      alterClass();
    });
    //Fire it when the page first loads:
    alterClass();
  });


  