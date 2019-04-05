<?php include "./includes/db.php"; ?>
<?php include "../functions/functions.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <?php include "../styles.php"; ?>
    <link rel="stylesheet" href="<?= $siteroot; ?>/css/register_style.css">

    <!-- Bootstrap core JavaScript -->
    <script src="<?= $siteroot ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $siteroot ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
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
                <button type="submit" class="btn" name="login_btn">Login</button>
            </div>
            <p>
                Not yet a member? <a href="register.php">Sign up</a>
            </p>
        </form>


    </div>
</body>

</html>