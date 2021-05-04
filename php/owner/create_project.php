<?php 
    session_start();
    if (!isset($_SESSION["ownerID"])){
      $_SESSION["login_error_message"] = "Please login to continue.";
      header("Location: ./landing_page.php");
    }
     ?>

<?php
 include_once("../owner_user.php"); // To connect to the database

 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
 // Check connection
 if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

$id = uniqid();

//  $sqlpj="INSERT INTO Project (projectID, project_name, max_participants, project_description) 
//  VALUES
//  ('$id','$_POST[pjname]','$_POST[max]','$_POST[pjtext]')";


$create_new_project_stmt = $con->prepare("INSERT INTO Project (projectID, project_name, max_participants, project_description) 
VALUES(?, ?, ?, ?)");
$create_new_project_stmt->bind_param("ssis", $id, $_POST["pjname"], $_POST["max"], $_POST["pjtext"]);
$create_new_project_stmt->execute();
$create_new_project_stmt->close();


$insert_proposes= $con->prepare("INSERT INTO Proposes (projectID,ownerID) VALUES (?, ?)");
$insert_proposes->bind_param("ss", $id, $_SESSION["ownerID"]);
$insert_proposes->execute();
$insert_proposes->close();

// echo $_POST["category"];
$insert_has= $con->prepare("INSERT INTO Has (projectID, category_name) VALUES (?, ?)");
$insert_has->bind_param("ss", $id, $_POST["category"]);
$insert_has->execute();
$insert_has->close();



// $sqlproposes="INSERT INTO Proposes (projectID,ownerID) 
// VALUES
// ('$id','$_SESSION[ownerID]')";

 



//  if (!mysqli_query($con,$sqlpj)) {
//     die('Error: ' . mysqli_error($con));
//  }  
//  if (!mysqli_query($con,$sqlproposes)) {
//    die('Error: ' . mysqli_error($con));
// }  

header("Location: ../../pages_owner/my_projects.php"); // Redirects you to my_projects page
exit;


 
mysqli_close($con);
?>