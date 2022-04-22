<?php
/*
 * Lecture du fichier XML initial (xml->objet)
 * Fonctions de calculs pour les différentes pages du document, les résultats des calculs sont stockés dans des objets en session
 */
session_start();
//require_once();
include_once("analyse_eco.php");
include_once("class_inter.php");
include_once("connection.php");

define('C_FICHIER_XML_INITIAL','analyseEco.xml');
define('C_SESSION_XML_INITIAL','DebutXml');
define('C_SESSION_TABLEAU_FLUX','Flux');
define('C_SESSION_SOLDES_INTERMEDIAIRES','SolidinterXml');
define('C_SESSION_RATIOS','Ratios');
define('C_SESSION_BILAN_COMPARATIF','BilanXml');
define('C_SESSION_TABLEAU_FINANCEMENT','Ecorche');
define('C_SESSION_ASSOLEMENT','assolement');
define('C_SESSION_MAIN_OEUVRE','main_oeuvre');

/**
 * Solde balance N
 */
function calcul_BNS($sum,$Oneparti){
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
						$sum = (float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
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
						$sum = (float)$sum-(float)$objet_infos_compta->mtDebit-(float)$objet_infos_compta->mtCredit;
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
						$sum=(float)$sum+(float)$objet_infos_compta->mtDebit+(float)$objet_infos_compta->mtCredit;
					}
				}
				break;
		}
	}
	return $sum;
}

/**
 * Solde balance N-1
 */
function calcul_BNNS($sum,$Oneparti) {
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
						$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
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
						$sum=(float)$sum-(float)$objet_infos_compta->mtDebitReport-(float)$objet_infos_compta->mtCreditReport;
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
						$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
					}
				}
				break;
					
		}
	}
}

/**
 * liasse fiscale
 */
function calcul_RN($sum,$Oneparti) {
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
}

/**
 * Solde Débit Balance N
 */
function calcul_BNSD($sum,$Oneparti) {
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
}

/**
 * Solde balance N-1 débit report
 */
function calcul_BNNSDR($sum,$Oneparti) {
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
}

/**
 * Tableau des flux
 */
function calcul_FL($sum,$Oneparti) {
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
}

/**
 * Solde balance N Mouvement Crédit
 */
function calcul_BNSMC($sum,$Oneparti) {
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
}

/**
 * Solde balance N Mouvement Débit
 */
function calcul_BNSMD($sum,$Oneparti) {
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
}

/**
 * Tableau de financement
 */
function calcul_TF($sum,$Oneparti) {
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
}

/**
 *	Lecture du fichier XML initial
 */
function lire_xml()
{

	//include_once("connection.php");
	$donnees_analyse_eco = simplexml_load_file(C_FICHIER_XML_INITIAL);
	$analyse_eco = new donnees_analyse_eco();//objet de analyse_eco.php

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

		$montant = $infos_liasse->repartition->montant;
		$valeur = $infos_liasse->repartition->valeur;
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

	#######pour les objets de infos_compta stoker dans le tableau de object donnees_analyse_eco
	$_SESSION[C_SESSION_XML_INITIAL] = $analyse_eco;

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
				if(preg_match($pattern3,$Oneparti)) {
					calcul_BNS(&$sum,$Oneparti);
				}
				$pattern4 = "/RN_/";
				if(preg_match($pattern4,$Oneparti)) {
					calcul_RN(&$sum,$Oneparti);
				}
				$pattern5 = "/BNSD_([0-9]*)/";
				if(preg_match($pattern5,$Oneparti)) {
					calcul_BNSD(&$sum,$Oneparti);
				}
				$pattern6 = "/BNNSDR_([0-9]*)/";
				if(preg_match($pattern6,$Oneparti)) {
					calcul_BNNSDR(&$sum,$Oneparti);
				}
				$pattern7 = "/BNNS_([0-9]*)/";
				if(preg_match($pattern7,$Oneparti)) {
					calcul_BNNS(&$sum,$Oneparti);
				}
				$pattern8 = "/VAR([0-9]*)/";
				if(preg_match($pattern8,$Oneparti)) {
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
				if(preg_match($pattern11,$Oneparti)) {
					calcul_FL(&$sum,$Oneparti);
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
				if(preg_match($pattern15,$Oneparti)) {
					calcul_BNSMC(&$sum,$Oneparti);
				}
				$pattern17 = "/BNSMD_([0-9]*)/";
				if(preg_match($pattern17,$Oneparti)) {
					calcul_BNSMD(&$sum,$Oneparti);
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
						$sum = (float)$sum+(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
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
		$valeurSum = $sum;
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
		$query = "select ID,NOM_FORMULE,FORMULE,SYNBOLE from FORMULES_INTER".$i;
		$result = mysql_query($query,$db_conn);
		$row =  mysql_fetch_row($result);
		while($row)
		{
			$sum = 0;
			$pattern1 = "/[+|-]/";
			if(!preg_match($pattern1,$row[2]))####pour BNS_707* ....seulement une terme
			{
				$pattern2 = "/^BNS_/";
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
							$sum = (float)$sum+(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
						}
					}
				}
				$pattern3 = "/^BNNS_/";
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
							$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
						}
					}
				}
				$pattern4 = "//";
				if(preg_match($pattern4,$row[2]))
				{
					$sum = 0;
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
					if(preg_match($pattern4,$Oneparti)) {
						calcul_BNS(&$sum,$Oneparti);
					}
					$pattern6 = "/BNNS_([0-9]*)/";
					if(preg_match($pattern6,$Oneparti)) {
						calcul_BNNS(&$sum,$Oneparti);
					}
				}
			}
			$objetLigne = new ligne_solids_inter();
			//$_SESSION['solid_inter_ligne'] = $objetLigne;
			$libelle = $row[1];
			$valeurSum = $sum;
			$identifiant = $row[3];
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
					if(preg_match($pattern1,$Oneparti)) {
						calcul_RN(&$sum,$Oneparti);
					}
					$pattern2 = "/BNS_([0-9]*)/";
					if(preg_match($pattern2,$Oneparti)) {
						calcul_BNS(&$sum,$Oneparti);
					}
					$pattern3 = "/BNNS_([0-9]*)/";
					if(preg_match($pattern3,$Oneparti)) {
						calcul_BNNS(&$sum,$Oneparti);
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
									case "+":
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
					if(preg_match($pattern8,$Oneparti)) {
						calcul_BNSMC(&$sum,$Oneparti);
						
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
							$sum=(float)$sum+(float)$objet_infos_compta->mtDebitReport+(float)$objet_infos_compta->mtCreditReport;
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
			$valeurSum = $sum;
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
					calcul_RN(&$sum,$Oneparti);
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
		$valeur = $sum;
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
				if(preg_match($pattern2,$Oneparti)) {
					calcul_BNS(&$sum,$Oneparti);
				}
				$pattern3 = "/BNSMC_([0-9]*)/";
				if(preg_match($pattern3,$Oneparti)) {
					calcul_BNSMC(&$sum,$Oneparti);
					
				}
				$pattern4 = "/BNSMD_([0-9]*)/";
				if(preg_match($pattern4,$Oneparti)) {
					calcul_BNSMD(&$sum,$Oneparti);
				}
				$pattern5 = "/TF([0-9]*)/";
				if(preg_match($pattern5,$Oneparti)) {
					calcul_TF(&$sum,$Oneparti);
				}
				$pattern6 = "/RN_/";
				if(preg_match($pattern6,$Oneparti))
				{
					calcul_RN(&$sum,$Oneparti);
				}
				$pattern7 = "/BNSD_([0-9]*)/";
				if(preg_match($pattern7,$Oneparti)) {
					calcul_BNSD(&$sum,$Oneparti);
				}
				$pattern8 = "/BNNSDR_([0-9]*)/";
				if(preg_match($pattern8,$Oneparti)) {
					calcul_BNNSDR(&$sum,$Oneparti);
				}
				$pattern9 = "/BNNS_([0-9]*)/";
				if(preg_match($pattern9,$Oneparti)) {
					calcul_BNNS(&$sum,$Oneparti);
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
						$sum = (float)$sum+(float)($objet_infos_compta->mtDebit)+(float)($objet_infos_compta->mtCredit);
					}
				}
			}
			$pattern4 = "/^FL(0-9)*/";
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
		$valeurSum = $sum;
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
		if($infos_analytique->atelier!=$atelier) {
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
	$_SESSION[C_SESSION_ASSOLEMENT] = $assolement;

	//main d'oeuvre : permanante->temps->salarié et temporaire->temps->salarié
	//TODO main d'oeuvre

	//fin des calculs - le reste des infos de la page provient de la saisie
}

/**
 * @todo Calculs pour "Analyse technico-economique"
 */
function analyse_technico_economique() {
	//Activite rentabilite globale => reprise soldes intermediaires
	//charges globales => balance analytique (compte et atelier)
	//marge brute => balance analytique (compte, atelier et activite)
	//marge nette => marge brute + balance analytique

	//$Ecorche_finace = new ecorche_financ();
	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	$query = "select ID,NOM_FORMULE,FORMULE,SYMBOLE from ANALYSE_TECHNICO";
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
				//si "/BAN_([0-9]*)/";
				//si "ATELIER_N"
				//si "ACTIVITE_N"
				//chercher si en 1er s'il y a des conditions par rapport aux atelier ou aux activite
				// et en faire une liste
				//$ateliers

				$pattern1 = "/BAN_([0-9]*)/";
				if(preg_match($pattern1,$Oneparti)) {
					$signe = substr($Oneparti,0,1);

					if($signe=="+" || $signe=="-") {//on enleve le signe
						$oneTerme = substr($Oneparti,1);
					} else { //pas de signe
						$oneTerme = $Oneparti;
					}

					foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_analytique as $infos_analytique) {
						$compte = substr($oneTerme,4,-1);
						$pattern = "/^".$compte."([0-9]*)/";
						if(preg_match($pattern,$infos_analytique->compte)) {
							if($signe=="+")
							$sum = (float)$sum + (float)$infos_analytique->total_charges+(float)$infos_analytique->total_produits;
							else if($signe=="-")
							$sum = (float)$sum - (float)$infos_analytique->total_charges-(float)$infos_analytique->total_produits;
							else
							$sum = (float)$sum + (float)$infos_analytique->total_charges+(float)$infos_analytique->total_produits;
						}

					}
				}



			}
		} else {// pas de "+" ni de "-" => pas de formule, valeur à récupérer directement
			//$pattern5 = "/C[^NS]([0-9]*)/";
		}
		//		$objetLigne = new ligne_ecorche_financ();
		//		$libelle = $row[1];
		//		$valeurSum = $sum;
		//		$identifiant = $row[3];
		//		$objetLigne->ajout_contenu($libelle,$valeurSum,$identifiant);
		//		$Ecorche_finace->ajout_contenu_ecorche($identifiant,$objetLigne);
		//		$_SESSION[C_SESSION_TABLEAU_FINANCEMENT] = $Ecorche_finace;
		//		echo "<".$objetLigne->valeur.">--".$objetLigne->identifiant."<br>";
		echo $row[3]."**".$sum."<br>";
		$row =  mysql_fetch_row($result);
	}
}

/**
 * @todo Calculs pour "Marge nette"
 */
function marge_nette() {

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
echo "========================= analyse_technico_economique ======================<BR>";
analyse_technico_economique();
?>