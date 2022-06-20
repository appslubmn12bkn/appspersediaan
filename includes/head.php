  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="?module=home" class="navbar-brand"><b>appsPsedia</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="?module=home" title="Home/Halaman Utama"><i class="fa fa-home"></i><span class="sr-only">(current)</span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i>&nbsp;&nbsp;&nbsp;Referensi <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?module=tbl_brg"><i class="fa fa-circle-o"></i>Tabel Barang </a></li>
                <li><a href="?module=tbl_stokbrg"><i class="fa fa-circle-o"></i>Tabel Stock Barang </a></li>
              </ul>
            </li>
            <li><a href="?module=sedia_pengajuan"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Pengajuan ATK / ART / Bakom</a> <span class="sr-only">(current)</span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i>&nbsp;&nbsp;&nbsp;Cek Persediaan <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php 
                $cek=umenu_akses("?module=t_mohoncek",$_SESSION[NIP]);
                if ($cek==1 OR $_SESSION[LEVEL]=='admin' OR $_SESSION[LEVEL]=='user') {
                $tabel = mysqli_query($koneksi, 
                "SELECT count(registrasi) as jumlah FROM c_unitsediaminta WHERE prosedur='6'");
                if(mysqli_num_rows($tabel) > 0) {
                $aksi = mysqli_fetch_assoc($tabel);
                }
                ?>
                <li>
                <a href="?module=c_aksiProsedia"><i class="fa fa-circle-o text-red"></i>Cek Pengajuan
                <span class="label bg-blue label-md pull-right"><?php echo "$aksi[jumlah]";?></span>
                </a>
                
                </li>
                <li><a href="?module=t_montlap"><i class="fa fa-circle-o text-red"></i>Monitoring dan Laporan </a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the messages -->
                  <ul class="menu">
                    <li><!-- start message -->
                      <a href="#">
                        <div class="pull-left">
                          <!-- User Image -->
                          <img src="dist/img/logo.png" class="img-circle" alt="User Image">
                        </div>
                        <!-- Message title and timestamp -->
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <!-- The message -->
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <!-- end message -->
                  </ul>
                  <!-- /.menu -->
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <!-- /.messages-menu -->

            <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- Inner Menu: contains the notifications -->
                  <ul class="menu">
                    <li><!-- start notification -->
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                    <!-- end notification -->
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- Tasks Menu -->
            <li class="dropdown tasks-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                  <!-- Inner menu: contains the tasks -->
                  <ul class="menu">
                    <li><!-- Task item -->
                      <a href="#">
                        <!-- Task title and progress text -->
                        <h3>
                          Design some buttons
                          <small class="pull-right">20%</small>
                        </h3>
                        <!-- The progress bar -->
                        <div class="progress xs">
                          <!-- Change the css width attribute to simulate progress -->
                          <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">20% Complete</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <!-- end task item -->
                  </ul>
                </li>
                <li class="footer">
                  <a href="#">View all tasks</a>
                </li>
              </ul>
            </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="dist/img/logo.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo"$_SESSION[NIP]";?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="dist/img/logo.png" class="img-circle" alt="User Image">

                  <p>
                  <?php echo"$_SESSION[NIP]";?>
                  <small><?php echo"$_SESSION[LOGIN_TERAKHIR]";?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                  <div class="col-xs-12 text-center">
                  <a href="?module=profile" class="btn bg-blue btn-block btn-flat"><font color='#fff'>Profile</font></a>
                  <a href="logout.php" class="btn bg-navy btn-block btn-flat"><font color='#fff'>Keluar</font></a>
                  </div>
                  </div>
                  <!-- /.row -->
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>