<?php
/**********************************************************************/
/* Classes/objets correspondant au stockage des résultats des calculs */
/**********************************************************************/


//abstract class result_analyse_eco {
//	/**
//	 * Retourne le champs 'valeur' de l'objet ayany pour cle $id,
//	 * dans la liste d'objet gérée par cette classe.
//	 * @param String $id
//	 * @return la valeur de la ligen $id
//	 */
//	abstract public function getValeur($id);
//}

class infos_dossier {
	public $adherent;
	public $annee;
	public $adresse_cogere;
	public $telephone_cogere;
	
	function set_valeur_attribu($attrib1,$attrib2,$attrib3,$attrib4)
	{
		$this->adherent = $attrib1;
		$this->annee = $attrib2;
		$this->adresse_cogere = $attrib3;
		$this->telephone_cogere = $attrib4;
	}
}

/**
 * Soldes intermédiaire de gestion
 */
class solids_inter /*extends result_analyse_eco*/
{
	public $contenu_inter1 = array();
	public $contenu_inter2 = array();
	public $contenu_inter3 = array();

	function ajout_contenu_inter1($attrib1,$attrib2)
	{
		$this->contenu_inter1[$attrib1] = $attrib2;
	}
	function ajout_contenu_inter2($attrib1,$attrib2)
	{
		$this->contenu_inter2[$attrib1] = $attrib2;
	}
	function ajout_contenu_inter3($attrib1,$attrib2)
	{
		$this->contenu_inter3[$attrib1] = $attrib2;
	}
}

class ligne_solids_inter
{
	public $libelle;
	public $valeur;
	public $identifiant;

	function ajout_contenu($attrib1,$attrib2,$attrib3)
	{
		$this->libelle = $attrib1;
		$this->valeur = $attrib2;
		$this->identifiant = $attrib3;
	}

}

/**
 * Bilan comparatif
 */
class bilans_compartifs /*extends result_analyse_eco*/
{
	public $contenu_bilan = array();

	function ajout_contenu_bilan($attrib1,$attrib2)
	{
		$this->contenu_bilan[$attrib1] = $attrib2;
	}
	
	
	function getValeurLigne($id) {
		return $this->contenu_bilan[$id]->valeur;
	}
}

class ligne_bilans_comparatifs
{
	public $libelle;
	public $valeur;
	public $identifiant;

	function ajout_contenu($attrib1,$attrib2,$attrib3)
	{
		$this->libelle = $attrib1;
		$this->valeur = $attrib2;
		$this->identifiant = $attrib3;
	}
}

/**
 * Flux financiers
 */
class ecorche_flux
{
	public $contenu_flux =array();

	function ajout_contenu_flux($attrib1,$attrib2)
	{
		$this->contenu_flux[$attrib1] = $attrib2;
	}

	function getValeurLigne($id) {
		return $this->contenu_flux[$id]->valeur;
	}
}
class ligne_ecorche_flux
{
	public $libelle;
	public $valeur;
	public $identifiant;

	function ajout_contenu($attrib1,$attrib2,$attrib3)
	{
		$this->libelle = $attrib1;
		$this->valeur = $attrib2;
		$this->identifiant = $attrib3;
	}
}

/**
 * Ratios financiers
 */
class ratios_financ
{
	public $contenu_ratios1 = array();
	public $contenu_ratios2 = array();

	function ajout_contenu_ratios1($attrib1,$attrib2)
	{
		$this->contenu_ratios1[$attrib1] = $attrib2;
	}
	function ajout_contenu_ratios2($attrib1,$attrib2)
	{
		$this->contenu_ratios2[$attrib1] = $attrib2;
	}
}
class ligne_ratios_financ
{
	public $libelle;
	public $valeur;
	public $identifiant;

	function ajout_contenu($attrib1,$attrib2,$attrib3)
	{
		$this->libelle = $attrib1;
		$this->valeur = $attrib2;
		$this->identifiant = $attrib3;
	}
}

/**
 * Tableau de financement
 */
class ecorche_financ
{
	public $contenu_ecorche = array();

	function ajout_contenu_ecorche($attrib1,$attrib2)
	{
		$this->contenu_ecorche[$attrib1] = $attrib2;
	}
}
class ligne_ecorche_financ
{
	public $libelle;
	public $valeur;
	public $identifiant;

	function ajout_contenu($attrib1,$attrib2,$attrib3)
	{
		$this->libelle = $attrib1;
		$this->valeur = $attrib2;
		$this->identifiant = $attrib3;
	}
}


//Dans page1,pour le tabeau de Mode faire valoir
class faire_valoir {
	public $propriete;
	public $fermage;
	public $mise_a_disp_prop;
	public $mise_a_disp_ferm;
	public $metayage;
	public $total_sau;
	public $non_sau;
	public $dont_bois;
	public $total_surface;
		
	//pour set des valeurs de atrribut.EX-$propriete...
	function Set_valeur($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7)
	{
		$this->propriete = (float)$attrib1;
		$this->fermage = (float)$attrib2;
		$this->mise_a_disp_prop = (float)$attrib3;
		$this->mise_a_disp_ferm = (float)$attrib4;
		$this->metayage = (float)$attrib5;
		$this->non_sau = (float)$attrib6;
		$this->dont_bois = (float)$attrib7;
		/*$this->total_sau = $this->propriete + $this->fermage + $this->mise_a_disp_prop + $this->mise_a_disp_ferm +$this->metayage;
		$this->total_surface = $this->non_sau - $this->dont_bois;*/
		$this->somme_total_sau();
		$this->somme_total_surface();
	}
	//pour caluler la somme de Total SAU
	function somme_total_sau()
	{
		(float)$this->total_sau = $this->propriete + $this->fermage + $this->mise_a_disp_prop + $this->mise_a_disp_ferm +$this->metayage;
		return($this->total_sau);
	}
	// pour calculer la somme de Total surface exploitat
	function somme_total_surface()
	{
		(float)$this->total_surface = $this->non_sau - $this->dont_bois;
		return ($this->total_surface);
	}
	//pour afficher l'infos de cette class
	function affichi_infos()
	{
		echo "propriete".$this->propriete."<br>";
		echo "fermage".$this->fermage."<br>";
		echo "mise_a_disp_prop".$this->mise_a_disp_prop."<br>";
		echo "mise_a_disp_ferm".$this->mise_a_disp_ferm."<br>";
		echo "metayage".$this->metayage."<br>";
		echo "total_sau".$this->total_sau."<br>";
		echo "non_sau".$this->non_sau."<br>";
		echo "dont_bois".$this->dont_bois."<br>";
		echo "Total surface exploitat".$this->total_surface."<br>";
	}
	
}

class stocks_produits {
	public $liste_stocks = array();
	/*
	 * $indic est libelle
	 */
	function ajout_ligne_produit($objet_ligne_stock,$indic)
	{
		$this->liste_stocks[$indic] = $objet_ligne_stock;
	}
	function modifi_ligne_produit($objet_ligne_stock,$indic)
	{
		$this->ajout_ligne_produit($objet_ligne_stock,$indic);
	}
	function suppri_ligne_produit($indic)
	{
		unset($this->liste_stocks[$indic]);
	}
}

class ligne_stock {
	public $libelle;
	public $qte_deb;
	public $entrees_a;
	public $entrees_n;
	public $entrees_ch;
	public $entrees_pr;
	public $sorties_v;
	public $sorties_pe;
	public $sorties_co;
	public $sorties_ch;
	public $sorties_ci;
	public $qte_fin;
	public $tx_perte;
	
	function set_valeur($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7,$attrib8,$attrib9,$attrib10,$attrib11,$attrib12,$attrib13)
	{
		$this->libelle = (string)$attrib1;
		$this->qte_deb = (int)$attrib2;
		$this->entrees_a = (int)$attrib3;
		$this->entrees_n = (int)$attrib4;
		$this->entrees_ch = (int)$attrib5;
		$this->entrees_pr = (int)$attrib6;
		$this->sorties_v = (int)$attrib7;
		$this->sorties_pe = (int)$attrib8;
		$this->sorties_co = (int)$attrib9;
		$this->sorties_ch = (int)$attrib10;
		$this->sorties_ci = (int)$attrib11;
		$this->qte_fin = (int)$attrib12;
		$this->tx_perte = (int)$attrib13;
	}
	
	/*
	 *	modifier les valeur de ligne stock 
	 */
	function modifi_ligne_stock($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7,$attrib8,$attrib9,$attrib10,$attrib11,$attrib12,$attrib13)
	{
		//$this->set_valeur($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7,$attrib8,$attrib9,$attrib10,$attrib11,$attrib12,$attrib13);
		$this->libelle = (string)$attrib1;
		$this->qte_deb = (int)$attrib2;
		$this->entrees_a = (int)$attrib3;
		$this->entrees_n = (int)$attrib4;
		$this->entrees_ch = (int)$attrib5;
		$this->entrees_pr = (int)$attrib6;
		$this->sorties_v = (int)$attrib7;
		$this->sorties_pe = (int)$attrib8;
		$this->sorties_co = (int)$attrib9;
		$this->sorties_ch = (int)$attrib10;
		$this->sorties_ci = (int)$attrib11;
		$this->qte_fin = (int)$attrib12;
		$this->tx_perte = (int)$attrib13;
	}
}

//****************pour le tableau ASSOLEMENT*********************//
class assolement {
	public $liste_assolement = array();
	public $total_surface;
	
	//pour ajouter un ligne(objet ligne_assolement) dans le tableau de ASSOLEMENT
	function ajout_ligne($objet_ligne_assolement,$indic)
	{
		//modifi_ligne($objet_ligne_assolement,$indic);
		$this->liste_assolement[$indic] = $objet_ligne_assolement;
		$this->valeur_total_surface();
	}
	//pour modifier un ligne(objet ligne_assolement) dans le tableau de ASSOLEMENT
	function modifi_ligne($objet_ligne_assolement,$indic)
	{
		$this->ajout_ligne($objet_ligne_assolement,$indic);
		$this->valeur_total_surface();
		//$liste_assolement[$indic] = $objet_ligne_assolement;
	}
	//pour supprimer un ligne dans le tableau de ASSOLEMENT
	function supprime_ligne($indic)
	{
		unset($this->liste_assolement[$indic]);
		$this->valeur_total_surface();
	}
	function valeur_total_surface()
	{
		$this->total_surface = 0;
		foreach($this->liste_assolement as $valeur)
		{
			$this->total_surface += $valeur->surface; 
		}
		return($this->total_surface);
	}
}
//pour chaque ligne de tableau de ASSOLEMENT
class ligne_assolement{
	public $culture;
	public $surface;
	public $derobe;
	public $irrigue;
	public $rdt;
	
	//pour set les valeur de proprite
	function set_valeur($attrib1,$attrib2,$attrib3,$attrib4,$attrib5)
	{
		$this->culture = (string)$attrib1;
		$this->surface = (float)$attrib2;
		$this->derobe = (float)$attrib3;
		$this->irrigue = (float)$attrib4;
		$this->rdt = (float)$attrib5;
	}
	
	function __construct($culture=NULL,$surface=NULL) {
		$this->culture = $culture;
		$this->surface = $surface;
	}
	
	
}

//
class main_oeuvre_calcul {
	public $temps_salarie_perm;//case A
	public $temps_salarie_tempo;//case B
}

class main_oeuvre {
	public $lignes_main_oeuvre = array();
 	const LIGNE = 3;
 	public $nom_ligne = array("non_salarie","aides","salarie");
 	/*const libelle1 = "non_salarie";
 	const libelle2 = "aides";
 	const libelle3 = "salarie";*/
 	const libelle4 = "totaux";
	
	function set_ligne_main($objet_ligne_main_oeuvre,$indic)
	{
		$this->lignes_main_oeuvre[$indic] = $objet_ligne_main_oeuvre;
	}
	/*
	 * afin de remplir la ligne de totaux
	 */
	function set_ligne_totaux()
	{
		$nom_element = count($this->lignes_main_oeuvre)-1;
		
		if($nom_element<=main_oeuvre::LIGNE)
		{
			$ligne_main_oeuvre = new ligne_main_oeuvre();
			$this->lignes_main_oeuvre[main_oeuvre::libelle4] = $ligne_main_oeuvre;
			$ligne_main_oeuvre->libelle = "Totaux";
			foreach($this->nom_ligne as $value)
			{
				//echo $this->lignes_main_oeuvre[main_oeuvre::libelle4]->perm_nombre;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->perm_nombre+=(int)$this->lignes_main_oeuvre[$value]->perm_nombre;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->perm_temps+=(int)$this->lignes_main_oeuvre[$value]->perm_temps;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->perm_uth+=(int)$this->lignes_main_oeuvre[$value]->perm_uth;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->temp_nombre+=(int)$this->lignes_main_oeuvre[$value]->temp_nombre;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->temp_temps+=(int)$this->lignes_main_oeuvre[$value]->temp_temps;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->temp_uth+=(int)$this->lignes_main_oeuvre[$value]->temp_uth;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->total_nombre+=(int)$this->lignes_main_oeuvre[$value]->total_nombre;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->total_temps+=(int)$this->lignes_main_oeuvre[$value]->total_temps;
				$this->lignes_main_oeuvre[main_oeuvre::libelle4]->total_uth+=(int)$this->lignes_main_oeuvre[$value]->total_uth;
			}
		}
	return $this->lignes_main_oeuvre[main_oeuvre::libelle4];
	}
}

class ligne_main_oeuvre {
	public $libelle;
	public $perm_nombre;
	public $perm_temps;
	public $perm_uth;
	public $temp_nombre;
	public $temp_temps;
	public $temp_uth;
	public $total_nombre;
	public $total_temps;
	public $total_uth;
	
	function set_valeur_main($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7)
	{
		$this->libelle = (string)$attrib7;
		$this->perm_nombre = (int)$attrib1;
		$this->perm_temps = (int)$attrib2;
		$this->perm_uth = (int)$attrib3;
		$this->temp_nombre = (int)$attrib4;
		$this->temp_temps = (int)$attrib5;
		$this->temp_uth = (int)$attrib6;
		$this->total_nombre = (int)$attrib1 + (int)$attrib4;
		$this->total_temps = (int)$attrib2 + (int)$attrib5;
		$this->total_uth = (int)$attrib3 + (int)$attrib6;
	}
	
}

class charges_globales{
	public $contenu_charges_globales = array();

	function ajout_charge_globale($attrib1,$attrib2) {
		$this->contenu_charges_globales[$attrib1] = $attrib2;
	}
	
	function getValeurLigne($id) {
		return $this->contenu_charges_globales[$id]->valeur;
	}
}

class ligne_charge_globale {
	public $libelle;
	public $valeur;
	public $identifiant;
	
	function __construct($libelle,$valeur,$identifiant) {
		$this->libelle = $libelle;
		$this->valeur  = $valeur;
		$this->identifiant = $identifiant;
	}

	function ajout_contenu($attrib1,$attrib2,$attrib3) {
		$this->libelle = $attrib1;
		$this->valeur = $attrib2;
		$this->identifiant = $attrib3;
	}
}

class marge_brute {
	public $marge_brute_totale;
	public $marge_brute_moins_structure;
	public $resultat_net;
	
	public $productions = array();
}

class ligne_marge_brute_graph {
	public $libelle;
	public $valeur;
}

class calcul_marge_brute{
	public $contenu_calcul_marge_brute = array();

	function ajout_calcul_marge_brute($attrib1,$attrib2) {
		$this->contenu_calcul_marge_brute[$attrib1] = $attrib2;
	}
}

class ligne_calcul_marge_brute {
	public $libelle;
	public $valeur;
	public $identifiant;
	
	function __construct($libelle,$valeur,$identifiant) {
		$this->libelle = $libelle;
		$this->valeur  = $valeur;
		$this->identifiant = $identifiant;
	}
}

class marge_production {
	public $atelier;
	public $libelle;
	public $charge_total;
	public $produit_total;
	public $nb_unite;
	
	function __construct($atelier=NULL,$libelle=NULL,$charge_total=NULL,$produit_total=NULL,$nb_unite=NULL) {
		$this->atelier = $atelier;
		$this->libelle = $libelle;
		$this->charge_total = $charge_total;
		$this->produit_total= $produit_total;
		$this->nb_unite = $nb_unite;
	}
}

class activite_globale {	
	public $contenu_activite_globale = array();
	public $resultat_exploitation;
	public $CA_HT;
	public $tx_rentabilite_eco;
	public $commentaire;
	
	function ajout_contenu_activite_globale($attrib1,$attrib2) {
		$this->contenu_activite_globale[$attrib1] = $attrib2;
	}
	
	function getValeurLigne($id) {
		return $this->contenu_activite_globale[$id]->valeur;
	}
}

class ligne_activite_globale {
	public $libelle;
	public $valeur;
	public $identifiant;
	
	function __construct($libelle,$valeur,$identifiant) {
		$this->libelle = $libelle;
		$this->valeur  = $valeur;
		$this->identifiant = $identifiant;
	}
}

class marge_nette {
	public $contenu_marge_nette = array();
	
	function modif_ligne_marge_nette($objet_ligne_marge_nette,$indic)
	{
		//$this->contenu_marge_nette[$indic] = $objet_ligne_marge_nette;
		//$this->$objet_ligne_marge_nette = $objet_ligne_marge_nette->;
		$this->contenu_marge_nette[$indic]->charge_structure_u = $objet_ligne_marge_nette->charge_structure_u;
		$this->contenu_marge_nette[$indic]->produits_structurels_u = $objet_ligne_marge_nette->produits_structurels_u;
		$this->contenu_marge_nette[$indic]->valeur_marge_nette_u();
		$this->contenu_marge_nette[$indic]->valeur_marge_nette();
		return ($this->contenu_marge_nette[$indic]);
	}
}

class ligne_marge_nette {
	public $libelle;
	public $marge_brute_u;
	public $charge_structure_u;
	public $produits_structurels_u;
	public $marge_nette_u;
	public $marge_nette;
	public $nombre_unite;
	
	function set_valeur_marge_nette($attrib1,$attrib2,$attrib3)
	{
		$this->libelle = $attrib1;
		$this->charge_structure_u = $attrib2;
		$this->produits_structurels_u = $attrib3;
		//$this->valeur_marge_nette_u();
		//$this->valeur_marge_nette();
	}
	//function valeur_marge_nette_u($valeur_marge_brut)
	function valeur_marge_nette_u()
	{
		$this->marge_nette_u = $this->marge_brute_u - $this->charge_structure_u + $this->produits_structurels_u;
		return($this->marge_nette_u); 
	}
	function valeur_marge_nette()
	{
		$this->marge_nette = $this->marge_nette_u*$this->nombre_unite;
		return($this->marge_nette);
	}
	
}

class commentaire_final {
	public $commentaire;
}

?>