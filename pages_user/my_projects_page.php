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
          <a class="dropdown-item" href="./profile.php">My profile</a>
          <a class="dropdown-item"  href="./logout.php">Log out</a>
        </div>
      </div>
    </nav>
</header>

  <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
    

  <?php
    require_once('../php/user_user.php');
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
      (SELECT * FROM Project NATURAL JOIN Joins NATURAL JOIN Has) AS joined
    WHERE userID = '$_SESSION[userID]'";


    $result = mysqli_query($con, $sql);
    echo "<div style='width: 100%; flex-direction: column; align-items:center;' class='d-flex'>
            <h3>My Followed Projects</h3>
            </div>";
    while($row = mysqli_fetch_array($result)){
	$participant_count_sql = "SELECT COUNT(projectID) AS member_count, projectID FROM (SELECT * FROM Has NATURAL JOIN Project) AS project_info NATURAL JOIN Joins WHERE projectID='$row[projectID]' GROUP BY projectID";
        $count_result = mysqli_query($con, $participant_count_sql);
        if (mysqli_num_rows($count_result) == 0) { 
          $curr_participants = 0;
       } else { 
        while($count_row = mysqli_fetch_array($count_result)) {
          $curr_participants = $count_row["member_count"];
        }
       }

       $project_membership_query = "SELECT * FROM Joins WHERE userID = '$_SESSION[userID]' AND projectID = '$row[projectID]'";
       $project_membership_result = mysqli_query($con, $project_membership_query);
       if(mysqli_num_rows($project_membership_result) == 0){
        $in_project = false;

       } else{
         $in_project = true;

       }

       $participant_fill_percentage = $curr_participants / $row["max_participants"] * 100;
        echo "
        <form style='min-width: 60%; max-width: 60%; padding-top: 20px; padding-bottom: 20px;' action='../php/user/follow_project.php' method='post'
          ";
          if($participant_fill_percentage == 100){
            echo "class='project-full'";
          }
          echo "  >
          <input style='display: none;' name='projectID' value='". $row['projectID'] ."'>
          <div class='card' >
            <div class='card-body'>
              <div style='display:flex; justify-content:space-between; align-items: center;'>
                <h5 class='card-title'>". $row['project_name'] ."</h5>";
                if($in_project){
                  echo "<button type='submit' class='btn' style='background-color: #FF2C55; color: white;'>Unfollow</button>
                  <input name='formAction' value='unfollow' hidden>";      
                } else if ($participant_fill_percentage == 100){
                  echo "<button type='submit' class='btn btn-secondary' disabled>Project Full</button>";
                        
                } else{
                  echo "<button type='submit' class='btn btn-primary' >Follow</button>
                        <input name='formAction' value='follow' hidden>";
                }
	echo "</div>
              <h6 class='card-subtitle mb-2 text-muted'>". $row['category_name'] ."</h6>
              <div class='card-text'>". $row['project_description'] ."</div>
              <div class='project-capacity' style='padding-top: 10px; padding-bottom: 10px;'>
                <div style='display: flex; justify-content: space-between; align-items: center;'>
                  <div>Current participants:</div>
                  <div class='progress' style='width: 70%'>";
                  if($curr_participants > 0){
                    echo "<div class='progress-bar' role='progressbar' style='width: ". $participant_fill_percentage ."%;' aria-valuenow='". $curr_participants ."' aria-valuemin='0' aria-valuemax='10'>". $curr_participants ."</div>";

                  } else{
                    echo "<div class='progress-bar' role='progressbar' style='width: 5%;' aria-valuenow='". $curr_participants ."' aria-valuemin='0' aria-valuemax='10'>". 0 ."</div>";
                  }

            echo "</div>
                </div>
                
              </div>
              <div style='font-weight: bold;'>Max participants: ". $row['max_participants'] ."</div>
      
            </div>
          </div>
        </form>";
    }
  ?>

      

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