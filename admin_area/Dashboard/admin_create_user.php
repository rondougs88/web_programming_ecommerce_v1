<?php include "./admin_panel_header.php"; ?>

<?php
if (!isLoggedIn() || !isAdmin()) {
    echo '<script type="text/javascript">alert("You are not authorized to access this page.");</script>';
    exit();
}
if (isset($_POST['register_btn'])) {
    $username = $_POST['username'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="row justify-content-center">
        <!-- <div class="card"> -->
        <div class="card col-md-6" style="margin-bottom:40px;  background-color:burlywood">
            <div class="card-body">
                <form method="post" action="./admin_create_user.php">
                    <!-- <div class="card col-md-6" method="post" action=""> -->
                    <h1> Create User </h1>
                    <?php echo display_error(); ?>
                    <?php
                    $reg_error = isset($_SESSION['reg_error']) ? $_SESSION['reg_error'] : "";
                    // if (isset($_GET['reg_error'])) {
                    if (!empty($reg_error)) {
                        echo "
                            <div class='alert alert-danger'>
                                <strong>Error!</strong> $reg_error
                            </div>
                            ";
                    }
                    ?>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php global $username; echo $username ?>">
                    </div>
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" class="form-control" name="firstname" value="<?php global $fname;
                                                                                        echo $fname; ?>">
                    </div>
                    <div class="form-group">
                        <label>Last name</label>
                        <input type="text" class="form-control" name="lastname" value="<?php global $lname;
                                                                                        echo $lname; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php global $email;
                                                                                        echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label>User type</label>
                        <select class="form-control" name="user_type" id="user_type">
                            <option value=""></option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password_1">
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" class="form-control" name="password_2">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="register_btn">Create user</button>
                    </div>
                </form>
                <!-- </div> -->
            </div>
        </div>
    </div>
</main>


<?php include "./admin_panel_footer.php"; ?>