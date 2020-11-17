<?php
include_once "./php/config.php";
include_once "./php/permissions.php";
include_once "./php/boilerplate.php";
?>

<!DOCTYPE html>

<head>
  <title>PEX.co.uk</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css"    type="text/css">
  <link rel="stylesheet" href="./css/apod.css"             type="text/css">
  <link rel="stylesheet" href="./css/carousel.css"         type="text/css">
  <link rel="stylesheet" href="./css/style.css"            type="text/css">
  <link rel="stylesheet" href="./css/tooltip-viewport.css" type="text/css">

</head>

<body>

  <!-- <nav class="navbar navbar-expand-sm navbar-dark bg-dark menu-font-size"> -->
  <nav class="navbar navbar-expand-sm navbar-dark menu-font-size">
    <a class="navbar-brand ptolemy-brand" href="index.php">
      <h1>Ptolemy Exchange</h1>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03"
      aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="nav-items collapse navbar-collapse " id="navbarsExample03">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item <?= (basename(($_SERVER['PHP_SELF']))=='index.php')? 'active' : ''; ?>">
          <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a> 
        </li>

        <li class="nav-item">
          <li class="nav-item <?= (basename(($_SERVER['PHP_SELF']))=='about.php')? 'active' : ''; ?>">
            <a class="nav-link" href="about.php">About</a>
          </li>
        </li>

        <li class="nav-item <?= (basename(($_SERVER['PHP_SELF']))=='contact.php')? 'active' : ''; ?>">
          <a class="nav-link" href="contact.php">Contact <span class="sr-only">(current)</span></a>
        </li>

        <?php if (isset($_SESSION['user_details'])) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown03" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown03">

              <!-- MENU ITEM: Profile -->
              <a class="dropdown-item" href="profile.php">Profile</a>
              
              <?php if ( HasMemberAccess($_SESSION['user_details']['user_permissions']) ) {?>

                <!-- MENU ITEM: Members ... Gallery -->
                <a class="dropdown-item" href="gallery.php">Member Gallery</a>

                <!-- MENU ITEM: Members ... Search -->
                <a class="dropdown-item" href="#">Search</a>
              <?php } ?>
              
              <?php if ( HasAdminAccess($_SESSION['user_details']['user_permissions']) ) {?>

                <!-- MENU ITEM: Admin -->
                <a class="dropdown-item" href="#">User admin</a>
              <?php } ?>

              <!-- MENU ITEM: {Dummy} -->
              <a class="dropdown-item" href="#">Another action</a>
              
              <!-- MENU ITEM: Sign Out -->
              <?php include_once("sign_out.php"); ?>
              
            </div>
          </li>
        <?php } else { ?>
          <li class="nav-item <?= (basename(($_SERVER['PHP_SELF']))=='sign_up.php')? 'active' : ''; ?>">
            <a class="nav-link" href="sign_up.php">Register</a>
          </li>
          
          <li class="nav-item <?= (basename(($_SERVER['PHP_SELF']))=='sign_in.php')? 'active' : ''; ?>">
            <a class="nav-link" href="sign_in.php">Login </a>            
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>