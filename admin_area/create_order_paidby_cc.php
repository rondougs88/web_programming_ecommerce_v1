<?php
// if (isset($_POST['checkout-form'])) {
//     creating orde r...
// }
require_once "./includes/db.php";
require_once "../classes/order_details.php";
require_once "../functions/functions.php";
require_once('../vendor/stripe-php/init.php');
global $con;
// $user_type = e($_POST['user_type']);
$token_id = $_POST['token_id'];

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_pftRMzMLYZ7Ea6PQiwSLdPEX002i7j0fQz");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['token_id'];

$charge = \Stripe\Charge::create([
    'amount' => 999,
    'currency' => 'usd',
    'description' => 'Example charge',
    'source' => $token,
]);

$username = $_POST['username'];
// Billing address details
$fname    = $_POST['firstName'];
$lname    = $_POST['lastName'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$address1 = $_POST['address'];
$address2 = $_POST['address2'];
$country  = $_POST['country'];
$state_c  = mysqli_real_escape_string($con, $_POST['state']);
$zip      = $_POST['zip'];
// Shipping address details
$sh_fname    = $_POST['sh_firstName'];
$sh_lname    = $_POST['sh_lastName'];
$sh_address1 = $_POST['sh_address'];
$sh_address2 = $_POST['sh_address2'];
$sh_country  = $_POST['sh_country'];
$sh_state_c  = mysqli_real_escape_string($con, $_POST['sh_state']);
$sh_zip      = $_POST['sh_zip'];
date_default_timezone_set('NZ');
$created_on = date("Y-m-d H:i:s");
$created_on = mysqli_real_escape_string($con, $created_on);
$query = "INSERT INTO order_header (status,created_on,username, payment, fname,lname,email, phone, address1, address2, country, state_c, zip,sh_fname,sh_lname,sh_address1,sh_address2,sh_country,sh_state_c,sh_zip) 
                  VALUES(
                  'Processing','$created_on','$username','Credit Card','$fname', '$lname', '$email', '$phone', '$address1', '$address2', '$country', '$state_c', '$zip','$sh_fname','$sh_lname','$sh_address1','$sh_address2','$sh_country','$sh_state_c','$sh_zip'
                  )";
mysqli_query($con, $query);
$order_id = mysqli_insert_id($con);
if (!empty($order_id)) {
    $order_details = new OrderDetails(
        $username,
        $fname,
        $lname,
        $email,
        $address1,
        $address2,
        $country,
        $state_c,
        $zip,
        $sh_fname,
        $sh_lname,
        $sh_address1,
        $sh_address2,
        $sh_country,
        $sh_state_c,
        $sh_zip,
        $order_id
    );
}
// $_SESSION['success']  = "New user successfully created!!";
// header("location: $siteroot/admin_area/create_user.php");

$uname = $_POST['username'];

$get_items = "SELECT * FROM cart INNER JOIN products ON cart.p_id = products.product_id WHERE cart.username = '$uname'";

$run_q = mysqli_query($con, $get_items);
while ($row_pro = mysqli_fetch_array($run_q)) {

    $pro_id = $row_pro['product_id'];
    $pro_qty = $row_pro['qty'];

    $query = "INSERT INTO order_items (order_id, p_id, qty)
                  VALUES('$order_id', '$pro_id', '$pro_qty')";
    mysqli_query($con, $query);

    // Update the inventory
    $query_stk = "SELECT * FROM products_inventory WHERE product_id = '$pro_id'";
    $prod_stock = mysqli_query($con, $query_stk);
    while ($row_pro_stk = mysqli_fetch_array($prod_stock)) {
        $new_qty = $row_pro_stk['qty'] - $pro_qty;
        $query_stk = "UPDATE products_inventory SET qty = $new_qty WHERE product_id = '$pro_id'";
        mysqli_query($con, $query_stk);
    }

    // Now, delete that item from the cart.
    $del_item = "DELETE FROM cart WHERE username = '$uname' AND p_id = '$pro_id'";
    mysqli_query($con, $del_item);
}


$order_number = $order_details->getOrderid();
if (!empty($order_number)) {
    $email_body = create_email_body($order_details);
    send_email($order_details, $email_body);
}
echo $order_number;
