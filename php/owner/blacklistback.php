<?php
 include_once("../library.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

 session_start();
 $search_for_user="SELECT * FROM Blacklist WHERE userID='$_POST[userID]' AND projectID='$_POST[pjID]'";
 $result = mysqli_query($con,$search_for_user);
 if (mysqli_num_rows($result)==0){
   $_SESSION["removeBlacklistError"] = "User is not in Blacklist";
   if (isset($_SESSION["addBlacklistError"])){
      unset($_SESSION["addBlacklistError"]);
    }
  //  header("Location: ../../pages_owner/blacklist_page.php");
 } else{
   if (isset($_SESSION["removeBlacklistError"])){
     unset($_SESSION["removeBlacklistError"]);
   }
   if (isset($_SESSION["addBlacklistError"])){
      unset($_SESSION["addBlacklistError"]);
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
 }
// header("Location: ../../pages_owner/blacklist_page.php");
echo "<form action='../../pages_owner/blacklist_page.php' method='post' name='returntoproject'>
   <input name='project_id' value='" . $_POST["pjID"] . "'>
   <input type='submit'>
</form>";
// header("Location: ../../pages_owner/blacklist_page.php");

mysqli_close($con);
?>
<body onload="document.forms['returntoproject'].submit()">
</body>