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
    <title>2BLM | Vrienden</title>
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/vrienden.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
        // if (!isset($_SESSION['loggedIn'])) {
        // 	header('Location: ../login');
        // 	exit;
        // }
        $UiD = $_SESSION['user_id'];

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
        if (isset($_GET["delete"])) {
            $id = $_GET["delete"];
            insertQuery("DELETE FROM vrienden WHERE (id_1 = '$id') and (id_2 = '$UiD');");
            insertQuery("DELETE FROM vrienden WHERE (id_1 = '$UiD') and (id_2 = '$id');");
            header('Location: ./');
        }
        if (isset($_GET["chat"])) {
            $id = $_GET["chat"];
            $already = getQuery("SELECT * FROM chats WHERE (user_verz_id = '$UiD' AND user_ont_id = '$id') OR (user_verz_id = '$id' AND user_ont_id = '$UiD');");
            if ($already == []) insertQuery("INSERT INTO chats VALUES (NULL,'$UiD','$id','Hallo, ik wil graag chatten met jou!',current_timestamp());");
            $_SESSION['chatReceId'] = $id;
            header('Location: ../chat/');
        }
    ?>

    <nav>
        <div class="navbar">
            <img src="../images/Logo.gif" alt="Logo 2BLM">

            <div class="navitems">
                <a href="../">Overzicht</a>
                <a href="../profiel/">Profiel</a>
                <a href="" style="text-decoration: underline;">Vrienden</a>
                <a href="../chat/">Chat</a>
                <a href="../login/logout.php" style="color: red;">Uitloggen</a>
            </div>
        </div>
    </nav>
    
    <div class="pagecontent">
        <!-- zoeken -->
        <h1>Zoeken naar mensen</h1>
        <form action="./" method="GET">
            <input type="text" name="search" id="search">
            <input type="submit" value="Zoeken">
        </form><br>

        <?php 
            if (isset($_GET["search"])) {
                $search = $_GET["search"];
                $resultaat = getQuery("SELECT id, naam, profiel_img_url FROM users WHERE naam LIKE '%$search%' AND tel_verif = 1 AND mail_verif = 1;");
                if (count($resultaat) > 0) {
                foreach ($resultaat as $rsl) {
        ?>
                <div class="vriend">
                    <img src="<?php echo $rsl["profiel_img_url"]; ?>" height="40px">
                    <p><?php echo $rsl["naam"]; ?></p>
                    <button onclick="location.href='../account?id=<?php echo $rsl['id']; ?>';">Bekijk profiel</button>
                    <br><br><br>
                </div>
        <?php
                }} else echo "<p>Geen zoekresultaten gevonden</p>";
            }
        ?>

        
        <!-- vrienden -->
        <h1>Mijn vrienden</h1>
        <?php 
            $vrienden = getQuery("SELECT id, naam, profiel_img_url FROM users WHERE id IN (SELECT id_2 FROM vrienden WHERE status = 'a' AND id_1 = '$UiD');");
            if (count($vrienden) > 0) {
            foreach ($vrienden as $vriend) {
        ?>
            <div class="vriend">
                <img src="<?php echo $vriend["profiel_img_url"]; ?>" height="40px">
                <p><?php echo $vriend["naam"]; ?></p>
                <button onclick="location.href='../account?id=<?php echo $vriend['id']; ?>';">Bekijk profiel</button>
                <button onclick="location.href='./?chat=<?php echo $vriend['id']; ?>';">Chatten</button>
                <button onclick="location.href='./?delete=<?php echo $vriend['id']; ?>';">Verwijder vriend</button>
                <br><br><br>
            </div>
        <?php
            }}
            else echo "<p>Geen vrienden gevonden</p>";
        ?>
        
        
        <!-- verzoeken -->
        <h1>Verzoeken</h1>
        <?php 
            $verzoeken = getQuery("SELECT id, naam, profiel_img_url FROM users WHERE id IN (SELECT id_1 FROM vrienden WHERE status = 'p' AND id_2 = '$UiD');");
            if (count($verzoeken) > 0) {
            foreach ($verzoeken as $verzoek) {
        ?>
            <div class="verzoek">
                <img src="<?php echo $verzoek["profiel_img_url"]; ?>" height="40px">
                <p><?php echo $verzoek["naam"]; ?></p>
                <button onclick="location.href='../account?id=<?php echo $verzoek['id']; ?>';">Bekijk profiel</button>
                <button onclick="location.href='./?accept=<?php echo $verzoek['id']; ?>';">Accepteren</button>
                <button onclick="location.href='./?ignore=<?php echo $verzoek['id']; ?>';">Negeren</button>
                <br><br><br>
            </div>
        <?php
            }}
            else echo "<p>Geen vriendschapsverzoeken gevonden</p>";
        ?>
    </div>

    <script src="./checkHeight.js"></script>
</body>
</html>