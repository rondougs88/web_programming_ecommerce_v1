<?php include "./admin_panel_header.php" ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

  <h2>View all Orders Here..</h2>
  <div class="table-responsive" style="margin-top:20px; width:70%">
          <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th width="10%">Order</th>
                  <th width="40%">Date</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>

              <tbody>
              <?php get_orders(); ?>
              </tbody>

            </table>
    </div>
  </main>



 <?php include "./admin_panel_footer.php"; ?>