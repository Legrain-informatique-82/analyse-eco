<?php
include_once("class_inter.php");
include_once("analyse_eco.php");
session_start();
include_once("connection.php");
include_once("const.php");
define('FICHE_XML_FINAL','xml/test1.xml');
print_r($_SESSION[C_SESSION_MARGE_PRODUCTION]);
echo "====================<br>";
function modifi_marge_nette($objet_ligne_marge_nette)
{
	$var1 = "descriptif-exploitation";
	$var2 = "analyse-technico";
	$var3 = "marge_nette";
	$var4 = "charge_structure_u";
	$var5 = "produits_structurels_u";
	$var6 = "marge_nette_u";
	$var7 = "marge_nette";
	$var8 = "marge_brute_u";
	$xml_final = file_xml_existe();
	$count = 0;
	foreach($xml_final->pages->page[3]->$var2->$var3->ligne as $ligne)
	{
		$libelle_xml = (string)$ligne->libelle;
		$propri_libelle = $objet_ligne_marge_nette->libelle;
		//echo $propri_libelle;
		if($libelle_xml == $propri_libelle)
		{
			
			$xml_final->pages->page[3]->$var2->$var3->ligne[$count]->$var4 = $objet_ligne_marge_nette->$var4;
			$xml_final->pages->page[3]->$var2->$var3->ligne[$count]->$var5 = $objet_ligne_marge_nette->$var5;
			$xml_final->pages->page[3]->$var2->$var3->ligne[$count]->$var6 = $objet_ligne_marge_nette->$var6;
			$xml_final->pages->page[3]->$var2->$var3->ligne[$count]->$var7 = $objet_ligne_marge_nette->$var7;
		
		}
	$count++;
	}
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
}
/*$ligne_marge_nette = new ligne_marge_nette();
$ligne_marge_nette->set_valeur_marge_nette("C-EG",10,10);
modifi_marge_nette($_SESSION[C_SESSION_MARGE_PRODUCTION]->modif_ligne_marge_nette($ligne_marge_nette,"C-EG"));
$ligne_marge_nette1 = new ligne_marge_nette();
$ligne_marge_nette1->set_valeur_marge_nette("MA-C",10,10);
modifi_marge_nette($_SESSION[C_SESSION_MARGE_PRODUCTION]->modif_ligne_marge_nette($ligne_marge_nette1,"MA-C"));
print_r($_SESSION[C_SESSION_MARGE_PRODUCTION]);*/
?>