jQuery(document).ready(function () {

    $(".list-group a").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

        $("#my-cart-badge").text(cart_count);


});