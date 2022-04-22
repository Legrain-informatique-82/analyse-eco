<?php
include_once("class_inter.php");
include_once("analyse_eco.php");
include_once("fonctions.inc.php");
session_start();
include_once("connection.php");
include_once("const.php");
define('FICHE_XML_FINAL','xml/test1.xml');
//print_r($_SESSION[C_SESSION_ASSOLEMENT]);
//echo count($_SESSION[C_SESSION_ASSOLEMENT]->liste_assolement);

function ajout_xml_tableau_assolement($ligne_assolement)
{
	$xml_final = file_xml_existe();
	$var1 = "descriptif-exploitation";
	
	$nombre_session = count($_SESSION[C_SESSION_ASSOLEMENT]->liste_assolement);
	$_SESSION[C_SESSION_ASSOLEMENT]->ajout_ligne($ligne_assolement,$nombre_session);
	
	$ligne = simplexml_addChild($xml_final->pages->page[0]->$var1->assolement,"ligne",$value='');
	simplexml_addChild($ligne,"culture",$ligne_assolement->culture);
	simplexml_addChild($ligne,"surface",$ligne_assolement->surface);
	simplexml_addChild($ligne,"derobe",$ligne_assolement->derobe);
	simplexml_addChild($ligne,"irrigue",$ligne_assolement->irrigue);
	simplexml_addChild($ligne,"rdt",$ligne_assolement->rdt);
	
	
	/*$ligne = $xml_final->pages->page[0]->$var1->assolement->addChild('ligne');
	$ligne->addChild('culture',$ligne_assolement->culture);
	$ligne->addChild('surface',$ligne_assolement->surface);
	$ligne->addChild('derobe',$ligne_assolement->derobe);
	$ligne->addChild('irrigue',$ligne_assolement->irrigue);
	$ligne->addChild('rdt',$ligne_assolement->rdt);*/
	
	$xml_final->pages->page[0]->$var1->assolement->total = $_SESSION[C_SESSION_ASSOLEMENT]->total_surface;
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
	
}
$ligne_assolement1 = new ligne_assolement();
$ligne_assolement1->set_valeur("pomme",1.0,1.0,1.0,1.0);
ajout_xml_tableau_assolement($ligne_assolement1);
print_r($_SESSION[C_SESSION_ASSOLEMENT]);
function position_ligne_assolement($nom_culture)
{
	$var1 = "descriptif-exploitation";
	$xml_final = file_xml_existe();
	$count = 0;
	
	foreach($xml_final->pages->page[0]->$var1->assolement->ligne as $ligne)
	{
		$culture = (string)$ligne->culture;
		if($nom_culture==$culture)
		{
			$num = $count;
		}
		$count++;
	}
	return $num;
}
function modif_xml_tableau_assolement($ligne_assolement,$no_ligne)
{
	$xml_final = file_xml_existe();
	$var1 = "descriptif-exploitation";
	
	$xml_final->pages->page[0]->$var1->assolement->ligne[$no_ligne]->culture = $ligne_assolement->culture;
	$xml_final->pages->page[0]->$var1->assolement->ligne[$no_ligne]->surface = $ligne_assolement->surface;
	$xml_final->pages->page[0]->$var1->assolement->ligne[$no_ligne]->derobe = $ligne_assolement->derobe;
	$xml_final->pages->page[0]->$var1->assolement->ligne[$no_ligne]->irrigue = $ligne_assolement->irrigue;
	$xml_final->pages->page[0]->$var1->assolement->ligne[$no_ligne]->rdt = $ligne_assolement->rdt;
	
	$_SESSION[C_SESSION_ASSOLEMENT]->modifi_ligne($ligne_assolement,$no_ligne);
	$xml_final->pages->page[0]->$var1->assolement->total = $_SESSION[C_SESSION_ASSOLEMENT]->total_surface;
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
}

/*$ligne_assolement1 = new ligne_assolement();
$ligne_assolement1->set_valeur("pomme",2.0,2.0,2.0,2.0);
modif_xml_tableau_assolement($ligne_assolement1,position_ligne_assolement("orange"));
print_r($_SESSION[C_SESSION_ASSOLEMENT]);*/
function supprim_xml_tableau_assolement($ligne_culture)
{
	$xml_final = file_xml_existe();
	$var1 = "descriptif-exploitation";
	unset($xml_final->pages->page[0]->$var1->assolement->ligne[$ligne_culture]);
	$_SESSION[C_SESSION_ASSOLEMENT]->supprime_ligne($ligne_culture);
	
	$xml_final->pages->page[0]->$var1->assolement->total = $_SESSION[C_SESSION_ASSOLEMENT]->total_surface;
	file_put_contents(FICHE_XML_FINAL, $xml_final->asXML());
}
/*supprim_xml_tableau_assolement(position_ligne_assolement("pomme"));
print_r($_SESSION[C_SESSION_ASSOLEMENT]);*/

?>