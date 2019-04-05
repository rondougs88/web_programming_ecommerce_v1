<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://localhost/web_programming_ecommerce_v1/">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>


                <?php 

                if (!isLoggedIn()) {
                  echo "
          <li class='nav-item'>
            <a class='nav-link' href='http://localhost/web_programming_ecommerce_v1/admin_area/register.php'><i class='fa fa-user-plus'></i>Register</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='http://localhost/web_programming_ecommerce_v1/admin_area/login.php'><i class='fa fa-fw fa-user'></i>Login</a>
          </li>
          ";
                }

                if (isLoggedIn() && isAdmin()) {
                  echo "
          <li class='nav-item'>
            <a class='nav-link' href='http://localhost/web_programming_ecommerce_v1/admin_area/create_user.php'>Create User</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='http://localhost/web_programming_ecommerce_v1/admin_area/insert_product.php'>Admin</a>
          </li>
          ";
                }

                if (isLoggedIn()) {
                  $username = $_SESSION['user']['username'];
                  echo "
                    <li class='nav-link'>|</li>
                    <li class='dropdown'><a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>Welcome, $username <b class='caret'></b></a>
                        <ul class='dropdown-menu'>
                            <li><a href='/user/preferences'><i class='icon-cog'></i> Preferences</a></li>
                            <li><a href='/help/support'><i class='icon-envelope'></i> Contact Support</a></li>
                            <li class='divider'></li>
                            <li><a href='http://localhost/web_programming_ecommerce_v1/index.php?logout='1''><i class='icon-off'></i> Logout</a></li>
                        </ul>
                    </li>
                    ";
                }
                ?>

            </ul>
        </div>
    </div>
</nav> 