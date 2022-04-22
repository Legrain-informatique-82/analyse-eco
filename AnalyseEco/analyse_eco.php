<?php
/*******************************************************************/
/* Classes/objets correspondant aux balises du fichier XML initial */
/*******************************************************************/

class donnees_analyse_eco
{
	public $liste_infos_compta = array();
	public $liste_infos_liasse = array();
	public $liste_infos_analytique = array();
	public $liste_infos_stocks = array();
	public $liste_acquisition = array();
	public $liste_infos_grd_livre_qte = array();
	public $liste_infos_dossier = array();

	function ajout_info_compta($attrib1,$attrib2)
	{
		$this->liste_infos_compta[$attrib1] = $attrib2;
	}

	function ajout_info_liasse($attrib3,$attrib4)
	{
		$this->liste_infos_liasse[$attrib3] = $attrib4;
	}

	function ajout_acquisition($attrib5,$attrib6)
	{
		$this->liste_acquisition[$attrib5] = $attrib6;
	}
	
	function ajout_infos_analytique($attrib7,$attrib8)
	{
		$this->liste_infos_analytique[$attrib7] = $attrib8;
	}
	
	function ajout_infos_grd_livre_qte($attrib9,$attrib10)
	{
		$this->liste_infos_grd_livre_qte[$attrib9] = $attrib10;
	}
	
	function ajout_infos_stocks($attrib11,$attrib12)
	{
		$this->liste_infos_stocks[$attrib11] = $attrib12;
	}
	
	function ajout_infos_dossier($attrib13,$attrib14)
	{
		$this->liste_infos_dossier[$attrib13] = $attrib14;
	}
}


//pour le balise de <liste-infos-compta>

//pour balise -- <infos_compta>
class infos_comptas
{
	public $numero;
	public $libelle;
	public $mtDebitReport;
	public $mtCreditReport;
	public $mtDebitMouvement;
	public $mtCreditMouvement;
	public $mtDebit;
	public $mtCredit;
	
	private $pattern_classe_6 = "/^6([0-9]*)/";
	private $pattern_classe_7 = "/^7([0-9]*)/";

	function __construct($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7,$attrib8)
	{
		$this->numero = $attrib1;
		$this->libelle = $attrib2;
		$this->mtDebitReport = $attrib3;
		$this->mtCreditReport = $attrib4;
		$this->mtDebitMouvement = $attrib5;
		$this->mtCreditMouvement = $attrib6;
		$this->mtDebit = $attrib7;
		$this->mtCredit = $attrib8;
	}
	
	function soldeN(){
		return $this->solde((float)$this->mtDebit,(float)$this->mtCredit);
	}
	
	function soldeReport(){
		return $this->solde((float)$this->mtDebitReport,(float)$this->mtCreditReport);
	}
	
	function soldeMouvement(){
		return $this->solde((float)$this->mtDebitMouvement,(float)$this->mtCreditMouvement);
	}
	
	private function solde($debit,$credit) {
		if(preg_match($this->pattern_classe_6,$this->numero))
			return $debit - $credit;
		else if(preg_match($this->pattern_classe_7,$this->numero))
			return $credit - $debit;
		else
			return $credit - $debit;
	}
}

//pour le balise de <liste-infos-liasse>
class infos_liasse
{
	public $objetCle;
	public $objetRepatition;

	function modif_infos_liasse($attrib1,$attrib2)
	{
		$this->objetCle = $attrib1;
		$this->objetRepatition = $attrib2;
	}

}

class cle
{
	public $sous_cle;
	public $cle;

	function __construct($attrib1,$attrib2)
	{
		$this->sous_cle = $attrib1;
		$this->cle = $attrib2;
	}
}

class repartition
{
	public $montant;
	public $valeur;
	public $detail=array();

	function ajoute_repartition($attrib1,$attrib2)
	{
		$this->montant = $attrib1;
		$this->valeur = $attrib2;
	}

	function ajout_detail($attrib3,$attrib4)
	{
		$this->detail[$attrib3] = $attrib4;//$attrib3 est numero de compte dans <detail>.$attrib4 est objet
	}
}

class ObjetDetail
{
	public $numCompt;
	public $mtDebit;
	public $mtCredit;

	function __construct($attrib1,$attrib2,$attrib3)
	{
		$this->numCompt = $attrib1;
		$this->mtDebit = $attrib2;
		$this->mtCredit = $attrib3;
	}
	/*function modifier($attrib1,$attrib2,$attrib3)
	 {

	 }*/
}

//pour le balise de <liste-infos-analytique>
class infos_analytique
{
	public $origine;
	public $atelier;
	public $libelle_atelier;
	public $compte;
	public $designation;
	public $total_charges;
	public $total_produits;
	public $qt1;
	public $pu1;
	public $qt2;
	public $pu2;
	public $code_activite;
	public $libelle_activite;
	public $nb_unite_atelier;

	function __construct($attrib1,$attrib2,$attrib3,$attrib4,$attrib5,$attrib6,$attrib7,$attrib8,$attrib9,$attrib10,$attrib11,$attrib12,$attrib13,$attrib14)
	{
		$this->origine = $attrib1;
		$this->atelier = $attrib2;
		$this->libelle_atelier = $attrib3;
		$this->compte = $attrib4;
		$this->designation = $attrib5;
		$this->total_charges = $attrib6;
		$this->total_produits = $attrib7;
		$this->qt1 = $attrib8;
		$this->pu1 = $attrib8;
		$this->qt2 = $attrib10;
		$this->pu2 = $attrib11;
		$this->code_activite = $attrib12;
		$this->libelle_activite = $attrib13;
		$this->nb_unite_atelier = $attrib14;
	}
}

//pour la balise de <liste-infos-stocks>
class infos_stocks
{
	public $origine;
	public $compte;
	public $designation;
	public $qte;
	public $prix_unitaire;
	public $decote;
	public $montant_ht;
}

class dossier
{
	public $adherent;
	public $annee;

	function ajout_valeur($attrib1,$attrib2)
	{
		$this->adherent = $attrib1;
		$this->annee = $attrib2;
	}
}

class acquisition
{
	public $numero;
	public $libelle;
	public $mtDebit;
	public $mtCredit;

	function __construct($attrib1,$attrib2,$attrib3,$attrib4)
	{
		$this->numero = $attrib1;
		$this->libelle = $attrib2;
		$this->mtDebit = $attrib3;
		$this->mtCredit = $attrib4;
	}
}

class infos_grd_livre_qte {
	public $compte;
	public $qte;
	
	function __construct($attrib1,$attrib2) {
		$this->compte = $attrib1;
		$this->qte = $attrib2;
	}
}

class infos_dossier_xml {
	public $cle;
	public $valeur;
	
	function __construct($attrib1,$attrib2) {
		$this->cle = $attrib1;
		$this->valeur = $attrib2;
	}
}

class contenu_infos_dossier{
	public $contenu_infos = array();
	
	function ajoute_contenu_info($attrib1,$attrib2)
	{
		$this->contenu_infos[$attrib1] = $attrib2;
	}
}
?>