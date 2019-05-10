<div class="container-fluid">
  <div class="row">
    <nav id="side_menu" class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item" 
              id="first-item"
            >
              <a class="nav-link" id="orders" href="./order.php">
                <span data-feather="file"></span>
                Orders
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="users" href="#submenu1" data-toggle="collapse" data-target="#submenu1" aria-expanded="false">
                <span data-feather="users"></span>
                Users
              </a>
              <div class="collapse" id="submenu1" aria-expanded="false">
                <ul class="flex-column pl-2 nav">
                  <li class="nav-item"><a class="nav-link py-0 sub-item" id="viewusers" href="../Dashboard/users.php">View / Edit users</a></li>
                  <li class="nav-item"><a class="nav-link py-0 sub-item" id="createuser" href="./admin_create_user.php">Create User</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="products" href="#submenu2" data-toggle="collapse" data-target="#submenu2" aria-expanded="false">
                <span data-feather="shopping-cart"></span>
                Products
              </a>
              <div class="collapse" id="submenu2" aria-expanded="false">
                <ul class="flex-column pl-2 nav">
                  <li class="nav-item"><a class="nav-link py-0 sub-item" id="view_products" href="../Dashboard/view_products.php">View / Edit products</a></li>
                  <li class="nav-item"><a class="nav-link py-0 sub-item" id="create_product" href="../Dashboard/insert_product.php">Create product</a></li>
                  <li class="nav-item"><a class="nav-link py-0 sub-item" id="manage_cat" href="../Dashboard/categories.php">Manage categories</a></li>
                  <li class="nav-item"><a class="nav-link py-0 sub-item" id="manage_cat" href="../Dashboard/brands.php">Manage brands</a></li>
                </ul>
              </div>
            </li>

        </div>
    </nav>


  </div>
</div>