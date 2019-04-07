<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Shopping Cart"; ?>
<?php include "../header.php"; ?>

<?php include "../navigation.php"; ?>

<div class="container">
    <div id="create-order" style="margin-top: 40px">
        <?php
        // if (isset($_POST['checkout-form'])) {
        //     creating orde r...
        // }
        $order_number = create_order();
        ?>
        <div class="jumbotron text-xs-center">
            <h1 class="display-3">Thank You!</h1>
            <p class="lead">Your order placement is successful.</strong></p>
            <p class="lead">Reference number is <strong>GG-<?= $order_number ?></strong>.</p>
            <p class="lead"><strong>Please check your email</strong> for further instructions on how to complete your account setup.</p>
            <hr>
            <p>
                Having trouble? <a href="">Contact us</a>
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-sm" href="https://bootstrapcreative.com/" role="button">Continue to homepage</a>
            </p>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

</html>