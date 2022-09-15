<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pos | Items</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/pos_items.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font_family.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed ">
  <input type="hidden" id="propid" value="<?php echo $propid; ?>">
  <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center" style="background:white;transition:none;">
      <!-- <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
      <div class="spinner-border text-primary"></div>
    </div>

    <nav class="main-header navbar navbar-expand navbar-white navbar-light nvc hide">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          <a class="nav-link" href="
	   	<?php echo base_url(); ?>Main_controller/index" role="button"><i class="fas fa-arrow-left"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">

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

    <nav class="main-header navbar navbar-expand  navbar-dark nvc " style="background-color: #2cbebb;">
      <!-- Left navbar links -->
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>


          <a id="common_back" class="nav-link pln" role="button"><i class="fas fa-arrow-left"></i></a>

        </li>
      </ul>
      <?php
      $data = $this->session->userdata('propdetails');
      $indiv_propid = $propid;
      // $userid=$this->session->userdata('userid')
      $propname = $data[$indiv_propid]['propname'];
      $propcity = $data[$indiv_propid]['propcity'];
      ?>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="brand" href="#">
            <div class="hh"><?php echo $propname; ?></div>
            <div class="hsh"><?php echo $propcity; ?></div>
          </a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item ">
          <a class="nav-link" href="authpage?propid=<?php echo $indiv_propid; ?>" style="padding-left:0px!important;padding-right:0px!important;">
            <i class="fa fa-key ci"></i>
          </a>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" href="alertspage?propid=<?php echo $indiv_propid; ?>">
            <i class="fas fa-bell ci"></i>
            <span class="badge badge-warning navbar-badge mi"></span>
          </a>

        </li>
      </ul>
    </nav>
    <!-- Main Sidebar Container -->


    <div class="content-wrapper" style="margin-top: 61px;background-color: white;">

      <div>
        <header id="header">
          <div class="main-header " style="width:100%;background-color: #5cd2fd;padding:4px;">
            <div class="row" style="margin: 0px;">
              <div class="col-8 mt-1">
                <span class="t1">Point of Sales</span>
                <span class="t2" id="headertxt">(ITEMS)</span>
              </div>
              <div class="col-4">

                <div class="form-group" style="margin-bottom: 0px!important;">
                  <select class="form-control fcc" id="date_filter">
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
        </header>
      </div>

      <section class="content" style="margin-top:100px;">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">

            </div>
          </div>











          <div class="row">
            <div class="col-12">
              <div class="card card-info mt-2">
                <div class="card-header brr">

                  <div class="">
                    <select class="form-control SC" id="arealist">

                    </select>
                  </div>
                  <div class="hide">
                    <label class="toggleSwitch nolabel" onclick="" style="margin-bottom: 0px!important;">
                      <input type="checkbox" checked />
                      <span>
                        <span>Group wise</span>
                        <span>Item wise</span>
                      </span>
                      <a></a>
                    </label>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <select class="form-control SC" id="item_select">
                      <option value="Items_Sold">Items Sold</option>
                      <option value="Cancelled_Items">Cancelled Items</option>
                      <option value="MostSold_Items">Most Sold Items</option>
                      <option value="LeastSold_Items">Least Sold Items</option>
                    </select>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-12 Items" style="margin-bottom: 85px;" id="Items_Sold">
              <div class="card">
                <div class="card-header bg-info">
                  <h3 class="card-title " id="titl">Items Sold</h3>
                </div>

                <div class="card-body" style="padding: 5px;">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead style="background-color: #5cd2fd;font-family:Source Sans Pro">
                      <tr>
                        <th style="width:50%">Items</th>
                        <th style="width:20%">Qty</th>
                        <th style="width:30%" colspan="">Amount</th>
                      </tr>
                    </thead>
                    <tbody id='tbody_item_sold_list'>


                    </tbody>

                  </table>
                </div>

              </div>
            </div>
            <div class="col-12 Items hide" style="margin-bottom: 85px;display:none;" id="Cancelled_Items">
              <div class="card">
                <div class="card-header bg-info">
                  <h3 class="card-title">Cancelled Items</h3>
                </div>

                <div class="card-body" style="padding: 5px;">
                  <!--reason tempervary hide--->
                  <div class="form-group hide">
                    <select class="form-control SC" id="reason">
                      <option value="0">Select Reason</option>
                      <option value="1">Wrong Entry</option>
                      <option value="2">Item not Available</option>
                      <option value="3">Delay Food</option>
                      <option value="4">Food not good</option>
                      <option value="5">Wrong Order</option>
                      <option value="6">Software Testing</option>
                    </select>
                  </div>
                  <div id="canceltable_div">
                    <table id="canceltable" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Itly</td>
                          <td>3</td>
                          <td>15</td>
                        </tr>
                        <tr>
                          <td>Dhosa</td>
                          <td>10</td>
                          <td>100</td>
                        </tr>
                        <tr>
                          <td>Vadai (South Indian)</td>
                          <td>15</td>
                          <td>75 </td>
                        </tr>
                        <tr class="item_not_available">
                          <td>chappathi</td>
                          <td>4</td>
                          <td>40</td>
                        </tr>
                      </tbody>
                      <tfoot class="hide">
                        <tr>
                          <th>Rendering engine</th>
                          <th>Browser</th>
                          <th>Platform(s)</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div id="wrong_entry_div">
                    <table id="wrong_entry" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Itly</td>
                          <td>3</td>
                          <td>15</td>
                        </tr>
                        <tr>
                          <td>Dhosa</td>
                          <td>10</td>
                          <td>100</td>
                        </tr>
                      </tbody>
                      <tfoot class="hide">
                        <tr>
                          <th>Rendering engine</th>
                          <th>Browser</th>
                          <th>Platform(s)</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div id="item_not_available_div">
                    <table id="item_not_available" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="item_not_available">
                          <td>chappathi</td>
                          <td>4</td>
                          <td>40</td>
                        </tr>
                      </tbody>
                      <tfoot class="hide">
                        <tr>
                          <th>Rendering engine</th>
                          <th>Browser</th>
                          <th>Platform(s)</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div id="delay_food_div">
                    <table id="delay_food" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="item_not_available">
                          <td>chicken 65</td>
                          <td>4</td>
                          <td>400</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="food_not_good_div">
                    <table id="food_not_good" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="item_not_available">
                          <td>fish</td>
                          <td>4</td>
                          <td>40</td>
                        </tr>
                        <tr class="item_not_available">
                          <td>Meals</td>
                          <td>4</td>
                          <td>40</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="wrong_order_div">
                    <table id="wrong_order" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="item_not_available">
                          <td>Ice cream</td>
                          <td>4</td>
                          <td>40</td>
                        </tr>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div id="software_testing_div">
                    <table id="software_testing" class="table table-bordered table-striped canceltable">
                      <thead style="background-color: #5cd2fd;">
                        <tr>
                          <th>Items</th>
                          <th>Qty</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="col-12 Items hide" style="margin-bottom: 85px;display:none;" id="MostSold_Items">
              <div class="card">
                <div class="card-header bg-info">
                  <h3 class="card-title">Most Sold Items</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="padding: 5px;">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead style="background-color: #5cd2fd;">
                      <tr>
                        <th>Items</th>
                        <th>Qty</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Itly</td>
                        <td>3</td>
                        <td>15</td>
                      </tr>
                      <tr>
                        <td>Dhosa</td>
                        <td>10</td>
                        <td>100</td>
                      </tr>
                      <tr>
                        <td>Vadai (South Indian)</td>
                        <td>15</td>
                        <td>75 </td>
                      </tr>
                      <tr>
                        <td>chappathi</td>
                        <td>4</td>
                        <td>40</td>
                      </tr>
                      <tr>
                        <td>Poori</td>
                        <td>13</td>
                        <td>215</td>
                      </tr>
                    </tbody>
                    <tfoot class="hide">
                      <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="col-12 Items hide" style="margin-bottom: 85px;display:none;" id="LeastSold_Items">
              <div class="card">
                <div class="card-header bg-info">
                  <h3 class="card-title">Least Sold Items</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="padding: 5px;">
                  <table id="example4" class="table table-bordered table-striped">
                    <thead style="background-color: #5cd2fd;">
                      <tr>
                        <th>Items</th>
                        <th>Qty</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Itly</td>
                        <td>3</td>
                        <td>15 </td>
                      </tr>
                      <tr>
                        <td>Dhosa</td>
                        <td>10</td>
                        <td>100</td>
                      </tr>
                      <tr>
                        <td>Vadai (South Indian)</td>
                        <td>15</td>
                        <td>75 </td>
                      </tr>
                      <tr>
                        <td>chappathi</td>
                        <td>4</td>
                        <td>40</td>
                      </tr>
                      <tr>
                        <td>Poori</td>
                        <td>13</td>
                        <td>215</td>
                      </tr>
                    </tbody>
                    <tfoot class="hide">
                      <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
    </div>
    <!--my work here end-->
  </div>



  <ul class="nav nav-tabs footer">
    <li class="nav-item fb">

      <a class="nav-link ac" href="pos_sales?propid=<?php echo $propid ?>">
        <img src="<?php echo base_url(); ?>assets/img/sales.png" alt="sales" width=40px height=40px><br>Sales</a>
    </li>
    <li class="nav-item fb">
      <a class="nav-link active ac" href="pos_items?propid=<?php echo $propid ?>">
        <img src="<?php echo base_url(); ?>assets/img/items.png" alt="items" width=40px height=40px><br>Items</a>
    </li>
  </ul>

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Default Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <!-- The Modal -->
  <div class="modal fade" id="Date_range_model">
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

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>


  <!-- DataTables  & Plugins -->
  <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!--my js file-->
  <script src="<?php echo base_url(); ?>assets/js/pos_items.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/alertauthcount.js"></script>
  <script>
    $(document).ready(function() {
      document.getElementById('common_back').addEventListener('click', function() {
        window.location = document.referrer;
      }, false);
    });
  </script>



</body>

</html>