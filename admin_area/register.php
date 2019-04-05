<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Register"; ?>
<?php include "../header.php"; ?>

<!-- Custom styling for this page. -->
<link rel="stylesheet" href="<?= $siteroot; ?>/css/register_style.css">

<?php include "../navigation.php"; ?>

<div class="container">

    <form method="post" action="register.php">

        <!-- when the user doesn't enter the form values correctly, 
            error messages should be displayed guiding them to do it correctly. -->
        <?php echo display_error(); ?>

        <h1>Register</h1>
        <div class="form-group">
            <label>Username</label>
            <input type="username" class="form-control" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
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
            <button type="submit" class="btn" name="register_btn">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</div>

<?php include "../footer.php"; ?>

</html>