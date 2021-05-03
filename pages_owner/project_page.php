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
        include '../stylesheets/owner/project_page.css'; 
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="./landing_page.php">Project Finder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">My Projects<span class="sr-only">(current)</span></a>
      
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

  <!-- Checks if the user/owner is logged in. If they're not, redirects them to the landing_page -->
  <?php 
    // For users
        // if (!isset($_SESSION["userID"])){
        //   $_SESSION["login_error_message"] = "Please login to continue.";
        //   header("Location: ./landing_page.php");
        // }

    //For Owners
        if (!isset($_SESSION["ownerID"])){
            $_SESSION["login_error_message"] = "Please login to continue.";
            header("Location: ./landing_page.php");
          }

     ?>

  <div class="container">
    <!-- This gets the DB credentials from the PHP folder and connects to phpMyAdmin  -->
    <?php
      require_once('../php/library.php');
      $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
      // Check connection
      if (mysqli_connect_errno()) {
        echo("Can't connect to MySQL Server. Error code: " .
        mysqli_connect_error());
        return null;
      }

      echo "<form>
      <input type='button' class='btn btn-primary' value='Back to Projects Page' onclick='history.back()'>  
      </form>";
      
      echo "<table class='table'>
      <thead>
          <tr>
              <th scope='col'>Project Name</th>
              <th scope='col'>Project Description</th>
              <th scope='col'>Project Category</th>
              <th scope='col'></th>
          </tr>
      </thead>
      <tbody>";

    
                                          

    
    echo "<p hidden id='projectID'>" . $_POST["project_id"] . "</p>";

    $categories = $con->query("SELECT category_name FROM Category");
    

      
      
    ?>
    <!-- Table for owner project -->
    <tr>
    <th scope='row'><div contenteditable id='edit_name' onblur='saveInput()'><?php print_r($_POST["project_name"]); ?> </div></th>
    <td><div contenteditable id='edit_description' onblur='saveInput()'><?php print_r($_POST["project_description"]); ?> </div></td>
    <td><div><select name='categories' id='categories' onBlur="saveInput()"><option value=<?php print_r($_POST["category_name"]); ?> selected><?php print_r($_POST["category_name"]); ?> </option>
    <?php while ($rows = $categories->fetch_assoc()) {
        $cat_name = $rows['category_name'];
        if ($cat_name != $_POST["category_name"])
          echo "<option value='$cat_name'>$cat_name</option>";
        }
    ?></select> </div>
    </td><td><form action='./delete.php', method='post'>
    <input type='text' name='project_id' value= <?php print_r($_POST["project_id"]); ?>   style='display: none;'>
    <button type='submit' class='btn btn-primary'>Delete Project</button> 
      </form></td>
      <td>
      <form action = "./blacklist.php", method="post">
      <input type='text' name='project_id' value=<?php print_r($_POST["project_id"]); ?>  style='display: none;'>
      <button type='submit' class='btn btn-primary'>Blacklisted Users</button>
      </form>
    </td></tr>

    


    
  </div>

  

  <!-- Close the database connection -->
  <?php
    mysqli_close($con);
    ?>

  <script>
    function saveInput() { // Save changes to project name and/or description
      
      var xr = new XMLHttpRequest();
      var url = "saveUserInput.php";
      
      var nameInput = document.getElementById("edit_name").innerHTML;
      var descriptionInput = document.getElementById("edit_description").innerHTML;
      var projectID = document.getElementById("projectID").innerHTML;
      var categoryInput = document.getElementById("categories");
      var selectedCategory = categoryInput.options[categoryInput.selectedIndex].text;
      
      var params = "newName=" + nameInput + "&projectID=" + projectID + "&newDescription=" + descriptionInput + "&newCategory=" + selectedCategory;
    
      xr.open("POST", url, true);
      xr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xr.send(params);
    }

 
    

  </script>

  

  <!-- Some boiler plate code, best to leave it (not sure what it does) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>

</body>

</html>