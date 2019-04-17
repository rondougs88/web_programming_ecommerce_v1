<?php include "./admin_panel_header.php" ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

  <h2>View all Orders Here..</h2>
  <div class="table-responsive" style="margin-top:20px">
          <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Order</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Total</th>
                </tr>
              </thead>

              <tbody>
              <?php get_orders(); ?>
              </tbody>

            </table>
    </div>
  </main>



 <?php include "./admin_panel_footer.php"; ?>