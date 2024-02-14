<?php


Header( 'Cache-Control: no-cache, must-revalidate');    // HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );      // TODO- proper XHTML headers...
Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );     // Date in the past

?>
<!DOCTYPE html>

<html lang="en-GB">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<title>Example - Command Injection</title>
	</head>

	<body>
		<h3>Liste des fichiers disponibles :</h3>
		<div>
		<?php
			$files = scandir(".");
			
			foreach($files as $file) {
			    if($file != '.' && $file != '..') {
			        echo "<p>" . HTMLSPECIALCHARS($file) . "</p>";
			    }
			}
		?>
		</div>
		<h3>Choix du fichier:</h3>
		<form action="command_injection.php" method="GET">
			<label for="filename">Nom du fichier</label> <br/> <input type="text" id="filename" name="filename"> <br/>
			<button type="submit">Lire le contenu</button>
		</form>
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			if (isset($_GET['filename'])) {
				$output = null;
				exec('Type '. $_GET['filename'], $output);
				echo "<h3> Contenu du fichier ". HTMLSPECIALCHARS($_GET['filename']) . " : </h3>";
				echo "<pre>";
				foreach ($output as $line) {
				   echo htmlspecialchars($line) . "\n";
				}
				echo "</pre>";
			} 
		}

	?>
	</body>

</html>