<?php
session_start();
include_once("../../includes/Database.php");
if (isset($_SESSION['loggedIn'])) {
	header('Location: ../../');
	exit;
}

$mode = "failed";

if (isset($_GET["id"])) {
  if ($_GET["id"] == "registratie") {
    $mode = "registratie";
  }
  else {
    $hash = $_GET["id"];
    $get = getQuery("SELECT user_id, mail_sms FROM verificatehashes WHERE hash = '$hash';");

    $userID = $get[0]["user_id"];
    $ms = $get[0]["mail_sms"];

    if ($ms == "sms") {
      $success = insertQuery("UPDATE users SET tel_verif = '1' WHERE id = '$userID';");
      if ($success == true) {
        $mode = "tel";
        insertQuery("DELETE FROM verificatehashes WHERE hash = '$hash';");
      } else $mode = "failed";
    }
    elseif ($ms == "mail") {
      $success = insertQuery("UPDATE users SET mail_verif = '1' WHERE id = '$userID';");
      if ($success == true) {
        $mode = "mail";
        insertQuery("DELETE FROM verificatehashes WHERE hash = '$hash';");
      } else $mode = "failed";
    }
    else {
      $mode = "failed";
    }
  }
}
else {
  die(header("Location: ../"));
  exit;
}
?>

<html>

<head>
	<title>2BLM | Verificatie</title>
	<link rel="stylesheet" type="text/css" href="../../style/login.css">
  <link rel="stylesheet" type="text/css" href="../../style/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<div id="wrapper">
		<div id="block1">
			<h1>2BLM</h1>
			<h3>In <i class="fa fa-heart"></i> met security</h3>
		</div>

		<!-- verificatie -->
		<div id="inlogDiv">
			<h2>Verificatie</h2>
      <?php 
        if ($mode == "registratie") {
      ?>
          <p>Er werd u een per sms en e-mail een verificatielink gestuurd. Gelieve op zowel de link in de mail als in de sms te klikken om uw account te verifiëren.</p>
      <?php
        }
        elseif ($mode == "mail") {
      ?>
          <p>Bedankt! Uw e-mailadres werd succesvol geverifiëerd.</p>
          <p>Als uw telefoonnummer ook al reeds geverifiëerd werd, kan u hieronder doorgaan naar aanmelden.</p>
          <br>
          <a href="../">Meld u aan!</a>
      <?php
        }
        elseif ($mode == "tel") {
      ?>
          <p>Bedankt! Uw telefoonnummer werd succesvol geverifiëerd.</p>
          <p>Als uw e-mailadres ook al reeds geverifiëerd werd, kan u hieronder doorgaan naar aanmelden.</p>
          <br>
          <a href="../">Meld u aan!</a>
      <?php
        }
        elseif ($mode == "failed") {
      ?>
          <p>Het was niet mogelijk uw aanvraag tot verificatie te behandelen, probeer het opnieuw alstublieft.</p>
      <?php
        }
      ?>
		</div>
	</div>
</body>

</html>