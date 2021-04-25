<?php
 include_once("../library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }


 $sql="SELECT * FROM Owner WHERE ownerID='$_POST[email]' AND password= SHA1('$_POST[password]')";
 


 if (!mysqli_query($con,$sql)) {
    die('Error: ' . mysqli_error($con));
 }  

 $result = mysqli_query($con,$sql);
 session_start();

 if (isset($_SESSION["signup_error_message"])){
    unset($_SESSION["signup_error_message"]);
}

if (isset($_SESSION["signup_success"])){
    unset($_SESSION["signup_success"]);
}

if (mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result);
    $_SESSION["ownerID"] = $row["ownerID"];
    if (isset($_SESSION["login_error_message"])){
        unset($_SESSION["login_error_message"]);
    }

    header("Location: ../../pages_owner/my_projects.php");
} else{

    $_SESSION["login_error_message"] = "Incorrect username and password.";
    header("Location: ../../pages_owner/landing_page.php");

}


mysqli_close($con);
?>