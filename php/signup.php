
<?php
 include_once("./library.php"); // To connect to the database
 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 // Form the SQL query (an INSERT query)
 $sql="SELECT * FROM User WHERE userID='$_POST[email]'";


 if (!mysqli_query($con,$sql)) {
    die('Error: ' . mysqli_error($con));
 }  

 $result = mysqli_query($con,$sql);
 session_start();
if (mysqli_num_rows($result) == 0){

    $sql ="INSERT INTO User (userID, name ,password)
    
    VALUES ('$_POST[email]', 'test name', SHA1('$_POST[password]'))";
    
    $insert_result = mysqli_query($con,$sql);

     if (!$insert_result) {
        die('Error: ' . mysqli_error($con));
        $_SESSION["signup_success"] = false;
        $_SESSION["signup_error_message"] = "Server error. Please try again later.";
        header("Location: ../landing_page.php");
     } else{
        $_SESSION["signup_success"] = true;
        if (isset($_SESSION["login_error_message"])){
           //clears any error messages on the login page.
            unset($_SESSION["login_error_message"]);
        }

        if (isset($_SESSION["signup_error_message"])){
           //clears signup messages
            unset($_SESSION["signup_error_message"]);
        }
        header("Location: ../landing_page.php");
     }
} else{

    $_SESSION["signup_error_message"] = "Email has already been registered";
    $_SESSION["signup_success"] = false;
    header("Location: ../landing_page.php");

}


mysqli_close($con);
?>