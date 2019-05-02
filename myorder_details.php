<?php include "./admin_area/includes/db.php"; ?>

<?php $pagetitle = "My Orders"; ?>
<?php include "header.php"; ?>

<?php include "navigation.php"; ?>
<?php
if (isset($_GET['order'])) {
    $orderid = $_GET['order'];

    global $con;
    $get_order = "SELECT order_items.*,
                                order_header.*,
                                products.*
                    FROM order_items
                            INNER JOIN order_header ON order_items.order_id = order_header.order_id
                            INNER JOIN products ON order_items.p_id = products.product_id WHERE order_header.order_id = '$orderid'";
    $run_q = mysqli_query($con, $get_order);
    while ($order = mysqli_fetch_array($run_q)) {
        $fname = $order['fname'];
        $lname = $order['lname'];
        $email = $order['email'];
        $phone = $order['phone'];
        $address1 = $order['address1'];
        $address2 = $order['address2'];
        $country = $order['country'];
        $state_c = $order['state_c'];
        $zip = $order['zip'];
        $sh_fname = $order['sh_fname'];
        $sh_lname = $order['sh_lname'];
        $sh_address1 = $order['sh_address1'];
        $sh_address2 = $order['sh_address2'];
        $sh_country = $order['sh_country'];
        $sh_state_c = $order['sh_state_c'];
        $sh_zip = $order['sh_zip'];
        $payment = $order['payment'];
        $items[] = $order;
    }
}
?>

<!-- Page Content -->
<div class="container">

    <!-- <div class="row justify-content-center"> -->
    <div class="py-5 text-center">
        <h2 style="margin-top:10px">Details for Order GG-<?= $orderid ?></h2>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Order items</span>
            </h4>
            <ul class="list-group mb-3">
                <!-- Display the cart items in this page. -->
                <?php
                global $total_price;
                for ($i = 0; $i < count($items); $i++) {
                    $pro_title = $items[$i]['product_title'];
                    $pro_price = $items[$i]['product_price'];
                    $pro_qty = $items[$i]['qty'];
                    $sub_total = $pro_qty * $pro_price;
                    $total_price += $pro_price * $pro_qty;
                    $pro_price = number_format($pro_price, 2); // Format this to have 2 decimal places.
                    $sub_total = number_format($sub_total, 2); // Format this to have 2 decimal places.
                    echo "<li class='list-group-item d-flex justify-content-between lh-condensed'>
                            <div>
                                <h6 class='my-0'>$pro_title</h6>
                                <small class='text-muted'>$pro_qty x $$pro_price</small>
                            </div>
                            <span class='text-muted'>$$sub_total</span>
                            </li>";
                }
                ?>

                <li class='list-group-item d-flex justify-content-between lh-condensed'>
                    <div>
                        <h6 class='my-0'>Shipping</h6>
                        <small class='text-muted'>Free Shipping</small>
                    </div>
                    <span class='text-muted'>$0.00</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total</span>
                    <strong>$<?= get_cart_total_price() ?></strong>
                </li>
            </ul>

        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" method="post" id="checkout-form" action="./create_order.php" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="firstName">First name</label>
                            <input disabled type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?=$fname?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="lastName">Last name</label>
                            <input disabled type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="<?=$lname?>">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input disabled type="email" class="form-control" name="email" id="email" value="<?=$email?>">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-group">
                        <label for="phone">Mobile number</label>
                        <input disabled type="tel" class="form-control" name="phone" id="phone" value="<?=$phone?>" placeholder="021 123 4567">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input disabled type="text" class="form-control" name="address" id="address" value="<?=$address1?>" placeholder="1234 Main St">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input disabled type="text" class="form-control" name="address2" id="address2" value="<?=$address2?>">
                </div>

                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input disabled type="text" class="form-control" name="country" id="country" value="<?=$country?>">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="state">State</label>
                            <input disabled type="text" class="form-control" name="state" id="state" value="<?=$state_c?>">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="zip">Zip</label>
                            <input disabled type="text" class="form-control" name="zip" id="zip" value="<?=$zip?>" placeholder="">
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="shipping-address">
                    <?php include "./admin_area/includes/shipping_address.details.php" ?>
                </div>
                <hr class="mb-4">

                <h4 class="mb-3">Shipping</h4>
                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="freeshipping" disabled name="shipping" type="radio" class="custom-control-input" value="freeshipping" checked>
                        <label class="custom-control-label" for="freeshipping">Free Shipping (NZ$ 0.00)</label>
                    </div>
                </div>

                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>
                <div class="d-block my-3">
                    <input type="text" disabled class="form-control" name="payment" id="payment" value="Paid via <?=$payment?>">
                </div>



            </form>
        </div>
        <!-- </div> -->

    </div>
</div>

<?php include "footer.php"; ?>

</html>