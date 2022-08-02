<?php
  require_once('../connection.php');
  session_start();
  if (isset($_SESSION['admin'])) {
    header("Location: main.php");
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
    <title>Login</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
  </head>

  <body class="bg-dark">
    <div class="container">
      <br><br><br><br><br>
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
          <form method="post">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="user" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Username</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary btn-block" value="Login">
          </form>

        </div>
      </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
      $user_admin   = $_POST['user'];
      $pass_admin   = $_POST['pass'];
      $sql          = "SELECT * FROM admin WHERE user_admin = ? AND pass_admin = ? LIMIT 1";
      $stmtselect   = $db->prepare($sql);
      $result       = $stmtselect->execute([$user_admin, $pass_admin]);
      if ($result) {
              $admin = $stmtselect->fetch(PDO::FETCH_ASSOC);
              if($stmtselect->rowCount() > 0){
                $_SESSION['admin'] = $admin;
                ?>
                    <script type="text/javascript">
                      alert("Login Successful");
                      window.location.href = "main.php";
                    </script>
                  <?php
              }else {
                ?>
                    <script type="text/javascript">
                      alert("Username and password does not match!");
                    </script>
                  <?php
                }
      }
    }




     ?>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>

</html>
