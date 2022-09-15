<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.css">


  <style>
     .hide
     {
       display:none;
     }
     .pn
     {
       padding: 0px!important;
     }
     .small_box
     {
       padding:0px;
       margin-left: 5px;
     }
     .sm_inside
     {
      padding-right: 18px!important;
      padding-left: 21px!important;
     }
     .callout 
     {
       padding:0px;
     }
     .fl
     {
       font-size: 16px;
     }
     .sl
     {
      font-size: 14px;
     }
     .one
     {
       position: relative;
     }
     .two
     {
       position: absolute;
       margin-left: 1px;
       margin-top: 12px;
       font-size: 10px;
     }
     .c1
     {
       color:#ffc000;
     }
     .c2
     {
       color:#00b0f0;
     }
     .c3
     {
       color:#ff7d7d;
     }

     .callout.callout-danger {
    border-left-color: #ffc000!important;
}
.callout.callout-success {
    border-left-color: #00b0f0!important;
}
.callout.callout-warning {
    border-left-color: #ff7d7d!important;
}
.ra
{
  margin-top: 15px;
    font-size: 20px;
   color: rgba(210, 214, 222, 1);
}
.main-footer
{
  background-color: #f4f6f9!important;
}
.hh{
 color:black;
 font-size: 16px;

}
.hsh
{
 color: white;
 font-style: italic;
 font-size: 14px;
}
.ci
{

  color:#ffbd00;
  font-size: 20px;
}
.mi
{
  color:white;
  background-color: #c11a00;
}
.brr
{

  border-top-left-radius: 0px!important;
  border-top-right-radius: 0px!important;
}
.nvc
{
  position: fixed;
  width:100%;
  overflow: hidden;
  top:0px;
}
.arrowr
{
  height: 23px;
  margin-top: 10px;
}
.arrowl
{
  height:23px;
}
.tta
{
    color: #dc3545;
    font-size: 14px;
    background: whitesmoke;
    text-align: center;
    font-style: oblique;
    padding: 3px;
    border-radius: 3px;
}
  </style>
</head>
<?php

//echo "test";

//echo $propid;

//return;
//echo $propcount;
//hide search and back button
if($propcount==1)
{
    $hide='hide';
    $unhide='';
}
else
{
    $hide='';
    $unhide='hide';
}


?>
<body class="hold-transition sidebar-mini layout-fixed ">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center hide">
    <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light nvc">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?php echo $unhide; ?>" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
       
        <a class="nav-link <?php echo $hide; ?>"  href="<?php echo base_url(); ?>Main_controller/index" role="button"><i class="fas fa-arrow-left"></i></a>
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
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Rasp Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Ansari</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
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
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-top: 54px;">
     <div class="main-header " style="width:100%;background-color: #5cd2fd;padding:4px;">

          <div class="row" style="margin: 0px;">

            <div class="col-8 mt-1">
              <span class="t1d hide">Front Office</span>
              <span class="t2d"></span>
            </div>
            <div class="col-4">
              <!-- select -->
              <div class="form-group" style="margin-bottom: 0px!important;">

                <select id="date_filter" class="form-control fcc">
                  <option value=1>Today</option>
                  <option value=2>Last 7 Days</option>
                  <option value=3>Last 30 Days</option>
                  <option value=4>Current Month</option>
                  <option value=5>Last Month</option>
                  <option value=6>For the Date Range</option>
                </select>
              </div>
            </div>
          </div>
 </div>
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

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>

<!-- FLOT CHARTS -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.pie.js"></script>

<script src="<?php echo base_url(); ?>assets/js/individual_dashboard.js"></script>
<script>

</script>


</body>
</html>
