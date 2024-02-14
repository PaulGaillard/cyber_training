<?php
$servername = "localhost";
$username = "example";
$password = "example";
$dbname = "example";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name=addslashes($_POST['name']);
	$comment=addslashes($_POST['comment']);
    $sql_insert = "INSERT INTO comment (Name, Comment) VALUES (\"" . $name . "\",\"" . $comment . "\");";
    $conn->query($sql_insert); 
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (isset($_GET['delete'])) {
		$sql_clean = "TRUNCATE TABLE comment;";
    	$conn->query($sql_clean); 
	}
}

$sql = "SELECT Name, Comment FROM comment";
$result = $conn->query($sql);



Header( 'Cache-Control: no-cache, must-revalidate');    // HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );      // TODO- proper XHTML headers...
Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );     // Date in the past

?>
<!DOCTYPE html>

<html lang="en-GB">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<title>Example - XSS stored</title>

	</head>

	<body>
	<h3> Mon commentaire :	</h3>
		<form action="xss_stored.php" method="post">
			<label for="comment">Mon nom</label> <br/> <input type="text" id="name" name="name"> <br/>
			<label for="comment">Mon commentaire</label> <br/> <textarea id="comment" name="comment"></textarea>
			<button type="submit">Envoyer</button>
		</form>

	<h3> Commentaires utilisateurs : </h3>
		<?php
			if ($result->num_rows > 0) {
			  while($row = $result->fetch_assoc()) {
			    echo "<div><label>Nom :</label><p>" . $row["Name"]. "</p><br/>";
			    echo "<label>Commentaire </label><p>" . $row["Comment"]. "</p><br/></div>";
			  }
			} else {
			  echo "<label>Pas de commentaire</label>";
			}
			$conn->close();
		?>
	<br/><a href="xss_stored.php?delete=all" class="button">Tout supprimer</a>
	</body>

</html>