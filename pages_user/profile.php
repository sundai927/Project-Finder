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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="./landing_page.php">Project Finder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="#">Main Feed <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
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
          <a class="dropdown-item" href="./main_feed.php">Main Feed</a>
          <a class="dropdown-item"  href="./logout.php">Log out</a>
        </div>
      </div>
    </nav>
</header>

<div> Hello </div>
<?php 
        //  This starts the user session. Allows you to access the $_SESSION object in PHP
        // I use the $_SESSION object to store things like userID/ownerID
        // session_start();
     ?>

    <!-- Header element contains the navbar -->

      <!-- This is how you can get stuff from the DB and show it dynamically -->
      <!-- Gets all the  userIDs and names and displays them-->
      <!-- More info on bootstrap tables: https://getbootstrap.com/docs/4.0/content/tables/ -->
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
     
      $sql="SELECT name FROM User WHERE userID='$_SESSION[userID]'";
      $result = mysqli_query($con,$sql);
      // Print the data from the table in a table

      $row = mysqli_fetch_array($result);

        echo "<div>Current Username: "  . $row['name'] .  "</div>";

        echo "<form action='./noPref.php', method='post'>
        <label for=' New Username'>New Username:</label>
        <input type='text' id='nName' name='nName'><br><br>
        ";
        echo "<form action='./password.php', method='post'>
        <label for=' New Password'>New Password:</label>
        <input type='text' id='nPass' name='nPass'><br><br>
        <input type='submit' value='Submit'>
        ";
      // mysqli_close($con);
?>

  <div class="container">

  <div> Projects Prefrences</div>
    <!-- This gets the DB credentials from the PHP folder and connects to phpMyAdmin  -->

      <!-- This is how you can get stuff from the DB and show it dynamically -->
      <!-- Gets all the  userIDs and names and displays them-->
      <!-- More info on bootstrap tables: https://getbootstrap.com/docs/4.0/content/tables/ -->
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
      //$sql="SELECT * FROM Prefers";
      $sql="SELECT category_name FROM Prefers WHERE userID='$_SESSION[userID]'";
      $result = mysqli_query($con,$sql);
      // Print the data from the table in a table
      echo "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>Category</th>
                        <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>";

      while($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <th scope='row'>" . $row['category_name'] . "</th>
                ";

        // This is how to can bring information to another page. Use a form and hide the input elements.
        // Manually set the input elements like below.
        // Make sure the button is of type submit.
        echo "
            <td>
                <form action='./noPref.php', method='post'>
                    <input type='text' name='user_id' value='". $row['category_name'] ."' style='display: none;'>
                    
                    <button type='submit' class='btn btn-primary'>Remove</button>
                </form>
                <form action='./hate.php', method='post'>
                    <input type='text' name='user_id' value='". $row['category_name'] ."' style='display: none;'>
                    
                    <button type='submit' class='btn btn-primary'>Dislike</button>
                </form>
            </td>
        ";

        echo "</tr>";
      }

      echo "<tbody>
        </table>";

      

      mysqli_close($con);
    ?>

</div>

  <div class="container">
  <div> Projects Dislikes</div>
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
      
      mysqli_close($con);
    ?>

      <!-- This is how you can get stuff from the DB and show it dynamically -->
      <!-- Gets all the  userIDs and names and displays them-->
      <!-- More info on bootstrap tables: https://getbootstrap.com/docs/4.0/content/tables/ -->
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
      $sql="SELECT category_name FROM Hates WHERE userID='$_SESSION[userID]'";
      $result = mysqli_query($con,$sql);
      // Print the data from the table in a table
      echo "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>Category</th>
                        <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>";

                

      while($row = mysqli_fetch_array($result)) {


        // This is how to can bring information to another page. Use a form and hide the input elements.
        // Manually set the input elements like below.
        // Make sure the button is of type submit.
        echo "
            <td>
                <form action='./noPref.php', method='post'>
                    <input type='text' name='user_id' value='". $row['category_name'] ."' style='display: none;'>
                    
                    <button type='submit' class='btn btn-primary'>Remove</button>
                </form>
                <form action='./prefer.php', method='post'>
                    <input type='text' name='user_id' value='". $row['category_name'] ."' style='display: none;'>
                    
                    <button type='submit' class='btn btn-primary'>Prefer</button>
                </form>
            </td>
        ";

        echo "</tr>";
      }

      echo "<tbody>
        </table>";

      

      mysqli_close($con);
    ?>
    </div>

  <div class="container">

  <div> Other Categories</div>
    <!-- This gets the DB credentials from the PHP folder and connects to phpMyAdmin  -->

      <!-- This is how you can get stuff from the DB and show it dynamically -->
      <!-- Gets all the  userIDs and names and displays them-->
      <!-- More info on bootstrap tables: https://getbootstrap.com/docs/4.0/content/tables/ -->
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
      //$sql="SELECT * FROM Prefers";
      $sql="SELECT * FROM Category";

      $result = mysqli_query($con,$sql);
      // Print the data from the table in a table
      echo "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>Category</th>
                        <th scope='col'>Options</th>
                    </tr>
                </thead>
                <tbody>";
  
      while($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <th scope='row'>" . $row['category_name'] . "</th>
                ";

        // This is how to can bring information to another page. Use a form and hide the input elements.
        // Manually set the input elements like below.
        // Make sure the button is of type submit.
        echo "
            <td>
              <form action='./prefer.php', method='post'>
                    <input type='text' name='user_id' value='". $row['category_name'] ."' style='display: none;'>
                    <button type='submit' class='btn btn-primary'>Prefer</button>
                </form>
                <form action='./hate.php', method='post'>
                <input type='text' name='user_id' value='". $row['category_name'] ."' style='display: none;'>
                <button type='submit' class='btn btn-primary'>Dislike</button>
            </form>
            </td>
        ";
        echo "</tr>";
      }

      echo "<tbody>
        </table>";

      

      mysqli_close($con);
    ?>

</div>

<!-- Testing stuff -->
    

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
