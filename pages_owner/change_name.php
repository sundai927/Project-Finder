<?php
 include_once("../php/library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 session_start();
 // Wants to get the specific category that needs to be prefered

 if ($_POST["nPass"] == "" && !$_POST["nName"] == ""){
    // $sql="UPDATE Owner SET name='$_POST[nName]' WHERE ownerID='$_SESSION[ownerID]'";
    $stmt = $con->prepare("UPDATE Owner SET name=? WHERE ownerID=?");
    $stmt->bind_param("ss", $_POST["nName"], $_SESSION["ownerID"]);



 } else if($_POST["nName"] == "" && !$_POST["nPass"] == ""){
    // $sql="UPDATE Owner SET password=SHA1('$_POST[nPass]') WHERE ownerID='$_SESSION[ownerID]'";
    $stmt = $con->prepare("UPDATE Owner SET password=? WHERE ownerID=?");
    $stmt->bind_param("ss", SHA1($_POST["nPass"]), $_SESSION["ownerID"]);
 }else{
    // $sql="UPDATE Owner SET name='$_POST[nName]', password=SHA1('$_POST[nPass]') WHERE ownerID='$_SESSION[ownerID]'";
    $stmt = $con->prepare("UPDATE Owner SET name=?, SET password=? WHERE ownerID=?");
    $stmt->bind_param("sss", $_POST["nName"], SHA1($_POST["nPass"]), $_SESSION["ownerID"]);
}

$stmt->execute();
$stmt->close();
 //$sql="SELECT * FROM User WHERE userID='$_POST[email]' AND password= SHA1('$_POST[password]')";
 


//  if (!mysqli_query($con,$sql)) {
//     die('Error: ' . mysqli_error($con));
//  }  

//  $result = mysqli_query($con,$sql);

header("Location: ./profile.php");

mysqli_close($con);
?>