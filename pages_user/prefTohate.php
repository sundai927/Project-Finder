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

    $change = "INSERT INTO Hates (userID, category_name) VALUES ('$_SESSION[userID]', '$ans[category_name]')";
    $change2 = "DELETE FROM Prefers WHERE userID = '$_SESSION[userID]' AND category_name = '$ans[category_name]'";

    $result2 = mysqli_query($con,$change);
    $result3 = mysqli_query($con,$change2);
    /*
    echo $change;
    $result2 = mysqli_query($con,$change);

    $change2 = "SELECT * FROM Prefers (userID, category_name) VALUES ('$_SESSION[userID]', '$ans[category_name]')";
    $run_change2 = mysqli_query($con,$change2);

    echo $change2;
    print_r($run_change2);
    
    if (mysqli_num_rows($run_change2)>0){
        $change3 = "DELETE FROM Prefers WHERE userID = '$_SESSION[userID]' AND category_name = '$ans[category_name]'";
        $result3 = mysqli_query($con,$change3);
    }

    */
 }

 

 if (!mysqli_query($con,$sql)) {
    die('Error: ' . mysqli_error($con));
 }  

 $result = mysqli_query($con,$sql);


 

mysqli_close($con);

header("Location: ./profile.php");
?>
