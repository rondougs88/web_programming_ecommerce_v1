<?php
include "./includes/db.php";
$pagetitle = "Create User";
include "../header.php"; 
// include "./Dashboard/";
?>

<!-- Custom styling for this page. -->
<link rel="stylesheet" href="<?= $siteroot; ?>/css/register_style.css">

<?php include "../navigation.php"; ?>

<?php
if (!isLoggedIn() || !isAdmin()) {
    echo '<script type="text/javascript">alert("You are not authorized to access this page.");</script>';
    exit();
}
?>
<div class="container">

    <form method="post" action="create_user.php">
        <h1> Create User </h1>
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
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
        </div>
        <div class="form-group">
            <label>First name</label>
            <input type="text" class="form-control" name="firstname" ?>
        </div>
        <div class="form-group">
            <label>Last name</label>
            <input type="text" class="form-control" name="lastname" ?>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
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

</div>

<?php include "../footer.php"; ?>

</html>