<?php
    session_start();
    include_once("../includes/Database.php");

    function getChatPartners($uid) {
        $result = getQuery("SELECT DISTINCT user_ont_id FROM chats WHERE user_verz_id = $uid UNION SELECT DISTINCT user_verz_id FROM chats WHERE user_ont_id = $uid;");
        return $result;
    }

    function getPartnerName($uid) {
        $result = getQuery("SELECT naam FROM users WHERE id = $uid;");
        return $result[0]["naam"];
    }

    // function getPartnerPhoto($uid) {
    //     $sql = "SELECT profiel_img_url FROM users WHERE id = $uid";
    //     $result = mysqli_query($this->db,$sql);
    //     $user_data = mysqli_fetch_array($result);
    //     return $user_data["foto"];
    // }

    $counter = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>2BLM | Chat</title>
    <link rel="shortcut icon" href="../images/Logo.gif" type="image/x-icon">
    <link rel="stylesheet" href="../style/chat.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <?php
    if (!isset($_SESSION['loggedIn'])) {
    	header('Location: ../login');
    	exit;
    }
    ?>

    <?php 
        $Uid = $_SESSION['user_id'];
        $idOfRec = 0;
    ?>

    <nav>
        <div class="navbar">
            <img src="../images/Logo.gif" alt="Logo 2BLM">

            <div class="navitems">
                <a href="../">Overzicht</a>
                <a href="../profiel/">Profiel</a>
                <a href="../vrienden/">Vrienden</a>
                <a href="" style="text-decoration: underline;">Chat</a>
                <a href="../login/logout.php" style="color: red;">Uitloggen</a>
            </div>
        </div>
    </nav>
    
    <div id="row">
        <div class="column" id="column1">
            <p class="title">Gesprekken met:</p>
            <div class="partners" id="partners">
            <?php
                $partnerIDS = getChatPartners($Uid);
                foreach ($partnerIDS as $value) { 
                    if ($value["user_ont_id"] != $Uid) {
            ?>
                    <button class="partner_btn" id=<?php echo "chat_knop_".$counter ?> value=<?php echo $value["user_ont_id"]; ?> onclick=<?php echo "javascript:setSession('chatReceId',".$value["user_ont_id"].")"; ?>><?php echo getPartnerName($value["user_ont_id"]); ?></button>
                    <br>
            <?php
                    }
                    $counter++;
                }
            ?>     

            </div>
        </div>
        <div class="column" id="column2">
            <p class="title">Berichten:</p>
            <div id="divToRefresh"></div>
            <br>
            <br>
            
            <form action="./sendChat.php" method="post">
                <textarea name="message" rows="1" cols="70" placeholder="Uw bericht" id="message" required></textarea>
                <input type="submit" value="Verstuur" id="send">
            </form>
        </div>
    </div>
    <script src="./load.js"></script>
    <script src="./activePartner.js"></script>
    <script src="./chat.js"></script>
    <script src="./checkHeight.js"></script>

    <?php 
        if (isset($_SESSION['chatReceId'])) {
            echo "<script>setActive(".$_SESSION['chatReceId'].")</script>";
        }
    ?>
</body>
</html>