<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Template</title>


  <!-- Code to allow bootstrap -->
  <!-- Bootstrap provides nice styles for elements like buttons and forms -->
  <!-- Documentation: https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- This is how you include a style sheet in PHP -->
  <style>
    <?php 
        include '../stylesheets/user/template.css'; 
    ?>
  </style>

</head>

<body>
    <?php 
        //  This starts the user session. Allows you to access the $_SESSION object in PHP
        // I use the $_SESSION object to store things like userID/ownerID
        session_start();
     ?>

    <!-- Header element contains the navbar -->
  <header>
    <nav class="navbar navbar-expand-md bg-light navbar-light">
      <a class="navbar-brand" href="./pages_user/landing_page.php">Project Finder</a>
      <text class="nav-link" >Logged in as <?php echo $_SESSION["userID"];?></text>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">

          <li class="nav-item">
            <a class="nav-link" href="logout.php">Log out</a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- Checks if the user/owner is logged in. If they're not, redirects them to the landing_page -->
  <?php 
    // For users
        // if (!isset($_SESSION["userID"])){
        //   $_SESSION["login_error_message"] = "Please login to continue.";
        //   header("Location: ./landing_page.php");
        // }

    //For Owners
        // if (!isset($_SESSION["ownerID"])){
        //     $_SESSION["login_error_message"] = "Please login to continue.";
        //     header("Location: ./landing_page.php");
        //   }

     ?>

  <div class="container">
    <!-- This gets the DB credentials from the PHP folder and connects to phpMyAdmin  -->
    <?php
      require_once('./php/library.php');
      $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
      // Check connection
      if (mysqli_connect_errno()) {
        echo("Can't connect to MySQL Server. Error code: " .
        mysqli_connect_error());
        return null;
      }
      
      mysqli_close($con);
    ?>
  </div>

  

  <!-- Some boiler plate code, best to leave it (not sure what it does) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>

</body>

</html>