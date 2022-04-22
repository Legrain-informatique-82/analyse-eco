<?php session_start();
include_once("analyse_eco.php");
include_once("class_inter.php");
include_once("const.php");
define('C_FICHE_XML_FINAL','xml/test1.xml');
define('PAGE1','decriptif exploitation');
define('PAGE2','soldes intermediaires de gestion');
/*define('PAGE3','soldes intermediaires de gestion');
define('PAGE4','analyse-technico');
define('PAGE5','flux financiers');
define('PAGE6','bilan comparatif');
define('PAGE7','ratios financiers');
define('PAGE8','tableau de financement');
define('PAGE9','synth�se');*/
function lire_xml_final()
{
	$var1 = "descriptif-exploitation";
	$var2 = "faire-valoir";
	$var3 = "mise-a-disp-prop";
	$var4 = "mise-a-disp-ferm";
	$var5 = "total-sau";
	$var6 = "non-sau";
	$var7 = "dont-bois";
	$var8 = "total-surface";
	$var9 = "stocks-produits";
	$var10 = "main-oeuvre";
	if(file_exists(C_FICHE_XML_FINAL))
	{
		$xml_final = simplexml_load_file("xml/test1.xml");
		
	}
	else
	{
		echo "pas trouve la fiche";
	}
	foreach($xml_final->dossier as $dossier)
	{
		$info_adherent = (string)$dossier->adherent;
		$info_annee = (string)$dossier->annee;
		$info_adresse_cogere = (string)$dossier->{'adresse-centre-cogere'};
		$info_telephone_cogere = (string)$dossier->{'tel-centre-cogere'};
		
		$debut_dossier = new infos_dossier();
		$debut_dossier->set_valeur_attribu($info_adherent,$info_annee,$info_adresse_cogere,$info_telephone_cogere);
		
	}
	$_SESSION[C_SESSION_INFOS_DOSSIER] = $debut_dossier ;
	//print_r($_SESSION[C_SESSION_INFOS_DOSSIER]);
	
	$infos_dossier = new contenu_infos_dossier();
	foreach($xml_final->liste_infos_dossier->info as $info)
	{
		$cle = (string)$info->cle;
		$valeur1 = (string)$info->valeur1;
		
		$new_infos_dossier = new infos_dossier_xml($cle,$valeur1);
		$infos_dossier->ajoute_contenu_info($cle,$new_infos_dossier);
	}
	$_SESSION[C_SESSION_INFOS_DOSSIER_EPICEA] = $infos_dossier;
	//print_r($_SESSION[C_SESSION_INFOS_DOSSIER_EPICEA]);
	
	foreach($xml_final->pages->page as $page)
	{
		
		if($page['nom']==PAGE1)//Dans page qui est decriptif exploitation
		{
			/*
			 * pourla balise <faire-valoir>...</faire-valoir>
			 */
			foreach($xml_final->pages->page[0]->$var1->$var2 as $faire_valoir)
			{
				$propriete = $faire_valoir->propriete;
				$fermage = $faire_valoir->fermage;
				$mise_a_disp_prop = $faire_valoir->$var3;
				$mise_a_disp_ferm = $faire_valoir->$var4;
				$metayage = $faire_valoir->metayage;
				$non_sau = $faire_valoir->$var6;
				$dont_bois = $faire_valoir->$var7;
				
				$objet_faire_valoir = new faire_valoir();
				$objet_faire_valoir->Set_valeur($propriete,$fermage,$mise_a_disp_prop,$mise_a_disp_ferm,$metayage,$non_sau,$dont_bois);
				
				
			}
			$_SESSION[C_SESSION_FAIRE_VALOIR] = $objet_faire_valoir;
			//print_r($_SESSION[C_SESSION_FAIRE_VALOIR]);
			
			/*
			 * pour la balise <assolement>...</assolement>
			 */
			$objet_assolement = new assolement();
			$count1 = 0;
			foreach($xml_final->pages->page[0]->$var1->assolement->ligne as $ligne)
			{
				$culture = (string)$ligne->culture;
				$surface = (float)$ligne->surface;
				$derobe = (float)$ligne->derobe;
				$irrigue = (float)$ligne->irrigue;
				$rdt = (float)$ligne->rdt;
				
				//echo $culture."---".$surface."---".$derobe."---".$irrigue."---".$rdt."<br>";
				$objet_ligne_assolement = new ligne_assolement();
				$objet_ligne_assolement->set_valeur($culture,$surface,$derobe,$irrigue,$rdt);
				
				$objet_assolement->ajout_ligne($objet_ligne_assolement,$count1);
				
				$count1++;
			}
			$_SESSION[C_SESSION_ASSOLEMENT] = $objet_assolement;
			//print_r($_SESSION[C_SESSION_ASSOLEMENT]);
		
			
			/*
			 * pour la balise <stocks-produits>...</stocks-produits>
			 */
			$objet_stocks_produits = new stocks_produits();
			$count2 = 0;
			foreach($xml_final->pages->page[0]->$var1->$var9->ligne as $ligne)
			{
				$libelle = (string)$ligne->libelle;
				$qte_deb = (int)$ligne->{'qte-deb'};
				$entrees_a = (int)$ligne->{'entrees-a'};
				$entrees_n = (int)$ligne->{'entrees-n'};
				$entrees_ch = (int)$ligne->{'entrees-ch'};
				$entrees_pr = (int)$ligne->{'entrees-pr'};
				$sorties_v = (int)$ligne->{'sorties-v'};
				$sorties_pe = (int)$ligne->{'sorties-pe'};
				$sorties_co = (int)$ligne->{'sorties-co'};
				$sorties_ch = (int)$ligne->{'sorties-ch'};
				$sorties_ci = (int)$ligne->{'sorties-ci'};
				$qte_fin = (int)$ligne->{'qte-fin'};
				$tx_perte = (int)$ligne->{'tx-perte'};
				
				$objet_ligne_stock = new ligne_stock();
				$objet_ligne_stock->set_valeur($libelle,$qte_deb,$entrees_a,$entrees_n,$entrees_ch,$entrees_pr,$sorties_v,$sorties_pe,$sorties_co,$sorties_ch,$sorties_ci,$qte_fin,$tx_perte);
				
				$objet_stocks_produits->ajout_ligne_produit($objet_ligne_stock,$count2);
				$count2++;
			}
			$_SESSION[C_SESSION_STOCKS] = $objet_stocks_produits;
			print_r($_SESSION[C_SESSION_STOCKS]);
			
			/*
			 * pour la balise <stocks-produits>...</stocks-produits>
			 */
			$objet_main_oeuvre = new main_oeuvre();
			foreach($xml_final->pages->page[0]->$var1->$var10->ligne as $ligne)
			{
				$libelle = (string)$ligne->libelle;
				$perm_nombre = (int)$ligne->perm_nombre;
				$perm_temps = (int)$ligne->perm_temps;
				$perm_uth = (int)$ligne->perm_uth;
				$temp_nombre = (int)$ligne->temp_nombre;
				$temp_temps = (int)$ligne->temp_temps;
				$temp_uth = (int)$ligne->temp_uth;	
				
				$objet_ligne_main_oeuvre = new ligne_main_oeuvre();
				$objet_ligne_main_oeuvre->set_valeur_main($perm_nombre,$perm_temps,$perm_uth,$temp_nombre,$temp_temps,$temp_uth,$libelle);
			}
			
		}
		/*elseif($page['nom']==PAGE2)
		{
			
		}*/
		
	}
}
lire_xml_final();
?>