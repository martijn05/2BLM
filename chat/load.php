<?php
    include_once("../includes/Database.php");
    session_start();
    $idOfReciever = $_SESSION['chatReceId'];
    $UiD = $_SESSION['user_id'];

    $result = getQuery("SELECT user_verz_id, tekst FROM chats WHERE (user_verz_id, user_ont_id) IN (('$UiD','$idOfReciever'),('$idOfReciever','$UiD'));");

    if ($idOfReciever != NULL) {
        if ($result == []) {
            echo "Nog geen gesprek gestart met deze persoon";
        } else {
            foreach ($result as $value) {
                if ($value["user_verz_id"] != $UiD) {
                    echo "<p class='streepje'>".$value["tekst"]."</p>";
                }
                else {
                    echo "<p class='geenStreepje'>".$value["tekst"]."</p>";
                }
            }
        }    
    } else {
        echo "Selecteer een persoon om mee te chatten";
    }

    