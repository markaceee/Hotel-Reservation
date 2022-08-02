<?php
  session_start();
  require_once('connection.php');
  $email      = $_POST['email'];
  $password   = $_POST['password'];
  $sql        = "SELECT * FROM reservation_form1 WHERE email = ? AND password = ? LIMIT 1";
  $stmtselect = $db->prepare($sql);
  $result     = $stmtselect->execute([$email, $password]);
  if ($result) {
      $user = $stmtselect->fetch(PDO::FETCH_ASSOC);
      if($stmtselect->rowCount() > 0){
          $_SESSION['email_login'] = $user;
          echo "Login Successful";
      }else {
          echo "Email and password doesn't exist or match!";
        }
  }
  else {
      echo "There were errors while connecting to database";
  }
 ?>
