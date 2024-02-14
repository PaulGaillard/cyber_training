<?php
$message="";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$file = $_FILES['file'];
	if ($file['error'] === 0) { 
		$name = $file['full_path'];
		$dest = 'telechargements/' . $name;

		if (move_uploaded_file($file['tmp_name'], $dest)) {
		    $message="<h3>Le fichier est valide, et a été téléchargé
		           avec succès.</h3>";
		} else {
		    $message="<h3>Erreur durant le téléchargement du fichier.</h3>";
		}
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