<?php
    session_start();
    include_once("../includes/Database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Profiel</title>
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
        if (!isset($_SESSION['loggedIn'])) {
            header('Location: ../login');
            exit;
        }
        $UiD = $_SESSION['user_id'];

        if (isset($_GET["id"])) {
            $_SESSION["accountID"] = $_GET["id"];
            header("Location: ./");
        }
        else if ($_SESSION["accountID"]) {
            $accountID = $_SESSION["accountID"];
            $profiel = getQuery("SELECT id, naam, profiel_img_url FROM users WHERE id = '$accountID';")[0];

            //status
            $getStatus = getQuery("SELECT * FROM vrienden WHERE (id_1 = '$UiD' AND id_2 = '$accountID') OR (id_1 = '$accountID' AND id_2 = '$UiD');");
            if (count($getStatus) == 0) {
                //geen vrienden
                $status = "niet";
                $posts = [];
            }
            elseif (count($getStatus) == 1) {
                //pending
                if ($getStatus[0]["id_1"] == $UiD) $status = "pendingWeg";
                if ($getStatus[0]["id_2"] == $UiD) $status = "pendingNaar";
                $posts = [];
            }
            elseif (count($getStatus) == 2) {
                //vrienden
                $status = "vriend";
                $posts = getQuery("SELECT * FROM posts WHERE user_id = '$accountID';");
            }
        }
        else die(header("Location: ../"));

        if (isset($_GET["verzoek"])) {
            $id = $_GET["verzoek"];
            insertQuery("INSERT INTO vrienden VALUES ('$UiD', '$id', 'p');");
            header('Location: ./');
        }
        if (isset($_GET["chat"])) {
            $id = $_GET["chat"];
            $already = getQuery("SELECT * FROM chats WHERE (user_verz_id = '$UiD' AND user_ont_id = '$id') OR (user_verz_id = '$id' AND user_ont_id = '$UiD');");
            if ($already == []) insertQuery("INSERT INTO chats VALUES (NULL,'$UiD','$id','Hallo, ik wil graag chatten met jou!',current_timestamp());");
            header('Location: ../chat/');
        }
        if (isset($_GET["accept"])) {
            $id = $_GET["accept"];
            insertQuery("UPDATE vrienden SET status = 'a' WHERE (id_1 = '$id') and (id_2 = '$UiD');");
            insertQuery("INSERT INTO vrienden VALUES ('$UiD', '$id', 'a');");
            header('Location: ./');
        }
        if (isset($_GET["ignore"])) {
            $id = $_GET["ignore"];
            insertQuery("DELETE FROM vrienden WHERE (id_1 = '$id') and (id_2 = '$UiD');");
            header('Location: ./');
        }
    ?>

    <nav>
        <div class="navbar">
            <img src="../images/Logo.gif" alt="Logo 2BLM">

            <div class="navitems">
                <a href="../">Overzicht</a>
                <a href="../profiel/">Profiel</a>
                <a href="../vrienden/">Vrienden</a>
                <a href="../chat/">Chat</a>
                <a href="../login/logout.php" style="color: red;">Uitloggen</a>
            </div>
        </div>
    </nav>
    
    <div class="pagecontent">
        <div class="info">
            <img src="<?php echo $profiel["profiel_img_url"]; ?>" height="100px">
            <p><?php echo $profiel["naam"]; ?></p>
            <?php 
                if ($status == "niet") {
            ?>
                <button onclick="location.href='./?verzoek=<?php echo $profiel['id']; ?>';">Stuur vriendschapsverzoek</button>
            <?php
                } elseif ($status == "pendingWeg") {
            ?>
                <p><strong>Vriendschapsverzoek aangevraagd!</strong></p>
            <?php      
                } elseif ($status == "pendingNaar") {
            ?>
                <button onclick="location.href='./?accept=<?php echo $profiel['id']; ?>';">Accepteren</button>
                <button onclick="location.href='./?ignore=<?php echo $profiel['id']; ?>';">Negeren</button>
            <?php      
                } elseif ($status == "vriend") {
            ?>
                <button onclick="location.href='./?chat=<?php echo $profiel['id']; ?>';">Chatten</button>
                <button onclick="document.getElementById('vriendenVanVrienden').style.display = 'block';">Bekijk vrienden</button>
            <?php      
                }
            ?>
        </div>
        <div id="vriendenVanVrienden" style="display: none;">
            <hr>
            <?php 
                if ($status == "vriend") {
                    $vriendenvv = getQuery("SELECT id, naam, profiel_img_url FROM users WHERE id IN (SELECT id_2 FROM vrienden WHERE status = 'a' AND id_1 = '$accountID');");
            ?>
                <button onclick="document.getElementById('vriendenVanVrienden').style.display = 'none';">Sluiten</button>
                <h2>Vrienden:</h2>
            
            <?php 
                if (count($vriendenvv) > 0) {
                foreach ($vriendenvv as $vriendvv) {
            ?>
                <div class="vriend">
                    <img src="<?php echo $vriendvv["profiel_img_url"]; ?>" height="40px">
                    <p><?php echo $vriendvv["naam"]; ?></p>
                </div>
            <?php
                }}
                else echo "<p>Geen vrienden gevonden</p>";
            ?>
            <?php
                }
            ?>
        </div>
        <br><hr><br>
        <div class="posts">
            <?php 
                if ($status == "vriend") {
                    if ($posts != []) {
                        foreach ($posts as $post) {
            ?>
                        <div class="postBericht">
                            <img src="<?php echo $post["foto_url"]; ?>" class="imagepost">
                            <p><?php echo $post["tekst"]; ?></p>
                        </div>
            <?php
                        }
                    }
                    else echo "<p>Deze persoon heeft nog geen posts.</p>";
                } else echo "<p>Om posts te kunnen zien moet u vrienden zijn met deze persoon.</p>";
            ?>
        </div>
    </div>

    <script src="./checkHeight.js"></script>
</body>
</html>