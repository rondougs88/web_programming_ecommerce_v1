<!DOCTYPE html>
<html>

<?php include "./admin_area/includes/db.php"; ?>
<?php include "./functions/functions.php" ?>

<head>
    <title>Login</title>

    <?php include "styles.php"; ?>
    <link rel="stylesheet" href="http://localhost/web_programming_ecommerce_v1/css/register_style.css">
</head>

<body>
    <?php include "navigation.php"; ?>
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
                <button type="submit" class="btn" name="login_btn">Login</button>
            </div>
            <p>
                Not yet a member? <a href="register.php">Sign up</a>
            </p>
        </form>


    </div>
</body>

</html> 