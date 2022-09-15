<html>

<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

</head>

<body>
    <table id="newexample1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Employee</th>
                <th>InTime</th>
            </tr>
        </thead>
        <tbody class="tablebody">
        </tbody>
    </table>
      <!-- jQuery -->
  <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script>
    
function newfunction() {
        $(".tablebody").append("<tr onclick='historyfunction()'><td>Sasi Kumar</td><td>Suresh Kumar</td><td>21/06/2019 10:59:02</td></tr>");
        $(".tablebody").append("<tr onclick='historyfunction()'><td>omar omar</td><td>Suresh Kumar</td><td>21/06/2019 10:59:02</td></tr>");
    }

    $(document).ready(function() {
        newfunction();
        $('#newexample1').DataTable();
    });







</script>

</body>

</html>