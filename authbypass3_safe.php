<?php
$message="";
$max_size=2048;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$file = $_FILES['file'];
	//première vérification d'erreur ou taille de fichier (pour éviter d'aller trop loin sur un fichier incorrect)
	if ($file['error'] === 0 and $file['size'] <= $max_size) { 

			//récupère le nom du fichier renvoyé par le serveur
			$name = $file['name'];
			//Chemin prévu
			$dest_dir = './telechargements/';

			//calcul la taille du fichier reçu = pour être sûr qu'on ne s'est pas fait tromper par la taille de fichier renvoyée
			$size = filesize($file['tmp_name']);
			//liste les extensions autorisées
			$extensions = array('.json', '.txt', '.xml');
			//récupère l'extension du fichier reçu
			$file_extension = strrchr($name, '.'); 
			//verif extension
			if(!in_array($file_extension, $extensions)) //Si l'extension n'est pas dans le tableau
			{
			     $message="<h3>Erreur le fichier doit être au format .json, .txt ou .xml.</h3>";
			} elseif ($size>$max_size) {
				$message="<h3>Fichier trop volumineux.</h3>";
			} else {
				//on supprime tous les caractères du nom qui ne sont pas des lettre ou chiffre
				$name = preg_replace('/([^.A-Za-z0-9]+)/i', '-', $name);
				if (move_uploaded_file($file['tmp_name'], $dest_dir . $name)) {
				    $message="<h3>Le fichier est valide, et a été téléchargé
				           avec succès.</h3>";
				} else {
				    $message="<h3>Erreur durant le téléchargement du fichier.</h3>";
				}
			}
	}else {
		$message="<h3>Erreur ou fichier trop volumineux.</h3>";
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
	<?php echo $message; ?>
	<h3>Importation de fichier</h3>
	<form method="post" enctype="multipart/form-data">
		<label for="file">Sélectionnez un fichier :</label><br/>
		<input type="file" id="file" name="file"><br/>
		<input type="submit" value="Importer"><br/>
	</form>
	</body>

</html>