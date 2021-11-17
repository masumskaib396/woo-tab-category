(function($) {
    "use strict";

    /*------------------------------------------------------------------
    [Table of contents]

    THEPAW TESTIMONIAL SLIDER JS
    THEPAW SWIPER SLIDER JS

    -------------------------------------------------------------------*/

    /*--------------------------------------------------------------
    CUSTOM PRE DEFINE FUNCTION
    ------------------------------------------------------------*/
    /* is_exist() */
    jQuery.fn.is_exist = function(){
      return this.length;
    }


    var woo_category = function(){
        // Show the first tab and hide the rest
        $('.sakib-tabs-nav li:first-child').addClass('active');
        $('.sakib-tab-content').hide();
        $('.sakib-tab-content:first').show();

        // Click function
        $('.sakib-tabs-nav li').click(function(){
        $('.sakib-tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('.sakib-tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
            $(activeTab).fadeIn();
            return false;
        });


        $('.qbutton').on('click', function () {

            $(this).addClass('active').siblings().removeClass('active');


            let quantity = $(this).data('q');
            let price = $(this).data('price');
            var discount = 0;

            if (quantity == 6){
                discount = 20;
            }else if (quantity == 10){
                discount = 30;
            }

            let discount_amount = discount / 100;
            let mainprice = price - (price * discount_amount);
            let subtotaol = quantity * mainprice;



            $(this).parents('.sakib-tab-header').find('.cart_btn').attr('data-quantity',quantity);
            $(this).parents('.sakib-tab-header').find('.tprice').text(subtotaol);
            $(this).closest('.sakib-tab-header').find('.main-price').text(mainprice);


        });

    }

    $(window).on("load", function () {
        $('.sakib-tab-item').each(function() {
            var self = $(this);
            self.find('.button_quantity').find('.qbutton[data-q="10"]').addClass('active').trigger('click');
        })
    });



    $(window).on("elementor/frontend/init", function () {

        elementorFrontend.hooks.addAction("frontend/element_ready/sakib_category_tab.default", woo_category);
    });


})(jQuery);





