<?php 
session_start();
// if (!isset($_SESSION['loggedIn'])) {
// 	header('Location: ./login');
// 	exit;
// }
$userID = $_SESSION['user_id'];
include_once("./includes/Database.php");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./style/homepage.css">
  <link rel="stylesheet" type="text/css" href="./style/style.css">
  <link rel="stylesheet" type="text/css" href="./style/navbar.css">
  <title>2BLM</title>
  
</head>
<body>
  <nav>
    <div class="navbar">
      <img src="./images/Logo.gif" alt="Logo 2BLM">
      
      <div class="navitems">
        <a href="" style="text-decoration: underline;">Overzicht</a>
        <a href="./mijnprofiel/">Profiel</a>
        <a href="./vrienden/">Vrienden</a>
        <a href="./chat/">Chat</a>
        <a href="./login/logout.php" style="color: red;">Uitloggen</a>
      </div>
    </div>
  </nav>

  <!-- homepage -->
  <div class="posts">
    <?php
      if ($_GET["post"] == "success") {
    ?>
    <div class="success">
      <h2>Uw post werd succesvol geplaatst!</h2>
    </div>
    <?php
      }
      else {
    ?>
    <div class="makePost">
      <h2>Schrijf een post!</h2>
      <form action="./controllers/post.php" method="POST" enctype="multipart/form-data">
        <label for="imagePost">Upload een foto:</label>
        <input type="file" name="imagePost" id="imagePost" accept="image/*" required>
        <textarea name="textPost" id="textPost" placeholder="Uw tekstje:" required></textarea><br><br>
        <input type="submit" value="Posten">
      </form>
    </div>
    <?php
      }

      $posts = getQuery("SELECT * FROM v_posts WHERE user_id IN (SELECT id_2 FROM vrienden WHERE status = 'a' AND id_1 = $userID) ORDER BY datum DESC;");
      foreach ($posts as $post) {
    ?>
      <div class="postBericht">
        <p><img src="<?php echo $post["profiel_img_url"]; ?>" class="imageuser"> <a href='./account?id=<?php echo $post['user_id']; ?>' class="postUserNaam"><?php echo $post["naam"]; ?></a></p>

        <img src="<?php echo $post["foto_url"]; ?>" class="imagepost">
        <h4 class="likes"><span class="aantallikes"></span>Likes ???</h4>
        <p><?php echo $post["tekst"]; ?></p>
        <p>Reacties ????</p>
        <br><br>
      </div>
    <?php
      }
    ?>
  </div>

  <footer>
    (c) 2BLM | Wij maken gebruik van externe lettertypes | <a href="./privacy/">Privacyverklaring</a>
  </footer>
</body>
</html>