(function ($) {
  Drupal.behaviors.owlcarouselblock = {
    attach: function () {
        /*var owl = $('.owl-carousel');
        owl.owlCarousel({
            loop:true,
            nav:true,
            margin:10,
            responsive:{
                0:{
                    items:1
                }
            }
        });
        owl.on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY>0) {
                owl.trigger('next.owl');
            } else {
                owl.trigger('prev.owl');
            }
            e.preventDefault();
        });*/
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:3,
            loop:true,
            margin:10,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true
        });
        $('.play').on('click',function(){
            owl.trigger('play.owl.autoplay',[1000])
        });
        $('.stop').on('click',function(){
            owl.trigger('stop.owl.autoplay')
        });
    }
  };
})(jQuery);