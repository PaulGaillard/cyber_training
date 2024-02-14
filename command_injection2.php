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
			        echo "<form action=\"command_injection2.php\" method=\"post\">
					    <button type=\"submit\" name=\"filename\" style=\"cursor: pointer;\" value=\"" . HTMLSPECIALCHARS($file) . "\">" . HTMLSPECIALCHARS($file) . " </button>
					</form>";
			    }
			}
		?>
		</div>
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['filename'])) {
				$output = null;
				exec('Type '. $_POST['filename'], $output);
				echo "<h3> Contenu du fichier ". HTMLSPECIALCHARS($_POST['filename']) . " : </h3>";
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