<?php
include_once("class_inter.php");
include_once("analyse_eco.php");
session_start();
include_once("connection.php");
include_once("const.php");
define('FICHE_XML_FINAL','xml/test1.xml');

print_r($_SESSION[C_SESSION_MAIN_OEUVRE]);
function modif_ligne_main($ligne_main,$num_ligne,$indic)
{
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
	
	$xml_final = file_xml_existe();
	if($indic == "salarie")
	{
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var5 = $_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]->temps_salarie_perm;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var8 = $_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]->temps_salarie_tempo;
	}
	else
	{
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var5 = $ligne_main->$var5;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var8 = $ligne_main->$var8;
	}
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var3 = $ligne_main->$var3;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var4 = $ligne_main->$var4;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var6 = $ligne_main->$var6;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var7 = $ligne_main->$var7;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var9 = $ligne_main->$var9;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var10 = $ligne_main->$var10;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var11 = $ligne_main->$var11;
		$xml_final->pages->page[0]->$var1->$var2->ligne[$num_ligne]->$var12 = $ligne_main->$var12;
	if(isset($_SESSION[C_SESSION_MAIN_OEUVRE]))
	{		
		$_SESSION[C_SESSION_MAIN_OEUVRE]->set_ligne_main($ligne_main,$indic);
		
		$ligne_totaux = $_SESSION[C_SESSION_MAIN_OEUVRE]->set_ligne_totaux();
		$xml_final->pages->page[0]->$var1->$var2->ligne[3]->$var3 = $ligne_totaux->$var3;
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
		echo "des erreur";
	}
}
/*$ligne_main1 = new ligne_main_oeuvre();
$ligne_main1->set_valeur_main(10,2,2,2,2,2,"Non salarie");
modif_ligne_main($ligne_main1,0,"non_salarie");*/
$ligne_main2 = new ligne_main_oeuvre();
$ligne_main2->set_valeur_main(10,2,2,2,2,2,"Salarié");
modif_ligne_main($ligne_main2,2,"salarie");
?>