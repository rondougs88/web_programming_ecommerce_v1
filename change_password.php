<?php include "./admin_area/includes/db.php"; ?>

<?php $pagetitle = "My Account"; ?>
<?php include "header.php"; ?>
<?php
$username = $_SESSION['user']['username'];
$userid = "";
$fname = "";
$lname = "";
$email = "";
$query = "SELECT * FROM users WHERE username='$username'";
$results = mysqli_query($con, $query);

if (mysqli_num_rows($results) == 1) { // user found

    // check if user is admin or user
    $row_user = mysqli_fetch_assoc($results);
    $userid = $row_user['id'];
    // $username = $row_user['username'];
    $email = $row_user['email'];
    $user_type = $row_user['user_type'];
    $fname = $row_user['fname'];
    $lname = $row_user['lname'];
};
?>
<?php include "navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row justify-content-center">
        <!-- <div class="col-md-6" method="post" action=""> -->
        <div class="card col-md-6" style="margin-top: 40px; margin-bottom:20px;  background-color:burlywood">
            <h1 style="padding-top:20px">Change Password</h1>
            <?php echo display_error(); ?>
            <div class="form-group" style="display:none">
                <label>Username (Cannot be changed)</label>
                <input disabled type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" class="form-control" id="curr_pwd" name="curr_pwd">
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" id="new_pwd" name="new_pwd" >
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" id="new_pwd2" name="new_pwd2" >
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="change_pwd_btn" name="change_pwd_btn">Submit</button>
            </div>
            <!-- </form> -->

        </div>
    </div>

</div>

<?php include "footer.php"; ?>

</html>