<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/jqueryswipe.js"></script>
  
  
  <!-- jQuery vibreate -->
  <script src="<?php echo base_url(); ?>assets/js/jquery-navigator-vibrate.js"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="
		<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font_family.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/authmain.css">


  <style>

  </style>
</head>

<?php


?>


<body class="hold-transition sidebar-mini layout-fixed ">
<div class="misloader">
    <img src="<?php echo base_url(); ?>/assets/img/misloader.gif" class="img-responsive" />
</div>
  <div id='hiddenvalues'>
    <?php
    $baseurl = base_url();
    $hiddenids = array();
    array_push($hiddenids,'swiperdone', 'msgdata', 'baseurl', 'propvalues', 'bodyswiperinit', 'bodyswiper', 'selectallcheckbox', 'activeauthtab', 'authtabconnect', 'authsfilter', 'authsresult', 'checkboxon', 'cardclickon');
    foreach ($hiddenids as $key => $hiddenid) {
      echo '<input type="hidden" id="' . $hiddenid . '" class="hiddeninputs" data-input="" value="">';
    }
    echo '<input type="hidden" id="hbaseurl" class="hiddeninputs onstarthinputs" value="' . $baseurl . '">';
    echo '<input type="hidden" id="propid" class="hiddeninputs" value="' . $propid . '">';
    echo '<input type="hidden" id="cmpid" class="hiddeninputs" value="' . $cmpid . '">';
    echo '<input type="hidden" id="userid" class="hiddeninputs" value="' . $userid . '">';
    echo '<input type="hidden" id="hactiveauthtab" class="hiddeninputs onstarthinputs" value=0>';
    if(!empty($msgdata))
    {
      //echo "<pre>";
      //print_r($msgdata);
      //echo "</pre>";
      echo "<input type='hidden' id='hmsgdata' class='hiddeninputs onstarthinputs' data-input='' value='".$msgdata."'>";
    }
    ?>
  </div>
  <div class="wrapper">

    <!-- Preloader -->
    <div style="background:white" class="preloader flex-column justify-content-center align-items-center">
      <!--img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60"-->
      <div class="spinner-border text-primary"></div>
    </div>




    <!-- /.navbar -->
    <nav class="main-header navbar navbar-expand  navbar-dark nvc " style="background-color: #2cbebb;">
      <!-- Left navbar links -->

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          <a href="back" class="nav-link pln" role="button"><i class="fas fa-arrow-left"></i></a>
        </li>

      </ul>
      <?php
               $data = $this->session->userdata('propdetails');
               $indiv_propid= $propid;
               // $userid=$this->session->userdata('userid')
               $propname = $data[$indiv_propid]['propname'];
               $propcity = $data[$indiv_propid]['propcity'];
       
       
       ?>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="brand" href="mainpage">
            <div class="hh"><?php echo $propname; ?></div>
            <div class="hsh"><?php echo $propcity; ?></div>
          </a>

        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->

        <li class="nav-item ">
          <a class="nav-link" id="authpage-link" href="authpage?propid=<?php echo $propid ?>" style="padding-left:0px!important;padding-right:0px!important;">

            <i class="fa fa-key ci"></i>
            <span id="unreadauthscount" class="badge badge-warning navbar-badge mi"></span>

          </a>
        </li>

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" id="alertspage-link" href="alertspage?propid=<?php echo $propid ?>">
            <i class="fas fa-bell ci"></i>
            <span id="unreadalertscount" class="badge badge-warning navbar-badge mi"></span>
          </a>
        </li>

      </ul>
    </nav>


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo base_url(); ?>Main_controller/index" class="brand-link">
        <img src=" <?php echo base_url(); ?>assets/img/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Rasp Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo base_url(); ?>assets/img/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
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

            <li class="nav-item ">
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
    <div class="content-wrapper" style="margin-top: 62px;background-color: white;">

      <!-- Main content -->
      <div id="fixeddiv">
        <div class="container-fluid">


          <div class="row" style="background:#5cd2fd;padding:5px;width:100vw">
            <div class="col-4 pt-1">
              <span class="ash">Authorization</span>
            </div>

            <div class="col-7">
              <div class="ml-2">
                <div class="input-group">
                  <input type="search" id="searchinput" class="form-control form-control-sm sicl" placeholder="">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-sm btn-default sicr">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-1 pn">
              <!--img src="<?php echo base_url(); ?>assets/img/fileter.png" class="fileter"-->
              <select id="auths-select">

              </select>
            </div>
          </div>
        </div>


        <ul class="nav nav-tabs nbc">
          <li class="nav-item flex-fill">
            <a class="nav-link active tc authtabs" id="authtabs-pending" data-toggle="tab" href="#authtabs-content-pending">Pending</a>
          </li>
          <li class="nav-item flex-fill">
            <a class="nav-link tc authtabs" id="authtabs-accepted" data-toggle="tab" href="#authtabs-content-accepted">Accepted</a>
          </li>
          <li class="nav-item flex-fill">
            <a class="nav-link tc authtabs" id="authtabs-denied" data-toggle="tab" href="#authtabs-content-denied">Denied</a>
          </li>
          <li class="nav-item flex-fill hideme">
            <a class="nav-link tc" id="authtabs-card" data-toggle="tab" href="#authtabs-content-card">Auth Details</a>
          </li>
        </ul>
      </div>
      <!-- Main content -->
      <section id="authscontent" class="content pn">


<div class="tab-content" style="margin-top: 5px;position: relative;">

<div id="authcard-allcheckbox-div" class="hideme">
  <!--label class="authcard-checkbox-label">
    <input type="checkbox" id="authcard-checkbox-all" class="authcard-checkbox" name="authcard-checkbox">
    <span id="authcardallcheckmark-id" class="authcardallcheckmark"></span>
  </label>
  <button id="authcard-allcheckbox-btn">Select All</button-->
</div>

<div id="authtabs-content-pending" style="height:100vh" class="container tab-pane active authtabs-content">
</div>
<div id="authtabs-content-accepted" style="height:100vh" class="container tab-pane fade authtabs-content">
</div>
<div id="authtabs-content-denied" style="height:100vh" class="container tab-pane fade authtabs-content">
</div>
<div id="authtabs-content-card" class="container tab-pane fade">
</div>

<div id="navtab-footer">
        <ul id="normalfooter" class="nav nav-tabs footer">
          <li class="nav-item fb">
            <a class="nav-link ac navftlink" href="pos_sales?propid=<?php echo $propid ?>">
              <img src="<?php echo base_url(); ?>assets/img/sales.png" alt="sales" width=40px height=40px><br>Sales</a>
          </li>
          <li class="nav-item fb">
            <a class="nav-link ac navftlink" href="pos_items?propid=<?php echo $propid ?>">
              <img src="<?php echo base_url(); ?>assets/img/items.png" alt="items" width=40px height=40px><br>Items</a>
          </li>
        </ul>

        <ul id="authfooter" class="nav nav-tabs footer">
          <li class="nav-item fb">
            <a id="authftlink-read" class="nav-link ac navftlink authftlink">
              <img src="<?php echo base_url(); ?>assets/img/sales.png" alt="sales" width=40px height=40px><br>Read</a>
          </li>
          <li class="nav-item fb">
            <a id="authftlink-remove" class="nav-link ac navftlink authftlink">
              <img src="<?php echo base_url(); ?>assets/img/items.png" alt="items" width=40px height=40px><br>Remove</a>
          </li>
        </ul>
      </div>


    </div>
        
      </section>
      <!-- /.content -->
      
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    //$.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="
		<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="
		<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
  

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!--script src="
		<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script-->

  <!-- FLOT CHARTS -->
  <!--script src="
		<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js"></script-->
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
  <!--script src="
		<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.resize.js"></script-->
  <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
  <!--script src="
		<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.pie.js"></script-->

  <script src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/underscore.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/authmain.js"></script>

  <script>
    appinit();
  </script>
   <script>
   </script>

</body>

</html>