<?php include "./admin_area/includes/db.php"; ?>
<?php $pagetitle = "Product Details"; ?>
<?php include "header.php"; ?>
<link href="<?= $siteroot; ?>/css/prod-carousel.css" rel="stylesheet">

<!-- This script is to update the cart count on this page every time add to cart button is clicked. -->
<script>
    $(document).ready(function() {
        $('.loading').show(); // show loading spinner
        $('.json-overlay').show(); // disable screen
        $.ajax({
            type: "POST",
            url: siteroot + "/get_cart_count.php",
            async: false,
            // data: { update_cart: filtered_array },
            success: function(count) {
                // Do stuff
                $('.loading').hide();
                $('.json-overlay').hide();
                $(".my-cart-badge").html(count);
            },
            error: function(request, status, errorThrown) {
                // There's been an error, do something with it!
                // Only use status and errorThrown.
                // Chances are request will not have anything in it.
                $('.loading').hide();
                $('.json-overlay').hide();
                alert("Update Cart Count Ajax Error: " + status + errorThrown);
            }

        });
    }); //END $(document).ready()
</script>

<?php include "navigation.php"; ?>

<!-- Styles for this page -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<link href="./css/product_detail.css" rel="stylesheet">

<?php include "navigation.php"; ?>
<?php cart(); ?>
<div class='container'>
    <div class='card'>
        <div class='container-fliud'>
            <div class='wrapper row'>
                <?php getPro();?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</html>