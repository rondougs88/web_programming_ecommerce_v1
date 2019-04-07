<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Login"; ?>
<?php include "../header.php"; ?>

<!-- Custom styling for this page. -->
<link rel="stylesheet" href="<?= $siteroot; ?>/css/register_style.css">

<?php include "../navigation.php"; ?>

<div class="container">

    <form method="post" action="login.php">

        <?php echo display_error(); ?>

        <div class="form-group">
            <label>Username</label>
            <input type="username" class="form-control" name="username">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="login_btn">Login</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>


</div>

<?php include "../footer.php"; ?>

</html>