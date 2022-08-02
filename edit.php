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
              <a href="customer_account_view.php">Welcome <?php print($rowAcc['full_name']) ?>! </a>
              </li>
              &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              <li class="nav-item">
                    <a href="edit.php">Edit</a>

              </li>.
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="customer_account_view.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
          </ul>
          </div>
      </nav>

    <form style="margin: 50px;" action="edit.php"  method="POST">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Contact</label>
        <input type="tel" class="form-control" pattern="09[0-9]{9}" name="contact" value="<?php print($rowAcc['contact']) ?>">
      </div>
      <div class="form-group col-md-6">
        <label>Password</label>
        <input type="text" class="form-control" name="password" value="<?php print($rowAcc['password']) ?>">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="<?php print($rowAcc['email']) ?>" >
      </div>
      <div class="form-group col-md-6">
        <label>Plan</label>
        <select class="form-control" name="plan">
          <option value="<?php print($rowAcc['plan']) ?>"><?php print($rowAcc['plan']) ?></option>
          <option value="Single_room">Single room</option>
          <option value="Double_room">Double room</option>
          <option value="Deluxe_room">Deluxe room</option>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Number of Adults</label>
        <select class="form-control" name="adults" >
          <option value="<?php print($rowAcc['adults']) ?>"><?php print($rowAcc['adults']) ?></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>
      <div class="form-group col-md-6">
        <label>Number of Children</label>
        <select class="form-control" name="children" >
          <option value="<?php print($rowAcc['children']) ?>"><?php  print($rowAcc['children']) ?></option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Check In</label>
        <input type="date" class="form-control"  name="check_in" value="<?php print($rowAcc['check_in']) ?>">
      </div>
      <div class="form-group col-md-6">
        <label>Check Out</label>
        <input type="date" class="form-control" name="check_out" value="<?php print($rowAcc['check_out']) ?>">
      </div>
    </div>
    <?php
  }

  ?>

    <?php

    if ($rowAcc['status'] == 'Cancelled' || $rowAcc['status'] == 'Checked-out') {
      ?>
        <button type="submit" name="new_reservation" class="btn btn-warning">New</button>
      <?php
    }else if ($rowAcc['status'] == 'Pending'){
      ?>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
      <?php
    }


     ?>
  </form>

<?php
if (isset($_POST['update'])) {
  $contact   = $_POST['contact'];
  $email     = $_POST['email'];
  $adults    = $_POST['adults'];
  $children  = $_POST['children'];
  $check_in  = $_POST['check_in'];
  $check_out = $_POST['check_out'];
  $plan      = $_POST['plan'];
  $password  = $_POST['password'];
  $full_name = $user['full_name'];
  //$sql       = "INSERT INTO reservation_form1 (full_name, contact, email, adults, children, check_in, check_out, plan, password, status) VALUES (?,?,?,?,?,?,?,?,?,?)";
  $sql       = "UPDATE reservation_form1 SET contact=:contact, email=:email, adults=:adults, children=:children,
       check_in=:check_in, check_out=:check_out, plan=:plan, password=:password WHERE full_name=:full_name";
  $stm = $db->prepare($sql);
  $result = $stm->execute(array(':full_name' => $full_name, ':contact' => $contact, ':email' => $email,':adults' => $adults,
      ':children' => $children,':check_in' => $check_in,':check_out' => $check_out,':plan' => $plan,
      ':password' => $password)); //execute prepared query

  if ($result) {
      header("Location: customer_account_view.php");
      if ($user['email'] != $email){
        session_destroy();
      }
    }
  }
  if (isset($_POST['new_reservation'])) {
    $contact   = $_POST['contact'];
    $email     = $_POST['email'];
    $adults    = $_POST['adults'];
    $children  = $_POST['children'];
    $check_in  = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $plan      = $_POST['plan'];
    $password  = $_POST['password'];
    $full_name = $user['full_name'];
    $status    = 'Pending';
    //$sql       = "INSERT INTO reservation_form1 (full_name, contact, email, adults, children, check_in, check_out, plan, password, status) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $sql       = "UPDATE reservation_form1 SET contact=:contact, email=:email, adults=:adults, children=:children,
         check_in=:check_in, check_out=:check_out, plan=:plan, password=:password, status=:status WHERE full_name=:full_name";
    $stm = $db->prepare($sql);
    $result = $stm->execute(array(':full_name' => $full_name, ':contact' => $contact, ':email' => $email,':adults' => $adults,
        ':children' => $children,':check_in' => $check_in,':check_out' => $check_out,':plan' => $plan,
        ':password' => $password, ':status' => $status)); //execute prepared query
    if ($result) {
      ?>
      <script type="text/javascript">
        alert("New Reservation Saved!");
        window.location.href = "customer_account_view.php";
      </script>
      <?php
        if ($user['email'] != $email){
          session_destroy();
        }
      }
    }
  ?>
</body>
</html>
