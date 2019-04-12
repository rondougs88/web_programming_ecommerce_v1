<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Checkout"; ?>
<?php include "../header.php"; ?>

<?php include "../navigation.php"; ?>

<div class="container">
    <?php
    if (cart_items_count() > 0) {
        include "./includes/checkout_form.php";
    } else {
        include "./includes/page_not_available.php";
    }
    ?>
</div>

<!-- Scripts for Stripe payment gateway -->
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    // var handler = StripeCheckout.configure({
    //     key: 'pk_test_bTvk82dYQkAekGQpYYp4J0il008fiA0MgB',
    //     image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
    //     locale: 'auto',
    //     token: function(token) {
    //         // You can access the token ID with `token.id`.
    //         // Get the token ID to your server-side code for use.
    //     }
    // });
    $(document).ready(function() {
        $('input[type="radio"]').click(function() {
            var rdbutton = $(this).val();
            if (rdbutton == "creditcard") {
                $("div.creditcardDetails").show();
            } else {
                $("div.creditcardDetails").hide();
            }
            // $("div.myDiv").hide();
            // $("#show" + demovalue).show();
        });
        // $('.place-order').click(function() {
        //     if ($('#credit').is(':checked')) {
        //         // Open Checkout with further options:
        //         handler.open({
        //             name: 'Demo Site',
        //             description: '2 widgets',
        //             currency: 'nzd',
        //             amount: 2000
        //         });
        //         e.preventDefault();
        //     }
        // });
        // // Close Checkout on page navigation:
        // // window.addEventListener('popstate', function() {
        // //     handler.close();
        // // });
    });
</script>

<?php include "../footer.php"; ?>

</html>