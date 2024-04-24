<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Add this CSS rule to control the maximum width of the reCAPTCHA container */
    .g-recaptcha {
      max-width: 100%;
    }
  </style>
  <link href="bootstrap.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
  <style>
    /* Media query for screen width 768px and above */
    @media (min-width: 768px) {

      /* Add margin to the top for larger screens */
      .custom-mt-md-5 {
        margin-top: 200px !important;
      }

      /* Force text alignment to left for larger screens */
      .text-md-left {
        text-align: left !important;
      }
    }

    /* Media query for screen width up to 767px */
    @media (max-width: 767px) {

      /* Adjust margin to the top for smaller screens */
      .custom-mt-md-5 {
        margin-top: 10px !important;
      }
    }
  </style>

  <style>
    /* Media query for screen width up to 767px */
    @media (max-width: 767px) {

      /* Center text alignment and adjust margin for smaller screens */
      .custom-mt-md-5 {
        text-align: center !important;
        margin-top: 10px !important;
      }
    }

    /* Media query for screen width 768px and above */
    @media (min-width: 768px) {

      /* Reset text alignment to left and adjust margin for larger screens */
      .custom-mt-md-5 {
        /* text-align: center !important;  */
        margin-top: 200px !important;
        margin-right :430px !important;
      }
    }
  </style>

  <style>
    /* Media query for screen width 992px and above */
    @media (min-width: 992px) {

      /* Adjust positioning for larger screens */
      .custom-button-container {
        position: relative !important;
        top: -90px !important;
        left: 280pt !important;
      }
    }
  </style>


  <style>
    /* Media query for screen width up to 768px */
    @media (max-width: 768px) {

      /* Adjust font size and positioning for smaller screens */
      .small-device-text {
        font-size: 10px !important;
        /* Reduce font size for small screens */
        top: -100px !important;
        /* Adjust vertical positioning */
        left: 380pt !important;
        /* Adjust horizontal positioning */
      }
    }
  </style>

  <style>
    /* Media query for screen width up to 768px */
    @media (max-width: 768px) {

      /* Adjust top padding for smaller screens */
      .col-md-6.pt-5 {
        padding-top: 100px;
        /* Adjust padding as needed */
      }
    }

    /* Media query for screen width up to 576px */
    @media (max-width: 576px) {

      /* Adjust the size of the logo for small screens */
      .logo-container.logo-size {
        width: 10%;
        /* Adjust this value as needed */
        top: -100px !important;
        /* Adjust vertical positioning */
        left: 280pt !important;
        /* Adjust horizontal positioning */
      }
    }
  </style>
     <style>
          @media (max-width: 576px) {
            .logo-container {
              text-align: left;
            }
          }

          @media (min-width: 577px) {
            .logo-container {
              text-align: center;
            }
          }
        </style>



  <!-- <div class="row pt-3"> -->
  <div class="row ">
    <div class="col-md-6 pt-5">
      <div class="col-md-6">
        <!-- <h7 style="color: #295DA4;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;DESIGNED BY</h7> -->
        <h7 class="small-device-text" style="color: #295DA4;">
          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        </h7>


        <!-- <center>
                <a href="https://www.innov8ivess.com">
                    <img class="logo-size img-fluid" src="images/innologo.png" alt="Innov8ivess Logo" style="width:60%;">
                </a>
            </center> -->
   

        <!-- <div class="logo-container">
          <a href="https://www.innov8ivess.com">
            <img class="logo-size img-fluid" src="images/innologo.png" alt="Innov8ivess Logo" style="width:60%;">
          </a>
        </div> -->

      </div>
      <center>
        <img class="logo-size img-fluid" src="images/eye.png" alt="clock image" style="width: 100%;">
      </center>

      <!-- <div class="text-center clocks-image"> -->
      <!-- <img class="logo-size img-fluid mx-auto w-40" src="images/clocks.jpg" alt="clock image">
      </div> -->
    </div>

    <div class="col-md-6 pt-md-5 pt-0">

      <!-- Logo container with text-center alignment and margin adjustments for different screen sizes -->
      <div class="text-center custom-mt-md-5 pga-logo">
        <!-- Link to the PGA Architects website -->
        <a href="https://www.pgaarchitects.co.za">
          <!-- Logo image with responsive styling -->
          <img class="logo-size img-fluid" src="images/dopslogo.png" alt="DOPSLogo" style="width: auto;">
        </a>
      </div>

      <div class="container-fluid pt-5">
        <div class="col-md-6">
          <form action="php_login.php" method="post">
            <?php if (isset($_SESSION["error"]) && $_SESSION["error"] != "") { ?>
              <div class="alert alert-danger">
                <?= $_SESSION["error"]; ?>
              </div>
            <?php
              $_SESSION["error"] = "";
            } ?>

            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" style="width: 100%;" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" style="width: 100%;" required>
            </div>
            
            <div class="mb-3">
              <div class="g-recaptcha" data-sitekey="6LcymeInAAAAAH1FqlEet22KBAqTFAx4g3i2IQnG"></div>
              <br>
              <a href="password-reset.php">Forgot Password?</a>
            </div>

            <!-- <div class="mb-3 text-center text-md-left"> -->
            <!-- <button type="submit" class="btn btn-primary mt-2" name="login">Login</button> -->
            <!-- </div> -->
            
            <div class="mb-3 text-center text-md-left custom-button-container">
              <button type="submit" class="btn btn-primary mt-2" name="login">Login</button>

            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
  </div>

</body>

</html>

<script>
  
</script>