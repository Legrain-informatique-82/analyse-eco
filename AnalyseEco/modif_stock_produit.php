<?php
include_once("class_inter.php");
include_once("analyse_eco.php");
include_once("fonctions.inc.php");
session_start();
include_once("connection.php");
include_once("const.php");
define('FICHE_XML_FINAL','xml/test1.xml');
function ajout_ligne_stocks($ligne_stock)
{
	$var1 = "descriptif-exploitation";
	$var2 = "stocks-produits";
	$var3 = "qte-deb";
	$var4 = "entrees-a";
	$var5 = "entrees-n";
	$var6 = "entrees-ch";
	$var7 = "entrees-pr";
	$var8 = "sorties-v";
	$var9 = "sorties-pe";
	$var10 = "sorties-co";
	$var11 = "sorties-ch";
	$var12 = "sorties-ci";
	$var13 = "qte-fin";
	$var14 = "tx-perte";
	
	$xml_final = file_xml_existe();
	$nombre_session = count($_SESSION[C_SESSION_STOCKS]->liste_stocks);
	
	$_SESSION[C_SESSION_STOCKS]->ajout_ligne_produit($ligne_stock,$nombre_session);
	
	$ligne = simplexml_addChild($xml_final->pages->page[0]->$var1->$var2,"ligne",$value='');
	simplexml_addChild($ligne,"libelle",$ligne_stock->libelle);
	simplexml_addChild($ligne,"qte-deb",$ligne_stock->qte_deb);
	simplexml_addChild($ligne,"entrees-a",$ligne_stock->entrees_a);
	simplexml_addChild($ligne,"entrees-n",$ligne_stock->entrees_n);
	simplexml_addChild($ligne,"entrees-ch",$ligne_stock->entrees_ch);
	simplexml_addChild($ligne,"entrees-pr",$ligne_stock->entrees_pr);
	simplexml_addChild($ligne,"sorties-v",$ligne_stock->sorties_v);
	simplexml_addChild($ligne,"sorties-pe",$ligne_stock->sorties_pe);
	simplexml_addChild($ligne,"sorties-co",$ligne_stock->sorties_co);
	simplexml_addChild($ligne,"sorties-ch",$ligne_stock->sorties_ch);
	simplexml_addChild($ligne,"sorties-ci",$ligne_stock->sorties_ci);
	simplexml_addChild($ligne,"qte-fin",$ligne_stock->qte_fin);
	simplexml_addChild($ligne,"tx-perte",$ligne_stock->tx_perte);
	/*$ligne = $xml_final->pages->page[0]->$var1->$var2->addChild('ligne');
	$ligne->addChild('libelle',$ligne_stock->libelle);
	$ligne->addChild('qte-deb',$ligne_stock->qte_deb);
	$ligne->addChild('entrees-a',$ligne_stock->entrees_a);
	$ligne->addChild('entrees-n',$ligne_stock->entrees_n);
	$ligne->addChild('entrees-ch',$ligne_stock->entrees_ch);
	$ligne->addChild('entrees-pr',$ligne_stock->entrees_pr);
	$ligne->addChild('sorties-v',$ligne_stock->sorties_v);
	$ligne->addChild('sorties-pe',$ligne_stock->sorties_pe);
	$ligne->addChild('sorties-co',$ligne_stock->sorties_co);
	$ligne->addChild('sorties-ch',$ligne_stock->sorties_ch);
	$ligne->addChild('sorties-ci',$ligne_stock->sorties_ci);
	$ligne->addChild('qte-fin',$ligne_stock->qte_fin);
	$ligne->addChild('tx-perte',$ligne_stock->tx_perte);*/
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());	
}


/*$ligne_stock = new ligne_stock();
$ligne_stock->set_valeur("ccc",1,1,1,1,1,1,1,1,1,1,1,1);
ajout_ligne_stocks($ligne_stock);
print_r($_SESSION[C_SESSION_STOCKS]);*/
/*
 * trouver la position de ligne. quelle ligne on vas modifier 
 * dans le tableau stocks produits 
 */
function position_ligne_stock($indic)
{
	$var1 = "descriptif-exploitation";
	$var2 = "stocks-produits";
	$xml_final = file_xml_existe();
	$count = 0;
	foreach($xml_final->pages->page[0]->$var1->$var2->ligne as $ligne)
	{
		$libelle = (string)$ligne->libelle;
		//echo $culture."<br>";
		if($indic==$libelle)
		{
			$num = $count;
		}
		$count++;
	}
	return $num;
}
/*
 * modifier les valeurs dans le balise <stocks-produits>
 * $position est numero de ligne  
 */
function modif_ligne_stocks($ligne_stock,$position)
{
	$var1 = "descriptif-exploitation";
	$var2 = "stocks-produits";
	$var3 = "qte-deb";
	$var4 = "entrees-a";
	$var5 = "entrees-n";
	$var6 = "entrees-ch";
	$var7 = "entrees-pr";
	$var8 = "sorties-v";
	$var9 = "sorties-pe";
	$var10 = "sorties-co";
	$var11 = "sorties-ch";
	$var12 = "sorties-ci";
	$var13 = "qte-fin";
	$var14 = "tx-perte";
	$xml_final = file_xml_existe();
	
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->libelle = $ligne_stock->libelle;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var3 = $ligne_stock->qte_deb;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var4 = $ligne_stock->entrees_a;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var5 = $ligne_stock->entrees_n;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var6 = $ligne_stock->entrees_ch;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var7 = $ligne_stock->entrees_pr;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var8 = $ligne_stock->sorties_v;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var9 = $ligne_stock->sorties_pe;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var10 = $ligne_stock->sorties_co;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var11 = $ligne_stock->sorties_ch;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var12 = $ligne_stock->sorties_ci;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var13 = $ligne_stock->qte_fin;
	$xml_final->pages->page[0]->$var1->$var2->ligne[$position]->$var14 = $ligne_stock->tx_perte;
	//echo $ligne_stock->libelle;
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
	
	//$_SESSION[C_SESSION_STOCKS] = lire_xml_final();
	if(isset($_SESSION[C_SESSION_STOCKS]))
	{
		//$_SESSION[C_SESSION_STOCKS]->modifi_ligne_produit($ligne_stock,$position);
		$_SESSION[C_SESSION_STOCKS]->liste_stocks[$position] = $ligne_stock;
	}
	else
	{
		echo "des erreur";
	}
}
/*$ligne_stock = new ligne_stock();
$ligne_stock->set_valeur("aaa",1,1,1,1,1,1,1,1,1,1,1,2);
modif_ligne_stocks($ligne_stock,position_ligne_stock("CCC"));
print_r($_SESSION[C_SESSION_STOCKS]);
echo "<br>";
echo count($_SESSION[C_SESSION_STOCKS]->liste_stocks);*/

/*$ligne_stock = new ligne_stock();
$ligne_stock->modifi_ligne_stock("orange",4,1,1,1,1,1,1,1,1,1,1,1);
modif_ligne_stocks($ligne_stock,position_ligne_stock("pomme"));
print_r($_SESSION[C_SESSION_STOCKS]);*/




function suppr_ligne_stock($position)
{
	$xml_final = file_xml_existe();
	$var1 = "descriptif-exploitation";
	$var2 = "stocks-produits";
	unset($xml_final->pages->page[0]->$var1->$var2->ligne[$position]);
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
	$_SESSION[C_SESSION_STOCKS]->suppri_ligne_produit($position);
}
//suppr_ligne_stock(position_ligne_stock("ccc"));
/*echo count($_SESSION[C_SESSION_STOCKS]->liste_stocks);
echo "<br>";
print_r($_SESSION[C_SESSION_STOCKS]);*/
?>
 