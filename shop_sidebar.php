<div class="col-lg-3">

    <div class="input-group" id="adv-search" style="margin-top:40px">
        <input type="text" class="form-control" placeholder="Search for products" />
        <div class="input-group-btn">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary">
                    <span class="fa fa-search" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>

    <h6 class="my-4" style="margin-top:20px">See all products</h6>
    <div class="list-group" style="margin-top:-16px">
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