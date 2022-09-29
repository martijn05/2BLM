<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>2BLM | Inloggen</title>
</head>
<body>
  <h1>2BLM</h1>

  <!-- inloggen -->
  <div style="border: 1px solid black;">
    <h2>Inloggen</h2>
    <form action="">
      <label for="emailTelefoon">E-mailadres of telefoonnummer</label><br>
      <input type="text" name="emailTelefoon" id="emailTelefoon" placeholder="E-mailadres of telefoonnummer">
      <br>
      <label for="wachtwoord">Wachtwoord</label><br>
      <input type="password" name="wachtwoord" id="wachtwoord" placeholder="Wachtwoord">
      <br>
      <button>Wachtwoord vergeten</button>
      <br>
      <input type="submit" value="Inloggen">
    </form>
    <button>Icon - Inloggen met Google</button>
    <p>Nog geen account? <button>Registreer nu!</button></p>
  </div>

  <!-- registreren -->
  <div style="border: 1px solid black;">
    <h2>Registreren</h2>
    <form action="">
      <label for="voornaam">Voornaam</label><br>
      <input type="text" name="voornaam" id="voornaam" placeholder="Voornaam">
      <br>
      <label for="achternaam">Achternaam</label><br>
      <input type="text" name="achternaam" id="achternaam" placeholder="Achternaam">
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
      <label for="wachtwoord2">Wachtwoord bevestigen</label><br>
      <input type="password" name="wachtwoord2" id="wachtwoord2" placeholder="Wachtwoord bevestigen">
      <br>
      <input type="submit" value="Registreren">
    </form>
    <p>Al een account? <button>Meld u aan!</button></p>
  </div>

  <!-- paswoord vergeten -->
  <div style="border: 1px solid black;">
    <h2>Paswoord vergeten</h2>
    <form action="">
      <label for="emailTelefoon">E-mailadres of telefoonnummer</label><br>
      <input type="text" name="emailTelefoon" id="emailTelefoon" placeholder="E-mailadres of telefoonnummer">
      <br>
      <input type="submit" value="Reset wachtwoord">
    </form>
  </div>

</body>
</html>