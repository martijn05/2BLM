<?php
session_start();
// if (!isset($_SESSION['verifcode'])) {
// 	die(header("Location: ../"));
// 	exit;
// }
// if (isset($_SESSION['loggedIn'])) {
// 	header('Location: ../../');
// 	exit;
// }

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
	<link rel="stylesheet" type="text/css" href="login.css">
	<link rel="stylesheet" type="text/css" href="../../style/login.css">
	<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
</head>

<body>
	<div id="wrapper">
		<div id="block1">
			<h1>2BLM</h1>
		</div>

		<!-- verificatie -->
		<div id="inlogDiv">
			<h2>Verificatie</h2>
			<p style="margin-right: 20px;">Er werd u een verificatiecode per sms/e-mail gestuurd. Vul deze hieronder in: </p>
			<form action="./" method="POST">
				<input type="number" name="logincode" id="logincode" placeholder="Verificatiecode" required>
				<br>
				<input type="submit" value="Ga door" name="verificate" id="verifButton">
			</form>
			<?php echo $verifCode; ?>
		</div>
	</div>
</body>

</html>