<?php
    include_once("../library.php"); // To connect to the database
    $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
    // Check connection
    if (mysqli_connect_errno()){
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    session_start();

    $sql="SELECT * FROM Joins WHERE userID='$_SESSION[userID]' AND projectID='$_POST[projectID]'";
    $check_membership_result = mysqli_query($con, $sql);
    if(mysqli_num_rows($check_membership_result) == 0){
        $user_in_project = false;
    } else{
        $user_in_project = true; 
    }


    $max_member_count_sql = "SELECT projectID, curr_participant_count, max_participants FROM Project WHERE projectID='$_POST[projectID]'";
    $max_member_count_result = mysqli_query($con, $max_member_count_sql);
    while($max_member_count_row = mysqli_fetch_array($max_member_count_result)) {
        $max_member_count = $max_member_count_row["max_participants"];
      }

      if($user_in_project && $_POST['formAction'] == "unfollow"){
        $unfollow_sql = "DELETE FROM Joins WHERE userID='$_SESSION[userID]' AND projectID='$_POST[projectID]'";
        $unfollow_result = mysqli_query($con, $unfollow_sql);
      } else if ($max_member_count_row['curr_participant_count'] < $max_member_count && $_POST['formAction'] == "follow"){
        $follow_sql = "INSERT INTO Joins (userID, projectID) VALUES ('$_SESSION[userID]', '$_POST[projectID]')";;
        $follow_result = mysqli_query($con, $follow_sql);
      }
      header("Location: ../../pages_user/main_feed.php");
    mysqli_close($con);   
?>