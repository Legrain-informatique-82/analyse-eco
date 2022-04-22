<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php

//local
$uploaddir = '/var/www/php/AnalyseEco/tmp/';


/*
//web
$uploaddir = '/var/www/vhosts/cogerea.net/httpdocs/ae/tmp/';
//$uploaddir = '/ae/tmp/';
*/

$uploadfile = $uploaddir . basename($_FILES['analyse']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['analyse']['tmp_name'], $uploadfile)) {
	echo "Le fichier est valide, et a été téléchargé avec succès.\n";
//	chown($uploadfile,"nicolas");
} else {
	echo "Attaque potentielle par téléchargement de fichiers.\n";
	echo 'Voici quelques informations de débogage :';
print_r($_FILES);
}

//echo 'Voici quelques informations de débogage :';
//print_r($_FILES);

echo '</pre>';

//calculs
$url_calculs="test_calculs_local.php";
echo "<a href=\"".$url_calculs."\">Calculs et édition.</a>";

?>
</body>
</html>