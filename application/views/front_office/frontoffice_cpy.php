<?php
//echo"<pre>";
//print_r($data);
//echo"</pre>";
//echo $propid;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mobile | Dashboard</title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css" />

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css" />


  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font_family.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/react/main.56e6221f.css">
  <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
  <style>
    /* my change */
    header {

      position: fixed;
      width: 100%;
      z-index: 1034;
      top: 61px;

    }


    .ajax-loader {
      visibility: hidden;
      background-color: rgba(255, 255, 255, 1);
      position: absolute;
      z-index: +100 !important;
      width: 100vw;
      height: 100vh;
    }

    .ajax-loader img {
      position: relative;
      top: 35%;
      left: 20%;
    }


    span.topgrid {
      font-size: 19px;
    }


    span.anchor_arrow {
      position: relative;
      top: 5px;
      right: 3px;
    }

    .card1 {
      padding: 5px 8px 5px 5px;

    }

    /*--*/
    .hide {
      display: none;
    }

    .pn {
      padding: 0px !important;
    }

    .small_box {
      padding: 0px;
      margin-left: 5px;
    }

    .sm_inside {
      padding-right: 18px !important;
      padding-left: 21px !important;
    }

    .callout {
      padding: 0px;
    }

    .fl {
      font-size: 16px;
    }

    .sl {
      font-size: 14px;
    }

    .one {
      position: relative;
    }

    .two {
      position: absolute;
      margin-left: 1px;
      margin-top: 12px;
      font-size: 10px;
    }

    .c1 {
      color: #ffc000;
    }

    .c2 {
      color: #00b0f0;
    }

    .c3 {
      color: #ff7d7d;
    }

    .callout.callout-danger {
      border-left-color: #ffc000 !important;
    }

    .callout.callout-success {
      border-left-color: #00b0f0 !important;
    }

    .callout.callout-warning {
      border-left-color: #ff7d7d !important;
    }

    .ra {
      margin-top: 15px;
      font-size: 20px;
      color: rgba(210, 214, 222, 1);
    }

    .main-footer {
      background-color: #f4f6f9 !important;
    }

    .hh {
      color: black;
      font-size: 16px;
    }

    .hsh {
      color: white;
      font-style: italic;
      font-size: 14px;
    }

    .ci {
      color: #ffbd00;
      font-size: 20px;
    }

    .mi {
      color: white;
      background-color: #c11a00;
    }

    .brr {
      border-top-left-radius: 0px !important;
      border-top-right-radius: 0px !important;
    }

    .nvc {
      position: fixed;
      width: 100%;
      overflow: hidden;
      top: 0px;
    }

    .navbar-dark {
      border-color: #2cbebb !important;
    }

    .fileter {
      height: 25px;
    }

    .sicl {
      border-top-left-radius: 0.9rem !important;
      border-bottom-left-radius: 0.9rem !important;
    }

    .sicr {
      border-top-right-radius: 0.9rem !important;
      border-bottom-right-radius: 0.9rem !important;
    }

    .btn-default {
      background: white;
    }

    .ash {
      color: white;
      font-weight: bold;
    }

    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      background-color: white;
      color: white;
      text-align: center;
      border: 1px solid #dee2e6 !important;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
      color: black;
      background-color: #5cd2fdb3;

      border-left: 1px solid #5cd2fd;
      border-right: 1px solid #5cd2fd;
      border-top: 1px solid #5cd2fd;
    }

    .fb {
      border-right: 1px solid #dee2e6 !important;
    }

    .ac {
      color: #00948b;
    }

    .tc {
      text-align: center;
      color: white;
      text-transform: uppercase;
    }

    .nbc {
      background-color: #2cbebb;
    }

    .nav-tabs .nav-link {
      margin-bottom: -1px;
      border: 1px solid transparent;
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
    }

    .nav-tabs {
      border-bottom: 0px solid #2cbebb;
    }

    .t1 {
      font-style: italic;
      color: forestgreen;
      font-size: 17px;
    }

    .t2 {
      font-size: 19px;
      font-weight: bold;
    }


    .art {
      height: 28px;
    }

    .tcc {
      text-align: right;
    }

    .card {
      box-shadow: rgb(179 186 197) 0px 0px 1px 0px, rgb(193 199 208) 0px 1px 1px 0px !important;
      border-radius: 5px !important;
    }

    .card1 {
      padding: 8px;

    }

    .brr {
      border-right: 2px solid #ececec;
    }

    .fcc {
      font-size: 14px;

      background-clip: padding-box;
      border: 1px solid #5cd2fd;
      height: 34px;
    }

    .t1d {
      font-size: 15px;
      color: white;
    }

    .t2d {
      font-size: 15px;
      color: black;
    }

    /*.bc {
      padding: 5px 10px;
    }*/

    .b1c {
      background-color: #00d68f;
    }

    .b2c {
      background-color: #03dac6;
    }

    .b3c {
      background-color: #808080;
    }

    .b4c {
      background-color: #BB86FC;
    }

    .b5c {
      background-color: #6200ee;
    }

    .tar {
      text-align: right;
    }

    .tac {
      text-align: center;
    }

    .ino {
      font-size: 23px;

      color: darkgray;
    }

    .inot {
      color: black;
      font-style: italic;
      font-weight: bold;
    }

    .calloutright1 {
      border-right: 5px solid #0070c0 !important;
      border-left: 0px !important;
    }

    .calloutright2 {
      border-right: 5px solid #29bfbb !important;
      border-left: 0px !important;
    }

    .acl {
      font-size: 16px;

      text-align: left;
    }

    .acl2 {

      color: #29bfbb;

    }

    .acl1 {

      color: #0070c0;

    }

    .acr {
      font-size: 16px;
      color: #6c757dd4;
      text-align: right;


    }

    .sm_inside {
      padding-right: 18px !important;
      padding-left: 21px !important;
    }

    .callout {
      margin-bottom: 6px;
    }

    .m1 {

      background-color: #5cd2fd;
    }

    .m2 {
      background-color: #ffc000;
    }

    .m3 {

      background-color: #9900cc;
    }

    .mt1 {
      color: #5cd2fd;
    }

    .mt2 {
      color: #ffc000;
    }

    .mt3 {
      color: #9900cc;
    }

    .aci {
      color: white;
      margin-top: 16px;
    }

    .mbc {
      margin-bottom: 5px;

    }

    .cm_header {
      background-color: deepskyblue;
      color: white;
    }

    #position_occ {
      position: absolute;
      font-size: 20px;
      z-index: 1;
      /*  margin-top: -108px;
    margin-left: 50px;*/
      top: 181px;
      /* bottom: 10px; */
      /* top: 86px; */
      left: 70px;
      color: darkslategray;
      font-weight: 600;
    }
  </style>
</head>
<input type="hidden" name="" id="baseurl" data-input="<?php echo base_url(); ?>">
<input type="hidden" name="" id="propid" value="<?php echo $propid; ?>">

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">
    <div class="ajax-loader">
      <img src="<?php echo base_url(); ?>/assets/img/misloader.gif" class="img-responsive" />
    </div>

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center" style="background:white;">
      <!-- <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
      <div class="spinner-border text-primary"></div>
    </div>

    <!-- /.navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark nbc" id="nav_prop" style="position: fixed;
    width: 100%;
    top: 0px;">
      <!-- Left navbar links -->

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          <a class="nav-link pln" href="back" role="button"><i class="fas fa-arrow-left"></i></a>





        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="brand" href="#" id="property_details">
            <div class="hh" id="propname">HOTEL 1</div>
            <div class="hsh" id="propcity">T.Nager</div>
          </a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->

        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>Main_controller/authentication" style="
                padding-left: 0px !important;
                padding-right: 0px !important;
              ">
            <i class="fa fa-key ci"></i>
          </a>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" href="<?php echo base_url(); ?>Main_controller/alerts">
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

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.html" class="brand-link">
        <img src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Rasp Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
          </div>
          <div class="info">
            <a href="#" class="d-block">Ansari</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
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
    <div class="content-wrapper" id="root" style="margin-top: 62px; background-color: white">
      <!-- Main content -->
      <!-- Main content -->
      <!-- <header id="header">
      <div class="main-header " style="width:100%;background-color: #5cd2fd;
          padding:4px;margin-left: 0px;">

        <div class="row" style="margin: 0px;">

          <div class="col-6 mt-1">
            <span class="t1d">Front Office</span>
            <span class="t2d"></span>
          </div>
          <div class="col-6">
            
            <div class="form-group" style="margin-bottom: 0px!important;">
              <select class="form-control fcc" id="sub_filter">
                <option id="filter" value="1" selected>Today</option>
                <option id="filter" value="2">Last 7 Days</option>
                <option id="filter" value="3">Last 30 Days</option>
                <option id="filter" value="4">Current Month</option>
                <option id="filter" value="5">Last Month</option>
                <option id="filter" value="6">For the Date Range</option>
              </select>
            </div>
          </div>
        </div>





      </div>
  </header>
      <section class="content pn" style=" background-color: #f9f7f7a6;" id="root">
        <div class="container-fluid">

        </div>



        <div style="margin-top:-14px">
          <div class="container" style="margin: 100px 0px; padding-bottom:5px;">
            <br />

            <div class="plot" id="plotsection">

            </div>



            <div class="card">
              <div class="card-body card1">
                <div class="row">
                  <div class="col-6 brr">
                    <div class="row">
                      <div class="col-12 mb-2">
                        <div class="row">
                          <div><span><img src="<?php echo base_url(); ?>assets/img/sales.png" style="height:25px;width:25px; margin-left: 4px;"></span></div>
                          <div style="margin-top: 3px;"><span class="ml-2" style="font-style: italic;font-weight: bold;"> Sales </span> </div>
                          <div id="sales_container"><span class="ml-2" style="font-size: 19px;color: darkgray;">12500</span></div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-10" style="padding-left: 0px!important;">
                        <div class="card-body small_box">

                          <div class="callout callout-danger sm_inside calloutright1">

                            <div class="row">
                              <div class="col-12 pn acl">

                                <span>sales</span>

                              </div>

                              <div class="col-12 pn acr" id="sales_totel">
                                <span>87000.00</span>


                              </div>


                            </div>

                          </div>

                        </div>
                        <div class="card-body small_box">

                          <div class="callout callout-danger sm_inside calloutright2">

                            <div class="row">
                              <div class="col-12 pn acl">
                                <span class="acl2"> Others</span>


                              </div>

                              <div class="col-12 pn acr" id='ot_sales_totel'>
                                <span>87000.00</span>


                              </div>


                            </div>

                          </div>

                        </div>

                      </div>
                      <div class="col-2 pn" style="text-align:right">
                        <img src="<?php echo base_url(); ?>assets/img/arrow.png" style="height: 25px;margin-top: 80px;">
                      </div>
                    </div>


                  </div>

                  <div class="col-6">
                    <div class="row">
                      <div class="col-12 mb-2">
                        <div class="row">
                          <div><span><img src="<?php echo base_url(); ?>assets/img/rev.png" style="height:25px;width:25px;margin-left: 4px;"></span></div>
                          <div style="margin-top: 3px;"><span class="ml-2" style="font-style: italic;font-weight: bold;"> Rev </span> </div>
                          <div id="rev_container"><span class="ml-2" style="font-size: 19px;color: darkgray;">12500</span></div>
                        </div>
                      </div>

                      <div class="col-10" style="padding-right: 0px;">
                        <div class="card mbc" style="border-right: 4px solid #5cd2fd;">
                          <div class="card-body pn">
                            <div class="row pl-2">
                              <div class="col-3 m1">

                                <i class="fas fa-money-bill-wave aci"></i>

                              </div>

                              <div class="col-9">

                                <div class="row">
                                  <div class="col-12 acl">
                                    <span class="mt1">Cash</span>
                                  </div>

                                  <div class="col-12 acr" id="totelcashamt">

                                    <span class="pr-1">16000.00</span>
                                  </div>
                                </div>


                              </div>




                            </div>



                          </div>
                        </div>

                        <div class="card mbc" style="border-right: 4px solid #ffc000;">
                          <div class="card-body pn">
                            <div class="row pl-2">
                              <div class="col-3 m2">

                                <i class="fas fa-credit-card aci"></i>

                              </div>

                              <div class="col-9">

                                <div class="row">
                                  <div class="col-12 acl">
                                    <span class="mt2">Card</span>
                                  </div>

                                  <div class="col-12 acr" id="totelcardamt">

                                    <span class="pr-1">16000.00</span>
                                  </div>
                                </div>


                              </div>




                            </div>



                          </div>
                        </div>

                        <div class="card mbc" style="border-right: 4px solid #9900cc;">
                          <div class="card-body pn">
                            <div class="row pl-2">
                              <div class="col-3 m3">

                                <i class="fas fa-person-booth aci"></i>

                              </div>

                              <div class="col-9">

                                <div class="row">
                                  <div class="col-12 acl pl-1">
                                    <span class="mt3">Bank</span>
                                  </div>

                                  <div class="col-12 acr" id="totelbankamt">

                                    <span class="pr-1">16000.00</span>
                                  </div>
                                </div>


                              </div>




                            </div>



                          </div>
                        </div>

                      </div>
                      <div class="col-2 pn" style="text-align:right">
                        <img src="<?php echo base_url(); ?>assets/img/arrow.png" style="height: 25px;margin-top: 132px;">
                      </div>


                    </div>


                  </div>




                </div>
              </div>
            </div>



            <div class="card">
              <div class="card-body card1">
                <div class="row">
                  <div class="col-6 brr">

                    <div class="row">
                      <div class="col-4">
                        <img src="<?php echo base_url(); ?>assets/img/highbalance1 copy.png" style="height:50px;width:50px">
                      </div>
                      <div class="col-8">
                        <div class="row">
                          <div class="col-12">
                            <span style="font-weight: bold;font-style: italic;">High Balance</span>
                          </div>
                          <div class="col-9" id="high_balance">
                            <span style="color: darkgray;font-size:14px;">12500</span>
                          </div>
                          <div class="col-3" style="padding: 0 !important;">
                            <a href="hbreport?propid=<?php echo $propid; ?>">
                            <span class="arrow_high"><img src="<?php echo base_url(); ?>assets/img/arrow.png" style="height: 25px;"></span></a>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-6">

                    <div class="row">
                      <div class="col-4">
                        <img src="<?php echo base_url(); ?>assets/img/outs.png" style="height:50px;width:50px">
                      </div>
                      <div class="col-8">
                        <div class="row">
                          <div class="col-12">
                            <span style="font-weight: bold;font-style: italic;">OutStanding</span>
                          </div>
                          <div class="col-8">
                            <span style="color: darkgray;font-size:17px;">12500</span>
                          </div>
                          <div class="col-4">
                            <span><img src="<?php echo base_url(); ?>assets/img/arrow.png" style="height: 25px;"></span>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section> -->
      <!-- /.content -->

      <ul class="nav nav-tabs footer">
        <li class="nav-item fb" style="background-color: #2cbebb;">
          <a class="nav-link ac" href="#">
            <img src="<?php echo base_url(); ?>assets/img/sales.png" alt="sales" width="40px" height="40px" /><br />Sales</a>
        </li>
        <li class="nav-item fb">
          <a class="nav-link ac" href="daysettle?propid=13">
            <i class="far fa-calendar-alt" style="font-size: 35px;"></i>
            <br />Day Settle</a>
        </li>
      </ul>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
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

  <!-- ./wrapper -->
  <script src="<?php echo base_url(); ?>assets/js/subfrontoffice.js"></script>



  <script>
    $.widget.bridge("uibutton", $.ui.button);
  </script>
  <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>

  <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/alertauthcount.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/react/main.6e6151bd.js"></script>

  <script>
    $(function() {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */


      //-------------

      //     var ctx = document.getElementById("myChart").getContext("2d");

      // var gradientStroke = ctx.createLinearGradient(5,10,15,20);
      // gradientStroke.addColorStop(0, "#007bff");
      // gradientStroke.addColorStop(1, "#5bd0fd");

      // var gradientFill = ctx.createLinearGradient(5,10,15,20);
      // gradientFill.addColorStop(0, "rgba(128, 182, 244, 0.6)");
      // gradientFill.addColorStop(1, "#88d9f587");

      // var myChart = new Chart(ctx, {
      //   type: "line",
      //   data: {
      //     labels: ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"],
      //     datasets: [
      //       {
      //         label: "Hotel 1",
      //         borderColor: gradientStroke,
      //         pointBorderColor: gradientStroke,
      //         pointBackgroundColor: gradientStroke,
      //         pointHoverBackgroundColor: gradientStroke,
      //         pointHoverBorderColor: gradientStroke,
      //         pointBorderWidth: 3,
      //         pointHoverRadius: 10,
      //         pointHoverBorderWidth: 1,
      //         pointRadius: 3,
      //         fill: true,
      //         backgroundColor: gradientFill,
      //         borderWidth: 4,
      //         data: [13,8,15,11,9,13,15,19]
      //       }
      //     ]
      //   },
      //   options: {
      //     legend: {
      //       position: "bottom"
      //     },
      //     scales: {
      //       yAxes: [
      //         {
      //           ticks: {
      //             fontColor: "rgba(0,0,0,0.5)",
      //             fontStyle: "bold",
      //             beginAtZero: true,
      //             maxTicksLimit: 5,
      //             padding: 20
      //           },
      //           gridLines: {
      //             drawTicks: false,
      //             display: false
      //           }
      //         }
      //       ],
      //       xAxes: [
      //         {
      //           gridLines: {
      //             zeroLineColor: "transparent"
      //           },
      //           ticks: {
      //             padding: 20,
      //             fontColor: "rgba(0,0,0,0.5)",
      //             fontStyle: "bold"
      //           }
      //         }
      //       ]
      //     }
      //   }
      // });


      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.

      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.



      /*   Chart.pluginService.register({
  beforeDraw: function(chart) {
    var width = chart.chart.width,
        height = chart.chart.height,
        ctx = chart.chart.ctx;

    ctx.restore();
    var fontSize = (height / 114).toFixed(2);
    ctx.font = fontSize + "em sans-serif";
    ctx.textBaseline = "middle";

    var text = "75%",
        textX = Math.round((width - ctx.measureText(text).width) / 2),
        textY = height / 2;

    ctx.fillText(text, textX, textY);
    ctx.save();
  }
});*/

      //-------------





    })
  </script>
</body>

</html>