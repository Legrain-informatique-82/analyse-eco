<?php session_start(); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
//include_once("Creat_Xml.php");

//redirection vers l'edition à la fin

//local
$uploaddir = '/var/www/php/AnalyseEco/tmp';
$nom_fichier_xml_edition="xml/test1.xml";
$repertoire_fichier_xml_edition="/var/www/php/AnalyseEco/";
$chemin_complet_donnees_edition=$repertoire_fichier_xml_edition.$nom_fichier_xml_edition;
//$chemin_complet_donnees_edition="/tmp/test1.xml";


/*
//web
$uploaddir = '/var/www/vhosts/cogerea.net/httpdocs/ae/';
$nom_fichier_xml_edition="xml/test1.xml";
$repertoire_fichier_xml_edition=$uploaddir;
$chemin_complet_donnees_edition="cogerea.net/ae/xml/test1.xml";
*/

$rptDesignPath=urlencode("/report/analyse.rptdesign");
$xmlDataSourcePath="http://".urlencode("localhost/php/AnalyseEco/xml/test1.xml");
//$xmlDataSourcePath=urlencode($chemin_complet_donnees_edition);
$encodedurl="frameset?__report=".$rptDesignPath."&data=".$xmlDataSourcePath;
$url_complete="http://localhost:8080/birt/".$encodedurl;
//$url_complete="http://213.186.38.48:8080/birt/".$encodedurl;
//$url_complete="http://cogerea.net:8080/birt/".$encodedurl;

$url_complete .= "&__format=pdf";

//header("location: $url_complete");

echo "<br>";
echo "<br>";
echo "<hr>";
echo "<a href=\"$url_complete\">Edition</a>";
echo "<hr>";
echo "<br>";
echo "<br>";

include_once("Creat_Xml.php");

?>
</body>
</html>