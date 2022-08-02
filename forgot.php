<?php
  require_once('connection.php');
  require 'admin/includes/PHPMailer.php';
  require 'admin/includes/SMTP.php';
  require 'admin/includes/Exception.php';
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="font/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script crossorigin="anonymous" src="https://kit.fontawesome.com/c8e4d183c2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="./js/jQuery.js"></script>
  </head>
  <body>
    <div id="LogIn" class="login-form">
      <div class="login-acc">
        <strong>Forgot password</strong>
        <form method="post">
            <a href="login.php" id="cancel-acc" class="cancel-form"><i class="fas fa-times-circle"></i></a>
            <input type="text" name="email" id="email" placeholder="Email@gmail.com">
            <input type="submit" name="submit" id="login" value="Send">
        </form>
      </div>
    </div>
    <?php
      if(isset($_POST['submit'])){
        $email      = $_POST['email'];
        $pass       = rand(100000, 999999);
        $sql        = "SELECT * FROM reservation_form1 WHERE email = ?";
        $stmtselect = $db->prepare($sql);
        $result     = $stmtselect->execute([$email]);
        if ($result) {
          if($stmtselect->rowCount() == 1){
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = "true";
            $mail->SMTPSecure = "tls";
            $mail->Port = "587";
            $mail->Username = "thehotel.booknow@gmail.com";
            $mail->Password = "1230hotel";
            $mail->Subject = "New password";
            $mail->setFrom("thehotel.booknow@gmail.com");
            $mail->isHTML(true);
            $mail->Body = "<h2> New password: </h2>"
                        . $pass;
            $mail->addAddress("$email");
            $mail->Send();
            $mail->smtpClose();

            $sql1       = "UPDATE reservation_form1 SET password=:password WHERE email=:email";
            $stm1 = $db->prepare($sql1);
            $result = $stm1->execute(array(':password' => $pass, ':email' => $email));
              ?>
                <script type="text/javascript">
                    alert("Password sent!");
                </script>
              <?php
               //execute prepared query
          }else {
            ?>
            <script type="text/javascript">
              alert("Email does not exist!");
            </script>
            <?php
          }
        }

      }


     ?>
