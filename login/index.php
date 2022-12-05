<?php
session_start();
include_once("../includes/Database.php");

if (isset($_SESSION['loggedIn'])) {
  header('Location: ../');
  exit;
}

function createVerifcode() {
  $unix = time();
  $rd1 = rand(1000, 9999);
  $rd2 = rand(0, 7);

  return substr(strval($unix * $rd1), $rd2, 6);
}

//login -- mail en telefoon sturen aanpassen
if (isset($_POST['login_user'])) {
  //telefoon
  if (isset($_POST['loginTel'])) {
    $tel = $_POST['loginTel'];
    $user = getQuery("SELECT * FROM users WHERE telefoon = '$tel';");
    $userID = $user[0]["id"];
    $verifOK1 = $user[0]["mail_verif"];
    $verifOK2 = $user[0]["tel_verif"];

    if ($userID != "") {
      if (($verifOK1 == 0 && $verifOK2 == 0) || ($verifOK1 == 0 || $verifOK2 == 0)) {
        $userID = "NIETVERIF";
      } else {
        $verifCode = createVerifcode();
        
        //$tel in +324... vorm, werkt enkel als op FTP server staat
        $url = "https://platform.clickatell.com/messages/http/send?apiKey=OkUo0CPiRp2zNo5uN8RTuA==&to=" . $tel . "&content=Uw+2BLM+verificatiecode+is:+" . $verifCode;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
      }
    }
  }
  //email
  if (isset($_POST['loginMail'])) {
    $mail = $_POST['loginMail'];
    $user = getQuery("SELECT * FROM users WHERE email = '$mail';");
    $userID = $user[0]["id"];
    $verifOK1 = $user[0]["mail_verif"];
    $verifOK2 = $user[0]["tel_verif"];

    if ($userID != "") {
      if (($verifOK1 == 0 && $verifOK2 == 0) || ($verifOK1 == 0 || $verifOK2 == 0)) {
        $userID = "NIETVERIF";
      } else {
        $verifCode = createVerifcode();
        $message = '
          <html>
          <head>
              <title>Verificatie | 2BLM</title>
              <style>  
                  h1 {
                      font-size: 60px;
                      margin: 0;
                      margin-top: 50px;
                      color: #070058;
                  }
                  
                  h2 {
                      font-size: 30px;
                      margin: 0;
                      color: #070058;
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
              <h1>2BLM</h1>
              <h2>Verificatie</h2>
          
              <p>Uw verificatiecode is: ' . $verifCode . '</p><br>
          </body>
          </html>
        ';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: 2BLM Verificatie <2blm@brentatweb.be>';
        mail($mail, '2BLM Verificatie', $message, implode("\r\n", $headers)); 
      }
    }
  }

  //account?
  if ($userID != "") {
    if ($userID != "NIETVERIF") {
      $_SESSION['verifcode'] = $verifCode;
      $_SESSION['user_id'] = $userID;
      header("Location: ./verificate");    
    }
  }
  else $userID = "NOTFOUND";
}
if (isset($_POST['register_user'])) {
  $name = $_POST['registerName'];
  $tel = $_POST['registerTel'];
  $mail = $_POST['registerMail'];
  $telInDB = getQuery("SELECT id FROM users WHERE telefoon = '$tel';")[0]["id"];
  $mailInDB = getQuery("SELECT id FROM users WHERE email = '$mail';")[0]["id"];

  if (($telInDB == "" && $mailInDB == "") || ($telInDB == "" || $mailInDB == "")) {
    //nog geen account --> voeg toe
    insertQuery("INSERT INTO users VALUES (NULL, '$name', '$mail', '$tel', '', 0, 0);");
    //id opvragen en link maken met hash van "mail1" en "tel1" ...
    $userID = getQuery("SELECT id FROM users WHERE email = '$mail';")[0]["id"];
    $linkMail = hash('sha1', 'mail'.$userID);
    $linkTel = hash('sha1', 'tel'.$userID);
    //hash opslaan in tabel verificatehashes (id, user_id, mail_sms/hash)
    insertQuery("INSERT INTO verificatehashes VALUES (NULL, '$userID', 'mail', '$linkMail');");
    insertQuery("INSERT INTO verificatehashes VALUES (NULL, '$userID', 'sms', '$linkTel');");
    //send mail en sms met link --> link naar verificate/sms_mail.php, daar zet je tel_verif en mail_verif op 1
    //tel
    $link = "https://www.brentatweb.be/2BLM/login/verificate/sms_mail.php?id=".$linkTel;
    $url = "https://platform.clickatell.com/messages/http/send?apiKey=OkUo0CPiRp2zNo5uN8RTuA==&to=".$tel."&content=Klik+op+volgende+link+om+u+te+verifiëren+bij+2BLM:+".$link;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    //mail
    $link = "https://www.brentatweb.be/2BLM/login/verificate/sms_mail.php?id=".$linkMail;
    $message = '
          <html>
          <head>
              <title>Verificatie | 2BLM</title>
              <style>  
                  h1 {
                      font-size: 60px;
                      margin: 0;
                      margin-top: 50px;
                      color: #070058;
                  }
                  
                  h2 {
                      font-size: 30px;
                      margin: 0;
                      color: #070058;
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
              <h1>2BLM</h1>
              <h2>Verificatie</h2>
          
              <p>Klik <a href="'.$link.'">hier</a> om u te verifieren bij 2BLM.</p><br>
          </body>
          </html>
        ';

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: 2BLM Verificatie <2blm@brentatweb.be>';
        mail($mail, '2BLM Verificatie', $message, implode("\r\n", $headers)); 

    header("Location: ./verificate/sms_mail.php?id=registratie");  
  }
  else $userID = "ALREADYFOUND";
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
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
  <div class="modal" id="modal">
    Wij maken gebruik van externe lettertypes. <br>
    <button onclick="document.getElementById('modal').style.display = 'none';">Perfect!</button>
  </div>

  <div id="wrapper">
    <div id="block1">
      <h1>2BLM</h1>
      <h3>In <i class="fas fa-heart"></i> met security</h3>
    </div>

    <!-- inloggen -->
    <div id="inlogDiv">
      <h2>Inloggen</h2>
      <form action="./" method="POST" id="loginMailForm">
        <input type="email" name="loginMail" id="loginMail" placeholder="E-mailadres" required>
        <a onclick="showHideDivs('i-t');" id="loginTelKnop">Of aanmelden met telefoonnummer</a>
        <input type="submit" value="Log in" name="login_user" id="LoginButton">
      </form>
      <form action="./" method="POST" id="loginTelForm" style="display:none;">
        <input type="tel" name="loginTel" id="loginTel" placeholder="Telefoonnummer" value="+32" required>
        <a onclick="showHideDivs('i-m');" id="loginMailKnop">Of aanmelden met e-mailadres</a>
        <input type="submit" value="Log in" name="login_user" id="LoginButton">
      </form>
      <?php 
        if (isset($userID) && ($userID == "NOTFOUND")){
          echo '<p style="margin-right: 20px;">Er is geen account gevonden met deze gegevens.</p>';
        }
        elseif (isset($userID) && ($userID == "NIETVERIF")){
          echo '<p style="margin-right: 20px;">Uw account werd nog niet (gedeeltelijk) geverifiëerd! Maak dit in orde om zich te kunnen aanmelden.</p>';
        }
      ?>
      <div id="Registreren">
        <p id="registreerP">Nog geen account? <a onclick="showHideDivs('r');" id="Registreer">Registreer nu!</a></p>
      </div>
    </div>

    <!-- registreren -->
    <div style="border: 1px solid black; display: none;" id="registreerDiv">
      <h2>Registreren</h2>
      <form action="./" method="POST">
        <input type="text" name="registerName" id="registerName" placeholder="Naam">
        <input type="email" name="registerMail" id="registerMail" placeholder="E-mailadres">
        <input type="tel" name="registerTel" id="registerTel" placeholder="Telefoonnummer" value="+32">
        <input type="submit" name="register_user" value="Registreren" id="RegistreerButton">
      </form>
      <?php 
        if (isset($userID) && ($userID == "ALREADYFOUND")){
          echo '<script>showHideDivs("r");</script>';
          echo '<p style="margin-right: 20px;">Er is al een account gevonden met deze gegevens.</p>';
        }
      ?>
      <div id="Inloggen">
        <p id="loginP">Al een account? <a onclick="showHideDivs('i');" id="Login">Meld u aan!</a></p>
      </div>
    </div>
  </div>
</body>

</html>