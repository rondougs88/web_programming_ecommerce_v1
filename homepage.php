<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include "./shop_sidebar.php"; ?>

        <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="./admin_area/uploads/img/slide1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="./admin_area/uploads/img/slide2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block img-fluid" src="./admin_area/uploads/img/slide3.jpg" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <h1 style="margin-top:40px; padding-bottom:10px; text-align:center">Latest Gadgets</h1>
            <div class="row">

                <?php
                $get_pro = "select * from products order by inserted_on desc LIMIT 0,9";

                $run_pro = mysqli_query($con, $get_pro);

                while ($row_pro = mysqli_fetch_array($run_pro)) {

                    $pro_id = $row_pro['product_id'];
                    $pro_cat = $row_pro['product_cat'];
                    $pro_brand = $row_pro['product_brand'];
                    $pro_title = $row_pro['product_title'];
                    $pro_price = $row_pro['product_price'];
                    $pro_image = $row_pro['product_image'];
                    $pro_desc = $row_pro['product_desc'];

                    echo "
                      <div class='col-lg-4 col-md-6 mb-4'>
                        <div class='card h-100'>
                          <a href='product_detail.php?pro_id=$pro_id''><img class='card-img-top' 
                          src='./admin_area/uploads/product_images/$pro_image' alt=''></a>
                          <div class='card-body'>
                            <h4 class='card-title'>
                              <a href='product_detail.php?pro_id=$pro_id'>$pro_title</a>
                            </h4>
                            
                            <p class='card-text'>$pro_desc</p>
                          </div>
                          <div class='card-footer'>
                          <h5>$$pro_price</h5>
                          </div>
                        </div>
                      </div>
                      ";
                }
                ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->