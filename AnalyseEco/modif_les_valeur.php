<?php
session_start();
include_once("class_inter.php");
include_once("connection.php");
include_once("Debutobjet.php");

define('FICHE_XML_FINAL','xml/test1.xml');
/*
 * pour modifier le tableau de Mode faire valoir surface
 */
//$xml_final = file_xml_existe();
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
$faire_valoir = new faire_valoir();
$faire_valoir->Set_valeur(100,100,100,100,100,4,3);
modif_xml_final_faire_valoir($faire_valoir);
echo "=========================_SESSION[C_SESSION_FAIRE_VALOIR] ======================<BR>";
print_r($_SESSION[C_SESSION_FAIRE_VALOIR]);
echo "<br>=========================_SESSION[C_SESSION_CHARGES_GLOBALES] ======================<BR>";
print_r($_SESSION[C_SESSION_CHARGES_GLOBALES]);

/*function modif_charge_global()
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
				//echo "<br>*********dinominateur est".$dinominateur."******<br>";
				//echo "<br>".$indis."<br>";
				//echo "<br>*********ligne_charge_globale->valeur  est".$ligne_charge_globale->valeur."******<br>";
				$a = round($ligne_charge_globale->valeur/$dinominateur,3);
				//echo "<br>*********ligne_charge_globale->valeur est".$a."******<br>";
				$xml_final->pages->page[3]->$var1->$var2->ligne[$count]->$var3 = $a;
				//echo "<br>+++".$id."+++<br>";
				//$_SESSION[C_SESSION_CHARGES_GLOBALES]->ajout_charge_globale($id,$ligne_charge_globale->valeur);
				$_SESSION[C_SESSION_CHARGES_GLOBALES]->contenu_charges_globales[$id]->valeur = $a;
				}
			}
			$count++;
		}
	}
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML(  ));
	
}
/*modif_charge_global();
echo "<br>***************apres modifier _SESSION[C_SESSION_CHARGES_GLOBALES]************<br>";
echo "<br>";
//print_r($_SESSION[C_SESSION_CHARGES_GLOBALES]);
echo "<br>*************** _SESSION[C_SESSION_MARGE_PRODUCTIO]************<br>";
print_r($_SESSION[C_SESSION_MARGE_PRODUCTION]);
echo "<br>".count($_SESSION[C_SESSION_MARGE_PRODUCTION]->produit)."<br>";
print_r($_SESSION[C_SESSION_MARGE_NETTE]);
echo "<br>++++++++++++++++++++++++++++<br>";*/
///Page la MARGE NETTE
/*function modifi_marge_nette($objet_ligne_marge_nette)
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
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML(  ));
}
/*$ligne_marge_nette = new ligne_marge_nette();
$ligne_marge_nette->set_valeur_marge_nette("MA-C",10,20);
modifi_marge_nette($_SESSION[C_SESSION_MARGE_PRODUCTION]->modif_ligne_marge_nette($ligne_marge_nette,"MA-C"));
print_r($_SESSION[C_SESSION_MARGE_PRODUCTION]);*/
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
$ligne_main1 = new ligne_main_oeuvre();
$ligne_main1->set_valeur_main(10,2,2,2,2,2,"Salarie");
modif_ligne_main($ligne_main1,2,"salarie");

/*$ligne_main2 = new ligne_main_oeuvre();
$ligne_main2->set_valeur_main(2,1,1,1,1,1,"Aides familiaux");
modif_ligne_main($ligne_main2,1,"aides");

$ligne_main3 = new ligne_main_oeuvre();
$ligne_main3->set_valeur_main(9,1,1,1,1,1,"Salarie");
modif_ligne_main($ligne_main3,2,"salarie");*/

 ?>