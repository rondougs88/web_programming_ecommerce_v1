<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Shopping Cart"; ?>
<?php include "../header.php"; ?>

<!-- Save the form values from checkout page. -->
<?php
$_SESSION['firstName'] = isset($_POST['firstName']) ? $_POST['firstName'] : "";
$_SESSION['lastName'] = isset($_POST['lastName']) ? $_POST['lastName'] : "";
$_SESSION['email'] = isset($_POST['email']) ? $_POST['email'] : "";
$_SESSION['phone'] = isset($_POST['phone']) ? $_POST['phone'] : "";
$_SESSION['address'] = isset($_POST['address']) ? $_POST['address'] : "";
$_SESSION['country'] = isset($_POST['country']) ? $_POST['country'] : "";
$_SESSION['state'] = isset($_POST['state']) ? $_POST['state'] : "";
$_SESSION['zip'] = isset($_POST['zip']) ? $_POST['zip'] : "";
?>

<script type="text/javascript">
    $(document).ready(function() {
                $(".my-cart-badge").html(""); // This will reset the cart badge to none.
    });
</script>

<?php include "../navigation.php"; ?>

<div class="container">
    <div id="create-order" style="margin-top: 40px">
        <?php
        // if (isset($_POST['checkout-form'])) {
        //     creating orde r...
        // }
        $order_details = create_order();
        $order_number = $order_details->getOrderid();
        if (!empty($order_number)) {
            $email_body = create_email_body($order_details);
            send_email($order_details, $email_body);
        }
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