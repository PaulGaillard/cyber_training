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
			        echo "<form action=\"command_injection2_safe.php\" method=\"post\">
					    <button type=\"submit\" name=\"filename\" style=\"cursor: pointer;\" value=\"" . HTMLSPECIALCHARS($file) . "\">" . HTMLSPECIALCHARS($file) . " </button>
					</form>";
			    }
			}
		?>
		</div>
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['filename'])) {
				//On authorise uniquement le dossier courant
				$allowed_path = './';
				//On calcul le chemin absolu
				$allowed_path_full = realpath($allowed_path);
				//On récupère et nettoie le nom du fichier pour le XSS
				$filename=HTMLSPECIALCHARS($_POST['filename']);
				//On construit le chemin du fichier demandé
				$file_path = $allowed_path . $filename;

				//On vérifie si le fichier est bien dans le dossier autorisé
				if (strpos(realpath($file_path), $allowed_path_full) === 0) {
					//le fichier est dans un dossier autorisé
					$output = file_get_contents($file_path);
					echo "<h3> Contenu du fichier ". $filename . " : </h3>";
					echo "<pre>";
					   echo htmlspecialchars($output);
					echo "</pre>";
				} else {
					echo "<h3> Accès interdit ! </h3>";
				}
			} 
		}

	?>
	</body>

</html>