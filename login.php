<?php
  require_once('connection.php');
  session_start();
  if (isset($_SESSION['email_login'])) {
      header("Location: customer_account_view.php");
  }
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
        <strong>Login Account</strong>
        <form method="post">
            <a href="index.php" id="cancel-acc" class="cancel-form"><i class="fas fa-times-circle"></i></a>
            <input type="text" name="email" id="email" placeholder="Email@gmail.com">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" name="submit" id="login" value="Login">
            <a href="forgot.php" class="forgot" style="color: black; font-family: 'Roboto'">Forgot password?</a>
        </form>

      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
    $(function(){
      $('#login').click(function(e){
        var valid = this.form.checkValidity();
        if(valid){
            var email       = $('#email').val();
            var password    = $('#password').val();
          }
            e.preventDefault();
            $.ajax({
                    type: 'POST',
                    url: 'jslogin.php',
                    data: {email: email, password: password},
                    success: function(data){
                      alert(data);
                      if(data){
                        setTimeout(' window.location.href = "customer_account_view.php"', 2000);
                      }
                    },
                    error: function(data){
                      alert("Error");
                    }
            });
          });
        });
    </script>
  </body>
</html>
