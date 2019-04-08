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

    // Call this only after creating an order or adding to cart.
    // update_cart_count();

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
        $('.loading').show();           // show loading spinner
        $('.json-overlay').show();      // disable screen
        var filtered_array = array_update_cart.filter(function (v) { return v !== '' });
        if (filtered_array.length > 0) {

            $.ajax({
                type: "POST",
                url: siteroot + "/updatecart.php",
                async: false,
                data: { update_cart: filtered_array },
                success: function (result) {
                    // Do stuff
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Cart Ajax Success: " + result);
                },
                error: function (request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    $('.loading').hide();
                    $('.json-overlay').hide();
                    alert("Update Cart Ajax Error: " + status + errorThrown);
                }
                // ,
                // complete: function () {
                //     $('.loading').hide();
                //     $('.json-overlay').hide();
                // }
            })
            // .done(function (msg) {
            //     alert("Data Saved: " + msg);
            // })
            // .success(function (result) {
            //     // Do stuff
            //     console.log("Update Cart Ajax Success: ", result);
            // }).error(function (request, status, errorThrown) {
            //         // There's been an error, do something with it!
            //         // Only use status and errorThrown.
            //         // Chances are request will not have anything in it.
            //         console.log("Update Cart Ajax Error: ", status, errorThrown);
            // });
        }
        else {
            alert("Nothing to update in this cart.");
            exit
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

    // Update the shopping cart badge.
    function update_cart_count() {
        $('.loading').show();           // show loading spinner
        $('.json-overlay').show();      // disable screen
        $.ajax({
            type: "POST",
            url: siteroot + "/get_cart_count.php",
            async: false,
            // data: { update_cart: filtered_array },
            success: function (count) {
                // Do stuff
                $('.loading').hide();
                $('.json-overlay').hide();
                $(".my-cart-badge").html(count);
            },
            error: function (request, status, errorThrown) {
                // There's been an error, do something with it!
                // Only use status and errorThrown.
                // Chances are request will not have anything in it.
                $('.loading').hide();
                $('.json-overlay').hide();
                alert("Update Cart Count Ajax Error: " + status + errorThrown);
            }

        });
    }
});

