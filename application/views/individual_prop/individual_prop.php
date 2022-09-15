<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile | Dashboard</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font_family.css">


</head>
<?php

//echo "test";

//echo $propid;

//return;
//echo $propcount;
//hide search and back button
if ($propcount == 1) {
  $hide = 'hide';
  $unhide = '';
} else {
  $hide = '';
  $unhide = 'hide';
}

//echo "<pre>";
//print_r($edata);
//echo "</pre>";




?>

<body class="hold-transition sidebar-mini layout-fixed ">
  <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">

  <div id="hiddendatas">
    <!-- <input type="hidden" id="cmpidh" value=<?php echo $cmpid; ?>>
  <input type="hidden" id="cmpid" data-input="" value="">
  <input type="hidden" id="propidh" value=<?php echo $allpropids; ?>>
  <input type="hidden" id="propid" data-input="" value="">-->

    <?php
    if (isset($_POST['deviceid'])) {
      //var_dump(1);
    ?>
      <input type="hidden" id="deviceid" value="<?php echo $_POST['deviceid'] ?>">
      <input type="hidden" id="userid" value="<?php echo $_POST['userid'] ?>">
      <input type="hidden" id="logouturl" value="<?php echo $_POST['logouturl'] ?>">
    <?php
    } else {
      //var_dump(2);
      $logouturl = $this->session->userdata('logouturl');
      //echo $logouturl;
      $deviceid = $this->session->userdata('deviceid');
      $userid = $this->session->userdata('userid');
    ?>
      <input type="hidden" id="deviceid" value="<?php echo $deviceid;   ?>">
      <input type="hidden" id="userid" value="<?php echo $userid;  ?>">
      <input type="hidden" id="logouturl" value="<?php echo $logouturl; ?>">

    <?php


    }
    ?>



  </div>
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center" style="background:white;transition:none;">
      <!-- <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
      <div class="spinner-border text-primary"></div>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light nvc">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php echo $unhide; ?>" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

          <a class="nav-link <?php echo $hide; ?>" href="<?php echo base_url(); ?>Main_controller/index" role="button"><i class="fas fa-arrow-left"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto hide">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>



      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <div class="row">
        <div class="col-9">
          <a href="#" class="brand-link hide">
            <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Rasp Admin</span>

          </a>
        </div>
        <div class="col-3">
          <button type="button" data-widget="pushmenu" class="btn btn-tool hide">
            <i class="fas fa-times mt-3 ml-3" style="font-size:22px;"></i>
          </button>

          <a class="btn btn-tool" data-widget="pushmenu" href="#" role="button"> <i class="fas fa-times mt-3 ml-3" style="font-size:22px;"></i></a>
        </div>

      </div>







      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 hide">
          <!--d-flex-->
          <div class="image">
            <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Ansari</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="page1.html" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Page 1</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="page2.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Page 2</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="page3.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Page 3</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Other Options
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>demo 1</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>demo 2</p>
                  </a>
                </li>


              </ul>
            </li>

          </ul>
        </nav>


        <button type="button" class="btn btn-block btn-danger btn-sm" onclick="logmeout();">Logout</button>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>


    <nav class="main-header navbar navbar-expand navbar-white navbar-light nvc">

      <!-- Left navbar links -->

      <ul class="navbar-nav">

        <li class="nav-item">

          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>



          <a class="nav-link hide" href="main_back" role="button"><i class="fas fa-arrow-left"></i></a>

        </li>



      </ul>



      <!-- Right navbar links -->

      <ul class="navbar-nav ml-auto" style="width:60%">
        <select id="date_filter" class="form-control fcc SC">
          <option value=1>Today</option>
          <option value=2>Last 7 Days</option>
          <option value=3>Last 30 Days</option>
          <option value=4>Current Month</option>
          <option value=5>Last Month</option>
          <option value=6>For the Date Range</option>
        </select>
      </ul>

    </nav>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-top: 54px;">

      <!-- Main content -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <!-- AREA CHART -->
              <div class="card card-primary hide">
                <div class="card-header">
                  <h3 class="card-title">Area Chart</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- DONUT CHART -->
              <div class="card card-danger hide">
                <div class="card-header">
                  <h3 class="card-title">Donut Chart</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- PIE CHART -->
              <div class="card card-danger hide">
                <div class="card-header">
                  <h3 class="card-title">Pie Chart</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col (LEFT) -->
            <div class="col-md-12" id="linechartarea">







            </div>
            <!-- /.col (RIGHT) -->






          </div>
          <!-- /.row -->

          <div class="row" id="properties_box">


          </div>








        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <button type="button" id="togglemodal" style="display:none;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button>


  <div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header cm_header">
          <h4 class="modal-title">Select Date Range</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body cm_body">
          <p><span><input class="form-control mb-3" type="date" value="" id="fromdate"></span><span>
              <input class="form-control" type="date" value="" id="todate"></span></p>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer cm_footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" id="submitdata" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!--<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>-->
  <!-- FLOT CHARTS -->
  <script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js"></script>
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
  <script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.resize.js"></script>
  <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
  <script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.pie.js"></script>
  <!--my js file-->

  <script src="<?php echo base_url(); ?>assets/js/individual_dashboard.js"></script>

  <script>
    function logmeout() {
      var url = $("#logouturl").val();
      // console.log(url);
      var logouturl = url;
      var deviceid = $("#deviceid").val();
      logouturl = logouturl.split("mob_login/");
      if (logouturl[1] == "") {} else {
        url = logouturl[0] + "mob_login/";
      }
      if (url && deviceid) {
        url = url.slice(0, -1) + "?deviceid=" + deviceid;
        location.href = url;
      } else {
        console.log("No logout URL Found!!!");
      }
    }
  </script>


</body>

</html>