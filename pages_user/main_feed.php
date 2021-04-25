<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>My Feed</title>

  <!-- bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


  <style>
    <?php include '../stylesheets/user/main_feed.css'; ?>
  </style>
</head>

<body>
<?php 
    session_start();
    if (!isset($_SESSION["userID"])){
      $_SESSION["login_error_message"] = "Please login to continue.";
      header("Location: ./landing_page.php");
    }
     ?>
  <header>
    <nav class="navbar navbar-expand-md bg-light navbar-light">
      <a class="navbar-brand" href="./landing_page.php">Project Finder</a>
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
    

      <h3>Main Feed</h3>

  </div>

  <script>
    var clickHandler = () => {
      console.log("clicked")
    }

    removeButtonHandler = (element) => {

      element.parentElement.style.display = 'none';
      element.parentElement.submit();
    }


    var toggleNewProjectForm = () =>{
      var newProjectForm = document.getElementById("new-project-form-container");
      if (newProjectForm.style.display === "none"){
        newProjectForm.style.display = "block";
      } else{
        newProjectForm.style.display = "none";
        setProjectFormErrorMsg("")

      }
    }

    var setProjectFormErrorMsg = (msg) =>{
      var msgDiv = document.getElementById("new-project-form-error-msg");
      msgDiv.textContent = msg;
    }

    var checkProjectName = () =>{
      var projectName = document.getElementById("new_project_name");
      if (tripName.value.length === 0){
        setProjectFormErrorMsg("Project name cannot be empty.")
        return false
      } else{
        return true;
      }
    }

  </script>

  <!-- CDN for JS bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>





</body>

</html>