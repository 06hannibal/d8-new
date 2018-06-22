(function($, Drupal)
{
    Drupal.behaviors.tab = {
        attach:function()
        {
            /*$(function() {
                console.log("JQUERY IS READY!");
            });*/
            $(document).ready(function() {
                $('.tabs .tab-links a').on('click', function(e) {
                    var currentAttrValue = $(this).attr('href');

                    // Show/Hide Tabs
                    $('.tabs ' + currentAttrValue).show().siblings().hide();

                    // Change/remove current tab to active
                    $(this).parent('li').addClass('active').siblings().removeClass('active');

                    e.preventDefault();
                });
            });

        }
    }

}(jQuery, Drupal));
