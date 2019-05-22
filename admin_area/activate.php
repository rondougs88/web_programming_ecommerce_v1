<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Login"; ?>
<?php $checkout_login = false; ?>
<?php include "../header.php"; ?>
<?php
$userid = $_GET['userid'];
$hash = $_GET['hash'];
$activate = "UPDATE users SET active = 1 WHERE id = '$userid' AND password = '$hash'";
$run_q = mysqli_query($con, $activate);
if (mysqli_affected_rows($con) > 0) {
    $success = true;
}
?>
<!-- Custom styling for this page. -->
<link rel="stylesheet" href="<?= $siteroot; ?>/css/register_style.css">

<?php include "../navigation.php"; ?>

<div class="container">
    <?php global $success;
    if ($success) {
        echo "
        <div style='margin-top:40px' class='alert alert-success' role='alert'>
        <p >Your account has been activated, please login below.</p>
        </div>
        ";
    } ?>
    <?php include "./includes/login_form.php"; ?>
</div>

<?php include "../footer.php"; ?>

</html>