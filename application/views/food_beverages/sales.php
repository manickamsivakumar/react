<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pos | Sales</title>
  <link rel="shortcut icon" href="#">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/pos_sales.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font_family.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <input type="hidden" id="propid" value="<?php echo $propid; ?>">
  <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center" style="background:white;transition:none;">
      <!-- <img class="animation__shake" src="<?php echo base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
      <div class="spinner-border text-primary"></div>
    </div>
    <nav class="main-header navbar navbar-expand  navbar-dark nvc " style="background-color: #2cbebb;">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          <?php
        // echo $m;


         
               // var_dump(3);
                echo '<a href="pos_back" class="nav-link pln"  role="button"><i class="fas fa-arrow-left"></i></a>';
       
         
          ?>
        </li>
      </ul>
      <?php
      //echo $m;
      $data = $this->session->userdata('propdetails');
      $indiv_propid = $propid;
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
      <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
          <a class="nav-link" href="authpage?propid=<?php echo $indiv_propid; ?>" style="padding-left:0px!important;padding-right:0px!important;">
            <i class="fa fa-key ci"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="alertspage?propid=<?php echo $indiv_propid; ?>">
            <i class="fas fa-bell ci"></i>
            <span class="badge badge-warning navbar-badge mi"></span>
          </a>
        </li>
      </ul>
    </nav>
   
    <div class="content-wrapper" style="margin-top: 60px;background-color: white;margin-bottom:20px;">
      <header id="header">
        <div class="main-header " style="width:100%;background-color: #5cd2fd;padding:4px;">
          <div class="row" style="margin: 0px;">
            <div class="col-8 mt-1">
              <span class="t1">Point of Sales</span>
              <span class="t2">(SALES)</span>
            </div>
            <div class="col-4">
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
        <div>
      </header>
      <section class="content" style="margin-top:115px;">
        <div class="container-fluid">
          
          <!--new collapsable style start-->
          <div class="small-box  bg-info hide" style="margin:0px">
            <div class="inner">
              <h3 id="hide_box">150</h3>
              <p>New Orders</p>
            </div>
            <a id="collabse_btn" class="small-box-footer test" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
          <div class="collapse hide" id="collapseExample">
            <div class="card card-body">
            </div>
          </div>
          <!--new collapsable style end-->
          <div class="" id="pos_sales_box">
          </div>
        </div>
      </section>
    </div>
    

        
    <ul class="nav nav-tabs footer">
      <li class="nav-item fb">
     
        <a class="nav-link active ac" href="pos_sales?propid=<?php echo $propid ?>">
          <img src="<?php echo base_url(); ?>assets/img/sales.png" alt="sales" width=40px height=40px><br>Sales</a>
      </li>
      <li class="nav-item fb">
        <a class="nav-link ac" href="pos_items?propid=<?php echo $propid ?>">
          <img src="<?php echo base_url(); ?>assets/img/items.png" alt="items" width=40px height=40px><br>Items</a>
      </li>
    </ul>
         
     

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
  </div>
  <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/pos_sales.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/alertauthcount.js"></script>
  <script>
    $(document).ready(function() {
      // $('#collabsable-body').css('display', 'none');
      //  $("#collabse_btn").attr( "data-card-widge","collapse");
      //  $("#collabse_card").removeClass("collapsed-card");
      //  data-card-widget="collapse"
      // $(".test").collapse({toggle: false});
      $('.collabse_btn').click(function() {
         
        alert('test');
        var araeid=$(this).attr('id');
        console.log(araeid);

        $('#hide_box').toggleClass('hide');
        $(this).find('i').toggleClass('fas fa-arrow-circle-right fas fa-arrow-circle-up');
      });
            document.getElementById('common_back').addEventListener('click', function() {
                window.location = document.referrer;
        }, false);
    });
  </script>
   <script>
        $('.btn-tool').click(function() {
         // alert('collapse');
            $(this).find('i').toggleClass('fas fa-arrow-circle-right fas fa-arrow-circle-up');
        });
    </script>

</body>
</html>