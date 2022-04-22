<?php
session_start();
include_once("class_inter.php");
include_once("connection.php");

define('FICHE_XML_FINAL','Copie de test1.xml');
$var1 = "descriptif-exploitation";
$var2 = "main-oeuvre";
$var3 = "libelle";
$var4 = "perm_nombre";
$var5 = "perm_temps";
$var6 = "perm_uth";
$var7 = "temp_nombre";
$var8 = "temp_temps";
$var9 = "temp_uth";
$var10 = "total_nombre";
$var11 = "total_temps";
$var12 = "total_uth";

function lire_xml_final_main()
{
	global $var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12;
	$xml_final = file_xml_existe();
	$main_oeuvre = new main_oeuvre();
	$count = 0;
	
	foreach($xml_final->pages->page[0]->$var1->$var2->ligne as $ligne)
	{
		$ligne_main_oeuvre = new ligne_main_oeuvre();
		$ligne_main_oeuvre->libelle = (string)$ligne->$var3;
		$ligne_main_oeuvre->perm_nombre = (int)$ligne->$var4;
		$ligne_main_oeuvre->perm_temps = (int)$ligne->$var5;
		$ligne_main_oeuvre->perm_uth = (int)$ligne->$var6;
		$ligne_main_oeuvre->temp_nombre = (int)$ligne->$var7;
		$ligne_main_oeuvre->temp_temps = (int)$ligne->$var8;
		$ligne_main_oeuvre->temp_uth = (int)$ligne->$var9;
		$ligne_main_oeuvre->total_nombre = (int)$ligne->$var10;
		$ligne_main_oeuvre->total_temps = (int)$ligne->$var11;
		$ligne_main_oeuvre->total_uth = (int)$ligne->$var12;
		
		$main_oeuvre->set_ligne_main($ligne_main_oeuvre,$count);
		$count++;
	}
	$_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL] = $main_oeuvre;
	return $_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL];
}

//print_r(lire_xml_final_main());
function modif_ligne_main($ligne_main,$num_ligne)
{
	lire_xml_final_main();
	global $var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9,$var10,$var11,$var12;
	$xml_final = file_xml_existe();
	
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var3 = $ligne_main->$var3;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var4 = $ligne_main->$var4;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var5 = $ligne_main->$var5;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var6 = $ligne_main->$var6;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var7 = $ligne_main->$var7;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var8 = $ligne_main->$var8;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var9 = $ligne_main->$var9;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var10 = $ligne_main->$var10;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var11 = $ligne_main->$var11;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var12 = $ligne_main->$var12;
	
	if(isset($_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]))
	{
		$_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]-> set_ligne_main($ligne_main,$num_ligne);
		$ligne_totaux = $_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]->set_ligne_totaux();
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var4 = $ligne_totaux->$var4;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var5 = $ligne_totaux->$var5;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var6 = $ligne_totaux->$var6;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var7 = $ligne_totaux->$var7;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var8 = $ligne_totaux->$var8;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var9 = $ligne_totaux->$var9;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var10 = $ligne_totaux->$var10;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var11 = $ligne_totaux->$var11;
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var12 = $ligne_totaux->$var12;
		file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
	}
	else
	{
		lire_xml_final_main();
	}
}
$ligne_main = new ligne_main_oeuvre();
$ligne_main->set_valeur_main(1,1,1,1,1,1,"Aides familiaux");
modif_ligne_main($ligne_main,1);
print_r($_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]);
 ?>