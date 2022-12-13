<?php
    session_start();
    include_once("../includes/Database.php");

    $UiD = $_SESSION['user_id'];
    
    if(isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
        
        insertQuery("DELETE FROM posts WHERE id = '$id' AND user_id = '$UiD';");
        
        header("Location: ../profiel/");
    }