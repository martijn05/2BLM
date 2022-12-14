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
    <title>2BLM | Profiel</title>
    <link rel="shortcut icon" href="../images/Logo.gif" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/profiel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <script>
        function deleteItem(id) {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open(
                "GET","../controllers/deletePost.php?id=" + id, true
            );
            xmlhttp.send();
            window.location.reload();
        }
    </script>
    <?php
        if (!isset($_SESSION['loggedIn'])) {
        	header('Location: ../login');
        	exit;
        }
        $UiD = $_SESSION['user_id'];

        $user = getQuery("SELECT * FROM users WHERE id = '$UiD';")[0];
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
        <h1>Profiel</h1>
        <img src="<?php echo $user["profiel_img_url"]; ?>" class="profielimage"><br>
        <form action="../controllers/updateAccount.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagePost" id="imagePost" accept="image/*"><br><br>

            <label for="name">Uw naam</label><br>
            <input type="text" name="name" id="name" value="<?php echo $user["naam"]; ?>" required><br><br>

            <label for="tel">Uw telefoonnummer</label><br>
            <input type="tel" name="tel" id="tel" value="<?php echo $user["telefoon"]; ?>" required><br><br>

            <label for="mail">Uw e-mailadres</label><br>
            <input type="mail" name="mail" id="mail" value="<?php echo $user["email"]; ?>" required><br><br>

            <input type="submit" value="Opslaan">
        </form>
        <p>Let op, bij het wijzigen van uw telefoonnummer en/of e-mailadres moet uw account opnieuw geverifieerd worden en wordt dit tijdelijk geblokkeerd tot de verificatie succesvol werd afgerond.</p>
    </div>

    <div class="pagecontent">
        <h1>Mijn posts</h1>
        <div class="posts">
            <?php 
                $posts = getQuery("SELECT * FROM posts WHERE user_id = '$UiD';");
                if ($posts != []) {
                    foreach ($posts as $post) {
            ?>
                    <div class="postBericht">
                        <p style="margin-top: 0; text-align: right;"><i class="fa fa-trash-o" aria-hidden="true" style="cursor: pointer;" onclick=<?php echo "javascript:deleteItem(".$post['id'].")"; ?>></i></p> 
                        <img src="<?php echo '.'.$post["foto_url"]; ?>" class="imagepost">
                        <p><?php echo $post["tekst"]; ?></p>
                    </div>
            <?php
                    }
                }
                else echo "<p>U hebt nog geen posts.</p>";
            ?>
        </div>
    </div>

    <footer id="footer">
        &copy; 2BLM | <a href="../privacy/">Privacyverklaring</a>
    </footer>
    <script src="../scripts/checkHeightFooter.js"></script>
</body>
</html>