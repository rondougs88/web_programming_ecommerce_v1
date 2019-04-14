<script src="https://checkout.stripe.com/checkout.js"></script>
<!-- <script src="../js/credit_card.js"></script> -->
<script>
    // $(document).ready(function() {
    // $('.loading').show(); // show loading spinner
    // $('.json-overlay').show(); // disable screen
    // alert("loading...");
    // }
    var success = false;
    var handler = StripeCheckout.configure({
        key: 'pk_test_bTvk82dYQkAekGQpYYp4J0il008fiA0MgB',
        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
        locale: 'auto',
        closed: function() {
            $('.loading').hide(); // show loading spinner
            $('.json-overlay').hide(); // disable screen
            if (!success) {
                window.location.href = '<?= $siteroot ?>';
            }
        },
        token: function(token) {
            // You can access the token ID with `token.id`.
            // Get the token ID to your server-side code for use.
            handler.close();

            $.ajax({
                type: "POST",
                url: siteroot + "/admin_area/create_order_paidby_cc.php",
                async: false,
                data: {
                    token_id: token.id,
                    username: "<?= $_SESSION["user"]["username"] ?>",
                    firstName: "<?= $_POST["firstName"] ?>",
                    lastName: "<?= $_POST["lastName"] ?>",
                    email: "<?= $_POST["email"] ?>",
                    phone: "<?= $_POST["phone"] ?>",
                    address: "<?= $_POST["address"] ?>",
                    address2: "<?= $_POST["address2"] ?>",
                    country: "<?= $_POST["country"] ?>",
                    state: "<?= $_POST["state"] ?>",
                    zip: "<?= $_POST["zip"] ?>",
                    sh_firstName: "<?= $_POST["sh_firstName"] ?>",
                    sh_lastName: "<?= $_POST["sh_lastName"] ?>",
                    sh_address: "<?= $_POST["sh_address"] ?>",
                    sh_address2: "<?= $_POST["sh_address2"] ?>",
                    sh_country: "<?= $_POST["sh_country"] ?>",
                    sh_state: "<?= $_POST["sh_state"] ?>",
                    sh_zip: "<?= $_POST["sh_zip"] ?>"
                },
                success: function(result) {
                    // alert(result);
                    $('.loading').hide(); // show loading spinner
                    $('.json-overlay').hide(); // disable screen
                    // Do stuff
                    // $('.loading').hide();
                    // $('.json-overlay').hide();
                    alert("Credit card payment has been processed.");
                    success = true;
                    window.location.href = '<?= $siteroot ?>' + "/admin_area/includes/order_created.php?order_number=" + result;
                },
                error: function(request, status, errorThrown) {
                    // There's been an error, do something with it!
                    // Only use status and errorThrown.
                    // Chances are request will not have anything in it.
                    // $('.loading').hide();
                    // $('.json-overlay').hide();
                    // alert("Update Cart Ajax Error: " + status + errorThrown);
                }
            });
        }
    });
    // Open Checkout with further options:
    handler.open({
        name: 'Geek Gadget',
        description: 'Pay using your credit card.',
        currency: 'nzd',
        amount: parseFloat('<?= get_cart_total_price(false) ?>' + '00').toFixed(2)
    });
</script>