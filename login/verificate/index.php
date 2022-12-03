<?php
session_start();
if (!isset($_SESSION['verifcode'])) {
	die(header("Location: ../"));
	exit;
}
if (isset($_SESSION['loggedIn'])) {
	header('Location: ../../');
	exit;
}

$verifCode = $_SESSION['verifcode'];

if (isset($_POST['verificate'])) {
	$vercod = $_POST['logincode'];
	if ($vercod == $verifCode) {
		$_SESSION['loggedIn'] = true;
		header('Location: ../../');
	}
}
?>

<html>

<head>
	<title>2BLM | Verificate</title>
	<link rel="stylesheet" type="text/css" href="../../style/login.css">
	<link rel="stylesheet" type="text/css" href="../../style/style.css">
	<link rel="stylesheet" href="../../style/verificate.css">
	<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
	<div id="wrapper">
		<div id="block1">
			<h1>2BLM</h1>
			<h3>In <i class="fas fa-heart"></i> met security</h3>
		</div>

		<!-- verificatie -->
		<div id="inlogDiv">
			<h2>Verificatie</h2>
			<p>Er werd u een verificatiecode per sms/e-mail gestuurd. Vul deze hieronder in: </p>
			<form action="./" method="POST">
				<input type="number" name="logincode" id="logincode" placeholder="Verificatiecode" required value="<?php echo $verifCode; ?>">
				<br>
				<input type="submit" value="Ga door" name="verificate" id="verifButton">
			</form>
		</div>
	</div>
</body>

</html>