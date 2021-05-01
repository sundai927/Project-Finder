<?php
      require_once('../php/library.php');
      $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
      // Check connection
      if (mysqli_connect_errno()) {
        echo("Can't connect to MySQL Server. Error code: " .
        mysqli_connect_error());
        return null;
      }
      $newName = $_POST['newName'];
      $projectID = $_POST['projectID'];
      $newDescription = $_POST['newDescription'];
      if ($newName != "") {
          $sqlName = "UPDATE Project 
                      SET project_name = '".$newName."', project_description = '".$newDescription."'  WHERE projectID = '".$projectID."' ";
          $result = mysqli_query($con,$sqlName);
      }
  ?>