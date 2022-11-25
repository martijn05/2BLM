<?php
    session_start();

    include_once("../includes/Database.php");

    $senderId = $_SESSION['user_id'];;
    $receId = $_SESSION['chatReceId'];
    $message = $_POST['message'];

    insertQuery("INSERT INTO chats VALUES (NULL,'$senderId','$receId','$message',current_timestamp());");

    header("Location:./index.php");