<?php if (isset($_GET["order_number"])) : ?>
    <?php include_once "./db.php"; ?>
    <?php $pagetitle = "Order Confirmation"; ?>
    <?php include_once "../../header.php"; ?>
    <?php include_once "../../navigation.php"; ?> F
    <div class="container">
    <?php endif; ?>

    <div id="create-order" style="margin-top: 40px">
        <?php
        // if (isset($_POST['checkout-form'])) {
        //     creating orde r...
        // }
        if (!isset($_GET["order_number"])) {
            require_once "../classes/order_details.php";
            $order_details = create_order();
            $order_number = $order_details->getOrderid();
            if (!empty($order_number)) {
                $email_body = create_email_body($order_details);
                send_email($order_details, $email_body);
            }
        } else {
            $order_number = $_GET["order_number"];
        }
        ?>
        <div class="jumbotron text-xs-center">
            <h1 class="display-3">Thank You!</h1>
            <p class="lead">Your order placement is successful.</strong></p>
            <p class="lead">Reference number is <strong>GG-<?= $order_number ?></strong>.</p>
            <p class="lead"><strong>Please check your email</strong> for your order confirmation.</p>
            <hr>
            <p>
                Having trouble? <a href="<?= $siteroot ?>/contact_form.php">Contact us</a>
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-sm" href="<?= $siteroot ?>" role="button">Continue to homepage</a>
            </p>
        </div>
    </div>

    <?php if (isset($_GET["order_number"])) : ?>
    </div>
<?php endif; ?>

<?php include_once "../../footer.php"; ?>