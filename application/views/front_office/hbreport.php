<?php
//echo"<pre>";
//print_r($data);
//echo"</pre>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mobile | Dashboard</title>

   
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css" />
 
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font_family.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <style>
        /* my change */
        header {

            position: fixed;
            width: 100%;
            z-index: 1034;
            top: 57px;

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
            background: white;
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

        .card1 {
            padding: 8px;
            background: white;
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

        .bc {
            padding: 5px 10px;
        }

        .b1c {
            background-color: #3366ff;
        }

        .b2c {
            background-color: #ffaa00;
        }

        .b3c {
            background-color: #0095ff;
        }

        .b4c {
            background-color: #ff3d71;
        }

        .b5c {
            background-color: #00d68f;
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

        .nav-item {
            width: 25%;
            background-color: #2cbebb;
            text-align: center;
            text-transform: uppercase;
            font-weight: 500;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #000 !important;
            background-color: #5cd2fd !important;
        }

        .nav-item a {
            color: white !important;

        }

        #indiv_cards {
            box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
            padding: 7px;
            border-radius: 5px;
            margin-bottom: 10px;

        }

        #cardbody {

            padding: 10px !important;
        }

        #indivcards {
            box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
            padding: 7px;
            border-radius: 5px;
        }

        #card_body {

            padding: 10px !important;
        }

        .card {
            box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
            
        }

        .modetype {
            font-weight: 550;
            font-size: 15px;
        }

        h5.guestname {
            text-align: center;
            font-weight: 600;
            letter-spacing: 3px;
            color: grey;
        }

        .card-title {
            margin-top: 8px;
        }

        .card-header {
            padding:0px !important;
            border-radius: 0 !important;
        }

        .card-header>.card-tools {
            float: right;
            margin-right: -.625rem;

        }

        .nav-pills .nav-link {
            border-radius: 0 !important;
        }

        h4.settle_ie_amt {

            text-align: end !important;
            position: relative !important;
            top: 4px !important;
        }

        .box_f_row,
        .box_s_row {
            font-size: 13px !important;
        }

        .bal_head {
            color: linen;
            font-weight: 600;
            letter-spacing: 2px;

        }

        .balamount {

            text-align: center;
            color: white;
        }

        .balance {
            text-align: center;
        }

        .row.hbdiv {
            border-bottom: 1px solid #22e090;
            

        }
        .hbdiv .col-6:nth-child(even){
            text-align:right;
         


        }
        .cm_header{
      background-color: deepskyblue;
    color: white;
    }
    i.fa-angle-up.fas {
    font-size: 20px;
    color: white;
    position: relative;
    top: 3px;
}
i.fas.fa-angle-down {
    font-size: 20px;
    color: white;
    position: relative;
    top: 3px;
}
.rotateme{
    transform: rotate(
180deg);
    transition: all 0.5s linear;
}
      /*-----authpage position cs s--*/

      #spnauthcount{
            z-index:1;
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
        <nav class="main-header navbar navbar-expand navbar-dark nvc" style="background-color: #2cbebb">
            <!-- Left navbar links -->

            <!-- Left navbar links -->
            <ul class="navbar-nav" style="width:20%">
                <li class="nav-item">
                    <a class="nav-link hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    <a class="nav-link pln" href="frontoffice?propid=<?php echo $propid; ?>" role="button"><i class="fas fa-arrow-left"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav" style="width:60%">
                <li class="nav-item" style="width: 100%;
    text-align: initial;">
                    <a class="brand" href="#" id="property_details">
                        <span class="hh" id="propname">HOTEL 1</span>
                        <span class="hsh" id="propcity">T.Nager</span>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto" style="width:20%">
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
        <div class="content-wrapper" style="margin-top: 110px; background-color: white">
            <!-- Main content -->
            <!-- Main content -->
            <header id="header">
                <div class="main-header " style="width:100%;background-color: #5cd2fd;
                    padding:4px;margin-left: 0px;">

                    <div class="row" style="margin: 0px;">

                        <div class="col-6 mt-1">
                            <span class="t1d">Highbalance Report</span>
                            <span class="t2d"></span>
                        </div>
                       
                    </div>

                   



                </div>
                <div class="row" style="background-color: #17a2b8;padding: 5px; color: white;width: 100%;
                margin: 0px;">
                <div class="col-4" style="text-align: center;">ROOM NO</div>
                <div class="col-4" style="text-align: center;">GUEST NAME</div>
                <div class="col-4" style="text-align: center;">BALANCE</div>

            </div>
            </header>
           
            <div class="row" id="hbreportsection" style="margin:130px 0; width:100vw;padding: 0px 10px;
">

            </div>
            <ul class="nav nav-tabs footer">
                <li class="nav-item fb">
                    <a class="nav-link ac" href="#">
                        <img src="<?php echo base_url(); ?>assets/img/sales.png" alt="sales" width="40px" height="40px" /><br />Sales</a>
                </li>

            </ul>

            <!-- /.content-wrapper -->

        </div>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
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

    <!-- ./wrappe-->
    <script src="<?php echo base_url(); ?>assets/js/hbreport.js"></script>

    <!-- jQuery -->
   
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
   
    <script src="<?php echo base_url(); ?>assets/js/alertauthcount.js"></script>



  
</body>

</html>