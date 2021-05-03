<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Create Projects</title>

  <!-- bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


  <style>
    <?php include '../stylesheets/owner/my_projects.css'; ?>
  </style>
</head>

<body>
<?php 
    session_start();
    if (!isset($_SESSION["ownerID"])){
      $_SESSION["login_error_message"] = "Please login to continue.";
      header("Location: ./landing_page.php");
    }
     ?>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="./landing_page.php">Project Finder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">My Projects <span class="sr-only">(current)</span></a>
          </li>
          <!-- <li class="nav-item active">
            <a class="nav-link" href="./createpj_page.php">Create New Projects  <span class="sr-only">(current)</span> </a>
          </li> -->
        </ul>
      <div class="btn-group">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          My Profile
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-item-text text-nowrap">
            
            <?php if(isset($_SESSION["ownerID"])){
                echo "Logged in as $_SESSION[ownerID]";
                echo " [Project Owner]";
              } else{
                echo "Logged in as $_SESSION[userID]";
              }
              
              ?>
          </div>
          <a class="dropdown-item" href="#">My profile</a>
          <a class="dropdown-item"  href="./logout.php">Log out</a>
        </div>
      </div>
    </nav>
</header>

  <div class="container">
    
    <?php
      require_once('../php/library.php');
      $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
      // Check connection
      if (mysqli_connect_errno()) {
        echo("Can't connect to MySQL Server. Error code: " .
        mysqli_connect_error());
        return null;
      }
      
      mysqli_close($con);
    ?>
      

      <div id="login-signup-panel" style="display: block">
      <form id="login-signup-panel-form" onsubmit="return checkLoginCredentials()" action="../php/owner/create_project.php" method="post">

      <h3 id="login-signup-panel-title">Create Projects</h3>
      <div class="signup-msg">
            <?php 
              if(isset($_SESSION['signup_success'])) {
                if( $_SESSION["signup_success"]){
                  echo "<div style='color: green'>" . "Sign up success! Please log in." . "</div>";
                } else{
                  echo "<div style='color: red'>" . $_SESSION['signup_error_message'] . "</div>";
                }
              }
              ?>
        </div>

        <div class="form-group">
          <label >Project Name</label>
          <input type="text" name="pjname" class="form-control"  
            placeholder="Enter Project Name">
        </div>
       
        <div class="form-group">
          <label>Max participant</label>
          <input type="text" name="max" class="form-control"  placeholder="Maximum number">
        </div>
       
        
        <div class="form-group" id="signup-name">
          <label >Project Description</label></br>
          <textarea name="pjtext" class="form-control"  style="width:400px; height:120px;" placeholder="Enter Project  Description"></textarea>
        </div>

        <div class="submit-button">
          <button id="login-button" type="submit" class="btn btn-primary" onclick="location.href='#';">Create</button>
        </div>

      </form>
      
    </div>



  </div>

  </div>

  <!-- CDN for JS bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>

</body>

</html>