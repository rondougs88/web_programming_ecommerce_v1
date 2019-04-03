<?php

session_start();

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

// LOGIN USER
function login(){
	global $con, $username, $errors;

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
				$_SESSION['success']  = "You are now logged in";
				header('location: index.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

// REGISTER USER
function register()
{
    // call these variables with the global keyword to make them available in function
    global $con, $errors, $username, $email;

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
            header('location: home.php');
        } else {
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
            mysqli_query($con, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($con);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: index.php');
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

function getPro()
{

    if (isset($_GET['pro_id'])) {

        $pro_id = $_GET['pro_id'];

        global $con;

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

            echo "
                
            <div class='container'>
            <div class='card'>
            <div class='container-fliud'>
                <div class='wrapper row'>
                    <div class='preview col-md-6'>

                        <div class='preview-pic tab-content'>
                            <div class='tab-pane active' id='pic-1'><img src='./admin_area/uploads/product_images/$pro_image' /></div>
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
                            <button class='add-to-cart btn btn-default' type='button'>add to cart</button>
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
