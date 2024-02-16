<?php

$url="/".basename(__DIR__)."/authbypass2.php";
$requested_uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if(strcasecmp($url, $requested_uri) === 0){
	http_response_code(403);
	echo "ERROR 403 - UNAUTHORIZED";
	exit();
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
	<h3> Seul un super administrateur a accès à cette page ! </h3>
	<p> Atttention ce test ne fonction que si vous êtes dans niveau n-1 de votre arborescence web (exemple qui fonctionne : http://localhost/example/authbypass2.php & exemple qui ne fonctionne pas : http://localhost/dir/example/authbypass2.php). Dans le cas où ça ne fonctionne pas, remplacer $url dans le code source par votre URI (exemple : /dir/example/authbypass2.php)<p>
	</body>

</html>
