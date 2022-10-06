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
    var pvDiv = document.getElementById("pasvergDiv");

    switch (div) {
      case "i":
        iDiv.style.display = "block";
        rDiv.style.display = "none";
        pvDiv.style.display = "none";
        break;
      
      case "r":
        iDiv.style.display = "none";
        rDiv.style.display = "block";
        pvDiv.style.display = "none";
        break;

      case "pv":
        iDiv.style.display = "none";
        rDiv.style.display = "none";
        pvDiv.style.display = "block";
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
      <form action="">
        <label for="emailTelefoon">E-mailadres of telefoonnummer</label><br>
        <input type="text" name="emailTelefoon" id="emailTelefoon" placeholder="E-mailadres of telefoonnummer">
        <br>
        <label for="wachtwoord">Wachtwoord</label><br>
        <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord">
        <br>
        <a style="color: red;" onclick="showHideDivs('pv');">Wachtwoord vergeten</a>
        <br>
        <input type="submit" value="Log in" id="LoginButton">
      </form>
      <button id="LoginGoogle">Icon - Inloggen met Google</button>
      <p>Nog geen account? <button onclick="showHideDivs('r');" id="Registreer">Registreer nu!</button></p>
    </div>
  </div>

  <!-- registreren -->
  <div style="border: 1px solid black; display: none;" id="registreerDiv">
    <h2>Registreren</h2>
    <form action="">
      <label for="naam">Naam</label><br>
      <input type="text" name="naam" id="naam" placeholder="Naam">
      <br>
      <label for="email">E-mailadres</label><br>
      <input type="email" name="email" id="email" placeholder="E-mailadres">
      <br>
      <label for="tel">Telefoonnummer</label><br>
      <input type="" name="telefoon" id="telefoon" placeholder="Telefoonnummer">
      <br>
      <label for="wachtwoord">Wachtwoord</label><br>
      <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord">
      <br>
      <input type="submit" value="Registreren">
    </form>
    <p>Al een account? <button onclick="showHideDivs('i');">Meld u aan!</button></p>
  </div>

  <!-- paswoord vergeten -->
  <div style="border: 1px solid black; display:none;" id="pasvergDiv">
    <h2>Paswoord vergeten</h2>
    <form action="">
      <label for="emailTelefoon">E-mailadres of telefoonnummer</label><br>
      <input type="text" name="emailTelefoon" id="emailTelefoon" placeholder="E-mailadres of telefoonnummer">
      <br>
      <input type="submit" value="Reset wachtwoord">
    </form>
    <p><button onclick="showHideDivs('i');">Meld u aan!</button> of <button onclick="showHideDivs('r');">Registreer nu!</button></p>
  </div>

</body>
</html>