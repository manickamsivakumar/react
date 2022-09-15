<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobile | Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
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
/*if($propcount==1)
{
    $hide='hide';
    $unhide='';
}
else
{
    $hide='';
    $unhide='hide';
}*/
?>
<body class="hold-transition sidebar-mini layout-fixed ">
    <input type="hidden" id="propid" value=<?php echo $propid; ?>>
    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
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
                    <a class="nav-link <?php //echo $unhide; 
                                        ?> hide" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    <a href="pos_back" class="nav-link" role="button"><i class="fas fa-arrow-left"></i></a>
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
        <!-- /.navbar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-top: 54px;">
            <div class="main-header hide" style="width:100%;background-color: #5cd2fd;padding:4px;">
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
    <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
    <!-- FLOT CHARTS -->
    <script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.resize.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="<?php echo base_url(); ?>assets/plugins/flot/plugins/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/indiv_dashboard.js"></script>
    <script>
        $(document).ready(function() {
            document.getElementById('common_back').addEventListener('click', function() {
                window.location = document.referrer;
            }, false);
        });
    </script>
</body>
</html>