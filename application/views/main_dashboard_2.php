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
<body class="hold-transition sidebar-mini layout-fixed ">

<?php

 

?>








<div class="wrapper">


<!--hidden values-->
<div id="hiddendatas">
 <!-- <input type="hidden" id="cmpidh" value=<?php echo $cmpid; ?>>
  <input type="hidden" id="cmpid" data-input="" value="">
  <input type="hidden" id="propidh" value=<?php echo $allpropids; ?>>
  <input type="hidden" id="propid" data-input="" value="">-->
  
 <!-- <input type="hidden" id="deviceid" value="<?php echo $_POST['deviceid'] ?>">
  <input type="hidden" id="userid" value="<?php echo $_POST['userid'] ?>">
   <input type="hidden" id="logouturl" value="<?php echo $_POST['logouturl'] ?>">-->
 
  


</div>









  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light nvc">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
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

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown hide">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url(); ?>assets/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url(); ?>assets/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url(); ?>assets/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown hide">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item hide">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item hide">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

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
                  <button type="button" data-widget="pushmenu" class="btn btn-tool hide" >
                    <i class="fas fa-times mt-3 ml-3" style="font-size:22px;"></i>
                  </button>

                     <a  class="btn btn-tool"  data-widget="pushmenu" href="#" role="button"> <i class="fas fa-times mt-3 ml-3" style="font-size:22px;"></i></a>
      </div>

    </div>
   

    




    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 hide"> <!--d-flex-->
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
        <div class="col-md-12">
          <!-- LINE CHART -->
          <div class="card card-info hide">
            <div class="card-header">
              <h3 class="card-title">Line Chart</h3>

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
                <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- BAR CHART -->
          <div class="card card-info mt-2">
            <div class="card-header brr">
              <h3 class="card-title">Property Revenue Comparison</h3>

              <div class="card-tools hide">
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
                <canvas id="barChart" style="min-height: 179px; height: 183px; max-height: 208px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- STACKED BAR CHART -->
          <div class="card card-success hide">
            <div class="card-header">
              <h3 class="card-title">Stacked Bar Chart</h3>

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
                <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

        </div>
        <!-- /.col (RIGHT) -->


        
      <div class="col-md-12 hide">
            
        <div class="card">
          <div class="card-header pn">
            <nav class="navbar navbar-expand  navbar-dark" style="background-color: #2cbebb;">
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="brand" href="#">
                    <div class="hh">HOTEL 1</div>
                    <div class="hsh">T.Nager</div>
                  </a>
                  
                </li>
               
              </ul>

              <!-- Right navbar links -->
              <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <li class="nav-item ">
                  <a class="nav-link"  href="<?php echo base_url(); ?>Main_controller/authentication" style="padding-left:0px!important;padding-right:0px!important;">
                   
                    <i class="fa fa-key ci"></i>
                    
                    
                  </a>
                  </li>
              
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                  <a class="nav-link"  href="<?php echo base_url(); ?>Main_controller/alerts">
                    <i class="fas fa-bell ci"></i>
                    <span class="badge badge-warning navbar-badge mi">15</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-users mr-2"></i> 8 friend requests
                      <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> 3 new reports
                      <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                  </div>
                </li>
               
              </ul>
            </nav>
            
          </div>
          <div class="card-body">
              
            <div class="row">

              <div class="col-5" style="border-right: 2px solid #ececec;">
                <canvas id="donutChart1" style="min-height: 107px; height: 135px; max-height: 139px; max-width: 100%;"></canvas>
                
                <div style="
                text-align: end;">
                  <a href="<?php echo base_url(); ?>Main_controller/individual_prop"> <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowl"> </a>
                  
                </div>
              </div>
              
              <div class="col-7 pn">

                 <!--test Start-->
                 <div class="card-body small_box">
                  <div class="callout callout-danger sm_inside">
                    
               <div class="row">
                <div class="col-12 pn">
                  <div class="row">
                  
                    <div class="col-6 pn">
                      <span class="fl c1">Front Office</span><br>
                      <span class="sl">Rs.12550</span>

                    </div>
                    <div class="col-4 pn" style="
                    text-align: end;">
                     <span class="sl">12/35</span><br>
                     <span class="sl">3296</span>
                    </div>
                    <div class="col-2  pn" style="
                    text-align: end;">
                
                    
                     <a href="<?php echo base_url(); ?>Main_controller/frontoffice">  <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowr"></i></a>
                    </div>
                  </div>



                </div>
                
            
              </div>
                 
                  </div>
                  <div class="callout callout-info">
               
                  </div>
                  <div class="callout callout-warning">
               
                  </div>
                  <div class="callout callout-success">
               
                  </div>
                </div>


                <div class="card-body small_box">
                  <div class="callout callout-success sm_inside">
                    
               <div class="row">
                <div class="col-12 pn">
                  <div class="row">
                  
                    <div class="col-10 pn">
                      <span class="fl c2">Food & Beverages
                      </span><br>
                      <span class="sl">Rs.12550</span>

                    </div>
                  
                    <div class="col-2  pn" style="
                    text-align: end;">
                
                    
                     <a href="<?php echo base_url(); ?>Main_controller/food_beverages_sales">  <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowr"></i></a>
                    </div>
                  </div>



                </div>
                
            
              </div>
                 
                  </div>
                  <div class="callout callout-info">
               
                  </div>
                  <div class="callout callout-warning">
               
                  </div>
                  <div class="callout callout-success">
               
                  </div>
                </div>



                <div class="card-body small_box">
                  <div class="callout callout-warning sm_inside">
                    
               <div class="row">
                <div class="col-12 pn">
                  <div class="row">
                  
                    <div class="col-10 pn">
                      <span class="fl c3">Banquet & Others 
                      </span><br>
                      <span class="sl">Rs.12550</span>

                    </div>
                   
                    <div class="col-2  pn" style="
                    text-align: end;">
                
                    
                     <a href="<?php echo base_url(); ?>Main_controller/banquet_others">  <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowr"></i></a>
                    </div>
                  </div>



                </div>
                
            
              </div>
                 
                  </div>
                  <div class="callout callout-info">
               
                  </div>
                  <div class="callout callout-warning">
               
                  </div>
                  <div class="callout callout-success">
               
                  </div>
                </div>



                <!--test End-->




              </div>
            </div>
          

          </div>


        </div>   

      </div>

      <div class="col-md-12 hide">
            
        <div class="card">
          <div class="card-header pn">
            <nav class="navbar navbar-expand  navbar-dark"  style="background-color: #5bd0fd;">
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="brand" href="#">    
                    <div class="hh">HOTEL 2</div>
                    <div class="hsh">T.Nager</div>
                  </a>
                  
                </li>
               
              </ul>

              <!-- Right navbar links -->
              <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#" style="padding-left:0px!important;padding-right:0px!important;">
                    
                    <i class="fa fa-key ci"></i>
                    
                    
                  </a>
                  </li>
              
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-bell ci"></i>
                    
                    <span class="badge badge-warning navbar-badge mi">15</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-envelope mr-2"></i> 4 new messages
                      <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-users mr-2"></i> 8 friend requests
                      <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                      <i class="fas fa-file mr-2"></i> 3 new reports
                      <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                  </div>
                </li>
               
              </ul>
            </nav>
            
          </div>
          <div class="card-body">
              
            <div class="row">

              <div class="col-5" style="border-right: 2px solid #ececec;">
                <canvas id="donutChart2" style="min-height: 107px; height: 135px; max-height: 139px; max-width: 100%;"></canvas>
                
                <div style="
                text-align: end;">
                                        <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowl"> 
                </div>
              </div>
              
              <div class="col-7 pn">

                 <!--test Start-->
                 <div class="card-body small_box">
                  <div class="callout callout-danger sm_inside">
                    
               <div class="row">
                <div class="col-12 pn">
                  <div class="row">
                  
                    <div class="col-6 pn">
                      <span class="fl c1">Front Office</span><br>
                      <span class="sl">Rs.12550</span>

                    </div>
                    <div class="col-4 pn" style="
                    text-align: end;">
                     <span class="sl">12/35</span><br>
                     <span class="sl">3296</span>
                    </div>
                    <div class="col-2  pn" style="
                    text-align: end;">
                
                    
                       <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowr"></i>
                      
                    </div>
                  </div>



                </div>
                
            
              </div>
                 
                  </div>
                  <div class="callout callout-info">
               
                  </div>
                  <div class="callout callout-warning">
               
                  </div>
                  <div class="callout callout-success">
               
                  </div>
                </div>


                <div class="card-body small_box">
                  <div class="callout callout-success sm_inside">
                    
               <div class="row">
                <div class="col-12 pn">
                  <div class="row">
                  
                    <div class="col-10 pn">
                      <span class="fl c2">Food & Beverages
                      </span><br>
                      <span class="sl">Rs.12550</span>

                    </div>
                  
                    <div class="col-2  pn" style="
                    text-align: end;">
                
                    
                       <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowr"></i>
                    </div>
                  </div>



                </div>
                
            
              </div>
                 
                  </div>
                  <div class="callout callout-info">
               
                  </div>
                  <div class="callout callout-warning">
               
                  </div>
                  <div class="callout callout-success">
               
                  </div>
                </div>



                <div class="card-body small_box">
                  <div class="callout callout-warning sm_inside">
                    
               <div class="row">
                <div class="col-12 pn">
                  <div class="row">
                  
                    <div class="col-10 pn">
                      <span class="fl c3">Banquet & Others 
                      </span><br>
                      <span class="sl">Rs.12550</span>

                    </div>
                   
                    <div class="col-2  pn" style="
                    text-align: end;">
                
                    
                       <img src="<?php echo base_url(); ?>assets/img/arrow.png" class="arrowr"></i>
                    </div>
                  </div>



                </div>
                
            
              </div>
                 
                  </div>
                  <div class="callout callout-info">
               
                  </div>
                  <div class="callout callout-warning">
               
                  </div>
                  <div class="callout callout-success">
               
                  </div>
                </div>



                <!--test End-->




              </div>
            </div>
          

          </div>


        </div>   

      </div>
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
<!--<script src="<?php echo base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>-->
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
<!--<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>-->

<!-- FLOT CHARTS -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.pie.js"></script>




<!--my js file-->
<script src="<?php echo base_url(); ?>assets/js/main_dashboard.js"></script>




<script>
  function logmeout() {
	var url = $("#logouturl").val();
	var logouturl = url;
	var deviceid = $("#deviceid").val();
	logouturl = logouturl.split("mob_login/");
	if (logouturl[1] == "") {
	} else {
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
