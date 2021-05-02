<?php
 include_once("../library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 $sqldelete="DELETE FROM Blacklist WHERE userID='$_POST[userID]' AND projectID='$_POST[pjID]'";
 $sqladd="INSERT INTO Joins (projectID, userID)
 VALUES ('$_POST[pjID]','$_POST[userID]' )";
 

 if (!mysqli_query($con,$sqldelete)) {
    die('Error: ' . mysqli_error($con));
 }  
 if (!mysqli_query($con,$sqladd)) {
   die('Error: ' . mysqli_error($con));
}  
header("Location: ../../pages_owner/blacklist_page.php");
 
mysqli_close($con);
?>