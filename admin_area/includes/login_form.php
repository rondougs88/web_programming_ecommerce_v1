<!-- Action of this form is handled in functions.php login() -->
<form method="post">

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