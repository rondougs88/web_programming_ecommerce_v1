jQuery(document).ready(function () {


    $('.loading').hide();
    $('.json-overlay').hide();

    $(window).on("beforeunload", function () {
        $('.loading').show();
        $('.json-overlay').show();
    });


    $(".list-group a").click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    });

    // $("#my-cart-badge").text(cart_count);
    $(".my-cart-badge").html(cart_count);

    // This part is for handling the shopping cart amount events.
    var array_update_cart = [];
    $(".cartqty").change(function () {
        var prod_id = $(this).attr("data-id");
        var newVal = $(this).val();
        // if it already exists, just update qty
        var exists = false;
        exists = array_update_cart.find(x => x.prod_id === prod_id);
        if (exists) {
            exists['qty'] = newVal;
        }
        else {
            array_update_cart.push({ 'prod_id': prod_id, 'qty': newVal, 'delete': false });
        }
    });

    // Update remote db via ajax php call for qty change - cart events.
    // $('#updatecart').click(function () {
    $('#updatecart').one('click', function () {
        var filtered_array = array_update_cart.filter(function (v) { return v !== '' });
        if (filtered_array.length > 0) {
            $.ajax({
                type: "POST",
                url: siteroot + "/updatecart.php",
                data: { update_cart: filtered_array }
            }).done(function (msg) {
                alert("Data Saved: " + msg);
            });
        }
        else {
            alert("Nothing to update in this cart.");
        }
        array_update_cart = [];
    });

    // Update remote db via ajax php call for deleting items - cart events.
    $(".delcartitem").click(function () {
        var prod_id = $(this).attr("data-id");
        // var prod_id = $(this).val();
        var idname = "#cart_" + prod_id;
        $(idname).empty();  // This will remove the item row from the cart.

        array_update_cart.push({ 'prod_id': prod_id, 'qty': '0', 'delete': true });
    });

    // Validate the checkout form
    $('#checkout-form').validate({
        rules: {
            firstName: {
                minlength: 2,
                required: true
            },
            lastName: {
                minlength: 2,
                required: true
            },
            // username: {
            //     required: true,
            //     username: true
            // },
            email: {
                required: true,
                email: true
            },
            address: {
                required: true,
            },
            country: {
                required: true,
            },
            state: {
                required: true,
            },
            zip: {
                required: true,
            },
            // message: {
            //     minlength: 2,
            //     required: true
            // }
        },
        highlight: function (element) {
            $(element)
            .closest('.form-group')
            // .siblings('input')
            .removeClass('alert alert-success')
            .addClass('alert alert-danger text-danger');
        },
        success: function (element) {
            element
            // .text('Ok!')
            // .removeClass('error')
            // .addClass('alert alert-success')
            .closest('.form-group')
            // .siblings('input')
            .removeClass('alert alert-danger text-danger')
            .addClass('alert alert-success');
        }
    });

});