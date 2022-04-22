<?php session_start();
include_once("class_inter.php");

define('FICHE_XML_FINAL','test1.xml');

/*
 * modifier la fiche de xml finale--test1.xml
 * en fonction de taleau --Mode faire valoir-- qui va saisire
*/
function modif_xml_final_faire_valoir($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7)
{
	$faire_valoir = new faire_valoir();
	$faire_valoir->Set_valeur($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7);
	$faire_valoir->somme_total_sau();
	$faire_valoir->somme_total_surface();
	
	if(file_exists(FICHE_XML_FINAL)){
		echo "fichier ok<br>";
	$donnees_analyse_eco = simplexml_load_file("test1.xml");
	//$analyse_eco = new donnees_analyse_eco();//objet de analyse_eco.php
	} else {
		echo "fichier introuvable<br>";
	}
	
}
 ?>