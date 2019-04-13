<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// variable declaration
$username = "";
$email    = "";
$errors   = array();

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ./index.php");
}

if (isset($_POST['login_btn'])) {
    login();
}

// Get the total items to be displayed for the cart
$cart_count = cart_items_count();

// LOGIN USER
function login()
{
    global $con, $username, $errors, $siteroot;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // make sure form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($con, $query);

        if (mysqli_num_rows($results) == 1) { // user found
            // check if user is admin or user
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['user_type'] == 'admin') {

                $_SESSION['user'] = $logged_in_user;
                $uname = $_SESSION['user']['username'];
                $_SESSION['success']  = "You are now logged in as $uname.";
                header("location: $siteroot/index.php");
            } else {
                $_SESSION['user'] = $logged_in_user;
                $uname = $_SESSION['user']['username'];
                $_SESSION['success']  = "You are now logged in as $uname.";

                header("location: $siteroot/index.php");
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

// REGISTER USER
function register()
{
    // call these variables with the global keyword to make them available in function
    global $con, $errors, $username, $email, $siteroot;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        if (isset($_POST['user_type'])) {
            $user_type = e($_POST['user_type']);
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
            mysqli_query($con, $query);
            $_SESSION['success']  = "New user successfully created!!";
            header("location: $siteroot/admin_area/create_user.php");
        } else {
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
            mysqli_query($con, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($con);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $un = $_SESSION['user']['username'];
            $_SESSION['success']  = "You are now logged in as $un.";
            header("location: $siteroot/index.php");
        }
    }
}

// return user array from their id
function getUserById($id)
{
    global $con;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($con, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// escape string
function e($val)
{
    global $con;
    return mysqli_real_escape_string($con, trim($val));
}

function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

function getPro()
{

    if (isset($_GET['pro_id'])) {

        $pro_id = $_GET['pro_id'];

        global $con, $siteroot;

        $get_pro = "select * from products where product_id = $pro_id";

        $run_pro = mysqli_query($con, $get_pro);

        while ($row_pro = mysqli_fetch_array($run_pro)) {

            $pro_id = $row_pro['product_id'];
            $pro_cat = $row_pro['product_cat'];
            $pro_brand = $row_pro['product_brand'];
            $pro_title = $row_pro['product_title'];
            $pro_price = $row_pro['product_price'];
            $pro_image = $row_pro['product_image'];
            $pro_desc = $row_pro['product_desc'];
            $self_page = $_SERVER['PHP_SELF'];

            echo "
                
            <div class='container'>
            <div class='card'>
            <div class='container-fliud'>
                <div class='wrapper row'>
                    <div class='preview col-md-6'>

                        <div class='preview-pic tab-content'>
                            <div class='tab-pane active' id='pic-1'><img src='$siteroot/admin_area/uploads/product_images/$pro_image' /></div>
                            <div class='tab-pane' id='pic-2'><img src='http://placekitten.com/400/252' /></div>
                            <div class='tab-pane' id='pic-3'><img src='http://placekitten.com/400/252' /></div>
                            <div class='tab-pane' id='pic-4'><img src='http://placekitten.com/400/252' /></div>
                            <div class='tab-pane' id='pic-5'><img src='http://placekitten.com/400/252' /></div>
                        </div>
                        <ul class='preview-thumbnail nav nav-tabs'>
                            <li class='active'><a data-target='#pic-1' data-toggle='tab'><img src='http://placekitten.com/200/126' /></a></li>
                            <li><a data-target='#pic-2' data-toggle='tab'><img src='http://placekitten.com/200/126' /></a></li>
                            <li><a data-target='#pic-3' data-toggle='tab'><img src='http://placekitten.com/200/126' /></a></li>
                            <li><a data-target='#pic-4' data-toggle='tab'><img src='http://placekitten.com/200/126' /></a></li>
                            <li><a data-target='#pic-5' data-toggle='tab'><img src='http://placekitten.com/200/126' /></a></li>
                        </ul>

                    </div>
                    <div class='details col-md-6'>
                        <h3 class='product-title'>$pro_title</h3>
                        <div class='rating'>
                            <div class='stars'>
                                <span class='fa fa-star checked'></span>
                                <span class='fa fa-star checked'></span>
                                <span class='fa fa-star checked'></span>
                                <span class='fa fa-star'></span>
                                <span class='fa fa-star'></span>
                            </div>
                            <span class='review-no'>41 reviews</span>
                        </div>
                        <p class='product-description'>$pro_desc</p>
                        <h4 class='price'>current price: <span>$$pro_price</span></h4>
                        <p class='vote'><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
                        
                        <div class='action'>
                            <button class='add-to-cart btn btn-default my-cart-btn' 
                            type='button'><a href='$self_page?pro_id=$pro_id&add_cart=$pro_id' style='color:white'>add to cart</button>
                            <button class='like btn btn-default' type='button'><span class='fa fa-heart'></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
		
		
		";
        }
    }
}

// getting the user IP address
function getIp()
{
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

//creating the shopping cart
function cart()
{

    if (isset($_GET['add_cart'])) {

        global $con;

        $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();

        $pro_id = $_GET['add_cart'];

        $check_pro = "select * from cart where username='$uname' AND p_id='$pro_id'";

        $run_check = mysqli_query($con, $check_pro);

        if (mysqli_num_rows($run_check) > 0) {

            echo "<script>alert('Product not added - already in the cart!')</script>";
        } else {

            $insert_pro = "INSERT INTO cart (username, p_id, qty) VALUES('$uname', '$pro_id', '1')";

            mysqli_query($con, $insert_pro);

            echo "<script>alert('Product has been added to cart!')</script>";
        }
    }
}

//Get items count for cart
function cart_items_count()
{
    global $con;

    $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();

    $get_count = "select sum(qty) from cart where username='$uname'";

    $run_q = mysqli_query($con, $get_count);
    // $data = mysqli_fetch_assoc($run_q);
    $data = mysqli_fetch_assoc($run_q);
    $count = $data['sum(qty)'];

    return $count > 0 ? $count : "";
}

//Get cart items for the user
function display_shopping_cart_items()
{
    global $con, $siteroot, $total_price;

    $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();

    $get_items = "SELECT * FROM cart INNER JOIN products ON cart.p_id = products.product_id WHERE cart.username = '$uname'";

    $run_q = mysqli_query($con, $get_items);

    if (mysqli_num_rows($run_q) > 0) {
        while ($row_pro = mysqli_fetch_array($run_q)) {

            $pro_id = $row_pro['product_id'];
            $pro_image = $row_pro['product_image'];
            $pro_title = $row_pro['product_title'];
            $pro_desc = $row_pro['product_desc'];
            $pro_price = $row_pro['product_price'];
            $pro_qty = $row_pro['qty'];
            $total_price += $pro_price * $pro_qty;
            $pro_price_formatted = number_format($pro_price, 2); // Format this to have 2 decimal places.

            echo "
        <div class='row' id='cart_$pro_id'>
                <div class='col-12 col-sm-12 col-md-2 text-center'>
                    <img class='img-responsive' src='$siteroot/admin_area/uploads/product_images/$pro_image' alt='prewiew' width='120' height='80'>
                </div>
                <div class='col-12 text-sm-center col-sm-12 text-md-left col-md-6'>
                    <h4 class='product-name'><strong>$pro_title</strong></h4>
                    <h4>
                        <small>$pro_desc</small>
                    </h4>
                </div>
                <div class='col-12 col-sm-12 text-sm-center col-md-4 text-md-right row'>
                    <div class='col-3 col-sm-3 col-md-6 text-md-right' style='padding-top: 5px'>
                        <h6><strong>NZD $pro_price_formatted <span class='text-muted'>x</span></strong></h6>
                    </div>
                    <div class='col-4 col-sm-4 col-md-4'>
                        <input type='number' 
                        value='$pro_qty' 
                        class='cartqty'
                        data-id='$pro_id'
                        min='0' max='99' step='1'/>
                    </div>
                    <div class='col-2 col-sm-2 col-md-2 text-right'>
                        <button type='button' 
                                class='btn btn-outline-danger btn-xs delcartitem'
                                data-id='$pro_id'>
                                
                            <i class='fa fa-trash' aria-hidden='true'></i>
                        </button>
                    </div>
                </div>
            </div>
            <hr>
        ";
        }
    } else {
        echo "
        <div class='row'>
            <h2>Your cart is empty.</h2>
        </div>
        ";
    }
}

// Display shopping cart items.
function display_checkout_cart_items()
{
    global $con, $siteroot, $total_price;

    $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();

    $get_items = "SELECT * 
                    FROM cart 
                    INNER JOIN products ON cart.p_id = products.product_id 
                    WHERE cart.username = '$uname'";

    $run_q = mysqli_query($con, $get_items);
    while ($row_pro = mysqli_fetch_array($run_q)) {

        $pro_id = $row_pro['product_id'];
        $pro_image = $row_pro['product_image'];
        $pro_title = $row_pro['product_title'];
        $pro_desc = $row_pro['product_desc'];
        $pro_price = $row_pro['product_price'];
        $pro_qty = $row_pro['qty'];
        $sub_total = $pro_qty * $pro_price;
        $total_price += $pro_price * $pro_qty;
        $pro_price = number_format($pro_price, 2); // Format this to have 2 decimal places.
        $sub_total = number_format($sub_total, 2); // Format this to have 2 decimal places.

        echo "
        <li class='list-group-item d-flex justify-content-between lh-condensed'>
        <div>
            <h6 class='my-0'>$pro_title</h6>
            <small class='text-muted'>$pro_qty x $$pro_price</small>
        </div>
        <span class='text-muted'>$$sub_total</span>
        </li>
        ";
    }
    // Formatting outside the loop to avoid dump.
    // $total_price = number_format($total_price, 2); // Format this to have 2 decimal places.
}

//Compute for the total price in the cart
function get_cart_total_price($conv = true)
{
    global $total_price;
    if (!$total_price) {
        global $con, $siteroot, $total_price;

        $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();

        $get_items = "SELECT * 
                    FROM cart 
                    INNER JOIN products ON cart.p_id = products.product_id 
                    WHERE cart.username = '$uname'";

        $run_q = mysqli_query($con, $get_items);
        while ($row_pro = mysqli_fetch_array($run_q)) {

            $pro_price = $row_pro['product_price'];
            $pro_qty = $row_pro['qty'];
            $total_price += $pro_price * $pro_qty;
        }
    }
    if ($conv) {
            $total_price = number_format($total_price, 2);
        }
    return $total_price;
}


//Create order after checkout
function create_order()
{
    // require_once "../classes/order_details.php";

    if (isset($_POST['create-order'])) {
        global $con;
        // $user_type = e($_POST['user_type']);
        $username = $_SESSION['user']['username'];
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
                $order_id
            );
        }
        // $_SESSION['success']  = "New user successfully created!!";
        // header("location: $siteroot/admin_area/create_user.php");

        $uname = isLoggedIn() ? $_SESSION['user']['username'] : getIp();

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
        // return $order_id;
        return $order_details;
    }
}

function send_email($order_details, $email_body)
{
    $email = $order_details->getEmail();

    require_once "../emailer.php";
}

function create_email_body($order_details)
{
    $username = $order_details->getUsername();
    $order_id = $order_details->getOrderid();

    return "
    <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
<head style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
    <meta name='viewport' content='width=device-width' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>

    <!-- For development, pass document through inliner -->


    <style type='text/css' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>

    /* Your custom styles go here */
    * { margin: 0; padding: 0; font-size: 100%; font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; line-height: 1.65; }

img { max-width: 100%; margin: 0 auto; display: block; }

body, .body-wrap { width: 100% !important; height: 100%; background: #f8f8f8; }

a { color: #71bc37; text-decoration: none; }

a:hover { text-decoration: underline; }

.text-center { text-align: center; }

.text-right { text-align: right; }

.text-left { text-align: left; }

.button { display: inline-block; color: white; background: #71bc37; border: solid #71bc37; border-width: 10px 20px 8px; font-weight: bold; border-radius: 4px; }

.button:hover { text-decoration: none; }

h1, h2, h3, h4, h5, h6 { margin-bottom: 20px; line-height: 1.25; }

h1 { font-size: 32px; }

h2 { font-size: 28px; }

h3 { font-size: 24px; }

h4 { font-size: 20px; }

h5 { font-size: 16px; }

p, ul, ol { font-size: 16px; font-weight: normal; margin-bottom: 20px; }

.container { display: block !important; clear: both !important; margin: 0 auto !important; max-width: 580px !important; }

.container table { width: 100% !important; border-collapse: collapse; }

.container .masthead { padding: 80px 0; background: #71bc37; color: white; }

.container .masthead h1 { margin: 0 auto !important; max-width: 90%; text-transform: uppercase; }

.container .content { background: white; padding: 30px 35px; }

.container .content.footer { background: none; }

.container .content.footer p { margin-bottom: 0; color: #888; text-align: center; font-size: 14px; }

.container .content.footer a { color: #888; text-decoration: none; font-weight: bold; }

.container .content.footer a:hover { text-decoration: underline; }

    </style>
</head>
<body style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;height: 100%;background: #f8f8f8;width: 100% !important;'>
<table class='body-wrap' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;height: 100%;background: #f8f8f8;width: 100% !important;'>
    <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
        <td class='container' style='margin: 0 auto !important;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;display: block !important;clear: both !important;max-width: 580px !important;'>

            <!-- Message start -->
            <table style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;border-collapse: collapse;width: 100% !important;'>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td align='center' class='masthead' style='margin: 0;padding: 80px 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: #71bc37;color: white;'>

                        <h1 style='margin: 0 auto !important;padding: 0;font-size: 32px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;max-width: 90%;text-transform: uppercase;'>Thank you!</h1>
                        <h2 style='margin: 0;padding: 0;font-size: 28px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;'> Your order with reference number <strong style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>GG-$order_id</strong> is now being processed.</h2>
                    </td>
                </tr>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td class='content' style='margin: 0;padding: 30px 35px;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: white;'>

                        <h2 style='margin: 0;padding: 0;font-size: 28px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;'>Hi $username,</h2>

                        <p style='margin: 0;padding: 0;font-size: 16px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 20px;'>We appreciate your business and we are continually expanding our product range with the latest in the market to serve you better. Please visit us often and browse our range for all your gadget needs.</p>

                        <!-- <table>
                            <tr>
                                <td align='center'>
                                    <p>
                                        <a href='#' class='button'>Share the Awesomeness</a>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p>By the way, if you're wondering where you can find more of this fine meaty filler, visit <a href='http://baconipsum.com'>Bacon Ipsum</a>.</p>

                        <p><em>– Mr. Pen</em></p> -->

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
        <td class='container' style='margin: 0 auto !important;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;display: block !important;clear: both !important;max-width: 580px !important;'>

            <!-- Message start -->
            <table style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;border-collapse: collapse;width: 100% !important;'>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td class='content footer' align='center' style='margin: 0;padding: 30px 35px;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: none;'>
                        <p style='margin: 0;padding: 0;font-size: 14px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 0;color: #888;text-align: center;'>Sent by <a href='#' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #888;text-decoration: none;font-weight: bold;'>Geek Gadget</a>, 1234 Yellow Brick Road, OZ, 99999</p>
                        <p style='margin: 0;padding: 0;font-size: 14px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 0;color: #888;text-align: center;'><a href='mailto:' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #888;text-decoration: none;font-weight: bold;'>geekgadget.2019@gmail.com</a> | <a href='#' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #888;text-decoration: none;font-weight: bold;'>Unsubscribe</a></p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
    ";
}
