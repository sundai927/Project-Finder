<?php
session_start();
 include_once("../php/library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 // Wants to get the specific category that needs to be prefered

 $sql="SELECT * FROM Category WHERE category_name='$_POST[category_name]'";
 $result = mysqli_query($con,$sql);
 //$sql="SELECT * FROM User WHERE userID='$_POST[email]' AND password= SHA1('$_POST[password]')";
 
 
 while($ans = mysqli_fetch_array($result)) {
    echo "<div> Category: " . $ans['category_name'] . "</div>";

    $change = "INSERT INTO Prefers (userID, category_name) VALUES ('$_SESSION[userID]', '$ans[category_name]')";

    echo $change;
    $result2 = mysqli_query($con,$change);

 }

 

 if (!mysqli_query($con,$sql)) {
    die('Error: ' . mysqli_error($con));
 }  

 $result = mysqli_query($con,$sql);


 

mysqli_close($con);

header("Location: ./profile.php");
?>
