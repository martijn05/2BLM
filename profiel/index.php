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
    <title>2BLM | Mijn acccount</title>
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
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
    ?>

    <nav>
        <div class="navbar">
            <img src="../images/Logo.gif" alt="Logo 2BLM">

            <div class="navitems">
                <a href="../">Overzicht</a>
                <a href="" style="text-decoration: underline;">Profiel</a>
                <a href="../vrienden/">Vrienden</a>
                <a href="../chat/">Chat</a>
                <a href="../login/logout.php" style="color: red;">Uitloggen</a>
            </div>
        </div>
    </nav>
    
    <div class="pagecontent">
        <h1>Uw Naam</h1>
        <form action="./" method="POST">
            <label for=""></label><br>
            <input type="text" name="" id=""><br><br>

            <label for=""></label><br>
            <input type="tel" name="" id=""><br><br>

            <label for=""></label><br>
            <input type="text" name="" id=""><br><br>
        </form>
    </div>

    <script src="./checkHeight.js"></script>
</body>
</html>