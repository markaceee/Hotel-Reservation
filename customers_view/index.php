<?php
  require_once('connection.php');
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Hotel Reservation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="font/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script crossorigin="anonymous" src="https://kit.fontawesome.com/c8e4d183c2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/jQuery.js"></script>
    <script src="js/hotel.js"></script>

  </head>
  <body>

    <div class="container">
      <div class="book">
        <div class="description">
              <img src="images/logo1.png" alt="logo">
          <p>
            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOur hotel has a wide variety of greatly furnished and fully equipped rooms for every guest. Whether you are traveling for business or with family, we have what you need to enjoy your stay.
          </p>
          <div class="quote">
            <p>
            Take your pick. Make the most of your stay with these world-class rooms curated for you.
          </div>
          <div class="roomphotobox">
              <div class="roomphoto">
                <div class="slideshow-container">
                      <div class="mySlides fade">
                        <img src="images/single.jpg" style="width: 380px">
                        <div class="text">Single Room</div>
                      </div>
                      <div class="mySlides fade">
                        <img src="images/double.jpg" style="width: 380px">
                        <div class="text">Double Room</div>
                      </div>
                      <div class="mySlides fade">
                        <img src="images/deluxe.jpg" style="width: 380px">
                        <div class="text">Deluxe Room</div>
                      </div>
                      </div>

                      <div style="text-align:center">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                      </div>
              </div>
          </div>
          <div class="contacts" style="font-size: 11px">
            <span><i class="flaticon-envelope"></i> thehotel.booknow@gmail.com</span> &nbsp
            <span><i class="flaticon-24-hours"></i> 24/7 Customer Service </span> &nbsp
            <span><i class="flaticon-placeholder"></i> 349-4 Sinam, Manila, Philippines</span> &nbsp
          </div>
        </div>
        <div class="form" >
          <form action="index.php" method="post">
            <h1 style="color: #000000">Reservation Form</h1>
            <div class="inpbox full">
              <span><i class="flaticon-user"></i></span>
                <input type="text" placeholder="Full name"  name = "full_name"  id="full_name" required>
            </div>
            <div class="inpbox full">
              <span><i class="flaticon-call"></i></span>
              <input type="tel" placeholder="09xxxxxxxxx" pattern="09[0-9]{9}" name = "contact" id="contact" required>
            </div>
            <div class="inpbox full">
              <span><i class="flaticon-user"></i></span>
              <input type="email" placeholder="Email@gmail.com" name="email" id="email" required>
            </div>
            <div class="inpbox full">
              <span><i class="flaticon-user"></i></span>
              <input type="password" placeholder="Password"  name = "password" id="password" required>
            </div>
            <div class="inpbox full">
              <span><i class="flaticon-user"></i></span>
              <input type="password" placeholder="Confirm password"  name = "password"  required>
            </div>
            <div class="inpbox full">
            <span><i class="flaticon-add-group"></i></span>
              <select id="adults" name="adults" required>
                <option value=""> Number of Adults</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </div>

            <div class="inpbox full">
              <span><i class="flaticon-add-group"></i></span>
              <select id="children" name="children" >
                <option value="0">Number of Children</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
            </div>
            <div class="inpbox">
              <span><i class="flaticon-check-in"></i></span>
              <input type="date" placeholder="Check-in" name="check_in" id="check_in"  required>
            </div>
            <div class="inpbox">
              <span><i class="flaticon-check-out"></i></span>
              <input type="date" placeholder="Check-Out" name="check_out" id="check_out" required>
            </div>
            <div class="inpbox full">
              <div class="inrbox">
                <span><i class="flaticon-single-bed"></i>Single Room</span>
                <input type="radio" name="plan" value="Single_room" id="plan" required >
                <h2>₱1,500</h2>
                <span>per night</span>
              </div>
              <div class="inrbox">
                <span><i class="flaticon-bed-1"></i>Double Room</span>
                <input type="radio" name="plan" value="Double_room" id="plan1" required>
                <h2>₱3,000</h2>
                <span>per night</span>
              </div>
              <div class="inrbox">
                <span><i class="flaticon-bed"></i> Deluxe_Room</span>
                <input type="radio" name="plan" value="Deluxe_room" id="plan2" required>
                <h2>₱5,000</h2>
                <span>per night</span>
              </div>
            </div>
            <button type="submit" name="submit" class="subt" id="register"  >Submit</button>
            <button class="rst">Reset</button>
            <a class="alrdy" href="login.php"> Already have an account? </a>
          </form>
        </div>
      </div>
    </div>
    <!-- JAVASCRIPT -->
    <script>
      showSlides();
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_POST['submit'])){
          $full_name    = $_POST['full_name'];
          $contact      = $_POST['contact'];
          $email        = $_POST['email'];
          $adults       = $_POST['adults'];
          $children     = $_POST['children'];
          $check_in     = $_POST['check_in'];
          $check_out    = $_POST['check_out'];
          $plan         = $_POST['plan'];
          $password     = $_POST['password'];
          $status       = 'Pending';

          $sql_e        = "SELECT * FROM reservation_form1 WHERE email = ? LIMIT 1";
          $stmtselect   = $db->prepare($sql_e);
          $result1      = $stmtselect->execute([$email]);
          if ($result1){
            if ($stmtselect->rowCount() > 0){
              ?>
              <script type="text/javascript">
              Swal.fire(
              'Error',
              'Email already exist!',
              'error'
            )
              </script>
              <?php
            }else {
            $sql          = "INSERT INTO reservation_form1 (full_name, contact, email, adults, children, check_in, check_out, plan, password, status) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmtinsert = $db->prepare($sql);
            $result = $stmtinsert->execute([$full_name, $contact, $email, $adults, $children, $check_in, $check_out, $plan, $password, $status]);
            if($result){
              ?>
            <script type="text/javascript">
                Swal.fire(
                'Success',
                'Reservation saved!',
                'success'
              )
            </script>
                <?php
              }else {
                "There were errors while saving the data.";
              }
            }
          }
    }
     ?>
  </body>
</html>
