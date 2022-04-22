<?php

//define('C_DB_HOST','localhost');
//define('C_DB_BASE','COGERE');
//define('C_DB_USER','root');
//define('C_DB_PASSWORD','');

define('C_DB_HOST','localhost');
define('C_DB_BASE','COGERE');
define('C_DB_USER','analyse');
define('C_DB_PASSWORD','pwdAnalyseEco');
function connection1()
{
	$db_conn=mysql_connect(C_DB_HOST,C_DB_USER,C_DB_PASSWORD) 
	or die ('erreur de connexion à la base de données : '.mysql_error());
	
	$query = "SET NAMES 'UTF8'";// sinon il faut utilisé des utf8_encode()
	$result = mysql_query($query,$db_conn);
	
	return $db_conn;
}

/*
 * verifier la fiche de xml final 
 */
function file_xml_existe()
{
	if(file_exists(FICHE_XML_FINAL))
	{
		//echo "fichier ok<br>";
		$xml_final = simplexml_load_file("xml/test1.xml");
	}
	else
	{
		echo "fichier introuvable<br>";
	}
	return $xml_final;
}

/*
 * charger la fiche de xml finale 
 */
?>