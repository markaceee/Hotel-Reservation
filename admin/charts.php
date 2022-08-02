<?php
  require_once('../customers_view/connection.php');
  $sql        = "SELECT * FROM reservation_form1";
  $stmtselect = $db->prepare($sql);
  $stmtselect->execute();

  $arrivals     = 0; $in_house     = 0; $departure    = 0;

  $single       = 0; $double       = 0; $deluxe       = 0;

  $confirmed    = 0; $pending      = 0; $check_out    = 0; $cancelled     = 0;
  $january      = 0; $february     = 0; $march        = 0; $april         = 0; $may         = 0;
  $june         = 0; $july         = 0; $august       = 0; $september     = 0; $october     = 0;
  $november     = 0; $december     = 0;

  $january1     = 0; $february1    = 0; $march1       = 0; $april1        = 0; $may1         = 0;
  $june1        = 0; $july1        = 0; $august1      = 0; $september1    = 0; $october1     = 0;
  $november1    = 0; $december1    = 0;

  while ($edit = $stmtselect->fetch(PDO::FETCH_ASSOC)) {

   if ($edit['status'] == 'Arrival') {
      $arrivals++;
      if ($edit['check_in'] < date("Y-m-d") ) {
          $edit['status'] = 'In-house';
          $status = $edit['status'];
          $full_name = $edit['full_name'];
          $sql = "UPDATE reservation_form1 SET status=:status WHERE full_name=:full_name";
          $stm = $db->prepare($sql);
          $result = $stm->execute(array(':full_name' => $full_name, ':status' => $status));
        }
    }
    if ($edit['status'] == 'In-house') {
       $in_house++;
       if ($edit['check_in'] < date("Y-m-d") AND $edit['check_out'] > date("Y-m-d")) {
         $edit['status'] = 'Departure';
         $status = $edit['status'];
         $full_name = $edit['full_name'];
         $sql = "UPDATE reservation_form1 SET status=:status WHERE full_name=:full_name";
         $stm = $db->prepare($sql);
         $result = $stm->execute(array(':full_name' => $full_name, ':status' => $status));
       }
     }

     if ($edit['status'] == 'Departure') {
        $departure++;
        if ($edit['check_out'] < date("Y-m-d")) {
          $edit['status'] = 'Checked-out';
          $status = $edit['status'];
          $full_name = $edit['full_name'];
          $sql = "UPDATE reservation_form1 SET status=:status WHERE full_name=:full_name";
          $stm = $db->prepare($sql);
          $result = $stm->execute(array(':full_name' => $full_name, ':status' => $status));
        }
      }


    // IF STATEMENT FOR MOST BOOKED ROOMS
    if ($edit['plan'] == 'Single_room' || $edit['plan'] == 'Single room' AND $edit['status'] == 'Checked-out') {
      $single++;
    }if ($edit['plan'] == 'Double_room' || $edit['plan'] == 'Double room' AND $edit['status'] == 'Checked-out') {
      $double++;
    }if ($edit['plan'] == 'Deluxe_room' || $edit['plan'] == 'Deluxe room' AND $edit['status'] == 'Checked-out') {
      $deluxe++;
    }
    // IF STATEMENT FOR STATUS LIKE PENDING, CONFIRMED, CHECKED OUT, CANCELLED
    if ($edit['status'] == 'Confirmed' || $edit['status'] == 'Arrival' || $edit['status'] == 'In-house' || $edit['status'] == 'Departure') {
      $confirmed++;
    }if ($edit['status'] == 'Pending') {
      $pending++;
    }if ($edit['status'] == 'Checked-out') {
      $check_out++;
    }if ($edit['status'] == 'Cancelled') {
      $cancelled++;
    }
    // IF STATMENT FOR MOST CHCEKED OUT PER MONTH
    if ($month = date ('m', strtotime($edit['check_in'])) AND $edit['status'] == 'Checked-out') {
            if($month == 01 ){$january++;}
       else if($month == 02){$february++;}
       else if($month == 03){$march++;}
       else if($month == 04){$april++;}
       else if($month == 05){$may++;}
       else if($month == 06){$june++;}
       else if($month == 07){$july++;}
       else if($month == 8 ){$august++;}
       else if($month == 9 ){$september++;}
       else if($month == 10){$october++;}
       else if($month == 11){$november++;}
       else if($month == 12){$december++;}
    }
    // IF STATEMENT FOR MOST CANCELLED RECERVATION PER MONTH
    if ($month = date ('m', strtotime($edit['check_in'])) AND $edit['status'] == 'Cancelled') {
           if($month == 01){$january1++;}
      else if($month == 02){$february1++;}
      else if($month == 03){$march1++;}
      else if($month == 04){$april1++;}
      else if($month == 05){$may1++;}
      else if($month == 06){$june1++;}
      else if($month == 07){$july1++;}
      else if($month == 8 ){$august1++;}
      else if($month == 9 ){$september1++;}
      else if($month == 10){$october1++;}
      else if($month == 11){$november1++;}
      else if($month == 12){$december1++;}
    }
  }

 ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="main.php">Hotel Reservation System</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">



      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="main.php?logout=true" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>
      </form>
    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="main.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Main page</span>
          </a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="charts.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Dashboard</span></a>
        </li>

      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-bed"></i>
                  Number of Guests</div>
                <div class="card-body">
                  <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                      <th>Arrivals</th>
                      <th>In-house</th>
                      <th>Departure</th>
                    </thead>
                    <tbody>
                      <td><?php print($arrivals) ?></td>
                      <td><?php print($in_house) ?></td>
                      <td><?php print($departure) ?></td>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>
            </div>
          </div>
          <br>
          <!-- Area Chart Example-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Number of Checked-out per month</div>
            <div class="card-body">
              <canvas id="myAreaChart" width="100%" height="30"></canvas>
            </div>
            <div class="card-footer small text-muted"></div>
          </div>


          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-chart-bar"></i>
                  Cancelled reservation</div>
                <div class="card-body">
                  <canvas id="myBarChart" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-chart-pie"></i>
                  Most Booked Rooms </div>
                <div class="card-body">
                  <canvas id="myPieChart" width="100%" height="100"></canvas>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-chart-pie"></i>
                  Status </div>
                <div class="card-body">
                  <canvas id="myPieChart1" width="100%" height="100"></canvas>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->



      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="main.php?logout=true">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->

    <script type="text/javascript">
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';
    // Bar Chart Example
      var ctx = document.getElementById("myBarChart");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
          datasets: [{
            label: "Cancelled reservation",
            backgroundColor: "#dc3545",
            borderColor: "rgba(2,117,216,1)",
            data: [<?php echo $january1 ?>, <?php echo $february1 ?>, <?php echo $march1     ?>,
                   <?php echo $april1   ?>, <?php echo $may1      ?>, <?php echo $june1      ?>,
                   <?php echo $july1    ?>, <?php echo $august1   ?>, <?php echo $september1 ?>,
                   <?php echo $october1 ?>, <?php echo $november1 ?>, <?php echo $december1  ?>],
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 12
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: 100,
                maxTicksLimit: 12
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });

      // Area Chart Example
      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
          datasets: [{
            label: "No. of Checked-out",
            lineTension: 0.3,
            backgroundColor: "rgba(2,117,216,0.2)",
            borderColor: "rgba(2,117,216,1)",
            pointRadius: 5,
            pointBackgroundColor: "rgba(2,117,216,1)",
            pointBorderColor: "rgba(255,255,255,0.8)",
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(2,117,216,1)",
            pointHitRadius: 50,
            pointBorderWidth: 2,
            data: [<?php echo $january ?>, <?php echo $february ?>, <?php echo $march     ?>,
                   <?php echo $april   ?>, <?php echo $may      ?>, <?php echo $june      ?>,
                   <?php echo $july    ?>, <?php echo $august   ?>, <?php echo $september ?>,
                   <?php echo $october ?>, <?php echo $november ?>, <?php echo $december  ?>],
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: 100,
                maxTicksLimit: 5
              },
              gridLines: {
                color: "rgba(0, 0, 0, .125)",
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });

      // Pie Chart Example
      var ctx = document.getElementById("myPieChart");
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Single room", "Double Room", "Deluxe Room"],
          datasets: [{
            data: [<?php echo $single ?>, <?php echo $double ?>, <?php echo $deluxe ?>],
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
          }],
        },
      });
      var ctx = document.getElementById("myPieChart1");
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Checked-out", "Cancelled", "Pending", "Confirm"],
          datasets: [{
            data: [<?php echo $check_out ?>, <?php echo $cancelled ?>, <?php echo $pending ?>, <?php echo  $confirmed ?>],
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
          }],
        },
      });
    </script>
  </body>
</html>
