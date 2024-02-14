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
		$sql = "SELECT * FROM comment WHERE Name = \"" . $_GET['name'] . "\"";
		//echo $sql;
		$result = $conn->query($sql);
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
			if ($result != ""){

				if ($result->num_rows > 0) {
				  while($row = $result->fetch_assoc()) {
				    echo "<label>Name</label><p>" . HTMLSPECIALCHARS($row["Name"]) . "</p><br/></div>";
				    echo "<label>Commentaire </label><p>" . HTMLSPECIALCHARS($row["Comment"]) . "</p><br/></div>";
				  }
				} else {
				  echo "<label>Pas de commentaire</label>";
				}

			}
			$conn->close();
		?>
	</body>

</html>