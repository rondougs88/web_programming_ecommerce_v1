<div class="col-lg-3">

    <div class="list-group" style="margin-top:40px">
        <a href='./all_products.php' class='list-group-item' id="all">All Products</a>
    </div>

    <h6 class="my-4">Shop by category</h6>
    <div class="list-group" style="margin-top:-16px">
        <?php get_categories(); ?>
    </div>

    <h6 class="my-4">Shop by brand</h6>
    <div class="list-group" style="margin-top:-16px">
        <?php get_brands(); ?>
    </div>

</div>
<!-- /.col-lg-3 -->