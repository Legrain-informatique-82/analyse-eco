<?php
include_once("class_inter.php");
include_once("analyse_eco.php");
session_start();
include_once("connection.php");
include_once("const.php");
define('FICHE_XML_FINAL','xml/test1.xml');
//print_r($_SESSION[C_SESSION_FAIRE_VALOIR]);
function modif_xml_final_faire_valoir($objet_faire_valoir)
{
	$var1 = "descriptif-exploitation";
	$var2 = "faire-valoir";
	$var3 = "mise-a-disp-prop";
	$var4 = "mise-a-disp-ferm";
	$var5 = "total-sau";
	$var6 = "non-sau";
	$var7 = "dont-bois";
	$var8 = "total-surface";
	$xml_final = file_xml_existe();
	$xml_final->pages->page[0]->$var1->$var2->propriete = $objet_faire_valoir->propriete;
	$xml_final->pages->page[0]->$var1->$var2->fermage = $objet_faire_valoir->fermage;
	$xml_final->pages->page[0]->$var1->$var2->$var3 = $objet_faire_valoir->mise_a_disp_prop;
	$xml_final->pages->page[0]->$var1->$var2->$var4 = $objet_faire_valoir->mise_a_disp_ferm;
	$xml_final->pages->page[0]->$var1->$var2->metayage = $objet_faire_valoir->metayage;
	$xml_final->pages->page[0]->$var1->$var2->$var5 = $objet_faire_valoir->total_sau;
	$xml_final->pages->page[0]->$var1->$var2->$var6 = $objet_faire_valoir->non_sau;
	$xml_final->pages->page[0]->$var1->$var2->$var7 = $objet_faire_valoir->dont_bois;
	$xml_final->pages->page[0]->$var1->$var2->$var8 = $objet_faire_valoir->total_surface;
	
	file_put_contents(FICHE_XML_FINAL,$xml_final->asXML());
	$_SESSION[C_SESSION_FAIRE_VALOIR] = $objet_faire_valoir;
	
}
print_r($_SESSION[C_SESSION_CHARGES_GLOBALES]);
/*$faire_valoir = new faire_valoir();
$faire_valoir->Set_valeur(100,100,100,100,100,4,3);
modif_xml_final_faire_valoir($faire_valoir);*/
function modif_charge_global()
{
	$var1 = "analyse-technico";
	$var2 = "charges_globales";
	$var3 = "n-hectare";
	$xml_final = file_xml_existe();
	$count = 0 ;
	foreach($_SESSION[C_SESSION_CHARGES_GLOBALES]->contenu_charges_globales as $ligne_charge_globale)
	{
		$pattern1 = "/^D[0-9]{2}$/";
		$id = $ligne_charge_globale->identifiant;
		if(preg_match($pattern1,$ligne_charge_globale->identifiant))
		{
			$chiffre = substr($ligne_charge_globale->identifiant,1);
			$dinominateur = $_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau;
	
			foreach($_SESSION[C_SESSION_CHARGES_GLOBALES]->contenu_charges_globales as $indis => $ligne_charge_globale)
			{
				$pattern2 = "/^C".$chiffre."$/";
		
				//$count = $chiffre - 55;
				if(preg_match($pattern2,$indis))
				{
				$a = round($ligne_charge_globale->valeur/$dinominateur,3);
				$xml_final->pages->page[3]->$var1->$var2->ligne[$count]->$var3 = $a;
				$_SESSION[C_SESSION_CHARGES_GLOBALES]->contenu_charges_globales[$id]->valeur = $a;
				}
			}
			$count++;
		}
	}
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML(  ));
	
}
//modif_charge_global();
?>