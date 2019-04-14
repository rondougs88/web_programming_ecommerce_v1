<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Checkout"; ?>
<?php $checkout_login = true; ?>
<?php include "../header.php"; ?>

<?php include "../navigation.php"; ?>

<div class="container">
    <?php if (!isLoggedIn()) : ?>
        <div class="row justify-content-center">
            <div class="col col-md-8" style="margin-top: 40px">
                <h1>Login/Register</h1>
                <h5><span class='text-muted'>An account is needed before you can proceed to checkout.</span></h5>
                <?php include "./includes/login_form.php"; ?>
            </div>
        </div>
    <?php elseif (cart_items_count() > 0) : ?>
        <?php include "./includes/checkout_form.php"; ?>
    <?php else : ?>
        <?php include "./includes/page_not_available.php"; ?>
    <?php endif; ?>
</div>

<!-- Scripts for Stripe payment gateway -->
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
    $(document).ready(function() {
        $("div.cod").hide();
        $('input[type="radio"]').click(function() {
            var rdbutton = $(this).val();
            if (rdbutton == "creditcard") {
                $("div.creditcardDetails").show();
                $("div.cod").hide();
            } else {
                $("div.cod").show();
                $("div.creditcardDetails").hide();
            }
        });
    });
</script>

<?php include "../footer.php"; ?>

</html>