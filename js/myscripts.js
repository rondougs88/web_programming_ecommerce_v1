jQuery(document).ready(function () {

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
    $('#updatecart').click(function () {
        var filtered_array = array_update_cart.filter(function (v) { return v !== '' });
        if (filtered_array) {
            $.ajax({
                type: "POST",
                url: siteroot + "/updatecart.php",
                data: { update_cart: filtered_array }
            }).done(function (msg) {
                alert("Data Saved: " + msg);
            });
        }
        array_update_cart = [];
    });

    // Update remote db via ajax php call for deleting items - cart events.
    $(".delcartitem").click(function()  {
        var prod_id = $(this).attr("data-id");
        // var prod_id = $(this).val();
        var idname = "#cart_"+prod_id;
        $(idname).empty();  // This will remove the item row from the cart.

        array_update_cart.push({ 'prod_id': prod_id, 'qty': '0', 'delete': true });
    });

});