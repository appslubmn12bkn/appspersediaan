<header class="main-header">
    <!-- Logo -->
    <a href="?module=home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BMN</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>appsbknLU</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo"$_SESSION[NIP]";?></span>
            </a>
            <ul class="dropdown-menu"> 
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.png" class="img-circle" alt="User Image">
                <p>
                  <?php echo"$_SESSION[NIP]";?>
                  <small><?php echo"$_SESSION[LAST_LOGIN]";?></small>
                </p>
              </li>
              <li class="user-body"> 
              <div class="row">
                  <div class="col-xs-4 text-center">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="col-xs-4 text-center">
                  <a href="#" class="btn btn-default btn-flat">Setting</a>
                  </div>
                  <div class="col-xs-4 text-center">
                  <a href="logout.php" class="btn btn-default btn-flat">Keluar</a>
                  </div>
              </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>