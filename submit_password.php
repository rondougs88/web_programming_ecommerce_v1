<?php
include "./admin_area/includes/db.php";
$username = $_POST['username'];
$curr = $_POST['curr_pwd'];
$curr2 = sha1($curr);
$new = $_POST['new_pwd'];
$new2 = sha1($new);


$confirm_pwd = "SELECT * FROM users WHERE username = '$username' AND password = '$curr2'";
$run_q = mysqli_query($con, $confirm_pwd);
if ($run_q->num_rows < 1) {
    echo "Current password is incorrect.";
} else {

    $update_pwd = "UPDATE users SET password = '$new2' WHERE username = '$username'";

    $run_q = mysqli_query($con, $update_pwd);
    if (empty(mysqli_error($con))) {
        echo "Password has been updated.";
    } else {
        echo "Error occured in changing password.";
    }

}
