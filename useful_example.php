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

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">

        </ul>
      </div>
    </nav>
  </header>


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

      <!-- This is how you can get stuff from the DB and show it dynamically -->
      <!-- Gets all the  userIDs and names and displays them-->
      <!-- More info on bootstrap tables: https://getbootstrap.com/docs/4.0/content/tables/ -->
    <?php
      require_once('./php/library.php');
      $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
      // Check connection
      if (mysqli_connect_errno()) {
      echo("Can't connect to MySQL Server. Error code: " .
      mysqli_connect_error());
      return null;
      }
      // Form the SQL query (a SELECT query)
      $sql="SELECT * FROM User";
      $result = mysqli_query($con,$sql);
      // Print the data from the table in a table
      echo "<table class='table'>
                <thead>
                    <tr>
                        <th scope='col'>userID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>";

      while($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <th scope='row'>" . $row['userID'] . "</th>
                <td>" . $row['name'] . "</td>";

        // This is how to can bring information to another page. Use a form and hide the input elements.
        // Manually set the input elements like below.
        // Make sure the button is of type submit.
        echo "
            <td>
                <form action='./useful_example2.php', method='post'>
                    <input type='text' name='user_id' value='". $row['userID'] ."' style='display: none;'>
                    <input type='text' name='user_name' value='". $row['name'] ."' style='display: none;'>
                    
                    <button type='submit' class='btn btn-primary'>More Info</button>
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

  

  <!-- Some boiler plate code, best to leave it (not sure what it does) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>

</body>

</html>