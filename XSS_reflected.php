<?php

Header( 'Cache-Control: no-cache, must-revalidate');    // HTTP/1.1
Header( 'Content-Type: text/html;charset=utf-8' );      // TODO- proper XHTML headers...
Header( 'Expires: Tue, 23 Jun 2009 12:00:00 GMT' );     // Date in the past

?>
<!DOCTYPE html>

<html lang="en-GB">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Example - XSS reflected</title>

	</head>

	<body>
	
	<h1> Oups ! L'article <?php echo $_GET['article_name']; ?> n'existe pas ! </h1>

	</body>

</html>
