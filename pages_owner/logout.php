<?php 
    session_start();
    if(count($_SESSION) > 0){
        foreach ($_SESSION as $k => $v){
        unset($_SESSION[$k]);
        }
        session_destroy();    
    }
    header("Location: ./landing_page.php");
?>

