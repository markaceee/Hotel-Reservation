<?php
  require_once('../customers_view/connection.php');
  session_start();
  require 'includes/PHPMailer.php';
  require 'includes/SMTP.php';
  require 'includes/Exception.php';
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
  $full_name  = $_SESSION['fname'];
  $sql        = "SELECT * FROM reservation_form1 WHERE full_name = ?";
  $stmtselect = $db->prepare($sql);
  $stmtselect->execute([$full_name]);
  $edit       = $stmtselect->fetch(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Edit</title>

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
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>
  </form>
    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="main.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Main page</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="charts.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Dashboard</span></a>
        </li>
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="main.php">Main page</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5">Reservation</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="checked_out.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5">Pending Reservation</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="pending.php">
                  <span class="float-left">View Details</span>

                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5">Confirmed Reservation</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="confirmed.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="mr-5">Cancelled Reservation</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="cancelled.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-edit"></i>
              Edit</div>
            <div class="card-body">
              <form style="margin: 50px;" action="edit.php"  method="POST">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Status: </label>
                    <span class="badge badge-warning"> Pending </span>
                  </div>
                </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Full name</label>
                  <input type="tel" class="form-control" pattern="09[0-9]{9}" name="contact" value="<?php print($edit['full_name']) ?>" disabled>
                </div>
                <div class="form-group col-md-6">
                  <label>Contact</label>
                  <input type="text" class="form-control" name="contact" value="<?php print($edit['contact']) ?>" disabled>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" value="<?php print($edit['email']) ?>" disabled >
                </div>
                <div class="form-group col-md-6">
                  <label>Plan</label>
                <input type="text" class="form-control" name="plan" value="<?php print($edit['plan']) ?>" disabled >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Number of Adults</label>
                  <input type="text" class="form-control" name="adults" value="<?php print($edit['adults']) ?>" disabled >
                </div>
                <div class="form-group col-md-6">
                  <label>Number of Children</label>
                  <input type="text" class="form-control" name="children" value="<?php print($edit['children']) ?>" disabled >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Check-In</label>
                  <input type="date" class="form-control"  name="check_in" value="<?php print($edit['check_in']) ?>" disabled>
                </div>
                <div class="form-group col-md-6">
                  <label>Check-Out</label>
                  <input type="date" class="form-control" name="check_out" value="<?php print($edit['check_out']) ?>" disabled>
                </div>
              </div>
              <br>
              <div class="form-row">
                <div class="form-group">
                  <button type="submit" name="confirm" style="background-color: #28A745; color: white">Confirm</button>
                  <button type="submit" name="cancel" style="background-color: #DC3545; color: white">Cancel Reservation</button>
                  <button type="submit" name="send" style="background-color: #0077F7; color: white">Send Mail</button>
                </div>
              </div>
            </div>
          </div>
          <?php

          if(isset($_POST['confirm'])) {
            $edit['status'] = 'Confirmed';
            $status1 = $edit['status'];
            $full_name1 = $edit['full_name'];
            $sql = "UPDATE reservation_form1 SET status=:status WHERE full_name=:full_name";
            $stm = $db->prepare($sql);
            $result = $stm->execute(array(':full_name' => $full_name1, ':status' => $status1));
            if ($result){
              session_destroy();
              unset($_SESSION);
              $email = $edit['email'];
              $mail = new PHPMailer();
              $mail->isSMTP();
              $mail->Host = "smtp.gmail.com";
              $mail->SMTPAuth = "true";
              $mail->SMTPSecure = "tls";
              $mail->Port = "587";
              $mail->Username = "thehotel.booknow@gmail.com";
              $mail->Password = "1230hotel";
              $mail->Subject = "Reservation Confirmed";
              $mail->setFrom("thehotel.booknow@gmail.com");
              $mail->isHTML(true);
              $mail->Body = ' <img src="cid:Logo" /> '
                          . '<hr>'
                          . '<p style="text-align: center; margin: 5px; color: gray"> You received this email because your reservation in now confirmed.
                              If this was sent to you by mistake, please email us thehotel.booknow@gmail.com</p>'

                          . '<p style="text-align: center"> Hotel Address: 349-4 Sinam, Manila, Philippines </p>';
              $mail->AddEmbeddedImage('images/2.png', 'Logo');
              $mail->addAddress("$email");
              $mail->Send();
              $mail->smtpClose();
              ?>
                <script type="text/javascript">
                  alert("Reservation Confirmed!");
                  window.location.href = "pending.php"
                </script>
              <?php

            } else {
              echo "failed!";
            }
          } if(isset($_POST['cancel'])) {
            $edit['status'] = 'Cancelled';
            $status1 = $edit['status'];
            $full_name1 = $edit['full_name'];
            $sql = "UPDATE reservation_form1 SET status=:status WHERE full_name=:full_name";
            $stm = $db->prepare($sql);
            $result = $stm->execute(array(':full_name' => $full_name1, ':status' => $status1));
            if ($result){
              session_destroy();
              unset($_SESSION);
              ?>
                <script type="text/javascript">
                  alert("Reservation Cancelled!");
                  window.location.href = "pending.php"
                </script>
              <?php

            } else {
              echo "failed!";
            }
          } if(isset($_POST['send'])) {

            $email = $edit['email'];
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = "true";
            $mail->SMTPSecure = "tls";
            $mail->Port = "587";
            $mail->Username = "thehotel.booknow@gmail.com";
            $mail->Password = "1230hotel";
            $mail->Subject = "Hotel Reservation Payment";
            $mail->setFrom("thehotel.booknow@gmail.com");
            $mail->isHTML(true);
            $mail->Body = ' <img src="cid:Logo" /> '
                        . '<hr>'
                        . '<p style="text-align: center; margin: 5px; color: gray"> You received this email to confirm your booking.
                            If this was sent to you by mistake, please email us thehotel.booknow@gmail.com</p>'
                        . '<p style="text-align: center"> Hotel Address: 349-4 Sinam, Manila, Philippines </p>';
            $mail->AddEmbeddedImage('images/1.png', 'Logo');
            $mail->addAddress("$email");
            if ($mail->Send()) {
              session_destroy();
              unset($_SESSION);
              ?>
                <script type="text/javascript">
                  alert("Email sent!");
                  window.location.href = "pending.php"
                </script>
              <?php
            }else {
              echo "Error";
            }
            $mail->smtpClose();
          }
          ?>
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
          <script src="vendor/datatables/jquery.dataTables.js"></script>
          <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
          <!-- Custom scripts for all pages-->
          <script src="js/sb-admin.min.js"></script>
          <!-- Demo scripts for this page-->
          <script src="js/demo/datatables-demo.js"></script>
          <script src="js/demo/chart-area-demo.js"></script>
          </body>
          </html>
