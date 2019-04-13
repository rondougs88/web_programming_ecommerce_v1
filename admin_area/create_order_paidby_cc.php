<?php
// if (isset($_POST['checkout-form'])) {
//     creating orde r...
// }
require_once "./includes/db.php";
require_once "../classes/order_details.php";
require_once "../functions/functions.php"; 
global $con;
// $user_type = e($_POST['user_type']);
$token_id = $_POST['token_id'];

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("sk_test_pftRMzMLYZ7Ea6PQiwSLdPEX002i7j0fQz");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];

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
$state_c  = $_POST['state'];
$zip      = $_POST['zip'];
// Shipping address details
$sh_fname    = $_POST['sh_firstName'];
$sh_lname    = $_POST['sh_lastName'];
// $sh_email    = $_POST['sh_email'];
$sh_address1 = $_POST['sh_address'];
$sh_address2 = $_POST['sh_address2'];
$sh_country  = $_POST['sh_country'];
$sh_state_c  = $_POST['sh_state'];
$sh_zip      = $_POST['sh_zip'];
$query = "INSERT INTO order_header (
                        username, 
                        fname, 
                        lname, 
                        email, 
                        phone, 
                        address1, 
                        address2, 
                        country, 
                        state_c, 
                        zip,
                        sh_fname,
                        sh_lname,
                        sh_address1,
                        sh_address2,
                        sh_country,
                        sh_state_c,
                        sh_zip
                        ) 
                  VALUES(
                  '$username', 
                  '$fname', 
                  '$lname', 
                  '$email', 
                  '$phone', 
                  '$address1', 
                  '$address2', 
                  '$country', 
                  '$state_c', 
                  '$zip',
                  '$sh_fname',
                  '$sh_lname',
                  '$sh_address1',
                  '$sh_address2',
                  '$sh_country',
                  '$sh_state_c',
                  '$sh_zip'
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
        $order_id,
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
