(function($, Drupal)
{
    Drupal.behaviors.searchResults = {
        attach:function()
        {
            /*setTimeout(function() {
                $(function () {
                    $('.level1').click(function(event){
                        event.preventDefault();
                        $(this).children('ul.level2').toggleClass("active");
                    });
                });
                }, 2000);*/
            setTimeout(function() {
            $('.level1').on('click', function (event) {
                event.preventDefault();
                $(this).children('.level2').toggle();
            });

            $('.level2').on('click', function (event) {
                event.stopPropagation();
            });
            }, 2000)


            setTimeout(function() {
            $(function() {
                $('.level22').click(function(event) {
                    event.preventDefault();
                    $(this).children('ul.level3').toggleClass("active")

                });
            }, 2000);
            });

        }
    }
}(jQuery, Drupal));

