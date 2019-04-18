<?php

include_once "../includes/db.php";

// $id = $_POST['userid'];
$username = $_POST['username'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$user_type = $_POST['user_type'];

$update_user = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', user_type = '$user_type' WHERE username = '$username'";

$run_q = mysqli_query($con, $update_user);
echo "User has been updated.";

?>