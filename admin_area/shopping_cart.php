<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Shopping Cart"; ?>
<?php include "../header.php"; ?>

<!-- Custom styles for this template -->
<link href="../css/cart.css" rel="stylesheet">

<!-- FA javascript for this page -->
<script src="https://use.fontawesome.com/c560c025cf.js"></script>

<!-- Pass this php variable to the main js file included in the footer. -->
<script>
    var siteroot = "<?= $siteroot ?>";
</script>

<?php include "../navigation.php"; ?>

<div class="container">
    <div class="card shopping-cart">
        <div class="card-header bg-dark text-light">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            Shopping cart
            <a href="<?= $siteroot . "/index.php" ?>" class="btn btn-outline-info btn-sm pull-right">Continue shopping</a>
            <div class="clearfix"></div>
        </div>
        <div class="card-body">
            <!-- Get all cart items from db. -->
            <?php display_shopping_cart_items(); ?>

            <div class="pull-right">
                <a href="" class="btn btn-outline-secondary pull-right" id="updatecart">
                    Update shopping cart
                </a>
            </div>
        </div>
        <div class="card-footer">
            <div class="pull-right" style="margin: 10px">
                <a href="<?= $siteroot ?>/admin_area/checkout.php" class="btn btn-success pull-right" role="button">Checkout</a>
                <div class="pull-right" style="margin: 5px">
                    Total price: <b>$ <?= get_cart_total_price() ?></b>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

</html>