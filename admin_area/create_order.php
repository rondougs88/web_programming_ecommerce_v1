<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Order Confirmation"; ?>
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

<?php $paymentmethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : ""; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".my-cart-badge").html(""); // This will reset the cart badge to none.
        <?php if ($paymentmethod === "creditcard") : ?>
            $('.loading').show(); // show loading spinner
            $('.json-overlay').show(); // disable screen
        <?php endif; ?>
    });
</script>

<?php include "../navigation.php"; ?>

<div class="container">
    <?php
    $cart_count = cart_items_count() == "" ? "0" : cart_items_count();
    if ($cart_count === "0") :
        include "./includes/page_not_available.php";
    elseif ([isset($_POST['create-order'])] && $paymentmethod !== "creditcard") : ?>
        <?php
        include "./includes/order_created.php";
        ?>
    <?php elseif ($paymentmethod === "creditcard") : ?>
        <?php include "./includes/charge_credit_card.php"; ?>
    <?php endif; ?>
</div>

<?php include "../footer.php"; ?>

</html>