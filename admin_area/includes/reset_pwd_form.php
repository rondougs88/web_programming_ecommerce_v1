<!-- Action of this form is handled in functions.php login() -->
<form method="post">

    <?php echo display_error(); ?>
    <h4>Please input your email below.</h4>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="rst_email" id="rst_email">
    </div>
    <div class="form-group">
        <button type = "submit" class="btn btn-primary" id="reset_pwd_btn" name="reset_pwd_btn">Reset Password</button>
    </div>
    <p>
        Not yet a member? <a href="./register.php">Sign up</a>
    </p>
</form>