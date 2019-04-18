<?php include "./admin_panel_header.php"; ?>

<?php
if (!isLoggedIn() || !isAdmin()) {
    echo '<script type="text/javascript">alert("You are not authorized to access this page.");</script>';
    exit();
}
?>

<?php
if (isset($_GET['userid'])) {
    set_user_details($_GET['userid']);
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="row justify-content-center">
        <!-- <div class="col-md-6" method="post" action=""> -->
        <div class="card col-md-6" style="margin-bottom:40px;  background-color:burlywood" method="post" action="">
            <h1 style="padding-top:20px"> Edit User </h1>
            <?php echo display_error(); ?>
            <?php
            $reg_error = isset($_SESSION['reg_error']) ? $_SESSION['reg_error'] : "";
            if (isset($_GET['reg_error'])) {
                echo "
        <div class='alert alert-danger'>
            <strong>Error!</strong> $reg_error
        </div>
        ";
            }
            ?>
            <div class="form-group">
                <label>Username (Cannot be changed)</label>
                <input disabled type="text" name="username" class="form-control" value="<?php echo $eu_username; ?>">
            </div>
            <div class="form-group">
                <label>First name</label>
                <input type="text" class="form-control" id="fname" name="firstname" ? value="<?php echo $eu_fname; ?>">
            </div>
            <div class="form-group">
                <label>Last name</label>
                <input type="text" class="form-control" id="lname" name="lastname" value="<?php echo $eu_lname; ?>" ?>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $eu_email; ?>">
            </div>
            <div class="form-group">
                <label>User type</label>
                <select class="form-control" id="user_type" name="user_type" id="user_type">
                    <?php
                    if ($eu_user_type === 'admin') {
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
                <button type="submit" class="btn btn-dark float-right" id="admin_reset_pwd" name="admin_reset_pwd">Reset user password</button>
            </div>
            <!-- </form> -->

        </div>
    </div>
</main>


<?php include "./admin_panel_footer.php"; ?>