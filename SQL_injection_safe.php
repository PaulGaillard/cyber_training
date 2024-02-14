<?php
$servername = "localhost";
$username = "example";
$password = "example";
$dbname = "example";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$name = "";
$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET['name'])) {
	// Check the database
		$name = $_GET[ 'name' ];
		$request = $conn->prepare('SELECT * FROM comment WHERE Name = ?');
		$request->bind_param('s', $name);
		$request->execute();
		$name = HTMLSPECIALCHARS(addslashes($_GET['name']));
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

	<h3> Commentaires de <?php echo $name ?> : </h3>
		<?php
			if ($request != ""){
				$request->bind_result($name, $comment);
				while ($request->fetch()) {
				    echo "<label>Name</label><p>" . HTMLSPECIALCHARS($name) . "</p><br/></div>";
				    echo "<label>Commentaire </label><p>" . HTMLSPECIALCHARS($comment) . "</p><br/></div>";
				  }

			}
			$conn->close();
		?>
	</body>

</html>