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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="./landing_page.php">Project Finder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="./main_feed.php">Main Feed <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
          <a class="nav-link" href="#">My Followed Projects <span class="sr-only">(current)</span></a>

          </li>

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

  <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
    

  <?php
    require_once('../php/library.php');
    $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
    // Check connection
    if (mysqli_connect_errno()) {
    echo("Can't connect to MySQL Server. Error code: " .
    mysqli_connect_error());
    return null;
    }
    // Form the SQL query (a SELECT query)
    $sql="SELECT * 
    FROM 
      (SELECT * FROM Project NATURAL JOIN Joins) AS joined
    WHERE userID = '$_SESSION[userID]'";


    $result = mysqli_query($con, $sql);
    echo "<div style='width: 100%; flex-direction: column; align-items:center;' class='d-flex'>
            <h3>My Projects</h3>
            </div>";
    while($row = mysqli_fetch_array($result)){
    	echo $row['projectID'];
	echo $row['userID'];
	echo "\r\n";
    }
  ?>

      

  </div>

  <script>
    var hideFullProjectsHandler = () => {
      console.log("clicked");
      var fullPreferedProjects = document.getElementsByClassName("project-full");
      var fullOtherProjects = document.getElementsByClassName("other-project-full");
      
      var otherProjectsCount = document.getElementById("other-projects-count");
      var otherProjectsHiddenCount = document.getElementById("other-projects-hidden-count");

      var toggleFullProjectsBtn = document.getElementById("toggleFullProjectsBtn");
      if (toggleFullProjectsBtn.textContent == "Hide full projects"){
        hideProjects(fullPreferedProjects, fullOtherProjects);
        toggleFullProjectsBtn.textContent = "Show full projects";
        otherProjectsHiddenCount.textContent = parseInt(otherProjectsHiddenCount.textContent) + fullOtherProjects.length;
      } else{
        showProjects(fullPreferedProjects, fullOtherProjects);
        toggleFullProjectsBtn.textContent = "Hide full projects";
        otherProjectsHiddenCount.textContent = parseInt(otherProjectsHiddenCount.textContent) - fullOtherProjects.length;
      }
      if (otherProjectsCount.textContent == otherProjectsHiddenCount.textContent){
        var otherTitle = document.getElementById("other-projects-title");
        otherTitle.style.display = "none";
      } else if (otherProjectsCount.textContent > otherProjectsHiddenCount.textContent && parseInt(otherProjectsCount.textContent) > 0){
        var otherTitle = document.getElementById("other-projects-title");
        otherTitle.style.display = "block";
      }
    }

    var hideProjects = (fullPreferedProjects, fullOtherProjects) =>{
      for (var i = 0; i < fullPreferedProjects.length; i ++){
        // console.log(fullPreferedProjects[i])
        fullPreferedProjects[i].style.display = "none";
      }
      for (var i = 0; i < fullOtherProjects.length; i ++){
        // console.log(fullPreferedProjects[i])
        fullOtherProjects[i].style.display = "none";
      }

    }

    var showProjects = (fullPreferedProjects, fullOtherProjects) =>{
      for (var i = 0; i < fullPreferedProjects.length; i ++){
        // console.log(fullPreferedProjects[i])
        fullPreferedProjects[i].style.display = "block";
      }
      for (var i = 0; i < fullOtherProjects.length; i ++){
        // console.log(fullPreferedProjects[i])
        fullOtherProjects[i].style.display = "block";
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