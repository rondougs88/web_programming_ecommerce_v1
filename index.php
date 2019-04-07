<?php include "./admin_area/includes/db.php"; ?>
<?php $pagetitle = "Geek Gadget"; ?>
<?php include "header.php"; ?>

<?php include "navigation.php"; ?>

<?php include "homepage.php"; ?>

<!-- Alert user he has been logged in -->
<?php
if (isset($_SESSION['success'])) {
    $msg = $_SESSION['success'];
    unset($_SESSION['success']);
    echo '<script type="text/javascript">alert("' . $msg . '");</script>';
}
?>

<?php include "footer.php"; ?>

</html>