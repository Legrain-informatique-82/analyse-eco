<?php session_start();
/*
 * Lecture du fichier XML initial (xml->objet)
 * Fonctions de calculs pour les différentes pages du document, les résultats des calculs sont stockés dans des objets en session
 */
//session_start();
//require_once();
include_once("analyse_eco.php");
include_once("class_inter.php");
include_once("connection.php");
include_once("const.php");



function sens_soldes($sens,$valeur) {
	//$sens => souvent $row[3]
	if($sens==1) {
		if($valeur<0)$valeur=abs($valeur);
	} else if($sens==-1) {
		$valeur=-$valeur;
	}
	return $valeur;
}

/**
 *	Lecture du fichier XML initial
 */
function lire_xml()
{

	//include_once("connection.php");
	if(file_exists(C_FICHIER_XML_INITIAL)){
		echo "fichier ok<br>";
	//$donnees_analyse_eco = simplexml_load_file(C_FICHIER_XML_INITIAL);
	$donnees_analyse_eco = simplexml_load_file("tmp/analyseEco.xml");
	$analyse_eco = new donnees_analyse_eco();//objet de analyse_eco.php
	} else {
		echo "fichier introuvable<br>";
	}
	
	//echo "<hr>";
	//print_r($donnees_analyse_eco);
	//echo "<hr>";

	#######################--pour la balise de <liste_infos_compta>--#######################
	foreach($donnees_analyse_eco->liste_infos_compta->infos_compta as $infos_compta)
	{
		$numeroCompte = (int)$infos_compta->compte['numero'];
		$libelle = (string)$infos_compta->compte['libelle'];
		$mtDebitReport = (float)$infos_compta->compte['mtDebitReport'];
		$mtCreditReport = (float)$infos_compta->compte['mtCreditReport'];
		$mtDebitMouvement = (float)$infos_compta->compte['mtDebitMouvement'];
		$mtCreditMouvement = (float)$infos_compta->compte['mtCreditMouvement'];
		$mtDebit = (float)$infos_compta->compte['mtDebit'];
		$mtCredit = (float)$infos_compta->compte['mtCredit'];

		$Ncompte = new infos_comptas($numeroCompte,$libelle,$mtDebitReport,$mtCreditReport,$mtDebitMouvement,$mtCreditMouvement,$mtDebit,$mtCredit);
		//$_SESSION['Ncompte']
		$analyse_eco->ajout_info_compta($numeroCompte,$Ncompte);
		/*echo "*****".$numeroCompte."*****<br>";
		 print_r($analyse_eco->liste_infos_compta);
		 echo "<br>";*/
	}

	#######################--pour la balise de <liste_infos_liasse>--#######################
	foreach($donnees_analyse_eco->liste_infos_liasse->infos_liasse as $infos_liasse)
	{
		//$Objet_infos_liasse = new infos_liasse();
		$sous_cle=(string)$infos_liasse->cle->sous_cle;
		$cle = (string)$infos_liasse->cle->cle;
		$ObjetCle = new cle($sous_cle,$cle);
	//	echo $infos_liasse->cle->cle." @ ".$infos_liasse->cle->sous_cle." ==> ".$infos_liasse->repartition->montant."  ****  ".$infos_liasse->repartition->valeur."<br>";
			
		$montant = (float)$infos_liasse->repartition->montant;
		$valeur = (float)$infos_liasse->repartition->valeur;
	//print_r($infos_liasse);
	//echo $cle." @ ".$sous_cle." ==> ".$montant."  ****  ".$valeur."<br>";
	$montant = round($montant,2);
	$valeur = round($valeur,2);
		$ObjetRepartition = new repartition();
		$ObjetRepartition->ajoute_repartition($montant,$valeur);
		foreach($infos_liasse->repartition->detail->compte as $compte)
		{
			$numeroCompte = (int)$compte['numero'];
			$mtDebit = (float)$compte['mtDebit'];
			$mtCredit = (float)$compte['mtCredit'];

			$ObjetDetail = new ObjetDetail($numeroCompte,$mtDebit,$mtCredit);//pour objet de <detail>
			$ObjetRepartition->ajout_detail($numeroCompte,$ObjetDetail);
		}
			
		$Objet_infos_liasse = new infos_liasse();
		$Objet_infos_liasse->modif_infos_liasse($ObjetCle,$ObjetRepartition);
		$analyse_eco->ajout_info_liasse($cle,$Objet_infos_liasse);
			
	}

	#########################--pour la balise de <liste_acquisition>--#######################
	foreach($donnees_analyse_eco->liste_acquisition->acquisition as $acquisition)
	{
		$numeroCompte = (string)$acquisition->compte['numero'];
		$libelle = (string)$acquisition->compte['libelle'];
		$mtDebit = (float)$acquisition->compte['mtDebit'];
		$mtCredit = (float)$acquisition->compte['mtCredit'];

		$new_acquisition = new acquisition($numeroCompte,$libelle,$mtDebit,$mtCredit);
		$analyse_eco->ajout_acquisition($numeroCompte,$new_acquisition);
	}
	
	#########################--pour la balise de <liste_infos_analytique>--#######################
	foreach($donnees_analyse_eco->liste_infos_analytique->infos_analytique as $infos_analytique)
	{
		$origine = (string)$infos_analytique->origine;
		$atelier = (string)$infos_analytique->atelier;
		$libelle_atelier = (string)$infos_analytique->libelle_atelier;
		$compte = (string)$infos_analytique->compte;
		$designation = (string)$infos_analytique->designation;
		$total_charges = (float)$infos_analytique->total_charges;
		$total_produits = (float)$infos_analytique->total_produits;
		$qt1 = (float)$infos_analytique->qt1;
		$pu1 = (float)$infos_analytique->pu1;
		$qt2 = (float)$infos_analytique->qt2;
		$pu2 = (float)$infos_analytique->pu2;
		$code_activite = (string)$infos_analytique->code_activite;
		$libelle_activite = (string)$infos_analytique->libelle_activite;
		$nb_unite_atelier = (float)$infos_analytique->nb_unite_atelier;

		$new_infos_analytique = new infos_analytique($origine,$atelier,$libelle_atelier,$compte,$designation,$total_charges,$total_produits,$qt1
		,$pu1,$qt2,$pu2,$code_activite,$libelle_activite,$nb_unite_atelier);
		$cle = $atelier."_".$compte;
		$analyse_eco->ajout_infos_analytique($cle,$new_infos_analytique);
	}
		
	#########################--pour la balise de <liste_qte>--#######################
	foreach($donnees_analyse_eco->liste_qte->infos_grd_livre_qte as $infos_grd_livre_qte)
	{
		$compte = (string)$infos_grd_livre_qte->compte;
		$qte = (string)$infos_grd_livre_qte->qte;

		$new_infos_grd_livre_qte = new infos_grd_livre_qte($compte,$qte);
		$analyse_eco->ajout_infos_grd_livre_qte($compte,$new_infos_grd_livre_qte);
	}
	
	#########################--pour la balise de <liste_infos_dossier>--#######################
	foreach($donnees_analyse_eco->liste_infos_dossier->info as $info_dossier)
	{
		$cle = (string)$info_dossier->cle;
		$valeur1 = (string)$info_dossier->valeur1;

		$new_infos_dossier_xml = new infos_dossier_xml($cle,$valeur1);
		$analyse_eco->ajout_infos_dossier($cle,$new_infos_dossier_xml);
	}
	
	#######pour les objets de infos_compta stoker dans le tableau de object donnees_analyse_eco
	$_SESSION[C_SESSION_XML_INITIAL] = $analyse_eco;
	
	//print_r($analyse_eco);

}

/**
 * Calculs pour "Tableau des flux"
 */
function tableau_flux()
{
	$Flux = new ecorche_flux();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYNBOLE from FORMULES_FLUX";
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);

	while($row)
	{
		$sum = 0;
		$pattern1 = "/[+-]/";
		if(preg_match($pattern1,$row[2]))
		{
			$changFormule = trim($row[2]);
			$changFormule = str_replace("+","$+",$changFormule );//
			$changFormule = str_replace("-","$-",$changFormule);
			//$changFormule = str_replace(">","$>",$changFormule);
			//$changFormule = str_replace("<","$<",$changFormule);

			$partisFormule = explode("$",$changFormule);
			//$sum = 0;
			foreach($partisFormule as $Oneparti)
			{
				/*$rest = substr($Oneparti,0,1);
			 	if($rest=="")
			 	{
			 	$Oneparti = "+".$Oneparti;
			 	}*/
				$pattern3 = "/BNS_([0-9]*)/";
				if(preg_match($pattern3,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum = (float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									//$sum = (float)$sum-(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum = (float)$sum-(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
									//$sum = (float)$sum+(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
									$sum = (float)$sum-(float)$objet_infos_compta->soldeN();
								}
							}
							break;
						default :
							$compte = substr($Oneparti,4,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
								}
							}
							break;
					}
				}
				$pattern4 = "/RN_/";
				if(preg_match($pattern4,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum+(float)$b->objetRepatition->montant;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum-(float)$b->objetRepatition->montant;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum+(float)$b->objetRepatition->montant;
								}
							}
							break;
					}
				}
				$pattern5 = "/BNSD_([0-9]*)/";
				if(preg_match($pattern5,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebit;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtDebit;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebit;
								}
							}
							break;
					}
				}
				$pattern6 = "/BNNSDR_([0-9]*)/";
				if(preg_match($pattern6,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport;
								}
							}
							break;
					}
				}
				$pattern7 = "/BNNS_([0-9]*)/";
				if(preg_match($pattern7,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
									$sum = (float)$sum-(float)$objet_infos_compta->soldeReport();
								}
							}
							break;
						default:
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
								}
							}
							break;
					}
				}
				$pattern8 = "/VAR([0-9]*)/";
				if(preg_match($pattern8,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
					}
				}
				$pattern11 = "/FL(0-9)*/";
				if(preg_match($pattern11,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
					}
				}
				$pattern12 = "/BNSC_([0-9]*)/";
				if(preg_match($pattern12,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCredit;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtCredit;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCredit;
								}
							}
							break;
					}
				}
				$pattern13 = "/BNNSCR_([0-9]*)/";
				if(preg_match($pattern13,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditReport;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtCreditReport;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditReport;
								}
							}
							break;
					}
				}
				$pattern14 = "/B[^NS_]([0-9]*)[^_]/";
				if(preg_match($pattern14,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
					}
				}
				$pattern15 = "/BNSMC_([0-9]*)/";
				if(preg_match($pattern15,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditMouvement;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtCreditMouvement;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditMouvement;
								}
							}
							break;
					}
				}
				$pattern17 = "/BNSMD_([0-9]*)/";
				if(preg_match($pattern17,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
					}
				}
				$pattern18 = "/INTER([0-9]*)/";
				if(preg_match($pattern18,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}
							}
							break;

					}

				}
			}
		}
		else
		{
			$pattern3 = "/^BNS_/";
			if(preg_match($pattern3,$row[2]))
			{
				$compte = substr($row[2],4,-1);
				$pattern = "/^".$compte."([0-9]*)/";
				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
				{
					if(preg_match($pattern,$objet_infos_compta->numero))
					{
						//$sum = (float)$sum+(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
						//$sum = (float)$sum-(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
						$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
					}
				}
			}
			$pattern9 = "/</";
			if(preg_match($pattern9,$row[2]))
			{
				$compte = substr($row[2],0,-2);
				$inter_sum = $_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux[$compte]->valeur;
				if($inter_sum<0)
				{
					$sum = $inter_sum;
				}
				else
				{
					$sum = 0;
				}
			}
			$pattern10 = "/>/";
			if(preg_match($pattern10,$row[2]))
			{
				$compte = substr($row[2],0,-2);
				$inter_sum = $_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux[$compte]->valeur;
				if($inter_sum>0)
				{
					$sum = $inter_sum;
				}
				else
				{
					$sum = 0;
				}
			}
			$pattern16 = "/^(ACQUISITION)$/";
			if(preg_match($pattern16,$row[2]))
			{
				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_acquisition as $a => $b)
				{
					$sum = (float)$sum + (float)$b->mtDebit;
				}
			}
			$pattern17 = "/^FL(0-9)*/";
			if(preg_match($pattern17,$row[2]))
			{
				$oneTerme = substr($row[2],0);
				foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
				{
					//echo "coucoc";
					$pattern =  "/^".$oneTerme."$/";
					if(preg_match($pattern,$symbole_identifiant->identifiant))
					{
						$sum = (float)$sum + (float)$symbole_identifiant->valeur;
					}
				}
			}
		}
		$objetLigne = new ligne_ecorche_flux();
		$libelle = $row[1];
		$valeurSum = round($sum,2);
		$identifiant = $row[3];
		$objetLigne->ajout_contenu($libelle,$valeurSum,$identifiant);
		$Flux->ajout_contenu_flux($identifiant,$objetLigne);
		$_SESSION[C_SESSION_TABLEAU_FLUX] = $Flux;
		echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
		$row =  mysql_fetch_row($result);
	}

}

/**
 * Calculs pour "Soldes intermédiares de gestion"
 */
function soldes_inter()
{
	$Solid_inter = new solids_inter();//objet de class_inter.php

	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);

	for($i= 1;$i<=3;$i++)
	{
		$query = "select ID,NOM_FORMULE,FORMULE,ABSOLUE,SYNBOLE from FORMULES_INTER".$i;
		$result = mysql_query($query,$db_conn);
		$row =  mysql_fetch_row($result);
		while($row)
		{
			$sum = 0;
			$pattern1 = "/[+|-]/";
			if(!preg_match($pattern1,$row[2]))####pour BNS_707* ....seulement une terme
			{
				//$pattern2 = "/^BNS_/";
				
				$pattern2 = "/BNS_([0-9]*)/";
				if(preg_match($pattern2,$row[2]))
				{
					$compte = substr($row[2],4,-1);
					$pattern = "/^".$compte."([0-9]*)/";
					$sum = 0;
					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
					{
						if(preg_match($pattern,$objet_infos_compta->numero))
						{
							//echo $objet_infos_compta->mtCredit;
							//$sum = (float)$sum+(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
							//$sum = (float)$sum-(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
							$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
							//echo (float)($objet_infos_compta->mtDebit)." --- ".(float)($objet_infos_compta->mtCredit)." ---- ".(float)$sum."<br>";
						}
					}
				}
				//$pattern3 = "/^BNNS_/";
				$pattern3 = "/BNNS_([0-9]*)/";
				if(preg_match($pattern3,$row[2]))
				{
					$compte = substr($row[2],5,-1);
					$pattern = "/^".$compte."([0-9]*)/";
					$sum = 0;
					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
					{
						if(preg_match($pattern,$objet_infos_compta->numero))
						{
							//echo $objet_infos_compta->mtCredit;
							//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
							$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
							//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
						}
					}
				}

			}
			else        ####pour pour B3+B3-B5
			{
				$changFormule = trim($row[2]);
				$changFormule = str_replace("+","$+",$changFormule );//EX=BNS_700*$+BNS_205*$+BNS_88* ou B3+B4-B5
				$changFormule = str_replace("-","$-",$changFormule);//EX=BNS_700*$+BNS_205*$+BNS_88* ou B3$+B4$-B5

				$partisFormule = explode("$",$changFormule);########couper la formule B3+B3-B5
				$sum = 0;
				//$count = 0;
				foreach($partisFormule as $Oneparti)
				{

					//$count++;
					$pattern3 = "/B[^NS]([0-9]*)/";
					if(preg_match($pattern3,$Oneparti))
					{
						//echo $count."*******<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}

								}
								break;
							case "-":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum - (float)$symbole_identifiant->valeur;
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}
					$pattern5 = "/C[^NS]([0-9]*)/";
					if(preg_match($pattern5,$Oneparti))
					{
						//echo $count."*******<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}

								}
								break;
							case "-":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum - (float)$symbole_identifiant->valeur;
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}
					$pattern4 = "/BNS_([0-9]*)/";
					if(preg_match($pattern4,$Oneparti))
					{
						//echo $count."////////<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$compte = substr($Oneparti,5,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
									}
								}
								break;
							case "-":
								$compte = substr($Oneparti,5,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
										$sum = (float)$sum-(float)$objet_infos_compta->soldeN();
									}
								}
								break;
							default :
								$compte = substr($Oneparti,4,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
									}
								}
								break;
									
						}
					}
					$pattern6 = "/BNNS_([0-9]*)/";
					if(preg_match($pattern6,$Oneparti))
					{
						//echo $count."////////<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$compte = substr($Oneparti,6,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
										//echo $pattern." ---".$changFormule."--- ".$objet_infos_compta->numero." ****".$objet_infos_compta->mtDebitReport."*****".$objet_infos_compta->mtCreditReport."********".$sum."******************** <br>";
									}
								}
								break;
							case "-":
								$compte = substr($Oneparti,6,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
										$sum = (float)$sum-(float)$objet_infos_compta->soldeReport();
									}
								}
								break;
							default :
								$compte = substr($Oneparti,5,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
										//echo $pattern." ---".$changFormule."--- ".$objet_infos_compta->numero." ****".$objet_infos_compta->mtDebitReport."*****".$objet_infos_compta->mtCreditReport."********".$sum."******************** <br>";
									}
								}
								break;
									
						}
					}
				}
			}
			$objetLigne = new ligne_solids_inter();
			//$_SESSION['solid_inter_ligne'] = $objetLigne;
			$libelle = $row[1];
			$valeurSum = round($sum,2);
			
	//		$valeurSum=sens_soldes($row[3],$valeurSum);
			
			//if($row[3]==1) {
			//	if($valeurSum<0)$valeurSum=abs($valeurSum); //pas de valeur negative dans le solde intermediare de gestion sauf pour le resultat
			//} else if($row[3]==-1) {
			//	$valeurSum=-$valeurSum;
			//}
			
			$identifiant = $row[4];
			$objetLigne->ajout_contenu($libelle,$valeurSum,$identifiant);
			//$_SESSION['solid_inter_ligne']->ajout_contenu($libelle,$sum,$identifiant);
			switch($i)
			{
				case "1":
					$Solid_inter->ajout_contenu_inter1($identifiant,$objetLigne);
					$_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES] = $Solid_inter;
					//$annee_N[] =  $_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1->valeur;

					break;
				case "2":
					$Solid_inter->ajout_contenu_inter2($identifiant,$objetLigne);
					$_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES] = $Solid_inter;
					//$annee_N_1[] =  $_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2->valeur;
					break;
				case "3":
					$Solid_inter->ajout_contenu_inter3($identifiant,$objetLigne);
					$_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES] = $Solid_inter;
					//$annee_N_2[] =  $_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter3->valeur;
					break;
			}
			echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";

			$row =  mysql_fetch_row($result);
		}
	}
}

/**
 * Calculs pour "Ratios financiers"
 */
function ratios_finance()
{
	$Ratios_finance = new ratios_financ();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	for($i= 1;$i<=2;$i++)
	{
		$sum = 0;
		//$i = 1;
		$query = "select ID,NOM_FORMULE,FORMULE,SYNBOLE from RATIOS".$i; //." where ID>=22";
		$result = mysql_query($query,$db_conn);
		$row =  mysql_fetch_row($result);
		while($row)
		{
			$sum = 0;
			$pattern = "/[+-\/*]/";
			if(preg_match($pattern,$row[2]))
			{
				$changFormule = trim($row[2]);
				$changFormule = str_replace("+","$+",$changFormule );//########################
				$changFormule = str_replace("-","$-",$changFormule);//pour changer la formule #
				$changFormule = str_replace("/","$/",$changFormule);//						  #
				$changFormule = str_replace("*","$*",$changFormule);//#########################

				$partisFormule = explode("$",$changFormule);
				foreach($partisFormule as $Oneparti)
				{
					$pattern1 = "/RN_/";
					if(preg_match($pattern1,$Oneparti))
					{
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
								{
									if(preg_match($pattern,$a))
									{
										$sum = (float)$sum+(float)$b->objetRepatition->montant;
									}
								}
								break;
							case "-":
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
								{
									if(preg_match($pattern,$a))
									{
										$sum = (float)$sum-(float)$b->objetRepatition->montant;
									}
								}
								break;
							case "/":
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
								{
									if(preg_match($pattern,$a))
									{
										$montant =(float)$b->objetRepatition->montant;
										if($montant==0)
										{
											$sum = 0;
										}
										else
										{
											$sum = (float)$sum/$montant;
										}
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
								{
									if(preg_match($pattern,$a))
									{
										$sum = (float)$sum+(float)$b->objetRepatition->montant;
									}
								}
								break;
						}
					}
					$pattern2 = "/BNS_([0-9]*)/";
					if(preg_match($pattern2,$Oneparti))
					{
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$compte = substr($Oneparti,5,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
									}
								}
								break;
							case "-":
								$compte = substr($Oneparti,5,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
										$sum = (float)$sum-(float)$objet_infos_compta->soldeN();
									}
								}
								break;
							default :
								$compte = substr($Oneparti,4,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
									}
								}
								break;
						}
					}
					$pattern3 = "/BNNS_([0-9]*)/";
					if(preg_match($pattern3,$Oneparti))
					{
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$compte = substr($Oneparti,6,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
									}
								}
								break;
							case "-":
								$compte = substr($Oneparti,6,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
										$sum = (float)$sum-(float)$objet_infos_compta->soldeReport();
									}
								}
								break;
							default:
								$compte = substr($Oneparti,5,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
										$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
									}
								}
								break;
						}
					}
					$pattern4 = "/INTER([0-9]*)/";
					if(preg_match($pattern4,$Oneparti))
					{
						switch($i)
						{
							case "1":
								$rest = substr($Oneparti,0,1);
								switch($rest)
								{
									case "+":
										$oneTerme = substr($Oneparti,1);
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											$pattern =  "/^".$oneTerme."$/";
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum + (float)$symbole_identifiant->valeur;
											}

										}
										break;
									case "-":
										$oneTerme = substr($Oneparti,1);
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											$pattern =  "/^".$oneTerme."$/";
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum - (float)$symbole_identifiant->valeur;
											}

										}
										break;
									case "/":
										$oneTerme = substr($Oneparti,1);
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											$pattern =  "/^".$oneTerme."$/";
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$valeur = (float)$symbole_identifiant->valeur;
												if($valeur==0)
												{
													$sum = 0;
												}
												else
												{
													$sum = (float)$sum/$valeur;
												}
											}
										}
										break;
									default:
										$oneTerme = substr($Oneparti,0);
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											$pattern =  "/^".$oneTerme."$/";
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum + (float)$symbole_identifiant->valeur;
											}

										}
										break;
								}
								break;
									case "2":
										$rest = substr($Oneparti,0,1);
										switch($rest)
										{
											case "+":
												$oneTerme = substr($Oneparti,1);
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													$pattern =  "/^".$oneTerme."$/";
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum + (float)$symbole_identifiant->valeur;
													}

												}
												break;
											case "+":
												$oneTerme = substr($Oneparti,1);
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													$pattern =  "/^".$oneTerme."$/";
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum - (float)$symbole_identifiant->valeur;
													}

												}
												break;
											case "/":
												$oneTerme = substr($Oneparti,1);
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													$pattern =  "/^".$oneTerme."$/";
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$valeur = (float)$symbole_identifiant->valeur;
														if($valeur==0)
														{
															$sum = 0;
														}
														else
														{
															$sum = (float)$sum/$valeur;
														}
													}
												}
												break;
											default:
												$oneTerme = substr($Oneparti,0);
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													$pattern =  "/^".$oneTerme."$/";
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum + (float)$symbole_identifiant->valeur;
													}

												}
												break;
										}
										break;
						}
					}
					$pattern5 = "/[^A-Za-z]([0-9]*)$/";
					if(preg_match($pattern5,$Oneparti))
					{
						//echo "coucou";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "*":
								$oneTerme = substr($Oneparti,1);
								$sum = (float)$sum *(int)$oneTerme;
								break;
						}
					}
					$pattern6 = "/BC([0-9]*)$/";
					if(preg_match($pattern6,$Oneparti))
					{
						//echo "coucou";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "/":
								//echo "coucou";
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_BILAN_COMPARATIF]->contenu_bilan as $symbole => $symbole_identifiant)
								{
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum/(float)$symbole_identifiant->valeur;
									}
								}
								break;
							default:
								//echo "wouwou";
								$oneTerme = substr($Oneparti,0);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_BILAN_COMPARATIF]->contenu_bilan as $symbole => $symbole_identifiant)
								{
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum+(float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}
					$pattern7 = "/VAR([0-9]*)([A-Z]+)/";
					if(preg_match($pattern7,$Oneparti))
					{
						switch($i)
						{
							case"1":
								$rest = substr($Oneparti,0,1);
								switch($rest)
								{
									case "+":
										$oneTerme = substr($Oneparti,1);
										$pattern = 	 "/^".$oneTerme."$/";
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum + (float)$symbole_identifiant->valeur;
											}
										}
										break;
									default:
										$oneTerme = substr($Oneparti,0);
										$pattern = 	 "/^".$oneTerme."$/";
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum + (float)$symbole_identifiant->valeur;
											}
										}
										break;
								}
								break;
									case "2":
										$rest = substr($Oneparti,0,1);
										switch($rest)
										{
											case "+":
												$oneTerme = substr($Oneparti,1);
												$pattern = 	 "/^".$oneTerme."$/";
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum + (float)$symbole_identifiant->valeur;
													}
												}
												break;
											default:
												$oneTerme = substr($Oneparti,0);
												$pattern = 	 "/^".$oneTerme."$/";
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum + (float)$symbole_identifiant->valeur;
													}
												}
												break;
										}
										break;
						}
					}
					$pattern8 = "/BNSMC_/";
					if(preg_match($pattern8,$Oneparti))
					{
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$compte = substr($Oneparti,7,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										$sum=(float)$sum+(float)$objet_infos_compta->mtCreditMouvement;
									}
								}
								break;
							case "-":
								$compte = substr($Oneparti,7,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										$sum=(float)$sum-(float)$objet_infos_compta->mtCreditMouvement;
									}
								}
								break;
							default:
								$compte = substr($Oneparti,6,-1);
								$pattern = "/^".$compte."([0-9]*)/";
								foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
								{
									if(preg_match($pattern,$objet_infos_compta->numero))
									{
										$sum=(float)$sum+(float)$objet_infos_compta->mtCreditMouvement;
									}
								}
								break;
						}
					}
					$pattern9 = "/VAR([0-9]*)$/";
					if(preg_match($pattern9,$Oneparti))
					{
						switch($i)
						{
							case "1":
								switch($rest)
								{
									case "+":
										$oneTerme = substr($Oneparti,1);
										$pattern = 	 "/^".$oneTerme."$/";
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum + (float)$symbole_identifiant->valeur;
											}
										}
										break;
									case "/":
										$oneTerme = substr($Oneparti,1);
										$pattern = 	 "/^".$oneTerme."$/";
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$valeur = (float)$symbole_identifiant->valeur;
												if($valeur==0)
												{
													$sum = 0;
												}
												else
												{
													$sum = (float)$sum/$valeur;
												}
											}
										}
										break;
									default:
										$oneTerme = substr($Oneparti,0);
										$pattern = 	 "/^".$oneTerme."$/";
										foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
										{
											if(preg_match($pattern,$symbole_identifiant->identifiant))
											{
												$sum = (float)$sum + (float)$symbole_identifiant->valeur;
											}
										}
										break;
								}
								break;
									case "2":
										switch($rest)
										{
											case "+":
												$oneTerme = substr($Oneparti,1);
												$pattern = 	 "/^".$oneTerme."$/";
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum + (float)$symbole_identifiant->valeur;
													}
												}
												break;
											case "/":
												$oneTerme = substr($Oneparti,1);
												$pattern = 	 "/^".$oneTerme."$/";
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$valeur = (float)$symbole_identifiant->valeur;
														if($valeur==0)
														{
															$sum = 0;
														}
														else
														{
															$sum = (float)$sum/$valeur;
														}
													}
												}
												break;
											default:
												$oneTerme = substr($Oneparti,0);
												$pattern = 	 "/^".$oneTerme."$/";
												foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
												{
													if(preg_match($pattern,$symbole_identifiant->identifiant))
													{
														$sum = (float)$sum + (float)$symbole_identifiant->valeur;
													}
												}
												break;
										}
										break;
						}
					}
					$pattern10 = "/BNSMD_/";
					if(preg_match($pattern10,$Oneparti))
					{
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+";
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
						}
					}
					$pattern11 = "/FL/";
					if(preg_match($pattern11,$Oneparti))
					{
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
			 				{
			 					$pattern =  "/^".$oneTerme."$/";
			 					if(preg_match($pattern,$symbole_identifiant->identifiant))
			 					{
			 						$sum = (float)$sum + (float)$symbole_identifiant->valeur;
			 					}
			 				}
			 				break;
							case "/":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$valeur = (float)$symbole_identifiant->valeur;
										if($valeur==0)
										{
											$sum = 0;
										}
										else
										{
											$sum = (float)$sum/$valeur;
										}
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}
				}
			}
			else
			{
				$pattern1 = "/^BNNS_/";
				if(preg_match($pattern1,$row[2]))
				{
					$compte = substr($row[2],5,-1);
					$pattern = "/^".$compte."([0-9]*)/";
					$sum = 0;
					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
					{
						if(preg_match($pattern,$objet_infos_compta->numero))
						{
							//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
							$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
						}
					}
				}
				$pattern2 = "/^RF/";
				if(preg_match($pattern2,$row[2]))
				{
					//ECHO "RF10";
					$oneTerme = substr($row[2],0);
					foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
					{
						$pattern =  "/^".$oneTerme."$/";
						if(preg_match($pattern,$symbole_identifiant->identifiant))
						{
							$sum = (float)$sum + (float)$symbole_identifiant->valeur;
						}
					}
				}
			}
			$objetLigne = new ligne_ratios_financ();
			$libelle = $row[1];
			$valeurSum = round($sum,2);
			$identifiant = $row[3];
			$objetLigne->ajout_contenu($libelle,$valeurSum,$identifiant);
			switch($i)
			{
				case "1":
					$Ratios_finance->ajout_contenu_ratios1($identifiant,$objetLigne);
					$_SESSION[C_SESSION_RATIOS] = $Ratios_finance;
					break;
				case "2":
					$Ratios_finance->ajout_contenu_ratios2($identifiant,$objetLigne);
					$_SESSION[C_SESSION_RATIOS] = $Ratios_finance;
					break;
			}
			//$Ratios_finance->ajout_contenu_ratios($identifiant,$objetLigne);
			//$_SESSION[C_SESSION_RATIOS] = $Ratios_finance;
			echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
			$row =  mysql_fetch_row($result);
		}
		//echo "<br>=====================<br>";
	}
}

/**
 * Calculs pour "Bilan comparatif"
 */
function bilans_comp()
{
	$bilans_comp = new bilans_compartifs();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYNBOLE from FORMULES_BILANS  ";//where ID<=18
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);
	while($row)
	{
		$sum = 0;
		$pattern1 = "/[+|-]/";
		if(!preg_match($pattern1,$row[2]))####pour RN_ZCL_21 OU BC7.. ....seulement une terme
		{
			$pattern2 = "/^RN_/";
			if(preg_match($pattern2,$row[2]))
			{
				$pattern = "/^".$row[2]."$/";
				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
				{
					if(preg_match($pattern,$a))
					{
						//$sum = $analyse_eco->liste_infos_liasse[$b->objetCle->cle]->objetRepatition->montant;
						$sum = (float)$b->objetRepatition->montant;
					}
				}
			}
			else
			{
				$pattern = "/^".$row[2]."$/";
				foreach($_SESSION[C_SESSION_BILAN_COMPARATIF]->contenu_bilan as $symbole => $symbole_identifiant)
				{
					if(preg_match($pattern,$symbole_identifiant->identifiant))
					{
						$sum = (float)$symbole_identifiant->valeur;
					}
				}
			}
		}
		else
		{
			$changFormule = trim($row[2]);
			$changFormule = str_replace("+","$+",$changFormule );//BC9+...-...
			$changFormule = str_replace("-","$-",$changFormule);
			//ECHO $changFormule."<br>";
			$partisFormule = explode("$",$changFormule);
			//print_r($partisFormule);
			//echo "<br>";
			$sum = 0;
			foreach($partisFormule as $Oneparti)
			{
				$pattern = "/RN_/";
				if(preg_match($pattern,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					//echo $rest;
					switch($rest)
					{
						case "+":
							//echo "coucou<br>";
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							//ECHO $oneTerme;
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum+(float)$b->objetRepatition->montant;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum-(float)$b->objetRepatition->montant;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum+(float)$b->objetRepatition->montant;
								}
							}
							break;
					}
				}
				else
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_BILAN_COMPARATIF]->contenu_bilan as $symbole => $symbole_identifiant)
							{
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum+(float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_BILAN_COMPARATIF]->contenu_bilan as $symbole => $symbole_identifiant)
							{
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum-(float)$symbole_identifiant->valeur;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_BILAN_COMPARATIF]->contenu_bilan as $symbole => $symbole_identifiant)
							{
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum+(float)$symbole_identifiant->valeur;
								}
							}
							break;
					}
				}
			}
		}
		$objetLigne = new ligne_bilans_comparatifs();
		$libelle = $row[1];
		$valeur = round($sum,2);
		$identifiant = $row[3];
		$objetLigne->ajout_contenu($libelle,$sum,$identifiant);
		$bilans_comp->ajout_contenu_bilan($identifiant,$objetLigne);
		$_SESSION[C_SESSION_BILAN_COMPARATIF] = $bilans_comp;
		echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
		$row =  mysql_fetch_row($result);
	}
}

/**
 * Calculs pour "Tableau de financement"
 */
function ecorche_finace()
{
	$Ecorche_finace = new ecorche_financ();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYNBOLE from ECORCHE_FINANCE";
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);
	while($row)
	{
		$sum = 0;
		$pattern = "/[+-]/";
		if(preg_match($pattern,$row[2]))
		{
			$changFormule = trim($row[2]);
			$changFormule = str_replace("+","$+",$changFormule );//########################
			$changFormule = str_replace("-","$-",$changFormule);//pour changer la formule #
				
			$partisFormule = explode("$",$changFormule);
			foreach($partisFormule as $Oneparti)
			{
				$pattern1 = "/B([0-9]*)$/";
				if(preg_match($pattern1,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
										
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}

							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}

							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
					}
				}
				$pattern2 = "/BNS_([0-9]*)/";
				if(preg_match($pattern2,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
									$sum = (float)$sum-(float)$objet_infos_compta->soldeN();
								}
							}
							break;
						default :
							$compte = substr($Oneparti,4,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
								}
							}
							break;
					}
				}
				$pattern3 = "/BNSMC_([0-9]*)/";
				if(preg_match($pattern3,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rset)
					{
						case "+":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditMouvement;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtCreditMouvement;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditMouvement;
								}
							}
							break;
					}
				}
				$pattern4 = "/BNSMD_([0-9]*)/";
				if(preg_match($pattern4,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitMouvement;
								}
							}
							break;
					}
				}
				$pattern5 = "/TF([0-9]*)/";
				if(preg_match($pattern5,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}
							}
							break;
						default:
						case "+":
							$oneTerme = substr($Oneparti,0);
							foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;

					}
				}
				$pattern6 = "/RN_/";
				if(preg_match($pattern6,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum+(float)$b->objetRepatition->montant;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum-(float)$b->objetRepatition->montant;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							$pattern = "/^".$oneTerme."$/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $a => $b)
							{
								if(preg_match($pattern,$a))
								{
									$sum = (float)$sum+(float)$b->objetRepatition->montant;
								}
							}
							break;
					}
				}
				$pattern7 = "/BNSD_([0-9]*)/";
				if(preg_match($pattern7,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebit;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtDebit;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebit;
								}
							}
							break;
					}
				}
				$pattern77 = "/BNSC_([0-9]*)/";
				if(preg_match($pattern77,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCredit;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtCredit;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCredit;
								}
							}
							break;
					}
				}
				$pattern8 = "/BNNSDR_([0-9]*)/";
				if(preg_match($pattern8,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport;
								}
							}
							break;
					}
				}
				$pattern88 = "/BNNSCR_([0-9]*)/";
				if(preg_match($pattern88,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditReport;
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,8,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum-(float)$objet_infos_compta->mtCreditReport;
								}
							}
							break;
						default:
							$compte = substr($Oneparti,7,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									$sum=(float)$sum+(float)$objet_infos_compta->mtCreditReport;
								}
							}
							break;
					}
				}
				$pattern9 = "/BNNS_([0-9]*)/";
				if(preg_match($pattern9,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
								}
							}
							break;
						case "-":
							$compte = substr($Oneparti,6,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
									$sum = (float)$sum-(float)$objet_infos_compta->soldeReport();
								}
							}
							break;
						default:
							$compte = substr($Oneparti,5,-1);
							$pattern = "/^".$compte."([0-9]*)/";
							foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
							{
								if(preg_match($pattern,$objet_infos_compta->numero))
								{
									//$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									//$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
									$sum = (float)$sum+(float)$objet_infos_compta->soldeReport();
								}
							}
							break;
					}
				}
				$pattern10 = "/VAR([0-9]*)/";
				if(preg_match($pattern10,$Oneparti))
				{
					$rest = substr($Oneparti,0,1);
					switch($rest)
					{
						case "+":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
						case "-":
							$oneTerme = substr($Oneparti,1);
							foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum - (float)$symbole_identifiant->valeur;
								}
							}
							break;
						default:
							$oneTerme = substr($Oneparti,0);
							foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $symbole => $symbole_identifiant)
							{
								$pattern =  "/^".$oneTerme."$/";
								if(preg_match($pattern,$symbole_identifiant->identifiant))
								{
									$sum = (float)$sum + (float)$symbole_identifiant->valeur;
								}
							}
							break;
					}
				}
			}
		}
		else //pas de + ni de -
		{
			$pattern1 = "//";
			if(preg_match($pattern1,$row[2]))
			{
				$sum = 0;
			}
			$pattern2 = "/^(ACQUISITION)$/";
			if(preg_match($pattern2,$row[2]))
			{
				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_acquisition as $a => $b)
				{
					$sum = (float)$sum + (float)$b->mtDebit;
				}
			}
			$pattern3 = "/^BNS_/";
			if(preg_match($pattern3,$row[2]))
			{
				$compte = substr($row[2],4,-1);
				//echo $compte;
				//echo "<br>";
				$pattern = "/^".$compte."([0-9]*)/";
				$sum = 0;
				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta)
				{
					if(preg_match($pattern,$objet_infos_compta->numero))
					{
						//echo $objet_infos_compta->mtCredit;
						//$sum = (float)$sum-(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
						$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
					}
				}
			}
			$pattern4 = "/^FL([0-9]*)/";
			if(preg_match($pattern4,$row[2]))
			{
				$oneTerme = substr($row[2],0);
				foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $symbole => $symbole_identifiant)
				{
					//echo "coucoc";
					$pattern =  "/^".$oneTerme."$/";
					if(preg_match($pattern,$symbole_identifiant->identifiant))
					{
						$sum = (float)$sum + (float)$symbole_identifiant->valeur;
					}
				}
			}
		}
		$objetLigne = new ligne_ecorche_financ();
		$libelle = $row[1];
		$valeurSum = round($sum,2);
		$identifiant = $row[3];
		$objetLigne->ajout_contenu($libelle,$valeurSum,$identifiant);
		$Ecorche_finace->ajout_contenu_ecorche($identifiant,$objetLigne);
		$_SESSION[C_SESSION_TABLEAU_FINANCEMENT] = $Ecorche_finace;
		echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
		$row =  mysql_fetch_row($result);
	}
}


/**
 * @todo Calculs pour "Descriptif de l'exploitation" 
 */
function descriptif_exploitation() {
	//1ere serie de calculs pour l'affichage

	//assolement : 6 lignes + 1 = 6 principales production + regroupement du reste
	//2 listes:
	//	- les 6 principaux
	//	- le reste
	//  foreach sur l'analytique
	//	si plus grand qu'un des 6, remplacer dans les 6 et prendre celui des 6 pour le mettre avec le reste
	$taille_max = 6;
	$les_principaux[$taille_max];
//	$le_reste[];
	$atelier = "";
	foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $cle => $infos_analytique) {
		//nb_unite_atelier
		if($infos_analytique->atelier!=$atelier && $infos_analytique->code_activite>=1 && $infos_analytique->code_activite<=7) {
			$atelier = $infos_analytique->atelier;
			$i=0;
			$trouve = false;

			while(!$trouve && $i<$taille_max) {
				if(
				//$les_principaux[$i]==null || 
				$infos_analytique->nb_unite_atelier > $les_principaux[$i]) {
					$trouve = true;
				} else {
					$i++;
				}
			}
			if($trouve){//decalage + le dernier passe dans $le_reste[]
				$le_reste[] = $les_principaux[$taille_max];
				for($j=$taille_max;$j>$i;$j--) {
					$les_principaux[$j]=$les_principaux[$j-1];
				}
				$les_principaux[$i]=$infos_analytique;
			} else {
				$le_reste[]=$infos_analytique;
			}
		}
	}
	
	uasort($les_principaux,"compareNbUniteAtelier");
	
//	echo "============ principaux =============<br>";
//	print_r($les_principaux);
//	echo "============ reste =============<br>";
//	print_r($le_reste);
	
	//remplissage de l'objet representant les assolement en session
	$assolement = new assolement();
	foreach ($les_principaux as $infos_analytique) {
		if($infos_analytique->nb_unite_atelier!=0) {//evite les ligne vide
			$assolement->liste_assolement[]=new ligne_assolement($infos_analytique->libelle_atelier,$infos_analytique->nb_unite_atelier);
			echo $infos_analytique->libelle_atelier." => ".$infos_analytique->nb_unite_atelier."<br>";
		}
	}
	
	//$ligne_assolement_autre = new ligne_assolement();
	//$ligne_assolement_autre->culture="Autre";
	foreach ($le_reste as $infos_analytique) {
		if($infos_analytique->nb_unite_atelier!=0) {//evite les ligne vide
			$ligne_assolement_autre->surface+=$infos_analytique->nb_unite_atelier;
		}
	}
	//if(count($le_reste)>0)
		//$assolement->liste_assolement[]=$ligne_assolement_autre;
	$assolement->valeur_total_surface();
	$_SESSION[C_SESSION_ASSOLEMENT] = $assolement;
	
	//print_r($_SESSION[C_SESSION_ASSOLEMENT]);

	
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYMBOLE from DESCRIPTIF_EXPLOITATION";
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);
	while($row) {
		$Oneparti=$row[2];
		$sum = 0;
		//main d'oeuvre : permanante->temps->salarié et temporaire->temps->salarié
		//TODO finier et vérifier main d'oeuvre
		$main_oeuvre_calcul = new main_oeuvre_calcul();
		//fin des calculs - le reste des infos de la page provient de la saisie
		$pattern1 = "/GDQT_([0-9]*)/";
		if(preg_match($pattern1,$Oneparti)) {
			$signe = substr($Oneparti,0,1);

			if($signe=="+" || $signe=="-") {//on enleve le signe
				$oneTerme = substr($Oneparti,1);
			} else { //pas de signe
				$oneTerme = $Oneparti;
			}
				
			foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_grd_livre_qte as $infos_grd_livre_qte) {
				$compte = substr($oneTerme,5);
				$pattern = "/^".$compte."([0-9]*)/";
				if(preg_match($pattern,$infos_grd_livre_qte->compte)) {
					//if($signe=="+")
						$sum = $infos_grd_livre_qte->qte;
				}
			}
		}
		$resultat_cal[$row[3]]=round($sum,2);//on stocke les résultats avant de les mettres dans un objet en session	
		$row =  mysql_fetch_row($result);
	}
	//remplissage d'un objet en session à partir du résultat des calculs
	$main_oeuvre_calcul->temps_salarie_perm=$resultat_cal["DEX1"];
	$main_oeuvre_calcul->temps_salarie_tempo=$resultat_cal["DEX2"];
	$_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL] = $main_oeuvre_calcul;
	
}

function activite_rentatbilite_globale() {
$Solid_inter = new solids_inter();//objet de class_inter.php

	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$activite_globale = new activite_globale();

		$query = "select ID,NOM_FORMULE,FORMULE,SYMBOLE from ATE_ACTIVITE_GLOBALE";
		$result = mysql_query($query,$db_conn);
		$row =  mysql_fetch_row($result);
		while($row)
		{
			$sum = 0;
//			$pattern1 = "/[+|-]/";
//			if(!preg_match($pattern1,$row[2]))####pour BNS_707* ....seulement une terme
//			{
//
//
//     		}
//			else        ####pour pour B3+B3-B5
//			{
				$changFormule = trim($row[2]);
				$changFormule = str_replace("+","$+",$changFormule );//EX=BNS_700*$+BNS_205*$+BNS_88* ou B3+B4-B5
				$changFormule = str_replace("-","$-",$changFormule);//EX=BNS_700*$+BNS_205*$+BNS_88* ou B3$+B4$-B5
				$changFormule = str_replace("/","$/",$changFormule);		

				$partisFormule = explode("$",$changFormule);########couper la formule B3+B3-B5
				$sum = 0;
				//$count = 0;
				foreach($partisFormule as $Oneparti)
				{

					//$count++;
					$pattern3 = "/B[^NS]([0-9]*)/";
					if(preg_match($pattern3,$Oneparti))
					{
						//echo $count."*******<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}

								}
								break;
							case "-":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum - (float)$symbole_identifiant->valeur;
									}
								}
								break;
							case "/":
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$montant = (float)$symbole_identifiant->valeur;
										if($montant==0)
										{
											$sum = 0;
										}
										else
										{
											$sum = (float)$sum/$montant;
										}
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}
					$pattern5 = "/C[^NS]([0-9]*)/";
					if(preg_match($pattern5,$Oneparti))
					{
						//echo $count."*******<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}

								}
								break;
							case "-":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum - (float)$symbole_identifiant->valeur;
									}
								}
								break;
							case "/":
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$montant = (float)$symbole_identifiant->valeur;
										if($montant==0)
										{
											$sum = 0;
										}
										else
										{
											$sum = (float)$sum/$montant;
										}
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}
				$pattern6 = "/D[^NS]([0-9]*)/";
					if(preg_match($pattern6,$Oneparti))
					{
						//echo $count."*******<br>";
						$rest = substr($Oneparti,0,1);
						switch($rest)
						{
							case "+":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter3 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}

								}
								break;
							case "-":
								$oneTerme = substr($Oneparti,1);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter3 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum - (float)$symbole_identifiant->valeur;
									}
								}
								break;
							case "/":
								$oneTerme = substr($Oneparti,1);
								$pattern = "/^".$oneTerme."$/";
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter3 as $symbole => $symbole_identifiant)
								{
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$montant = (float)$symbole_identifiant->valeur;
										if($montant==0)
										{
											$sum = 0;
										}
										else
										{
											$sum = (float)$sum/$montant;
										}
									}
								}
								break;
							default:
								$oneTerme = substr($Oneparti,0);
								foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter3 as $symbole => $symbole_identifiant)
								{
									$pattern =  "/^".$oneTerme."$/";
									if(preg_match($pattern,$symbole_identifiant->identifiant))
									{
										$sum = (float)$sum + (float)$symbole_identifiant->valeur;
									}
								}
								break;
						}
					}

				}
			//}
			
			//$_SESSION['solid_inter_ligne'] = $objetLigne;
			$libelle = $row[1];
			$valeurSum = round($sum,2);
			$identifiant = $row[3];
			$objetLigne = new ligne_activite_globale($libelle,$valeurSum,$identifiant);
			$activite_globale->ajout_contenu_activite_globale($identifiant,$objetLigne);
			$_SESSION[C_SESSION_ACTIVITE_GLOBALE] = $activite_globale;
			echo $row[3]."**".$sum."<br>";
			$row =  mysql_fetch_row($result);
		}
		$activite_globale->resultat_exploitation = $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->getValeurLigne("ATE10");
		$activite_globale->CA_HT = $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->getValeurLigne("ATE11");
		$activite_globale->tx_rentabilite_eco = $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->getValeurLigne("ATE12")*100;
		$_SESSION[C_SESSION_ACTIVITE_GLOBALE] = $activite_globale;
}

/**
 * @todo Calculs pour "Analyse technico-economique" 
 * manque total SAU de la premiere page
 * manque cas/traitement pour N-1 et N-2
 */
function analyse_technico_economique() {
	//Activite rentabilite globale => reprise soldes intermediaires
	//charges globales => balance analytique (compte et atelier)
	//marge brute => balance analytique (compte, atelier et activite)
	//marge nette => marge brute + balance analytique

	$charges_globales = new charges_globales();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYMBOLE from ATE_CHARGES_GLOBALE";
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);
	while($row)
	{
		$sum = 0;
		$pattern = "/[^-][+-\/*][^-]/"; //pas deux '-' consécutifs
		//$pattern = "/[+-]/";
		if(preg_match($pattern,$row[2]))
		{
			$changFormule = trim($row[2]);
			$changFormule = preg_replace("/([^+])([+])([^+])/","$1$+$3",$changFormule);//str_replace("+","$+",$changFormule );//########################
			$changFormule = preg_replace("/([^-])([-])([^-])/","$1$-$3",$changFormule);//str_replace("-","$-",$changFormule);//pour changer la formule #
			$changFormule = preg_replace("/([^\/\/])([\/])([^\/\/])/","$1$/$3",$changFormule);//str_replace("/","$/",$changFormule);//pour changer la formule #
			$changFormule = preg_replace("/([^*])([*])([^*])/","$1$*$3",$changFormule);//str_replace("/","$*",$changFormule);//pour changer la formule #
				
			$partisFormule = explode("$",$changFormule);
			foreach($partisFormule as $Oneparti)
			{
				//si "/BAN_([0-9]*)/";
				//si "ATELIER_N"
				//si "ACTIVITE_N"
				//chercher si en 1er s'il y a des conditions par rapport aux atelier ou aux activite
				// et en faire une liste
				//$ateliers

				////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////
				$patternConditionAtelier = "/[+-]ATELIER_N\[[A-Z,-]*\]/";  //-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]
				$conditionAtelier = array_values(preg_grep($patternConditionAtelier,$partisFormule)); 
				if(count($conditionAtelier)==1) {
					$listeConditionAtelier = explode(",", substr($conditionAtelier[0],11,strlen($conditionAtelier[0])-11-1));
					$signeConditionAtelier = substr($conditionAtelier[0],0,1);
				}
				

				////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////

				$pattern1 = "/BAN_([0-9]*)/";
				if(preg_match($pattern1,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}
					

					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $infos_analytique) {
						//if(array_search($infos_analytique->atelier,$listeConditionAtelier)==false){
						if(in_array($infos_analytique->atelier,$listeConditionAtelier)==false){
							$compte = substr($oneTerme,4);
							$pattern = "/^".$compte."([0-9]*)/";
							if(preg_match($pattern,$infos_analytique->compte)) {
								if($signe=="+")
									$sum = (float)$sum + (float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits;
								else if($signe=="-")
									$sum = (float)$sum - (float)$infos_analytique->total_charges+(float)$infos_analytique->total_produits;
								else
									$sum = (float)$sum + (float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits;
							}
						} 
					}
				}
				
				$pattern1 = "/[CDEFGH]([0-9])/";
				if(preg_match($pattern1,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-" || $signe=="/" || $signe=="*") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}
						
					foreach($_SESSION[C_SESSION_CHARGES_GLOBALES]->contenu_charges_globales as $cle => $ligne_charge_globale) {
//echo $cle."--------------------<br>";
							//$compte = substr($oneTerme,1);
							$pattern = "/^".$oneTerme."/";
							if(preg_match($pattern,$cle)) {
								if($signe=="+")
									$sum = (float)$sum + (float)$ligne_charge_globale->valeur;
								else if($signe=="-")
									$sum = (float)$sum - (float)$ligne_charge_globale->valeur;
								else if($signe=="/") {
									if((float)$ligne_charge_globale->valeur==0) {
										$sum = 0;
									} else {
										$sum = (float)$sum / (float)$ligne_charge_globale->valeur;
									}
								}
								else if($signe=="*")
									$sum = (float)$sum * (float)$ligne_charge_globale->valeur;
								else
									$sum = (float)$sum + (float)$ligne_charge_globale->valeur;
							}

					}
				}
				
				$pattern1 = "/TotalSAU/";
				if(preg_match($pattern1,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-" || $signe=="/" || $signe=="*") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}
					//foreach($_SESSION[C_SESSION_FAIRE_VALOIR]->contenu_charges_globales as $cle => $ligne_charge_globale) {
//echo $cle."--------------------<br>";
							//$compte = substr($oneTerme,1);
							$pattern = "/^".$oneTerme."/";
						//	if(preg_match($pattern,$cle)) {
								if($signe=="+")
									$sum = (float)$sum + $_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau;
								else if($signe=="-")
									$sum = (float)$sum - $_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau;
								else if($signe=="/") {
									//echo "SESSION[C_SESSION_FAIRE_VALOIR]->total_sau : ".$_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau."<br>";
									if($_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau==0) {
										$sum = 0;
									} else {
										$sum = (float)$sum / $_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau;
									}
								}
								else if($signe=="*")
									$sum = (float)$sum * $_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau;
								else
									$sum = (float)$sum + $_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau;
						//	}

					//}
				}
				
			}
		} else {// pas de "+" ni de "-" => pas de formule, valeur à récupérer directement

			$pattern1 = "/ATELIER_N\[[A-Z-]*\]/";
			if(preg_match($pattern1,$row[2])) {
				$signe = substr($row[2],0,1);

				if($signe=="+" || $signe=="-") {//on enleve le signe
					$oneTerme = substr($row[2],1);
				} else { //pas de signe
					$oneTerme = $row[2];
				}

				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $infos_analytique) {
					$compte = substr($oneTerme,10,strlen($oneTerme)-10-1);
					$pattern = "/^".$compte."$/";
					if(preg_match($pattern,$infos_analytique->atelier)) {
						if($signe=="+")
							$sum = (float)$sum + (float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits;
						else if($signe=="-")
							$sum = (float)$sum - (float)$infos_analytique->total_charges+(float)$infos_analytique->total_produits;
						else
							$sum = (float)$sum + (float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits;
					}

				}
			}
		}
		$libelle = $row[1];
		$valeurSum = round($sum,2);
		$identifiant = $row[3];
		$ligne_charge_globale = new ligne_charge_globale($libelle,$valeurSum,$identifiant);
		$charges_globales->ajout_charge_globale($identifiant,$ligne_charge_globale);
		$_SESSION[C_SESSION_CHARGES_GLOBALES] = $charges_globales;
//		echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
		echo $row[3]."**".$sum."<br>";
		$row =  mysql_fetch_row($result);
	}
}

/**
 * @todo Calculs pour "Marge brute" 
 * calcul de D98 à faire => changer le nom des cellules dans les formules (2 x C95)
 */
function marge_brute() {
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	//calculs generaux
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	$calcul_marge_brute = new calcul_marge_brute();
	//$marge_brute = new marge_brute();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYMBOLE from ATE_MARGE_BRUTE";
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);
	while($row)
	{
		$sum = 0;
		$pattern = "/[^-][+-][^-]/"; //pas deux '-' consécutifs
		//$pattern = "/[+-]/";
		if(preg_match($pattern,$row[2]))
		{
			$changFormule = trim($row[2]);
			$changFormule = preg_replace("/([^+])([+])([^+])/","$1$+$3",$changFormule);//str_replace("+","$+",$changFormule );//########################
			$changFormule = preg_replace("/([^-])([-])([^-])/","$1$-$3",$changFormule);//str_replace("-","$-",$changFormule);//pour changer la formule #
				
			$partisFormule = explode("$",$changFormule);
			foreach($partisFormule as $Oneparti)
			{
//	echo "==============================  **** $Oneparti ***** =============================<br>";			
				//si "/BAN_([0-9]*)/";
				//si "ATELIER_N"
				//si "ACTIVITE_N"
				//chercher si en 1er s'il y a des conditions par rapport aux atelier ou aux activite
				// et en faire une liste
				//$ateliers

				////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////
				$patternConditionAtelier = "/[+-]ATELIER_N\[[A-Z,-]*\]/";  //-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]
				$conditionAtelier = array_values(preg_grep($patternConditionAtelier,$partisFormule)); 
				if(count($conditionAtelier)==1) {
					$listeConditionAtelier = explode(",", substr($conditionAtelier[0],11,strlen($conditionAtelier[0])-11-1));
					$signeConditionAtelier = substr($conditionAtelier[0],0,1);
				}

				////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////

				$pattern1 = "/BAN_([0-9]*)/";
				if(preg_match($pattern1,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}
					

					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $infos_analytique) {
						//if(array_search($infos_analytique->atelier,$listeConditionAtelier)==false){
						if(in_array($infos_analytique->atelier,$listeConditionAtelier)==false){
							$compte = substr($oneTerme,4);
							$pattern = "/^".$compte."([0-9]*)/";
							if(preg_match($pattern,$infos_analytique->compte)) {
								if($signe=="+")
									$sum = (float)$sum - ((float)$infos_analytique->total_charges+(float)$infos_analytique->total_produits);
								else if($signe=="-")
									$sum = (float)$sum + ((float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits);
								else
									$sum = (float)$sum - ((float)$infos_analytique->total_charges+(float)$infos_analytique->total_produits);
							}
						}

					}
				}
				
				$pattern1 = "/ACTIVITE\[[1-9]*\]/";
				if(preg_match($pattern1,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}

					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $infos_analytique) {
						//if(array_search($infos_analytique->atelier,$listeConditionAtelier)==false){
						if(in_array($infos_analytique->atelier,$listeConditionAtelier)==false){
							$compte = substr($oneTerme,9,strlen($oneTerme)-9-1);
							$pattern = "/^".$compte."$/";
							if(preg_match($pattern,$infos_analytique->code_activite)) {
								if($signe=="+")
									$sum = (float)$sum - ((float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits);
								else if($signe=="-")
									$sum = (float)$sum + ((float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits);
								else
									$sum = (float)$sum - ((float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits);
							}
						}

					}
				}
				
				$pattern8 = "/VAR([0-9]*)/";
				if(preg_match($pattern8,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}
					foreach($_SESSION[C_SESSION_MARGE_BRUTE_CALC]->contenu_calcul_marge_brute as $cle => $ligne_calcul_marge_brute) {

						$pattern = "/^".$oneTerme."/";
						if(preg_match($pattern,$cle)) {
							if($signe=="+")
								$sum = (float)$sum + (float)$ligne_calcul_marge_brute->valeur;
							else if($signe=="-")
								$sum = (float)$sum - (float)$ligne_calcul_marge_brute->valeur;
							else
								$sum = (float)$sum + (float)$ligne_calcul_marge_brute->valeur;
						}

					}
				}
				
				//TODO attention à E77,C95 =>C_SESSION_MARGE_BRUTE_CALC et C56,C56,C57,C58,C59 =>C_SESSION_CHARGES_GLOBALES
				//$pattern8 = "/[EC]([0-9]*)/";
				$pattern8 = "/(C56)|(C57)|(C58)|(C59)/";
				if(preg_match($pattern8,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}

					foreach($_SESSION[C_SESSION_CHARGES_GLOBALES]->contenu_charges_globales as $cle => $ligne_charge_globale) {

						$pattern = "/^".$oneTerme."/";
						if(preg_match($pattern,$cle)) {
							if($signe=="+")
							$sum = (float)$sum + (float)$ligne_charge_globale->valeur;
							else if($signe=="-")
							$sum = (float)$sum - (float)$ligne_charge_globale->valeur;
							else
							$sum = (float)$sum + (float)$ligne_charge_globale->valeur;
						}

					}
				}

				//$pattern8 = "/[EC]([0-9]*)/";
				$pattern9 = "/(E77)|(C95)/";
				if(preg_match($pattern9,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}

					foreach($_SESSION[C_SESSION_MARGE_BRUTE_CALC]->contenu_calcul_marge_brute as $cle => $ligne_calcul_marge_brute) {

						$pattern = "/^".$oneTerme."/";
						if(preg_match($pattern,$cle)) {
							if($signe=="+")
							$sum = (float)$sum + (float)$ligne_calcul_marge_brute->valeur;
							else if($signe=="-")
							$sum = (float)$sum - (float)$ligne_calcul_marge_brute->valeur;
							else
							$sum = (float)$sum + (float)$ligne_calcul_marge_brute->valeur;
						}

					}
				}
			}
		} else {// pas de "+" ni de "-" => pas de formule, valeur à récupérer directement

			$Oneparti = $row[2];

			$pattern3 = "/BNS_([0-9]*)/";
			if(preg_match($pattern3,$Oneparti)) {
				$signe = substr($Oneparti,0,1);

				if($signe=="+" || $signe=="-") {//on enleve le signe
					$oneTerme = substr($Oneparti,1);
				} else { //pas de signe
					$oneTerme = $Oneparti;
				}

				$compte = substr($oneTerme,4,-1);
				$pattern = "/^".$compte."([0-9]*)/";
				foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_compta as $Numbre => $objet_infos_compta) {
					if(preg_match($pattern,$objet_infos_compta->numero)) {
						if($signe=="+")
							//$sum = (float)$sum + (float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
							$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
						else if($signe=="-")
							//$sum = (float)$sum - (float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
							$sum = (float)$sum-(float)$objet_infos_compta->soldeN();
						else
							//$sum = (float)$sum + (float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
							$sum = (float)$sum+(float)$objet_infos_compta->soldeN();
					}
				}
			}
		}
		$libelle = $row[1];
		$valeurSum = round($sum,2);
		$identifiant = $row[3];
		$ligne_calcul_marge_brute = new ligne_calcul_marge_brute($libelle,$valeurSum,$identifiant);
		//$charges_globales->ajout_charge_globale($identifiant,$ligne_charge_globale);
		$calcul_marge_brute->ajout_calcul_marge_brute($identifiant,$ligne_calcul_marge_brute);
		$_SESSION[C_SESSION_MARGE_BRUTE_CALC] = $calcul_marge_brute;
//		echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
		echo $row[3]."**".$sum."<br>";
		$row =  mysql_fetch_row($result);
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	//calculs des 6 principaux +1
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	//liste des ateliers a ne pas prendre en compte
	$query = "select ID,NOM_FORMULE,FORMULE,SYMBOLE from ATE_MARGE_BRUTE WHERE SYMBOLE='EX_AT'";
	$result = mysql_query($query,$db_conn);
	$row =  mysql_fetch_row($result);
	if($row) {
		$listeConditionAtelier = explode(",",$row[2]);
	} else {
		$listeConditionAtelier = explode(",",",,MECA,M--O,BAFO,DIVE,ELEM");
	}

	$productions = array();
	foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $cle => $infos_analytique) {
		if(array_search($infos_analytique->atelier,$listeConditionAtelier)==false){
			if(array_key_exists($infos_analytique->atelier,$productions)) {
				$productions[$infos_analytique->atelier]->charge_total+=$infos_analytique->total_charges;
				$productions[$infos_analytique->atelier]->produit_total+=$infos_analytique->total_produits;
			} else {
				$productions[$infos_analytique->atelier] = new marge_production($infos_analytique->atelier,
				$infos_analytique->libelle_atelier,
				$infos_analytique->total_charges,
				$infos_analytique->total_produits,
				$infos_analytique->nb_unite_atelier);
			}
		}
	}
	//tri selon le produit/charge le plus grand
	foreach ($productions as $key => $marge_production) {
		echo "$key: $marge_production->charge_total<br>";
	}
	
	uasort($productions,"compareProductionProduit");
	
	foreach ($productions as $key => $marge_production) {
		echo "$key: $marge_production->charge_total<br>";
	}
	
	//TODO récupérer les 6 premiers et grouper le reste
	$nb_prod_max = 6;
	$i=0;
	$production_temp = array();
	$marge_production_autre=new marge_production();
	$marge_production_autre->atelier="AUTRES";
	$marge_production_autre->libelle="AUTRES";
	foreach ($productions as $key => $marge_production) {
		if($i<$nb_prod_max) {
			$production_temp[$key]=$marge_production;
		} else {
			$marge_production_autre->charge_total+=$marge_production->charge_total;
			$marge_production_autre->produit_total+=$marge_production->produit_total;
			$marge_production_autre->nb_unite+=$marge_production->nb_unite;
		}
		$i++;
	}
	if($i>=$nb_prod_max) {
		$production_temp[$marge_production_autre->atelier]=$marge_production_autre;
	}
	$productions = $production_temp;
	
	$_SESSION[C_SESSION_MARGE_PRODUCTION]=$productions;
	
	
	$marge_brute = new marge_brute();
	foreach ($_SESSION[C_SESSION_MARGE_PRODUCTION] as $key => $marge_production) {
		$ligne_marge_brute_graph = new ligne_marge_brute_graph();
		$ligne_marge_brute_graph->libelle = $marge_production->atelier;
		$ligne_marge_brute_graph->valeur = -($marge_production->charge_total-$marge_production->produit_total);
		$marge_brute->productions[$marge_production->atelier]=$ligne_marge_brute_graph;
	}
	
	$marge_brute->marge_brute_totale = $_SESSION[C_SESSION_MARGE_BRUTE_CALC]->contenu_calcul_marge_brute["E77"]->valeur;
	$marge_brute->marge_brute_moins_structure = $_SESSION[C_SESSION_MARGE_BRUTE_CALC]->contenu_calcul_marge_brute["C95"]->valeur;
	$marge_brute->resultat_net = $_SESSION[C_SESSION_MARGE_BRUTE_CALC]->contenu_calcul_marge_brute["D98"]->valeur;
	$_SESSION[C_SESSION_MARGE_BRUTE]=$marge_brute;

}

/**
 * Compare deux objets de type "marge_production" en fonction de leur propriété "charge_total"
 *
 * @param marge_production $a
 * @param marge_production $b
 * @return int 
 * -1 si charge de $a > charge de $b, 
 * 0 si charge de $a = charge de $b, 
 * 1 si charge de $a > charge de $b
 */
function compareProductionProduit($a, $b){
	if ($a->produit_total == $b->produit_total) {
		return 0;
	}
	return ($a->produit_total > $b->produit_total) ? -1 : 1;
}

/**
 * Compare deux objets de type "marge_production" en fonction de leur propriété "marge"
 *
 * @param marge_production $a
 * @param marge_production $b
 * @return int 
 * -1 si charge-produit de $a > charge-produit de $b, 
 * 0 si charge-produit de $a = charge-produit de $b, 
 * 1 si charge-produit de $a > charge-produit de $b
 */
function compareProductionMarge($a, $b){
	if (($a->charge_total-$a->produit_total) == ($b->charge_total-$b->produit_total)) {
		return 0;
	}
	return (($a->charge_total-$a->produit_total) > ($b->charge_total-$b->produit_total)) ? -1 : 1;
}

/**
 * Compare deux objets de type "infos_analytique" en fonction de leur propriété "nb_unite_atelier"
 *
 * @param infos_analytique $a
 * @param infos_analytique $b
 * @return int 
 * -1 si nb_unite_atelier de $a > nb_unite_atelier de $b, 
 * 0 si nb_unite_atelier de $a = nb_unite_atelier de $b, 
 * 1 si nb_unite_atelier de $a > nb_unite_atelier de $b
 */
function compareNbUniteAtelier($a, $b){
	if ($a->nb_unite_atelier == $b->nb_unite_atelier) {
		return 0;
	}
	return ($a->nb_unite_atelier > $b->nb_unite_atelier) ? -1 : 1;
}

/**
 * Calculs pour "Marge nette" 
 */
function marge_nette() {
	//reprise des 6 principaux +1
	$marge_nette = new marge_nette();
	foreach ($_SESSION[C_SESSION_MARGE_PRODUCTION] as $key => $marge_production) {
		$ligne_marge_nette = new ligne_marge_nette();
		$ligne_marge_nette->libelle = $marge_production->atelier;
		$ligne_marge_nette->marge_brute_u = -($marge_production->charge_total-$marge_production->produit_total)/$marge_production->nb_unite;
		$ligne_marge_nette->charge_structure_u = 0;
		$ligne_marge_nette->produits_structurels_u = 0;
		$ligne_marge_nette->marge_nette_u = $ligne_marge_nette->marge_brute_u-$ligne_marge_nette->charge_structure_u+$ligne_marge_nette->produits_structurels_u;
		$ligne_marge_nette->marge_nette = $ligne_marge_nette->marge_nette_u*$marge_production->nb_unite;
		$ligne_marge_nette->nombre_unite = $marge_production->nb_unite;
		$marge_nette->contenu_marge_nette[$marge_production->atelier]=$ligne_marge_nette;
	}
	//variables en session invers� : A MODIFIER
	$_SESSION[C_SESSION_MARGE_NETTE]=$_SESSION[C_SESSION_MARGE_PRODUCTION];
	$_SESSION[C_SESSION_MARGE_PRODUCTION]=$marge_nette;
}

function simulation_saisie_descriptif_exploitation() {
	$dossier = new infos_dossier();
	$dossier->adherent="ABC";
	$dossier->annee=2007;
	$dossier->adresse_cogere="adresse cogere";
	$dossier->telephone_cogere="tel cogere";
	$_SESSION[C_SESSION_INFOS_DOSSIER] = $dossier;
	
	$faire_valoir = new faire_valoir();
	/*$faire_valoir->propriete = 1;
	$faire_valoir->fermage = 2;
	$faire_valoir->mise_a_disp_prop = 3;
	$faire_valoir->mise_a_disp_ferm = 4;
	$faire_valoir->metayage = 5;
	$faire_valoir->total_sau = 2;
	$faire_valoir->non_sau = 7;
	$faire_valoir->dont_bois = 8;
	$faire_valoir->total_surface = 9;*/
	$_SESSION[C_SESSION_FAIRE_VALOIR] = $faire_valoir;
	
	//compléter les lignes des assolement
	
	$stocks_produits = new stocks_produits();
	/*$stocks_produits->liste_stocks[] = new ligne_stock();
	$stocks_produits->liste_stocks[] = new ligne_stock();
	$stocks_produits->liste_stocks[] = new ligne_stock();*/
	//$stocks_produits->liste_stocks[] = new ligne_stock();
	//$stocks_produits->liste_stocks[] = new ligne_stock();
	//$stocks_produits->liste_stocks[] = new ligne_stock();
	$_SESSION[C_SESSION_STOCKS] = $stocks_produits;
	
	$main_oeuvre = new main_oeuvre();
	$ligne_main_oeuvre=new ligne_main_oeuvre();
	$ligne_main_oeuvre->libelle="Non salarié";
	$main_oeuvre->lignes_main_oeuvre["non_salarie"]=$ligne_main_oeuvre;
	$ligne_main_oeuvre=new ligne_main_oeuvre();
	$ligne_main_oeuvre->libelle="Aides familiaux";
	$main_oeuvre->lignes_main_oeuvre["aides"]=$ligne_main_oeuvre;
	
	$ligne_main_oeuvre=new ligne_main_oeuvre();
	$ligne_main_oeuvre->libelle="Salarie";
	$ligne_main_oeuvre->perm_temps=$_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]->temps_salarie_perm;
	$ligne_main_oeuvre->temp_temps=$_SESSION[C_SESSION_MAIN_OEUVRE_CALCUL]->temps_salarie_tempo;
	$main_oeuvre->lignes_main_oeuvre["salarie"]=$ligne_main_oeuvre;
	
	$ligne_main_oeuvre=new ligne_main_oeuvre();
	$ligne_main_oeuvre->libelle="Totaux";
	$main_oeuvre->lignes_main_oeuvre["totaux"]=$ligne_main_oeuvre;
	$_SESSION[C_SESSION_MAIN_OEUVRE] = $main_oeuvre;
	
}

function simulation_saisie_analyse_technico_economique() {
	//charges globales => calculs en fonctions de SAU de la premiere page

	//commentaire rentabilité globale
	$_SESSION[C_SESSION_ACTIVITE_GLOBALE]->commentaire="le commentaire sur la rentabilité globale ...";
	
	//marge nette : charge_de_structure/U et Produit_structurel/U
}

function simulation_saisie_commentaire_final() {
	//commentaire final
	$commentaire_final = new commentaire_final();
	$commentaire_final->commentaire="le commentaire final ...";
	$_SESSION[C_SESSION_COMMENTAIRE_FINAL]=$commentaire_final;
}

function recalculer() {
}

lire_xml();
echo "================================= soldes_inter =============================<BR>";
soldes_inter();
echo "================================= bilans_comp ==============================<BR>";
bilans_comp();
echo "================================ tableau_flux ==============================<BR>";
tableau_flux();
echo "================================ ratios_finance ============================<BR>";
ratios_finance();
echo "=============================== ecorche_finace =============================<BR>";
ecorche_finace();
echo "============================ descriptif_exploitation =======================<BR>";
descriptif_exploitation();
simulation_saisie_descriptif_exploitation();
echo "========================= analyse_technico_economique *** activite rentatbilite globales ======================<BR>";
activite_rentatbilite_globale();
echo "========================= analyse_technico_economique *** charges globales ======================<BR>";
analyse_technico_economique();
echo "========================= analyse_technico_economique *** marge brute ======================<BR>";
marge_brute();
echo "========================= analyse_technico_economique *** marge nette ======================<BR>";
marge_nette();
simulation_saisie_analyse_technico_economique();

simulation_saisie_commentaire_final();
echo "<a href = \"modif_stock_produit.php\">modif_stock_produit.php</a><br>";
echo "<a href = \"modif_assolement.php\">modif_assolement.php</a><br>";
echo "<a href = \"modif_valoir_global.php\">modif_valoir_global.php</a><br>";
echo "<a href = \"modif_main.php\">modif_main.php</a><br>";
echo "<a href = \"modif_marge_nette.php\">modif_marge_nette.php</a><br>";
//print_r($_SESSION[C_SESSION_ASSOLEMENT]);
?>
