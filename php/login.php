<?php
 include_once("./library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }


 $sql="SELECT * FROM User WHERE userID='$_POST[email]' AND password='$_POST[password]'";


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
    $_SESSION["userID"] = $row["userID"];
    if (isset($_SESSION["login_error_message"])){
        unset($_SESSION["login_error_message"]);
    }

    header("Location: ../homepage.php");
} else{

    $_SESSION["login_error_message"] = "Incorrect username and password.";
    header("Location: ../landing_page.php");

}


mysqli_close($con);
?>