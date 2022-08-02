<?php
  require_once('connection.php');
  session_start();
  if (!isset($_SESSION['email_login'])) {
      header("Location: index.php");
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION);
    header("Location: index.php");
  }
  $user = $_SESSION['email_login'];
 ?>
<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <title>Customer account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/jQuery.js"></script>
  </head>
  <body>
    <?php
    $sql        = "SELECT * FROM reservation_form1 WHERE email = ?";
    $stmtselect = $db->prepare($sql);
    $result     = $stmtselect->execute([$user['email']]);
    $rowAcc     = $stmtselect->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        ?>
  <nav class="navbar navbar-expand-sm bg-dark">
  <div class="container-fluid">
  <!--<img src="../images/logo.png" alt="Logo">-->
    <ul class="nav navbar-nav navbar-left">
        <li class="nav-item">
          <a href="">Welcome <?php print($user['full_name']) ?>! </a>
        </li>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <li class="nav-item">
          <?php
            if ($rowAcc['status'] == 'Pending' || $rowAcc['status'] == 'Cancelled' || $rowAcc['status'] == 'Checked-out') {
              ?>
              <a href="edit.php">Edit</a>
              <?php
            }
           ?>
        </li>.
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="customer_account_view.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
    </ul>
    </div>
</nav>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col"> </th>
      <th scope="col">Full name</th>
      <th scope="col">Contact</th>
      <th scope="col">Email</th>
      <th scope="col">No. of Adult</th>
      <th scope="col">No. of Children</th>
      <th scope="col">Check In</th>
      <th scope="col">Check Out</th>
      <th scope="col">Type of Plan</th>
      <th scope="col">Status</th>
      <th scope="col">Button</th>
    </tr>
  </thead>
  <tbody>
        <form method="POST">
        <tr>
          <th scope="row">1</th>
          <td><?php  print($rowAcc['full_name']) ?></td>
          <td><?php  print($rowAcc['contact']) ?></td>
          <td><?php  print($rowAcc['email']) ?></td>
          <td><?php  print($rowAcc['adults']) ?></td>
          <td><?php  print($rowAcc['children']) ?></td>
          <td><?php  print($rowAcc['check_in']) ?></td>
          <td><?php  print($rowAcc['check_out']) ?></td>
          <td><?php  print($rowAcc['plan']) ?></td>
          <?php
          if ($rowAcc['status'] == 'Pending') {
            ?>
            <td><span class="badge badge-warning"><?php  print($rowAcc['status']) ?></span></td>
            <?php
          }else if ($rowAcc['status'] == 'Cancelled') {
            ?>
            <td><span class="badge badge-danger"><?php  print($rowAcc['status']) ?></span></td>
            <?php
          }else if ($rowAcc['status'] == 'Checked-out') {
            ?>
            <td><span class="badge badge-primary"><?php  print($rowAcc['status']) ?></span></td>
            <?php
          }else if ($rowAcc['status'] == 'Confirmed') {
            ?>
            <td><span class="badge badge-success"><?php  print($rowAcc['status']) ?></span></td>
            <?php
          }else {
            ?>
            <td><span class="badge badge-secondary"><?php  print($rowAcc['status']) ?></span></td>
            <?php
          }
           ?>
           <td>
             <?php
             if ($rowAcc['status'] == 'Pending'){
             ?>
             <button type="submit" name="button" style="background-color: #DC3545; color: white; border: none; border-radius: 5px;">Cancel</button>
             <?php
           }
              ?>
           </td>
        </tr>
      </form>
          <?php
          if(isset($_POST['button'])) {
            $rowAcc['status'] = 'Cancelled';
            $status = $rowAcc['status'];
            $full_name = $rowAcc['full_name'];
            $sql1 = "UPDATE reservation_form1 SET status=:status WHERE full_name=:full_name";
            $stm1 = $db->prepare($sql1);
            $result1 = $stm1->execute(array(':full_name' => $full_name, ':status' => $status));
            if ($result1){
              ?>
                <script type="text/javascript">
                  alert("Reservation Cancelled");
                  window.location.href = "edit.php";
                </script>
              <?php
            } else {
              echo "failed!";
            }
          }
    }

     ?>
  </tbody>
</table>
<br>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i> <strong>note*</strong> For the confirmation of this booking, kindly check your e-mail account
to settle your payment for the reservation.</i>
  </body>
</html>
