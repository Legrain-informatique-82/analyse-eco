<?php
/***************************************************************************/
/* Création du fichier XML final à partir des résultats stockés en session */
/***************************************************************************/

//session_start();
include_once("analyse_eco.php");
include_once("class_inter.php");
include_once("connection.php");

//session_start();
include_once("Debutobjet.php");
//include_once("Debutobjet_fonctions.php");
/*lire_xml();
 soldes_inter();
 bilans_comp();*/
//session_start();
define('C_LIB_DB','LIB_DB');

//$dom = new DOMDocument('1.0','iso-8859-1');
$dom = new DOMDocument('1.0','utf-8');
//$dom = new DOMDocument('1.0');

$donnees_economique = $dom->createElement("analyse-economique");
$dom->appendChild($donnees_economique);
$donnees_economique->setAttribute("version","");

$db_conn = connection1();
mysql_select_db(C_DB_BASE,$db_conn);

/**
 * Ajoute un noeud texte
 * $domDocument - document DOM (DOMDocument)
 * $parentNode - noeud parent
 * $libelle - texte de la balise
 * $valeur - contenu à l'intérieur de la balise
 * Retourne le nouveau noeud
 */
function addTextNode($domDocument,$parentNode,$libelleNode,$valeurNode) {
	$elemNode = $domDocument->createElement($libelleNode);
	$parentNode->appendChild($elemNode);
	$contenuNode = $domDocument->createTextNode($valeurNode);
	$elemNode->appendChild($contenuNode);
	return $elem;
}

/**
 * Création de la structure d'un tableau dans le document DOM. La valeur des éléments du tableau est recherché dans la session.
 * Utilise la table "tableaux" dans la base de données.
 * 
 * @param $cnx - connexion à la base MySQL
 * @param $domDoc - document DOM (DOMDocument)
 * @param $xmlPere - noeud parent
 * @param $varSession - nom de la variable de session dans laquelle chercher les valeur à affichier, la variable doit avoir une methode getValeurLigne() : $_SESSION[$varSession]->getValeurLigne($a);
 * @param $page - nom de la page dans laquelle se trouve le tableau => colonne page dans la bdd
 * @param $tableau - nom du tableau dans cette page => colonne tableau dans la bdd
 * @param $balise - nom de la balise représentant le tableau (ajouter sous $xmlPere)
 * @param $baliseElem - nom de la balise des éléments à l'intérieur du tableau (ex : ligne)
 * @param $lib - nom de la balise de libelle de l'élément s'il doit etre affiché, sinon NULL, la valeur C_LIB_DB utilise libelle comme nom de balise et prends la valeur dans la bdd et nom dans la session 
 * @param $val1=NULL - nom de la balise pour la valeur1 de l'élément
 * @param $val2=NULL - nom de la balise pour la valeur2 de l'élément
 * @param $val3=NULL - nom de la balise pour la valeur3 de l'élément
 * @param $val4=NULL - nom de la balise pour la valeur4 de l'élément
 * @param $val5=NULL - nom de la balise pour la valeur5 de l'élément
 * @param $val6=NULL - nom de la balise pour la valeur6 de l'élément
 * @param $val7=NULL - nom de la balise pour la valeur7 de l'élément
 * @param $val8=NULL - nom de la balise pour la valeur8 de l'élément
 * @param $val9=NULL - nom de la balise pour la valeur9 de l'élément
 * @param $val10=NULL - nom de la balise pour la valeur10 de l'élément
 * 
 * @example
 * <xmlPere>
 * 	<balise>
 * 		<baliseElem>
 * 			<lib>valeur de la session ou de la bdd si C_LIB_DB</lib>
 * 			<val1>valeur de la session</val1>
 * 			...
 * 		</baliseElem>
 * 		...
 * 	</balise>
 * </xmlPere>
 */
function tableau_xml($cnx,$domDoc,$xmlPere,$varSession,$page,$tableau,$balise,$baliseElem,$lib,$val1=NULL,$val2=NULL,$val3=NULL,$val4=NULL,$val5=NULL,$val6=NULL,$val7=NULL,$val8=NULL,$val9=NULL,$val10=NULL) {
	echo "tableau_xml - $tableau <br>";
	$query = "select id,libelle,valeur_1,valeur_2,valeur_3,valeur_4,valeur_5,valeur_6,valeur_7,valeur_8,valeur_9,valeur_10,affichage from tableaux where page='$page' and tableau='$tableau'";
	$result = mysql_query($query,$cnx);
	$tableau = $domDoc->createElement($balise);
	$xmlPere->appendChild($tableau);
	while($row=mysql_fetch_row($result)) {
		//echo "ligne<br>";
		$ligne = $domDoc->createElement($baliseElem);
		$tableau->appendChild($ligne);
		
		if($lib!=NULL) {
			if($lib==C_LIB_DB)
				addTextNode($domDoc,$ligne,"libelle",$row[1]);
			else
				addTextNode($domDoc,$ligne,$lib,$_SESSION[$varSession]->getValeurLigne($row[1]));
		}
		if($val1!=NULL)
			addTextNode($domDoc,$ligne,$val1,$_SESSION[$varSession]->getValeurLigne($row[2]));
		if($val2!=NULL)
			addTextNode($domDoc,$ligne,$val2,$_SESSION[$varSession]->getValeurLigne($row[3]));
		if($val3!=NULL)
			addTextNode($domDoc,$ligne,$val3,$_SESSION[$varSession]->getValeurLigne($row[4]));
		if($val4!=NULL)
			addTextNode($domDoc,$ligne,$val4,$_SESSION[$varSession]->getValeurLigne($row[5]));
		if($val5!=NULL)
			addTextNode($domDoc,$ligne,$val5,$_SESSION[$varSession]->getValeurLigne($row[6]));
		if($val6!=NULL)
			addTextNode($domDoc,$ligne,$val6,$_SESSION[$varSession]->getValeurLigne($row[7]));
		if($val7!=NULL)
			addTextNode($domDoc,$ligne,$val7,$_SESSION[$varSession]->getValeurLigne($row[8]));
		if($val8!=NULL)
			addTextNode($domDoc,$ligne,$val8,$_SESSION[$varSession]->getValeurLigne($row[9]));
		if($val9!=NULL)
			addTextNode($domDoc,$ligne,$val9,$_SESSION[$varSession]->getValeurLigne($row[10]));
		if($val10!=NULL)
			addTextNode($domDoc,$ligne,$val10,$_SESSION[$varSession]->getValeurLigne($row[11]));

	}
}

/***********/
/* Dossier */
/***********/
$dossier = $dom->createElement('dossier');
$donnees_economique->appendChild($dossier);
addTextNode($dom,$dossier,"adherent",$_SESSION[C_SESSION_INFOS_DOSSIER]->adherent);
addTextNode($dom,$dossier,"annee",$_SESSION[C_SESSION_INFOS_DOSSIER]->annee);
addTextNode($dom,$dossier,"adresse-centre-cogere",$_SESSION[C_SESSION_INFOS_DOSSIER]->adresse_cogere);
addTextNode($dom,$dossier,"tel-centre-cogere",$_SESSION[C_SESSION_INFOS_DOSSIER]->telephone_cogere);

/***********************/
/* Dossier XML initial */
/***********************/
$dossier_xml = $dom->createElement('liste_infos_dossier');
$donnees_economique->appendChild($dossier_xml);
foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_dossier as $cle => $infos_dossier)
{
	$info = $dom->createElement("info");
	$dossier_xml->appendChild($info);
	addTextNode($dom,$info,"cle",$infos_dossier->cle);
	addTextNode($dom,$info,"valeur1",$infos_dossier->valeur);
}

/*********/
/* Pages */
/*********/
$pages = $dom->createElement('pages');
$donnees_economique->appendChild($pages);

/********************************/
/* //TODO Descriptif de l'exploitation */
/********************************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("decriptif exploitation");
$nom->appendChild($nom_page);

$desc = $dom->createElement("descriptif-exploitation");
$page->appendChild($desc);


$faire_valoir = $dom->createElement("faire-valoir");
$desc->appendChild($faire_valoir);
addTextNode($dom,$faire_valoir,"propriete",$_SESSION[C_SESSION_FAIRE_VALOIR]->propriete);
addTextNode($dom,$faire_valoir,"fermage",$_SESSION[C_SESSION_FAIRE_VALOIR]->fermage);
addTextNode($dom,$faire_valoir,"mise-a-disp-prop",$_SESSION[C_SESSION_FAIRE_VALOIR]->mise_a_disp_prop);
addTextNode($dom,$faire_valoir,"mise-a-disp-ferm",$_SESSION[C_SESSION_FAIRE_VALOIR]->mise_a_disp_ferm);
addTextNode($dom,$faire_valoir,"metayage",$_SESSION[C_SESSION_FAIRE_VALOIR]->metayage);
addTextNode($dom,$faire_valoir,"total-sau",$_SESSION[C_SESSION_FAIRE_VALOIR]->total_sau);
addTextNode($dom,$faire_valoir,"non-sau",$_SESSION[C_SESSION_FAIRE_VALOIR]->non_sau);
addTextNode($dom,$faire_valoir,"dont-bois",$_SESSION[C_SESSION_FAIRE_VALOIR]->dont_bois);
addTextNode($dom,$faire_valoir,"total-surface",$_SESSION[C_SESSION_FAIRE_VALOIR]->total_surface);

$assolement = $dom->createElement("assolement");
$desc->appendChild($assolement);
addTextNode($dom,$assolement,"total",$_SESSION[C_SESSION_ASSOLEMENT]->total_surface);
foreach ($_SESSION[C_SESSION_ASSOLEMENT]->liste_assolement as $ligne_assolement) {
	$ligne = $dom->createElement("ligne");
	$assolement->appendChild($ligne);
	addTextNode($dom,$ligne,"culture",$ligne_assolement->culture);
	addTextNode($dom,$ligne,"surface",$ligne_assolement->surface);
	addTextNode($dom,$ligne,"derobe",$ligne_assolement->derobe);
	addTextNode($dom,$ligne,"irrigue",$ligne_assolement->irrigue);
	addTextNode($dom,$ligne,"rdt",$ligne_assolement->rdt);
}



$stocks_produits = $dom->createElement("stocks-produits");
$desc->appendChild($stocks_produits);
foreach ($_SESSION[C_SESSION_STOCKS]->liste_stocks as $ligne_stock) {
	$ligne = $dom->createElement("ligne");
	$stocks_produits->appendChild($ligne);
	addTextNode($dom,$ligne,"libelle",$ligne_stock->libelle);
	addTextNode($dom,$ligne,"qte-deb",$ligne_stock->qte_deb);
	addTextNode($dom,$ligne,"entrees-a",$ligne_stock->entrees_a);
	addTextNode($dom,$ligne,"entrees-n",$ligne_stock->entrees_n);
	addTextNode($dom,$ligne,"entrees-ch",$ligne_stock->entrees_ch);
	addTextNode($dom,$ligne,"entrees-pr",$ligne_stock->entrees_pr);
	addTextNode($dom,$ligne,"sorties-v",$ligne_stock->sorties_v);
	addTextNode($dom,$ligne,"sorties-pe",$ligne_stock->sorties_pe);
	addTextNode($dom,$ligne,"sorties-co",$ligne_stock->sorties_co);
	addTextNode($dom,$ligne,"sorties-ch",$ligne_stock->sorties_ch);
	addTextNode($dom,$ligne,"sorties-ci",$ligne_stock->sorties_ci);
	addTextNode($dom,$ligne,"qte-fin",$ligne_stock->qte_fin);
	addTextNode($dom,$ligne,"tx-perte",$ligne_stock->tx_perte);
}

$main_oeuvre = $dom->createElement("main-oeuvre");
$desc->appendChild($main_oeuvre);
foreach ($_SESSION[C_SESSION_MAIN_OEUVRE]->lignes_main_oeuvre as $ligne_main_oeuvre) {
	$ligne = $dom->createElement("ligne");
	$main_oeuvre->appendChild($ligne);
	addTextNode($dom,$ligne,"libelle",$ligne_main_oeuvre->libelle);
	addTextNode($dom,$ligne,"perm_nombre",$ligne_main_oeuvre->perm_nombre); 
	addTextNode($dom,$ligne,"perm_temps",$ligne_main_oeuvre->perm_temps);
	addTextNode($dom,$ligne,"perm_uth",$ligne_main_oeuvre->perm_uth);
	addTextNode($dom,$ligne,"temp_nombre",$ligne_main_oeuvre->temp_nombre);
	addTextNode($dom,$ligne,"temp_temps",$ligne_main_oeuvre->temp_temps);
	addTextNode($dom,$ligne,"temp_uth",$ligne_main_oeuvre->temp_uth);
	addTextNode($dom,$ligne,"total_nombre",$ligne_main_oeuvre->total_nombre);
	addTextNode($dom,$ligne,"total_temps",$ligne_main_oeuvre->total_temps);
	addTextNode($dom,$ligne,"total_uth",$ligne_main_oeuvre->total_uth);
}

/***************/
/* //TODO Bilan actif */
/***************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("liasse fiscale");
$nom->appendChild($nom_page);

$bilan = $dom->createElement("liasse");
$page->appendChild($bilan);
//print_r($_SESSION[C_SESSION_XML_INITIAL]);

foreach($_SESSION[C_SESSION_XML_INITIAL]->liste_infos_liasse as $cle => $infos_liasse)
{
	$ligne = $dom->createElement($cle);
	$bilan->appendChild($ligne);
	addTextNode($dom,$ligne,"valeur",$infos_liasse->objetRepatition->valeur);
}
/****************/
/* Bilan passif */
/****************/

/*************************/
/* Compte d'exploitation */
/*************************/

/*************************/
/* Compte d'exploitation */
/*************************/

/***********************************/
/* Soldes intermediares de gestion */
/***********************************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("soldes intermediaires de gestion");
$nom->appendChild($nom_page);

$solds = $dom->createElement("soldes-intermediaires");
$page->appendChild($solds);

foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
{//creation d'un tableau avec des nombres en index, cela permettra de parcourrir plusieurs tableau (n,n-1,n-2) en meme temps
	$pattern = "/^B([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$annee_N[] = $symbole_identifiant->valeur;
	}
}

foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter2 as $symbole => $symbole_identifiant)
{
	$pattern = "/^C([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$annee_N_1[] = $symbole_identifiant->valeur;
	}
}

foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter3 as $symbole => $symbole_identifiant)
{
	$pattern = "/^D([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$annee_N_2[] = $symbole_identifiant->valeur;
	}
}

foreach($_SESSION[C_SESSION_SOLDES_INTERMEDIAIRES]->contenu_inter1 as $symbole => $symbole_identifiant)
{
	$pattern = "/^B([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$contenu_libelle[] = $symbole_identifiant->libelle;
		$nombre_tableau = count($contenu_libelle);
	}
}
for($i=0;$i<$nombre_tableau;$i++)
{
	$ligne = $dom->createElement('ligne');
	$solds->appendChild($ligne);
	
	addTextNode($dom,$ligne,"libelle",$contenu_libelle[$i]);
	addTextNode($dom,$ligne,"valeur-n",$annee_N[$i]);
	addTextNode($dom,$ligne,"valeur-n-1",$annee_N_1[$i]);
	addTextNode($dom,$ligne,"valeur-n-2", $annee_N_2[$i]);

}

/*******************************/
/* //TODO Analyse Technico-economique */
/*******************************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("analyse-technico");
$nom->appendChild($nom_page);

$ate = $dom->createElement("analyse-technico");
$page->appendChild($ate);
tableau_xml($db_conn,$dom,$ate,C_SESSION_ACTIVITE_GLOBALE,"ATE","activite_globale","activite_globale","ligne",C_LIB_DB,"y1","y2","y3");
addTextNode($dom,$ate,"resultat_exploitation", $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->resultat_exploitation);
addTextNode($dom,$ate,"CA_HT", $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->CA_HT);
addTextNode($dom,$ate,"tx_rentabilite_eco", $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->tx_rentabilite_eco);
addTextNode($dom,$ate,"commentaire", $_SESSION[C_SESSION_ACTIVITE_GLOBALE]->commentaire);

tableau_xml($db_conn,$dom,$ate,C_SESSION_CHARGES_GLOBALES,"ATE","charges_globales","charges_globales","ligne",C_LIB_DB,"n","n-hectare","n-1","var1","n-2","var2");

tableau_xml($db_conn,$dom,$ate,C_SESSION_CHARGES_GLOBALES,"ATE","charge_globale_graph","charge_globale_graph","ligne",C_LIB_DB,"valeur");

addTextNode($dom,$ate,"marge_brute_totale", $_SESSION[C_SESSION_MARGE_BRUTE]->marge_brute_totale);
addTextNode($dom,$ate,"marge_brute_moins_structure", $_SESSION[C_SESSION_MARGE_BRUTE]->marge_brute_moins_structure);
addTextNode($dom,$ate,"resultat_net", $_SESSION[C_SESSION_MARGE_BRUTE]->resultat_net);

$marge_brute_graph = $dom->createElement('marge_brute_graph');
$ate->appendChild($marge_brute_graph);

foreach($_SESSION[C_SESSION_MARGE_BRUTE]->productions as $cle => $ligne_marge_brute_graph) {
	$ligne = $dom->createElement('ligne');
	$marge_brute_graph->appendChild($ligne);
	addTextNode($dom,$ligne,"libelle", $ligne_marge_brute_graph->libelle);
	addTextNode($dom,$ligne,"valeur", $ligne_marge_brute_graph->valeur);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$marge_nette = $dom->createElement('marge_nette');
$ate->appendChild($marge_nette);

foreach($_SESSION[C_SESSION_MARGE_PRODUCTION]->contenu_marge_nette as $cle => $ligne_marge_nette) {
	$ligne = $dom->createElement('ligne');
	$marge_nette->appendChild($ligne);
	addTextNode($dom,$ligne,"libelle", $ligne_marge_nette->libelle);
	addTextNode($dom,$ligne,"marge_brute_u", $ligne_marge_nette->marge_brute_u);
	addTextNode($dom,$ligne,"charge_structure_u", $ligne_marge_nette->charge_structure_u);
	addTextNode($dom,$ligne,"produits_structurels_u", $ligne_marge_nette->produits_structurels_u);
	addTextNode($dom,$ligne,"marge_nette_u", $ligne_marge_nette->marge_nette_u);
	addTextNode($dom,$ligne,"marge_nette", $ligne_marge_nette->marge_nette);
}

/***************/
/* //TODO Marge nette */
/***************/

/***************************/
/* Tableau flux financiers */
/***************************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("flux financiers");
$nom->appendChild($nom_page);

$ff = $dom->createElement("flux-financiers");
$page->appendChild($ff);

//tableau_xml($db_conn,$dom,$ff,C_SESSION_TABLEAU_FLUX,"tableau_flux","exercice","exercice","ligne","libelle","emplois","ressources",NULL,NULL);


foreach($_SESSION[C_SESSION_TABLEAU_FLUX]->contenu_flux as $cle => $ligne_ecorche_flux)
{
	$pattern = "/^FL([0-9]*)/";
	if(preg_match($pattern,$cle))
	{
		
		$ligne = $dom->createElement($cle);
		$ff->appendChild($ligne);
		addTextNode($dom,$ligne,"valeur", $ligne_ecorche_flux->valeur);
	}
}

/********************/
/* Bilan comparatif */
/********************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("bilan comparatif");
$nom->appendChild($nom_page);

$bilan = $dom->createElement("bilan-comparatif");
$page->appendChild($bilan);

	$db_conn = connection1();
	mysql_select_db(C_DB_BASE,$db_conn);
	
	tableau_xml($db_conn,$dom,$bilan,C_SESSION_BILAN_COMPARATIF,"bilans_comparatifs","actif","actif","ligne",C_LIB_DB,"n","n-1","n-2");
	tableau_xml($db_conn,$dom,$bilan,C_SESSION_BILAN_COMPARATIF,"bilans_comparatifs","passif","passif","ligne",C_LIB_DB,"n","n-1","n-2");
	tableau_xml($db_conn,$dom,$bilan,C_SESSION_BILAN_COMPARATIF,"bilans_comparatifs","totaux","totaux","ligne",C_LIB_DB,"n","n-1","n-2");
	tableau_xml($db_conn,$dom,$bilan,C_SESSION_BILAN_COMPARATIF,"bilans_comparatifs","fonds_roulement","fonds_roulement","ligne",C_LIB_DB,"n","n-1","n-2");
	tableau_xml($db_conn,$dom,$bilan,C_SESSION_BILAN_COMPARATIF,"bilans_comparatifs","variation_fr","variation_fr","ligne",C_LIB_DB,"n","n-1","n-2");

/*********************/
/* Ratios financiers */
/*********************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("ratios financiers");
$nom->appendChild($nom_page);

$ratios = $dom->createElement("ratios-financiers");
$page->appendChild($ratios);

foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
{
	$pattern = "/^RF([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$annee_N_Ratios[] = $symbole_identifiant->valeur;
	}
}
foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios2 as $symbole => $symbole_identifiant)
{
	$pattern = "/^RF([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$annee_N_1_Ratios[] = $symbole_identifiant->valeur;
	}
}
foreach($_SESSION[C_SESSION_RATIOS]->contenu_ratios1 as $symbole => $symbole_identifiant)
{
	$pattern = "/^RF([0-9]*)/";
	if(preg_match($pattern,$symbole_identifiant->identifiant))
	{
		$contenu_libelle_ratios[] = $symbole_identifiant->libelle;
		$nombre_tableau_ratios = count($contenu_libelle_ratios);
	}
}
for($i=0;$i<$nombre_tableau_ratios;$i++)
{
	$ligne = $dom->createElement('ligne');
	$ratios->appendChild($ligne);
	
	addTextNode($dom,$ligne,"libelle", $contenu_libelle_ratios[$i]);
	addTextNode($dom,$ligne,"valeur-n", $annee_N_Ratios[$i]);
	addTextNode($dom,$ligne,"valeur-n-1", $annee_N_1_Ratios[$i]);
	//TODO n-2 ratios financiers
	addTextNode($dom,$ligne,"valeur-n-2", ""); //$annee_N_2_Ratios[$i]
}

/***********************/
/* Tableau financement */
/***********************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("tableau de financement");
$nom->appendChild($nom_page);

$tf = $dom->createElement("tableau-financement");
$page->appendChild($tf);

foreach($_SESSION[C_SESSION_TABLEAU_FINANCEMENT]->contenu_ecorche as $cle => $ligne_ecorche_financ) {
	
	$pattern = "/^TF([0-9]*)/";
	if(preg_match($pattern,$cle)) {
		$ligne = $dom->createElement($cle);
		$tf->appendChild($ligne);
		addTextNode($dom,$ligne,"valeur", $ligne_ecorche_financ->valeur);
	}
	
}

/************/
/* Synthèse */
/************/
$page = $dom->createElement("page");
$pages->appendChild($page);
$nom = $dom->createAttribute("nom");
$page->appendChild($nom);
$nom_page = $dom->createTextNode("synthèse");
$nom->appendChild($nom_page);

$synthese = $dom->createElement("synthese");
$page->appendChild($synthese);

addTextNode($dom,$synthese,"commentaire", $_SESSION[C_SESSION_COMMENTAIRE_FINAL]->commentaire);


/*****************************/
/* Sauvegarde du fichier XML */
/*****************************/
$dom->save("xml/test1.xml");
//$dom->save("/tmp/test1.xml");

?>