<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Blacklist users</title>

  <!-- bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


  <style>
    <?php include '../stylesheets/owner/blacklist_page.css'; ?>
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
          <li class="nav-item active">
            <a class="nav-link" href="./createpj_page.php">Create New Projects  <span class="sr-only">(current)</span> </a>
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


<div class="container">
    <?php
        include_once("../php/library.php"); // To connect to the database

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
        // Check connection
        if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        //list out users
        $result = mysqli_query($con,"SELECT * FROM Joins WHERE projectID = 'ABCD1234'");

        echo "<h3>Current Available Users</h3>";
        echo "<table border='1' class='usertable' >
        <tr>
        <th>User ID</th>
        <th>Project ID</th>
        </tr>";

        while($row = mysqli_fetch_array($result))
        {
        echo "<tr>";
        echo "<td>" . $row['userID'] . "</td>";
        echo "<td>" . $row['projectID'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";
    
        echo "<form action='../php/owner/blacklist.php' method='post' class='blacklistinput'> 
        <input type='text' name='userID' placeholder='Enter wanted user's ID to blacklist'>
        <input type='text' name='pjID' placeholder='Enter pj's ID to blacklist'>
        <br/>
        <button  type='submit' class='btn btn-primary' onclick='location.href='./blacklist_page.php';'>Bye</button>
         </form>";

         $result2 = mysqli_query($con,"SELECT * FROM Blacklist WHERE projectID = 'ABCD1234'");
        
        echo "<h3>Current Blacklisted Users</h3>";
        echo "<table border='1' class='bltable' >
        <tr>
        <th>User ID</th>
        <th>Project ID</th>
        </tr>";

        while($row2 = mysqli_fetch_array($result2))
        {
        echo "<tr>";
        echo "<td>" . $row2['userID'] . "</td>";
        echo "<td>" . $row2['projectID'] . "</td>";
        echo "</tr>";
        }
        echo "</table>";

        echo "<form action='../php/owner/blacklistback.php' method='post' class='blacklistinput'> 
        <input type='text' name='userID' placeholder='Enter wanted user's ID to blacklist'>
        <input type='text' name='pjID' placeholder='Enter pj's ID to blacklist'>
        <br/>
        <button  type='submit' class='btn btn-primary' onclick='location.href='./blacklist_page.php';'>Comeback</button>
         </form>";

        if (!mysqli_query($con,$result)) {
            die('Error: ' . mysqli_error($con));
        }  

        if (!mysqli_query($con,$result2)) {
          die('Error: ' . mysqli_error($con));
      }  

        

        
        mysqli_close($con);
    ?>

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
    
    <h3> header3</h3>
    


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