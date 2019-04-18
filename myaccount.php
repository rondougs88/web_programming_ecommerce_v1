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
            <h1 style="padding-top:20px">My Details</h1>
            <?php echo display_error(); ?>
            <div class="form-group">
                <label>Username (Cannot be changed)</label>
                <input disabled type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label>First name</label>
                <input type="text" class="form-control" id="fname" name="firstname" ? value="<?php echo $fname; ?>">
            </div>
            <div class="form-group">
                <label>Last name</label>
                <input type="text" class="form-control" id="lname" name="lastname" value="<?php echo $lname; ?>" ?>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label>User type (Cannot be changed)</label>
                <select disabled class="form-control" id="user_type" name="user_type" id="user_type">
                    <?php
                    if ($user_type === 'admin') {
                        echo "<option selected value='admin'>Admin</option>";
                        echo "<option value='user'>User</option>";
                    } else {
                        echo "<option value='admin'>Admin</option>";
                        echo "<option selected value='user'>User</option>";
                    }
                    ?>


                </select>
            </div>
            <!-- <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password_1">
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password" class="form-control" name="password_2">
            </div> -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="edit_user_btn" name="edit_user_btn">Save changes</button>
                <button type="submit" class="btn btn-dark float-right" id="admin_reset_pwd" name="admin_reset_pwd">Change password</button>
            </div>
            <!-- </form> -->

        </div>
    </div>

</div>

<?php include "footer.php"; ?>

</html>