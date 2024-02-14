<?php
$servername = "localhost";
$username = "example";
$password = "example";
$dbname = "example";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$login_result = "";
$login=	"<form action=\"login_safe.php\" method=\"post\">
			<label for=\"username\">Login</label> <br/> <input type=\"text\" id=\"username\" name=\"username\"> <br/>
			<label for=\"password\">Password</label> <br/> <input type=\"text\" id=\"password\" name=\"password\"> <br/>
			<button type=\"submit\">Login</button>
		</form>";
$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = $_POST["username"];
	$passwd = $_POST["password"];
	$request = $conn->prepare('SELECT * FROM users WHERE username=? and password=?');
	$request->bind_param('ss', $user, $passwd);
	$request->execute();
	$result = $request->get_result();
	// Vérifier si l'utilisateur a été trouvé dans la base de données
	if ($result->num_rows > 0) {
	    $login_result="<p>Connexion réussie pour l'utilisateur " . HTMLSPECIALCHARS($user) . "</p>";
		$login = "";
	} else {
	    $login_result="<p>Nom d'utilisateur et/ou mot de passe invalide(s).</p>";
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

		<title>Example - SQL Injection</title>
	</head>

	<body>

		<?php
			echo $login;
			echo $login_result;
		?>
	</body>

</html>