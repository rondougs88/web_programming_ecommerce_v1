<?php

// Set default timezone.
date_default_timezone_set('NZ');

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
    $code = $_GET['logout'];
    if ($code == 5) {
        header("location: ./login.php");
    } else {
        header("location: ./index.php");
    }
}

if (isset($_POST['login_btn'])) {
    login();
}

// Get the total items to be displayed for the cart
$cart_count = cart_items_count();

function get_select_topics()
{
    global $con, $siteroot;

    $get_topics = "SELECT * FROM forum_categories ORDER BY cat_name ASC";

    $run_q = mysqli_query($con, $get_topics);

    while ($topics = mysqli_fetch_array($run_q)) {
        $topic_id = $topics['cat_id'];
        $topic_name = $topics['cat_name'];
        // $topic_id = $topics['cat_id'];
        echo "
    <option value='$topic_id'>$topic_name</option>
    ";
    }
}

// Get the forum topics
function get_forum_topics()
{

    global $con, $siteroot;

    $get_topics = "SELECT * FROM forum_categories ORDER BY cat_name ASC";

    $run_q = mysqli_query($con, $get_topics);

    while ($topics = mysqli_fetch_array($run_q)) {

        $id = $topics['cat_id'];
        $catname = $topics['cat_name'];
        $catdesc = $topics['cat_description'];

        echo "
            <div class='forum-item '>
                <div class='row'>
                    <div class='col-md-9'>
                        <div class='forum-icon'>
                        <i class='fa fa-star' aria-hidden='true'></i>
                        </div>
                        <a href='./subjects.php?topic_id=$id' class='forum-item-title'>$catname</a>
                        <div class='forum-sub-title'>$catdesc</div>
                    </div>
                </div>
            </div>
    ";
    }
}

// Get the forum subjects
function get_forum_subjects($id)
{

    global $con, $siteroot;

    $get_topics = "SELECT * FROM topics WHERE topic_cat = '$id' ORDER BY topic_date DESC";

    $run_q = mysqli_query($con, $get_topics);

    while ($subject = mysqli_fetch_array($run_q)) {

        $subject_id = $subject['topic_id'];
        $subject_subject = $subject['topic_subject'];
        $subject_date = $subject['topic_date'];

        echo "
            <div class='forum-item '>
                <div class='row'>
                    <div class='col-md-9'>
                        <div class='forum-icon'>
                        <i class='fa fa-star' aria-hidden='true'></i>
                        </div>
                        ";
        if (isAdmin()) {
            echo "
                        <span><button class='btn btn-danger float-right del_subj_btn' id='$subject_id' name='del_post_btn'>Delete</button></span>
                        ";
        }
        echo "
                        <a href='./messages.php?topic_id=$id&subject_id=$subject_id' class='forum-item-title'>$subject_subject</a>
                        <div class='forum-sub-title'>Created on: $subject_date</div>
                    </div>
                </div>
            </div>
    ";
    }
}

// Get the forum subjects
function get_subject_messages($subject_id)
{

    global $con, $siteroot;

    $get_posts = "SELECT * FROM posts INNER JOIN users ON posts.post_by = users.id WHERE posts.post_topic = '$subject_id' ORDER BY posts.post_date DESC";

    $run_q = mysqli_query($con, $get_posts);

    while ($posts = mysqli_fetch_array($run_q)) {

        $post_id = $posts['post_id'];
        $post_content = $posts['post_content'];
        $topic_date = $posts['post_date'];
        $username = $posts['username'];
        $fname = $posts['fname'];
        $lname = $posts['lname'];

        echo "
        <div class='row'>
        <div class='col-md-2'>
            <img src='https://image.ibb.co/jw55Ex/def_face.jpg' class='img img-rounded img-fluid' />
            <p class='text-secondary'>$topic_date</p>
        </div>
        <div class='col-md-10'>
            <p>
                <a class='float-left' href='#'><strong>$fname $lname ($username)</strong></a> 
                ";
        if (isAdmin()) {
            echo
                "<span><button class='btn btn-danger float-right del_post_btn' id='$post_id' name='del_post_btn'>Delete</button></span>
                ";
        }
        echo "
            </p>
            <div class='clearfix'></div>
            <p>$post_content</p>
        </div>
    </div>
    <hr>
    ";
    }
}

// LOGIN USER
function login()
{
    global $con, $username, $errors, $siteroot, $checkout_login;

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
        $password = sha1($password);

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($con, $query);

        if (mysqli_num_rows($results) == 1) { // user found
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['active']) {
                // check if user is admin or user
                if ($logged_in_user['user_type'] == 'admin') {

                    $_SESSION['user'] = $logged_in_user;
                    $uname = $_SESSION['user']['username'];
                    $_SESSION['success']  = "You are now logged in as $uname.";
                    if (!$checkout_login) {
                        header("location: $siteroot/index.php");
                    } else {
                        update_cart_from_checkoutlogin();
                        header("location: $siteroot/admin_area/checkout.php");
                    }
                } else {
                    $_SESSION['user'] = $logged_in_user;
                    $uname = $_SESSION['user']['username'];
                    $_SESSION['success']  = "You are now logged in as $uname.";
                    if (!$checkout_login) {
                        header("location: $siteroot/index.php");
                    } else {
                        update_cart_from_checkoutlogin();
                        header("location: $siteroot/admin_area/checkout.php");
                    }
                }
            }
            else {
                array_push($errors, "Your account needs to be activated first. Please check your email for the activation link.");
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

    unset($_SESSION['reg_error']);

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);
    $firstname   =  e($_POST['firstname']);
    $lastname    =  e($_POST['lastname']);
    $created_on  = date("Y-m-d H:i:s");

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($firstname)) {
        array_push($errors, "First name is required");
    }
    if (empty($lastname)) {
        array_push($errors, "Last name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if (strlen($password_1) < 8) {
        // $errors[] = "Password too short!";
        array_push($errors, "Password is too short. Minimum of 8 characters.");
    }
    if (!preg_match("#[0-9]+#", $password_1)) {
        // $errors[] = "Password must include at least one number!";
        array_push($errors, "Password must include at least one number!");
    }
    if (!preg_match("#[a-zA-Z]+#", $password_1)) {
        // $errors[] = "Password must include at least one letter!";
        array_push($errors, "Password must include at least one letter!");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = sha1($password_1); //encrypt the password before saving in the database

        if (isset($_POST['user_type'])) {
            $user_type = e($_POST['user_type']);
            $query = "INSERT INTO users (username, email, user_type, password, fname, lname, created_on, active) 
            VALUES('$username', '$email', '$user_type', '$password', '$firstname', '$lastname', '$created_on', '1')";
            mysqli_query($con, $query);
            $error_msg = mysqli_error($con);
            if ($error_msg == "") {
                $_SESSION['success']  = "New user successfully created!!";
                header("location: $siteroot/admin_area/Dashboard/users.php");
            } else {
                // An error occured.
                $_SESSION['reg_error'] = "Either username or email has already been registered.";
                // header("location: $siteroot/admin_area/Dashboard/admin_create_user.php?reg_error=1");
            }
        } else {
            $query = "INSERT INTO users (username, email, user_type, password, fname, lname, created_on) 
                      VALUES('$username', '$email', 'user', '$password', '$firstname', '$lastname', '$created_on')";
            mysqli_query($con, $query);
            $error_msg = mysqli_error($con);
            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($con);
            if ($error_msg == "") {
                // $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
                // $un = $_SESSION['user']['username'];
                // $_SESSION['success']  = "You are now logged in as $un.";
                $email_body = create_email_body_activate($username, $logged_in_user_id, $password);
                send_email_activate($email, $email_body);
                $_SESSION['success']  = "Please check your email to activate your newly created account.";
                // update_cart_from_checkoutlogin();
                header("location: $siteroot/index.php");
            } else {
                // An error occured.
                $_SESSION['reg_error'] = "Either username or email has already been registered.";
                header("location: $siteroot/admin_area/register.php?reg_error=1");
            }
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

    // $success_msg = isset($_SESSION['success']) ? $_SESSION['success'] : "";

    if (count($errors) > 0) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
    // elseif (!empty($success_msg)) {
    //     echo '<div class="alert alert-success">';
    //     echo $success_msg;
    //     echo '</div>';
    // }
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

        // Get also the product images from product_images table
        $get_pro_img = "SELECT * from product_images where product_id = $pro_id";

        $run_pro_img = mysqli_query($con, $get_pro_img);
        $run_pro_img2 = mysqli_query($con, $get_pro_img);

        // Get the available stock
        $available_qty = 0;
        $get_qty = "SELECT * from products_inventory where product_id = $pro_id";
        $run_pro_qty = mysqli_query($con, $get_qty);
        while ($qty = mysqli_fetch_array($run_pro_qty)) {
            $available_qty = $qty['qty'];
        }

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
                
            <div class='preview col-md-6'>
            <div id='slider'>
                <div id='myCarousel' class='carousel slide'>

                    <!-- main slider carousel items -->
                    <div class='carousel-inner'>
                        <div class='active item carousel-item' data-slide-number='0'>
                            <img src='$siteroot/admin_area/uploads/product_images/$pro_image' class='img-fluid'>
                        </div>";

            $iteration = 0;
            while ($row_pro_img = mysqli_fetch_array($run_pro_img)) {
                $iteration += 1;
                $image = $row_pro_img['image_name'];
                echo "
                        <div class='item carousel-item' data-slide-number='$iteration'>
                            <img src='$siteroot/admin_area/uploads/product_images/$image' class='img-fluid'>
                        </div>
                        ";
            }

            echo "
                        <a class='carousel-control-prev' href='#myCarousel' role='button' data-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Previous</span>
                        </a>
                        <a class='carousel-control-next' href='#myCarousel' role='button' data-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Next</span>
                        </a>

                    </div>
                    <!-- main slider carousel nav controls -->


                    <ul class='carousel-indicators list-inline'>
                        <li class='list-inline-item active'>
                            <a id='carousel-selector-0' class='selected' data-slide-to='0' data-target='#myCarousel'>
                                <img style='height:50px;' src='$siteroot/admin_area/uploads/product_images/$pro_image' class='img-fluid'>
                            </a>
                        </li>";

            $iteration = 0;
            while ($row_pro_img = mysqli_fetch_array($run_pro_img2)) {
                $iteration += 1;
                $image = $row_pro_img['image_name'];
                echo "
                        <li class='list-inline-item'>
                            <a id='carousel-selector-$iteration' data-slide-to='$iteration' data-target='#myCarousel'>
                                <img style='height:50px;' src='$siteroot/admin_area/uploads/product_images/$image' class='img-fluid'>
                            </a>
                        </li>
                        ";
            }

            echo "
                    </ul>
                </div>
            </div>

        </div>
        <div class='details col-md-6'>
            <h3 class='product-title'>$pro_title</h3>

            <p class='product-description'>$pro_desc</p>
            <h4 class='price'>current price: <span>$$pro_price</span></h4>";

            if ($available_qty > 0) {
                echo "
            <div class='action'>
                <button class='add-to-cart btn btn-default my-cart-btn' type='button'><a href='$self_page?pro_id=$pro_id&add_cart=$pro_id' style='color:white'>add to cart</a></button>
            </div>
            <p style='color:black; margin-top:10px'>Available Stock: $available_qty</p>";
            } else {
                echo "<h4>(Out of stock)</h4>";
            }

            echo "
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

function update_cart_from_checkoutlogin()
{
    // Select first items based on IP Address.
    global $con;

    $uname = $_SESSION['user']['username'];
    $ipaddress = getIp();

    // Delete first the cart items of username.
    $del_q = "DELETE FROM cart WHERE username = '$uname';";
    mysqli_query($con, $del_q);

    $get_items = "SELECT * FROM cart INNER JOIN products ON cart.p_id = products.product_id WHERE cart.username = '$ipaddress'";

    $run_q = mysqli_query($con, $get_items);

    if (mysqli_num_rows($run_q) > 0) {
        while ($row_pro = mysqli_fetch_array($run_q)) {
            $prod_id = $row_pro['product_id'];
            $qty = $row_pro['qty'];
            $insert_pro = "INSERT INTO cart (username, p_id, qty) VALUES('$uname', '$prod_id', '$qty')";

            mysqli_query($con, $insert_pro);
        }
    }

    // Overwrite the cart of the logged in user with the items selected.
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

    $get_items = "SELECT cart.*, products_inventory.*, products.*, products_inventory.qty as 'available_qty', cart.qty as 'cart_qty' FROM cart INNER JOIN products ON cart.p_id = products.product_id INNER JOIN products_inventory ON products_inventory.product_id = cart.p_id WHERE cart.username = '$uname'";

    $run_q = mysqli_query($con, $get_items);

    if (mysqli_num_rows($run_q) > 0) {
        while ($row_pro = mysqli_fetch_array($run_q)) {

            $pro_id = $row_pro['product_id'];
            $pro_image = $row_pro['product_image'];
            $pro_title = $row_pro['product_title'];
            $pro_desc = $row_pro['product_desc'];
            $pro_price = $row_pro['product_price'];
            $pro_qty = $row_pro['cart_qty'];
            $available_qty = $row_pro['available_qty'];
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
                        <p id='available_qty'>Available stock: <span>$available_qty</span></p>
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
        $state_c  = mysqli_real_escape_string($con, $_POST['state']);
        $zip      = $_POST['zip'];
        // Shipping address details
        if ($_POST['same-address'] == "same_address") {
            $sh_fname    = $_POST['firstName'];
            $sh_lname    = $_POST['lastName'];
            $sh_address1 = $_POST['address'];
            $sh_address2 = $_POST['address2'];
            $sh_country  = $_POST['country'];
            $sh_state_c  = mysqli_real_escape_string($con, $_POST['state']);
            $sh_zip      = $_POST['zip'];
        } else {
            $sh_fname    = $_POST['sh_firstName'];
            $sh_lname    = $_POST['sh_lastName'];
            $sh_address1 = $_POST['sh_address'];
            $sh_address2 = $_POST['sh_address2'];
            $sh_country  = $_POST['sh_country'];
            $sh_state_c  = mysqli_real_escape_string($con, $_POST['sh_state']);
            $sh_zip      = $_POST['sh_zip'];
        }
        $created_on = date("Y-m-d H:i:s");
        $created_on = mysqli_real_escape_string($con, $created_on);
        $query = "INSERT INTO order_header (status,created_on,username, payment, fname,lname,email, phone, address1, address2, country, state_c, zip,sh_fname,sh_lname,sh_address1,sh_address2,sh_country,sh_state_c,sh_zip) 
                          VALUES(
                          'Processing','$created_on','$username','COD','$fname', '$lname', '$email', '$phone', '$address1', '$address2', '$country', '$state_c', '$zip','$sh_fname','$sh_lname','$sh_address1','$sh_address2','$sh_country','$sh_state_c','$sh_zip'
                          )";
        mysqli_query($con, $query);
        $order_id = mysqli_insert_id($con);
        if (!empty($order_id)) {
            // Populate details for newly created order
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
        // return $order_id;
        return $order_details;
    }
}

function send_email($order_details, $email_body)
{
    $email = $order_details->getEmail();

    require_once "../emailer.php";
}

function send_email_activate($email, $email_body)
{
    $email = $email;

    require_once "../emailer_activate.php";
}

function create_email_body_activate($username, $userid, $hash)
{
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

                        <h1 style='margin: 0 auto !important;padding: 0;font-size: 32px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;max-width: 90%;text-transform: uppercase;'>Activate Account</h1>
                        
                    </td>
                </tr>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td class='content' style='margin: 0;padding: 30px 35px;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: white;'>

                        <h2 style='margin: 0;padding: 0;font-size: 28px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;'>Hi $username,</h2>

                        <p style='margin: 0;padding: 0;font-size: 16px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 20px;'><a href='http://localhost/web_programming_ecommerce_v1/admin_area/activate.php?userid=$userid&hash=$hash' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #71bc37;text-decoration: none;'>Click here to activate your account.</a></p>

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

function get_categories()
{
    global $con;
    $get_categories = "SELECT * from categories";
    $run_q = mysqli_query($con, $get_categories);
    while ($category = mysqli_fetch_array($run_q)) {
        $title = $category['cat_title'];
        $id = $category['cat_id'];
        echo "<a href='./category.php?cat=$id' id='cat_$id' class='list-group-item'>$title</a>";
    }
}

function get_brands()
{
    global $con;
    $get_brands = "SELECT * from brands";
    $run_q = mysqli_query($con, $get_brands);
    while ($brand = mysqli_fetch_array($run_q)) {
        $title = $brand['brand_title'];
        $id = $brand['brand_id'];
        echo "<a href='./brand.php?brand=$id' id='brand_$id' class='list-group-item'>$title</a>";
    }
}

function get_my_orders()
{
    global $con;

    $username = $_SESSION['user']['username'];

    $get_orders = "SELECT order_items.*,
                                order_header.*,
                                products.*
                    FROM order_items
                            INNER JOIN order_header ON order_items.order_id = order_header.order_id
                            INNER JOIN products ON order_items.p_id = products.product_id WHERE order_header.username = '$username' ORDER BY order_items.order_id ASC";

    $run_query = mysqli_query($con, $get_orders);

    $prev_id = '';
    $num_rows = $run_query->num_rows;
    $counter = 0;
    while ($row = $run_query->fetch_assoc()) {
        $data[] = $row;
    }
    if (!empty($data)) {
        for ($i = 0; $i < count($data); $i++) {
            $row_order = $data[$i];
            $counter += 1;
            $order = $row_order['order_id'];
            $date = $row_order['created_on'];
            $status = $row_order['status'];
            if (isset($data[$counter])) {
                $next_id = $data[$counter]['order_id'];
            }
            if ($order != $prev_id) {
                $total = $row_order['product_price'] * $row_order['qty'];
            } else {
                $total += $row_order['product_price'] * $row_order['qty'];
            }
            if ($order != $prev_id) {
                $prev_id = $order;
            }
            if ($counter == $num_rows || ($next_id != $order)) {
                $formatted_number = number_format($total, 2);
                echo "
                <tr>
                    <td>GG-$order</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$$formatted_number</td>
                    <td><a href='myorder_details.php?order=$order'>Details</td>
                </tr>
        ";
            }
        }
    }
}
