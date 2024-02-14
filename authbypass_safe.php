<?php
$servername = "localhost";
$username = "example";
$password = "example";
$dbname = "example";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$name = "";
$result = "";

$sql = "SELECT * FROM users WHERE id = 1";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$username = $user['username'];
$userid = $user['id'];
$html="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['id']) and $_POST['id'] === $userid) {
		$password = HTMLSPECIALCHARS($_POST['password']);
		$id = HTMLSPECIALCHARS($_POST['id']);
		$request = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
		$request->bind_param('si', $password, $id);
		$request->execute();
		$html = "<h3> Mot de passe correctement modifié !</h3>";
	} else {
		$html = "<h3>Erreur durant la modification du mot de passe.</h3>";
	}
}

Header( 'Cache-Control: no-cache, must-revalidate');    // HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );      // TODO- proper XHTML headers...
Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );     // Date in the past

?>
<!DOCTYPE html>

<html lang="en-GB">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<title>Example - bypass authentication</title>
	</head>

	<body>
	<?php echo $html; ?>
	<h3> Bonjour <?php echo $username; ?>, tu peux modifier ton mot de passe : </h3>
		<form action="authbypass_safe.php" method="post">
			<label for="password">Nouveau mot de passe</label> <br/> <input type="text" id="password" name="password"> <br/>
			<label for="password2">Confirmation du nouveau mot de passe</label> <br/> <textarea id="password2" name="password2"></textarea>
			<input type="text" id="id" name="id" value="<?php echo $userid; ?>" readonly style="display: none;">
			<button type="submit">Envoyer</button>
		</form>
	</body>

</html>