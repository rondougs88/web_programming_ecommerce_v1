<?php include "./includes/db.php"; ?>
<?php $pagetitle = "Login"; ?>
<?php $checkout_login = false; ?>
<?php include "../header.php"; ?>

<!-- Custom styling for this page. -->
<link rel="stylesheet" href="<?= $siteroot; ?>/css/register_style.css">

<?php include "../navigation.php"; ?>

<div class="container">
    <?php include "./includes/reset_pwd_form.php"; ?>
</div>

<?php include "../footer.php"; ?>

</html>