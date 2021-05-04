<?php
    require_once('../php/library.php');
    $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
    // Check connection
    if (mysqli_connect_errno()) {
      echo("Can't connect to MySQL Server. Error code: " .
      mysqli_connect_error());
      return null;
    }

    

    

    $id = $_POST['project_id'];
    $del = mysqli_query($con, "DELETE FROM Project WHERE projectID = '".$id."'");
   
    

  if($del)
{
    mysqli_close($con); // Close connection
    header("location:my_projects.php"); 
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}

?>