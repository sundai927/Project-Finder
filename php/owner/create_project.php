<?php 
    session_start();
    if (!isset($_SESSION["ownerID"])){
      $_SESSION["login_error_message"] = "Please login to continue.";
      header("Location: ./landing_page.php");
    }
     ?>

<?php
 include_once("../library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

$id = uniqid();

 $sqlpj="INSERT INTO Project (projectID, project_name, max_participants, project_description) 
 VALUES
 ('$id','$_POST[pjname]','$_POST[max]','$_POST[pjtext]')";

$sqlproposes="INSERT INTO Proposes (projectID,ownerID) 
VALUES
('$id','$_SESSION[ownerID]')";

 



 if (!mysqli_query($con,$sqlpj)) {
    die('Error: ' . mysqli_error($con));
 }  
 if (!mysqli_query($con,$sqlproposes)) {
   die('Error: ' . mysqli_error($con));
}  

header("location:/cs4750_project/pages_owner/my_projects.php"); // Redirects you to my_projects page
exit;


 
mysqli_close($con);
?>