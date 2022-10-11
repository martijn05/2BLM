<?php
session_start();
include_once("../includes/Database.php");

// if (isset($_SESSION['loggedIn'])) {
//   header('Location: ../');
//   exit;
// }

function createVerifcode() {
  $unix = time();
  $rd1 = rand(1000, 9999);
  $rd2 = rand(0, 7);

  return substr(strval($unix * $rd1), $rd2, 6);
}

//login
if (isset($_POST['login_user'])) {
  //telefoon
  if (isset($_POST['loginTel'])) {
    $tel = $_POST['loginTel'];
    $userID = getQuery("SELECT id FROM users WHERE telefoon = '$tel';")[0]["id"];

    if ($userID != "") {
      $verifCode = createVerifcode();
      
      //$tel in +324... vorm, werkt enkel als op FTP server staat
      $url = "https://platform.clickatell.com/messages/http/send?apiKey=OkUo0CPiRp2zNo5uN8RTuA==&to=" . $tel . "&content=BrentAtWeb+dashboard+verificatiecode:+" . $verifCode;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);
    }
  }
  //email
  if (isset($_POST['loginMail'])) {
    $mail = $_POST['loginMail'];
    $userID = getQuery("SELECT id FROM users WHERE email = '$mail';")[0]["id"];

    if ($userID != "") {
      $verifCode = createVerifcode();
      $message = '
        <html>
        <head>
            <title>Verificator | Niels Elektriciteitswerken</title>
            <style>  
                h1 {
                    font-size: 60px;
                    margin: 0;
                    margin-top: 50px;
                    color: #55558E;
                }
                
                h2 {
                    font-size: 30px;
                    margin: 0;
                    color: #55558E;
                }
                
                p {
                    font-size: 100px;
                    margin-bottom: 0;
                }
                
                html {
                    text-align: center;
                    font-family: "Arial";
                }
            </style>
        </head>
        
        <body>
            <h1>Verificator</h1>
            <h2>Niels Elektriciteitswerken</h2>
        
            <p>' . $verifCode . '</p><br>
        </body>
        </html>
      ';

      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';
      $headers[] = 'From: Niels Elektriciteitswerken Verificatie <verificator@nielselektriciteitswerken.be>';
      mail($Email, 'Niels Elektriciteitswerken Verificatie', $message, implode("\r\n", $headers));
    }
  }

  //account?
  if ($userID != "") {
    $_SESSION['verifcode'] = $verifCode;
    $_SESSION['user_id'] = $userID;
    header("Location: ./verificate");    
  }
  else $userID = "NOTFOUND";
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>2BLM | Inloggen</title>
  <link rel="stylesheet" href="../style/login.css">
  <link rel="stylesheet" href="../style/style.css">
</head>

<script>
  function showHideDivs(div) {
    var iDiv = document.getElementById("inlogDiv");
    var rDiv = document.getElementById("registreerDiv");

    switch (div) {
      case "i-m":
        // inloggen met mail
        document.getElementById("loginTelForm").style.display = "none";
        document.getElementById("loginMailForm").style.display = "block";
        break;

      case "i-t":
        // inloggen met telefoon
        document.getElementById("loginTelForm").style.display = "block";
        document.getElementById("loginMailForm").style.display = "none";
        break;

      case "i":
        iDiv.style.display = "block";
        rDiv.style.display = "none";
        break;

      case "r":
        iDiv.style.display = "none";
        rDiv.style.display = "block";
        break;

      default:
        break;
    }
  }
</script>

<body>
  <div id="wrapper">
    <div id="block1">
      <h1>2BLM</h1>
    </div>

    <!-- inloggen -->
    <div id="inlogDiv">
      <h2>Inloggen</h2>
      <form action="" method="POST" id="loginMailForm">
        <input type="email" name="loginMail" id="loginMail" placeholder="E-mailadres" required>
        <input type="submit" value="Log in" name="login_user" id="LoginButton">
        <a onclick="showHideDivs('i-t');" id="loginTelKnop">Of aanmelden met telefoonnummer</a>
      </form>
      <form action="./" method="POST" id="loginTelForm" style="display:none;">
        <input type="tel" name="loginTel" id="loginTel" placeholder="Telefoonnummer" required>
        <input type="submit" value="Log in" name="login_user" id="LoginButton">
        <a onclick="showHideDivs('i-m');" id="loginMailKnop">Of aanmelden met e-mailadres</a>
      </form>
      <?php 
        if (isset($userID) && ($userID == "NOTFOUND")){
          echo '<p style="margin-right: 20px;">Er is geen account gevonden met deze gegevens.</p>';
        }
      ?>
      <div id="Registreren">
        <p id="registreerP">Nog geen account? <a onclick="showHideDivs('r');" id="Registreer">Registreer nu!</a></p>
      </div>
    </div>

    <!-- registreren -->
    <div style="border: 1px solid black; display: none;" id="registreerDiv">
      <h2>Registreren</h2>
      <form action="" method="POST">
        <input type="text" name="naam" id="naam" placeholder="Naam">
        <br>
        <input type="email" name="email" id="email" placeholder="E-mailadres">
        <br>
        <input type="" name="telefoon" id="telefoon" placeholder="Telefoonnummer">
        <br>
        <input type="submit" name="register_user" value="Registreren">
      </form>
      <p>Al een account? <button onclick="showHideDivs('i');">Meld u aan!</button></p>
    </div>
  </div>
</body>

</html>