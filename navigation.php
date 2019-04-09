</head>

<body>

  <div class="json-overlay">
    <div class="spinner-border text-primary loading" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>


  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?= $siteroot ?>">Geek Gadget</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?= $siteroot ?>/">Home
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
            <a class='nav-link' href='$siteroot/admin_area/register.php'><i class='fa fa-user-plus'></i>Register</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='$siteroot/admin_area/login.php'><i class='fa fa-fw fa-user'></i>Login</a>
          </li>
          ";
          }

          if (isLoggedIn() && isAdmin()) {
            echo "
          <li class='nav-item'>
            <a class='nav-link' href='$siteroot/admin_area/create_user.php'>Create User</a>
          </li>
          <li class='nav-item'>
            <a class='nav-link' href='$siteroot/admin_area/Dashboard/dashboard.php'>Admin</a>
          </li>
          ";
          }

          if (isLoggedIn()) {
            $username = $_SESSION['user']['username'];
            echo "
                    <li class='nav-link'>|</li>
                    <li class='dropdown'>
                      <a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>Welcome, $username <b class='caret'></b></a>
                        <ul class='dropdown-menu'>
                            <li class='dropdown-item'><a href='/user/preferences'><i class='icon-cog'></i> Preferences</a></li>
                            <li class='dropdown-item'><a href='/help/support'><i class='icon-envelope'></i> Contact Support</a></li>
                            <li class='dropdown-divider'></li>
                            <li class='dropdown-item'><a href='$siteroot/index.php?logout='1''><i class='icon-off'></i> Logout</a></li>
                        </ul>
                    </li>
                    ";
          }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $siteroot ?>/admin_area/shopping_cart.php">
              <span class="fa fa-2x fa-shopping-cart my-cart-icon">
                <!-- <span class="badge badge-notify my-cart-badge"></span> -->
                <span class="badge badge-notify my-cart-badge" style="font-size:12px;"></span>
              </span>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>