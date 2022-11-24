<?php 
session_start();
// if (!isset($_SESSION['loggedIn'])) {
// 	header('Location: ./login');
// 	exit;
// }
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./style/homepage.css">
  <title>2BLM</title>
  
</head>
<body>
  <?php include 'header.html';?>
  <!-- homepage -->
  <h1>2BLM - Homepage</h1>
  
  <div class="post">

    <div class="user">
      <img src="./images/profielfoto.jpg" alt="user" class="imageuser"> 
      <h3>Martijn Coudyzer</h3>
    </div>

    <div class="image">
      <img src="./images/zee.jpg" alt="zee" class="imagepost">
      <h4 class="likes"><span class="aantallikes">4</span> vind-ik-leuks</h4>
      <p>Ik ben naar zee geweest yeeey</p>
    </div>

    <div class="reacties">
      <h4>Reacties</h4>
      <p>Brent Schillemans</p><p>Wat cool was ik daar ook maar!!!!!!!!!!!</p>
      <br>
      <p>Bastiaan De Mey</p><p>Hebben ze daar ook bier?</p>
      <br>
      <p>Lina Stroobants</p><p>joepiiii</p>
    </div>
    

      
  </div>
</body>
</html>