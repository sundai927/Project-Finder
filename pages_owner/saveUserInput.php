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
      $newCategory = $_POST['newCategory'];
      if ($newName != "" && $newDescription != "") {
          $sqlName = "UPDATE Project 
                      SET project_name = '".$newName."', project_description = '".$newDescription."'  WHERE projectID = '".$projectID."' ";
          $result = mysqli_query($con,$sqlName);

          // $update_project= $con->prepare("UPDATE Project SET project_name=?, project_description=? WHERE projectID=?");
          // $update_project->bind_param("sss", $newName, $newDescription, $projectID);
          // $update_project->execute();
          // $update_project->close();
      }
      // $update_category= $con->prepare("UPDATE HAS SET category_name=? WHERE projectID=?");
      // $update_category->bind_param("ss", $newCategory, $projectID);
      // $update_category->execute();
      // $update_category->close();

      $sqlcategory = "UPDATE Has SET category_name = '".$newCategory."' WHERE projectID = '".$projectID."' ";
      $result_category = mysqli_query($con,$sqlcategory);
  ?>