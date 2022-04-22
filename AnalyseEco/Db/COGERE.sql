-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-2ubuntu1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 22, 2007 at 03:15 PM
-- Server version: 5.0.38
-- PHP Version: 5.2.1
-- 
-- Database: `COGERE`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `ATE_ACTIVITE_GLOBALE`
-- 

CREATE TABLE `ATE_ACTIVITE_GLOBALE` (
  `ID` int(11) NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYMBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `ATE_ACTIVITE_GLOBALE`
-- 

INSERT INTO `ATE_ACTIVITE_GLOBALE` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYMBOLE`) VALUES 
(1, '', 'D9', 'ATE1'),
(2, '', 'C9', 'ATE2'),
(3, '', 'B9', 'ATE3'),
(4, '', 'D15', 'ATE4'),
(5, '', 'C15', 'ATE5'),
(6, '', 'B15', 'ATE6'),
(7, '', 'D35', 'ATE7'),
(8, '', 'C35', 'ATE8'),
(9, '', 'B35', 'ATE9'),
(10, '', 'B31', 'ATE10'),
(11, '', 'B9', 'ATE11'),
(12, '', 'B31/B9', 'ATE12');

-- --------------------------------------------------------

-- 
-- Table structure for table `ATE_CHARGES_GLOBALE`
-- 

CREATE TABLE `ATE_CHARGES_GLOBALE` (
  `ID` int(11) NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYMBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- 
-- Dumping data for table `ATE_CHARGES_GLOBALE`
-- 

INSERT INTO `ATE_CHARGES_GLOBALE` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYMBOLE`) VALUES 
(1, '', 'BAN_6*+BAN_7132*+BAN_7134*-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'C55'),
(2, '****** A FAIRE *******', 'C55/TotalSAU', 'D55'),
(3, '', 'ATELIER_N[MECA]', 'C56'),
(4, '', 'ATELIER_N[M--O]', 'C57'),
(5, '', 'ATELIER_N[BAFO]', 'C58'),
(6, '', 'ATELIER_N[DIVE]', 'C59'),
(7, '', 'C55+C56+C57+C58+C59', 'C60'),
(8, '****** A FAIRE *******', 'C56/TotalSAU', 'D56'),
(9, '****** A FAIRE *******', 'C57/TotalSAU', 'D57'),
(10, '****** A FAIRE *******', 'C58/TotalSAU', 'D58'),
(11, '****** A FAIRE *******', 'C59/TotalSAU', 'D59'),
(12, '****** A FAIRE *******', 'C60/TotalSAU', 'D60'),
(13, '', 'BAN1_6*+BAN1_7132*+BAN1_7134*-ATELIER_N1[MECA,M--O,BAFO,DIVE,ELEM]', 'E55'),
(14, '', 'ATELIER_N1[MECA]', 'E56'),
(15, '', 'ATELIER_N1[M--O]', 'E57'),
(16, '', 'ATELIER_N1[BAFO]', 'E58'),
(17, '', 'ATELIER_N1[DIVE]', 'E59'),
(18, '', 'E55+E56+E57+E58+E59', 'E60'),
(19, '', 'BAN2_6*+BAN2_7132*+BAN2_7134*-ATELIER_N2[MECA,M--O,BAFO,DIVE,ELEM]', 'G55'),
(20, '', 'ATELIER_N2[MECA]', 'G56'),
(21, '', 'ATELIER_N2[M--O]', 'G57'),
(22, '', 'ATELIER_N2[BAFO]', 'G58'),
(23, '', 'ATELIER_N2[DIVE]', 'G59'),
(24, '', 'G55+G56+G57+G58+G59', 'G60'),
(25, '', 'C55-E55', 'F55'),
(26, '', 'C56-E56', 'F56'),
(27, '', 'C57-E57', 'F57'),
(28, '', 'C58-E58', 'F58'),
(29, '', 'C59-E59', 'F59'),
(30, '', 'C60-E60', 'F60'),
(31, '', 'E55-G55', 'H55'),
(32, '', 'E56-G56', 'H56'),
(33, '', 'E57-G57', 'H57'),
(34, '', 'E58-G58', 'H58'),
(35, '', 'E59-G59', 'H59'),
(36, '', 'E60-G60', 'H60');

-- --------------------------------------------------------

-- 
-- Table structure for table `ATE_MARGE_BRUTE`
-- 

CREATE TABLE `ATE_MARGE_BRUTE` (
  `ID` int(11) NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYMBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- 
-- Dumping data for table `ATE_MARGE_BRUTE`
-- 

INSERT INTO `ATE_MARGE_BRUTE` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYMBOLE`) VALUES 
(1, 'Marge brute activite 1', 'ACTIVITE[1]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR1'),
(2, 'Marge brute activite 2', 'ACTIVITE[2]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR2'),
(3, 'Marge brute activite 3', 'ACTIVITE[3]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR3'),
(4, 'Marge brute activite 4', 'ACTIVITE[4]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR4'),
(5, 'Marge brute activite 5', 'ACTIVITE[5]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR5'),
(6, 'Marge brute activite 6', 'ACTIVITE[6]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR6'),
(7, 'Marge brute activite 7', 'ACTIVITE[7]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR7'),
(8, 'Marge brute activite 8', 'ACTIVITE[8]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR8'),
(9, 'Marge brute activite 9', 'ACTIVITE[9]-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]', 'VAR9'),
(10, 'Marge brute totale', 'VAR1+VAR2+VAR3+VAR4+VAR5+VAR6+VAR7+VAR8+VAR9', 'E77'),
(11, 'C95', 'BNS_7452*', 'C95'),
(12, 'resultat net (C56-C57-C58-C59) dans charges globale', 'E77-C56-C57-C58-C59+C95', 'D98'),
(13, 'Exclusion atelier', ',,MECA,M--O,BAFO,DIVE,ELEM', 'EX_AT');


-- --------------------------------------------------------

-- 
-- Table structure for table `ATE_MARGE_NETTE`
-- 

CREATE TABLE `ATE_MARGE_NETTE` (
  `ID` int(11) NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYMBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `ATE_MARGE_NETTE`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `BILAN_ACTIF`
-- 

CREATE TABLE `BILAN_ACTIF` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `LIBELLE` varchar(100) NOT NULL,
  `BRUT` varchar(100) default NULL,
  `AMORT_PRO` varchar(100) default NULL,
  `NET3` varchar(100) NOT NULL,
  `NET4` varchar(100) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- 
-- Dumping data for table `BILAN_ACTIF`
-- 

INSERT INTO `BILAN_ACTIF` (`ID`, `LIBELLE`, `BRUT`, `AMORT_PRO`, `NET3`, `NET4`) VALUES 
(1, 'Capital souscrot non appelé', 'RN_A2_1_1', 'NULL', 'RN_ZCL_1', 'RN_A2_1_2'),
(2, 'Frais d''établissement', 'RN_A2_2_1', 'RN_A2_2_2', 'RN_ZCL_2', 'RN_A2_2_3'),
(3, 'Autres immobilisations incorporelles', 'RN_A2_3_1', 'RN_A2_3_2', 'RN_ZCL_3', 'RN_A2_3_3'),
(4, 'Avances et comptes', 'RN_A2_4_1', 'RN_A2_4_2', 'RN_ZCL_4', 'RN_A2_4_3'),
(5, 'Terrains', 'RN_A2_5_1', 'RN_A2_5_2', 'RN_ZCL_5', 'RN_A2_5_3'),
(6, 'Aménagements fonciers', 'RN_A2_6_1', 'RN_A2_6_2', 'RN_ZCL_6', 'RN_A2_6_3'),
(7, 'Amélioration du fonds', 'RN_A2_7_1', 'RN_A2_7_2', 'RN_ZCL_7', 'RN_A2_7_3'),
(8, 'Constructions', 'RN_A2_8_1', 'RN_A2_8_2', 'RN_ZCL_8', 'RN_A2_8_3'),
(9, 'Installation technique,matériel et outillage', 'RN_A2_9_1', 'RN_A2_9_2', 'RN_ZCL_9', 'RN_A2_9_3'),
(10, 'Autre immobilisations corporelles', 'RN_A2_10_1', 'RN_A2_10_2', 'RN_ZCL_10', 'RN_A2_10_3'),
(11, 'Animaux reproducteurs', 'RN_A2_11_1', 'RN_A2_11_2', 'RN_ZCL_11', 'RN_A2_11_3'),
(12, 'Animaux de service', 'RN_A2_12_1', 'RN_A2_12_2', 'RN_ZCL_12', 'RN_A2_12_3'),
(13, 'Plantation pérennes et autres végétaux immobilisés', 'RN_A2_13_1', 'RN_A2_13_2', 'RN_ZCL_13', 'RN_A2_13_3'),
(14, 'Immobilisations corporelles en cours', 'RN_A2_14_1', 'RN_A2_14_2', 'RN_ZCL_14', 'RN_A2_14_3'),
(15, 'Avances et acomptes', 'RN_A2_15_1', 'RN_A2_15_2', 'RN_ZCL_15', 'RN_A2_15_3'),
(16, 'Participation et créances rattachées', 'RN_A2_16_1', 'RN_A2_16_2', 'RN_ZCL_16', 'RN_A2_16_3'),
(17, 'Prêts', 'RN_A2_17_1', 'RN_A2_17_2', 'RN_ZCL_17', 'RN_A2_17_3'),
(18, 'Autres immobilisations financières', 'RN_A2_18_1', 'RN_A2_18_2', 'RN_ZCL_18', 'RN_A2_18_3'),
(19, 'Total', 'RN_ZCL_19', 'RN_ZCL_20', 'RN_ZCL_21', 'RN_ZCL_22'),
(20, 'Approvisionnement et marchandises', 'RN_A3_1_1', 'RN_A3_1_2', 'RN_ZCL_23', 'RN_A3_1_3'),
(21, 'Animaux et végétaux en terre(cycle long)', 'RN_A3_2_1', 'RN_A3_2_2', 'RN_ZCL_24', 'RN_A3_2_3'),
(22, 'EN cours de production de biens et services(cycle long)', 'RN_A3_3_1', 'RN_A3_3_2', 'RN_ZCL_25', 'RN_A3_3_3'),
(23, 'Animaux et végétaux en terre(cycle court)', 'RN_A3_4_1', 'RN_A3_4_2', 'RN_ZCL_26', 'RN_A3_4_3'),
(24, 'EN cours de production de biens et services(cycle court)', 'RN_A3_5_1', 'RN_A3_5_2', 'RN_ZCL_27', 'RN_A3_5_3'),
(25, 'Produits intermèdiaires et finis', 'RN_A3_6_1', 'RN_A3_6_2', 'RN_ZCL_28', 'RN_A3_6_3'),
(26, 'Avances et acomptes versés sur commande', 'RN_A3_7_1', 'RN_A3_7_2', 'RN_ZCL_29', 'RN_A3_7_3'),
(27, 'Clients et comptes rattachés(2)', 'RN_A3_8_1', 'RN_A3_8_2', 'RN_ZCL_30', 'RN_A3_8_3'),
(28, 'Autre clients et comptes rattachés(convention)(2)', 'RN_A3_9_1', 'RN_A3_9_2', 'RN_ZCL_31', 'RN_A3_9_3'),
(29, 'Autre créances(2)', 'RN_A3_10_1', 'RN_A3_10_2', 'RN_ZCL_32', 'RN_A3_10_3'),
(30, 'Valeurs mobilières de placement', 'RN_A3_11_1', 'RN_A3_11_2', 'RN_ZCL_33', 'RN_A3_11_3'),
(31, 'Disponibilité', 'RN_A3_12_1', 'RN_A3_12_2', 'RN_ZCL_34', 'RN_A3_12_3'),
(32, 'Charges constatées d''avance(2)', 'RN_A3_13_1', 'RN_A3_13_2', 'RN_ZCL_35', 'RN_A3_13_3'),
(33, 'Total', 'RN_ZCL_36', 'RN_ZCL_37', 'RN_ZCL_38', 'RN_ZCL_39'),
(34, 'Frais d''émission d''emprunt à étaler', 'RN_A4_1_1', '', 'RN_ZCL_40', 'RN_A4_1_2'),
(35, 'Ecarts de conversion Actif', 'RN_A4_2_1', '', 'RN_ZCL_41', 'RN_A4_2_2'),
(36, 'Total Général', 'RN_ZCL_42', 'RN_ZCL_43', 'RN_ZCL_44', 'RN_ZCL_45'),
(37, 'Renois:', '(1)part à mois d''un an des immobilisations financieres nettes :', 'RN_A5_1_1', '(2)Part à plus d''un an:', 'RN_A5_1_2');

-- --------------------------------------------------------

-- 
-- Table structure for table `BILAN_PASSIF`
-- 

CREATE TABLE `BILAN_PASSIF` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `LIBELLE1` varchar(100) NOT NULL,
  `LIBELLE2` varchar(20) default NULL,
  `Exercice_N` varchar(20) default NULL,
  `Exercice_N_1` varchar(20) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `BILAN_PASSIF`
-- 

INSERT INTO `BILAN_PASSIF` (`ID`, `LIBELLE1`, `LIBELLE2`, `Exercice_N`, `Exercice_N_1`) VALUES 
(1, 'Capital individuel ou social(dont verse)', 'RN_B1_1_3', 'RN_B1_1_1', 'RN_B1_1_2'),
(2, 'Primes demission,de fusion,d''apport', '', 'RN_B1_2_1', 'RN_B1_2_2'),
(3, 'Ecarts de reevaluation(1)', '', 'RN_B1_3_1', 'RN_B1_3_2'),
(4, 'Reserves statutaires ou contratuelle', '', 'RN_B1_4_1', 'RN_B1_4_2'),
(5, 'Reserves reglementees', '', 'RN_B1_5_1', 'RN_B1_5_2'),
(6, 'Autre reserves', '', 'RN_B1_6_1', 'RN_B1_6_2'),
(7, 'Report a nouveau', '', 'RN_B1_7_1', 'RN_B1_7_2'),
(8, 'RESULTAT DE L''EXERCICE(benefice ou pert)', '', 'RN_B1_8_1', 'RN_B1_8_2'),
(9, 'Subventions d''investissement', '', 'RN_B1_9_1', 'RN_B1_9_2'),
(10, 'Provisions reglementees', '', 'RN_B1_10_1', 'RN_B1_10_2'),
(11, 'Total(I)', '', 'RN_ZCL_46', 'RN_ZCL_47'),
(12, 'Provisions pour risques', '', 'RN_B1_11_1', 'RN_B1_11_2'),
(13, 'Provisions pour charges', '', 'RN_B1_12_1', 'RN_B1_12_2'),
(14, 'Total(II)', '', 'RN_ZCL_48', 'RN_ZCL_49'),
(15, 'Emprunts et dettes aupres des etablissements de credit', '', 'RN_B1_13_1', 'RN_B1_13_2'),
(16, 'Emprunts fonciers', '', 'RN_B1_14_1', 'RN_B1_14_2'),
(17, 'Concours bancaires courants et decouverts bancaires', '', 'RN_B1_15_1', 'RN_B1_15_2'),
(18, 'Autres dettes financieres', '', 'RN_B1_16_1', 'RN_B1_16_2'),
(19, 'Avances et acomptes recus sur commandes en cours', '', 'RN_B1_17_1', 'RN_B1_17_2'),
(20, 'Dettes fournisseurs et comptes rattaches', '', 'RN_B1_18_1', 'RN_B1_18_2'),
(21, 'Dettes autres fournisseurs et comptes rattache(conventions de compt-courant)', '', 'RN_B1_19_1', 'RN_B1_19_2'),
(22, 'Dettes fiscals et socials', '', 'RN_B1_20_1', 'RN_B1_20_2'),
(23, 'Dettes sur immobilisations et comptes rattaches', '', 'RN_B1_21_1', 'RN_B1_21_2'),
(24, 'Autres dettes', '', 'RN_B1_22_1', 'RN_B1_22_2'),
(25, 'Produits constates d''avance', '', 'RN_B1_23_1', 'RN_B1_23_2'),
(26, 'Toatl(III)', '', 'RN_ZCL_50', 'RN_ZCL_51'),
(27, 'Ecarts de conversion Passif(IV)', '', 'RN_B1_24_1', 'RN_B1_24_2'),
(28, 'TOTAL GENERAL(I A IV)', '', 'RN_ZCL_52', 'RN_ZCL_53'),
(29, 'Reserve special de reevaluation(1959)', '', 'RN_B1_25_1', 'RN_B1_25_2'),
(30, 'Ecart de reevaluation', '', 'RN_B1_26_1', 'RN_B1_26_2'),
(31, 'Reserve de reevaluation(1976)', '', 'RN_B1_27_1', 'RN_B1_27_2'),
(32, 'Dettes et produits constates d''avance a moins d''un an', '', 'RN_B1_28_1', 'RN_B1_28_2'),
(33, 'Dettes et produits constates d''avance a plus d''un an', '', 'RN_B1_29_1', 'RN_B1_29_2');

-- --------------------------------------------------------

-- 
-- Table structure for table `COMPTE_EXPLOITATION1`
-- 

CREATE TABLE `COMPTE_EXPLOITATION1` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `LIBELLE` varchar(50) NOT NULL,
  `FRANCE` varchar(20) default NULL,
  `Exercice_N_Expor` varchar(20) default NULL,
  `Total` varchar(20) NOT NULL,
  `Exercice_precedent_N_1` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `COMPTE_EXPLOITATION1`
-- 

INSERT INTO `COMPTE_EXPLOITATION1` (`ID`, `LIBELLE`, `FRANCE`, `Exercice_N_Expor`, `Total`, `Exercice_precedent_N_1`) VALUES 
(1, 'Ventes d''origine vegetale', 'RN_C1_1_1', 'RN_C1_1_2', 'RN_C1_1_3', 'RN_C1_1_4'),
(2, 'Ventes d''origine animale', 'RN_C1_2_1', 'RN_C1_2_2', 'RN_C1_2_3', 'RN_C1_2_4'),
(3, 'Ventes de produits transformes', 'RN_C1_3_1', 'RN_C1_3_2', 'RN_C1_3_3', 'RN_C1_3_4'),
(4, 'Ventes d''animale(1)', 'RN_C1_4_1', 'RN_C1_4_2', 'RN_C1_4_3', 'RN_C1_4_4'),
(5, 'Autre production vendue(2)', 'RN_C1_5_1', 'RN_C1_5_2', 'RN_C1_5_3', 'RN_C1_5_4'),
(6, 'Montant net du chiffre d''affaires', 'RN_ZCL_54', 'RN_ZCL_55', 'RN_ZCL_56', 'RN_ZCL_57');

-- --------------------------------------------------------

-- 
-- Table structure for table `COMPTE_EXPLOITATION2`
-- 

CREATE TABLE `COMPTE_EXPLOITATION2` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `LIBELLE` varchar(100) NOT NULL,
  `Total` varchar(20) NOT NULL,
  `Exercice_precedent_N_1` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- 
-- Dumping data for table `COMPTE_EXPLOITATION2`
-- 

INSERT INTO `COMPTE_EXPLOITATION2` (`ID`, `LIBELLE`, `Total`, `Exercice_precedent_N_1`) VALUES 
(1, 'Variation d''inventaire : animaux reproducteurs immobilise', 'RN_C2_1_1', 'RN_C2_1_2'),
(2, 'Variation d''inventaire de la production stockee', 'RN_C2_2_1', 'RN_C2_2_1'),
(3, 'Production immobilisee', 'RN_C2_3_1', 'RN_C2_3_2'),
(4, 'Production autoconsommee', 'RN_C2_4_1', 'RN_C2_4_2'),
(5, 'Indemnites et subvention d''exploitation(3)', 'RN_C2_5_1', 'RN_C2_5_2'),
(6, 'Reprises sur provisions et amortissements,transfert de charges', 'RN_C2_6_1', 'RN_C2_6_2'),
(7, 'Autres produit(4)', 'RN_C2_7_1', 'RN_C2_7_2'),
(8, 'Total des produits d''exploitation(5)(I)', 'RN_ZCL_58', 'RN_ZCL_59'),
(9, 'Achat de marchandises et d''approvisionnement(y compris droits de douane)', 'RN_C3_1_1', 'RN_C3_1_2'),
(10, 'Variation de stock(marchandises et approvisionnements)', 'RN_C3_2_1', 'RN_C3_2_2'),
(11, 'Achats d''animaux(y compris droits de douane)', 'RN_C3_3_1', 'RN_C3_3_2'),
(12, 'Autres achata et charges externes(6)', 'RN_C3_4_1', 'RN_C3_4_2'),
(13, 'Impot,taxes et versements assimiles', 'RN_C3_5_1', 'RN_C3_5_2'),
(14, 'Remunerations(7)', 'RN_C3_6_1', 'RN_C3_6_2'),
(15, 'Cotisations sociales personnelles de l''exploitant', 'RN_C3_7_1', 'RN_C3_7_2'),
(16, 'Autres charges sociales', 'RN_C3_8_1', 'RN_C3_8_2'),
(17, 'Sur immobilisations:dotation aux amortissements', 'RN_C3_9_1', 'RN_C3_9_2'),
(18, 'Sur immobilisations:dotation aux provisions', 'RN_C3_10_1', 'RN_C3_10_2'),
(19, 'Sur actif circulant:dotations aux provisions', 'RN_C3_11_1', 'RN_C3_11_2'),
(20, 'Pour risques et charges:dotations aux provisions', 'RN_C3_12_1', 'RN_C3_12_2'),
(21, 'Autre charge(8)', 'RN_C3_13_1', 'RN_C3_13_2'),
(22, 'Total des charges d''exploitation(9)(II)', 'RN_ZCL_60', 'RN_ZCL_61'),
(23, '1 RESULTAT D''EXPLOITATION(I_II)(III)', 'RN_ZCL_62', 'RN_ZCL_63'),
(24, 'Produits financiers de participations', 'RN_C4_1_1', 'RN_C4_1_2'),
(25, 'Produits d''autre valeurs mobilieres et creances de l''actif immobilise', 'RN_C4_2_1', 'RN_C4_2_2'),
(26, 'Autre interets,produit assimiles et differences positives de charge(10)', 'RN_C4_3_1', 'RN_C4_3_2'),
(27, 'Reprises sur provisions et transferts de charges', 'RN_C4_4_1', 'RN_C4_4_2'),
(28, 'Produits nets sur cessions de valeurs mobiliere de placement', 'RN_C4_5_1', 'RN_C4_5_2'),
(29, 'Total des produits financiers(IV)', 'RN_ZCL_64', 'RN_ZCL_65'),
(30, 'Dotations financiere aux amortissements et provisions', 'RN_C5_1_1', 'RN_C5_1_2'),
(31, 'Interet,charges assimilees et differences negatives de charge(II)', 'RN_C5_2_1', 'RN_C5_2_2'),
(32, 'Charges nettes sur cessions de valeurs mobilieres de placement', 'RN_C5_3_1', 'RN_C5_3_2'),
(33, 'Total des charges financieres(V)', 'RN_ZCL_66', 'RN_ZCL_67'),
(34, '2 RESULTAT FINANCIER(IV_V)(VI)', 'RN_ZCL_68', 'RN_ZCL_69');

-- --------------------------------------------------------

-- 
-- Table structure for table `COMPTE_EXPLOITATION3`
-- 

CREATE TABLE `COMPTE_EXPLOITATION3` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `LIBELLE` varchar(100) default NULL,
  `Exercice_N` varchar(20) NOT NULL,
  `Exercice_N_1` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- 
-- Dumping data for table `COMPTE_EXPLOITATION3`
-- 

INSERT INTO `COMPTE_EXPLOITATION3` (`ID`, `LIBELLE`, `Exercice_N`, `Exercice_N_1`) VALUES 
(1, 'Produits exceptionnel sur operations de gestion', 'RN_D1_1_1', 'RN_D1_1_2'),
(2, 'Produits des cessiond d''elements d''actif', 'RN_D1_2_1', 'RN_D1_2_2'),
(3, 'Autres produits exceptionnels sur operations en capital', 'RN_D1_3_1', 'RN_D1_3_2'),
(4, 'Reprises sur provisions et transferts de charges', 'RN_D1_4_1', 'RN_D1_4_2'),
(5, 'Total des produits d''exploitation(12)(VII)', 'RN_ZCL_70', 'RN_ZCL_71'),
(6, 'Charges exceptionnelles sur operations de gestion', 'RN_D1_5_1', 'RN_D1_5_2'),
(7, 'Valeurs comptables des element d''actif cedes', 'RN_D1_6_1', 'RN_D1_6_2'),
(8, 'Autres charges exceptionnelles sur operations en capital', 'RN_D1_7_1', 'RN_D1_7_2'),
(9, 'Dotation aux amortissements et aux provisions', 'RN_D1_8_1', 'RN_D1_8_2'),
(10, 'Total des charges d''exploitation(12)(VIII)', 'RN_ZCL_72', 'RN_ZCL_73'),
(11, '3 RESULTAT EXCEPTIONNEL(VII-VIII)(IX)', 'RN_ZCL_74', 'RN_ZCL_75'),
(12, 'Participation des salaries aux resultat de l''entreprise(X)', 'RN_D1_9_1', 'RN_D1_9_2'),
(13, 'TOTAL DES PRODUITS(I+IV+VII)', 'RN_ZCL_76', 'RN_ZCL_77'),
(14, 'TOTAL DES CHARGES(II+V+VIII+X)', 'RN_ZCL_78', 'RN_ZCL_79'),
(15, '4 BENEFICE OU PERTE(Total dezs produits-Total des charges)', 'RN_ZCL_80', 'RN_ZCL_81'),
(16, 'Dont produit de cessions d''animaux reproducteurs', 'RN_D1_10_1', 'RN_D1_10_2'),
(17, 'Dont operations de nature commerciale ou non commerciale', 'RN_D1_11_1', 'RN_D1_11_2'),
(18, 'Dont rembouresement forfaitaire TVA', 'RN_D1_12_1', 'RN_D1_12_2'),
(19, 'Dont quotes-parts de benefice sur operations faites en commun', 'RN_D1_13_1', 'RN_D1_13_2'),
(20, 'Dont produits d''exploitation afferents a des exercices anterieurs(a detailler au(13)ci-dessous)', 'RN_D1_14_1', 'RN_D1_14_2'),
(21, 'Dont valeur comptable des animaux reprogucteurs cedes', 'RN_D1_15_1', 'RN_D1_15_2'),
(22, 'Dont remuneration du travail de(ou des)lexploitation(s)', 'RN_D1_16_1', 'RN_D1_16_2'),
(23, 'Dont quotes-parts de perte sur operations faites en commun', 'RN_D1_17_1', 'RN_D1_17_2'),
(24, 'Dont charges d''exploitation afferents a des exercices anterieurs(a detailler au(13)ci-dessous)', 'RN_D1_18_1', 'RN_D1_18_2'),
(25, 'Dont differences positives de change', 'RN_D1_19_1', 'RN_D1_19_2'),
(26, 'Dont differences negatives de change', 'RN_D1_20_1', 'RN_D1_20_2'),
(27, 'Detail des produits et charge exceptionnels(si ce cadre est insuffisant,joindre un etat du meme mode', 'Exercice N', 'Exercice N'),
(28, '', 'Charges exceptionnel', 'Produits exceptionne'),
(29, 'RN_D1_21_1', 'RN_D1_21_1', 'RN_D1_21_3'),
(30, 'RN_D1_22_1', 'RN_D1_22_1', 'RN_D1_22_3'),
(31, 'RN_D1_23_1', 'RN_D1_23_1', 'RN_D1_23_3'),
(32, 'RN_D1_24_1', 'RN_D1_24_1', 'RN_D1_24_3'),
(33, 'RN_D1_25_1', 'RN_D1_25_1', 'RN_D1_25_3'),
(34, 'RN_D1_26_1', 'RN_D1_26_1', 'RN_D1_26_3'),
(35, 'Detail des produits et charge anterieurs(si ce cadre est insuffisant,joindre un etat du meme modele)', 'Exercice N', 'Exercice N'),
(36, '', 'Charges anterieurs', 'Produits anterieurs'),
(37, 'RN_D1_27_1', 'RN_D1_27_1', 'RN_D1_27_3'),
(38, 'RN_D1_28_1', 'RN_D1_28_1', 'RN_D1_28_3'),
(39, 'RN_D1_29_1', 'RN_D1_29_1', 'RN_D1_29_3'),
(40, 'RN_D1_30_1', 'RN_D1_30_1', 'RN_D1_30_3'),
(41, 'RN_D1_31_1', 'RN_D1_31_1', 'RN_D1_31_3');

-- --------------------------------------------------------

-- 
-- Table structure for table `DESCRIPTIF_EXPLOITATION`
-- 

CREATE TABLE `DESCRIPTIF_EXPLOITATION` (
  `ID` int(11) NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYMBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `DESCRIPTIF_EXPLOITATION`
-- 

INSERT INTO `DESCRIPTIF_EXPLOITATION` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYMBOLE`) VALUES 
(1, 'Main oeuvre permanente salarie temps', 'GDQT_64111', 'DEX1'),
(2, 'Main oeuvre temporaire salarie temps', 'GDQT_64115', 'DEX2');

-- --------------------------------------------------------

-- 
-- Table structure for table `ECORCHE_FINANCE`
-- 

CREATE TABLE `ECORCHE_FINANCE` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(100) NOT NULL,
  `FORMULE` varchar(200) default NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- 
-- Dumping data for table `ECORCHE_FINANCE`
-- 

INSERT INTO `ECORCHE_FINANCE` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYNBOLE`) VALUES 
(1, 'TF1', '', 'TF1'),
(2, 'Resultat corrige', 'B44-BNS_777?-BNS_775?+BNS_675?-BNSC_726?', 'TF2'),
(3, 'TF3', '', 'TF3'),
(4, 'Dotations', 'BNS_68?-BNS_78?-BNS_79?', 'TF4'),
(5, 'Capacite autofinancement', 'TF2+TF4', 'TF25'),
(6, 'Augmentation de capital', 'BNSMC_1013?+BNSMC_1014?+BNSMC_1015?+BNSMC_1018?', 'TF5'),
(7, 'Diminution de capital', 'BNSMD_1013?+BNSMD_1014?+BNSMD_1015?+BNSMD_1018?', 'TF6'),
(8, 'Investissements', 'FL21', 'TF7'),
(9, 'Cession imobilisations', 'BNS_775?', 'TF8'),
(10, 'Subv equipement percue', 'BNSMC_131?+BNSMC_138?', 'TF9'),
(11, 'Emprunts LMT souscrits', 'FL16', 'TF10'),
(12, 'Rembouresement emprunts LMT', 'BNSMD_161?+BNSMD_163?+BNSMD_1641?+BNSMD_1642?+BNSMD_165?+BNSMD_166?+BNSMD_167?+BNSMD_1681?+BNSMD_1687?', 'TF11'),
(13, 'Prelevement prives', 'FL26', 'TF12'),
(14, 'Apports prives', 'FL27', 'TF13'),
(15, 'Total emplois', 'TF6+TF7+TF11+TF12', 'TF14'),
(16, 'Total ressources', 'TF5+TF8+TF9+TF10+TF13', 'TF15'),
(17, 'TF16', '', 'TF16'),
(18, 'Variatioin Fond de roulement', 'TF15-TF14+TF25', 'TF17'),
(19, 'Variation stock N/(N-1)', 'RN_C2_1_1+RN_C2_2_1-RN_C3_2_1', 'TF18'),
(20, 'VAR1', 'RN_ZCL_29+RN_ZCL_30+RN_ZCL_31+RN_ZCL_32-BNSD_452*-BNSD_453*-BNSD_454*-BNSD_455*-BNSD_456*-BNSD_457*-BNSD_458*+RN_ZCL_35+BNS_6714*-BNS_7714*', 'VAR1'),
(21, 'VAR2', 'RN_A3_7_3+RN_A3_8_3+RN_A3_9_3+RN_A3_10_3-BNNSDR_452*-BNNSDR_453*-BNNSDR_454*-BNNSDR_455*-BNNSDR_456*-BNNSDR_457*-BNNSDR_458*+RN_A3_13_3+BNNS_6714*-BNNS_7714*', 'VAR2'),
(22, 'Var creances N/(N-1)', 'VAR1-VAR2', 'TF19'),
(23, 'VAR3', 'RN_B1_17_1+RN_B1_18_1+RN_B1_19_1+RN_B1_20_1+RN_B1_21_1+RN_B1_22_1-BNSC_452*-BNSC_453*-BNSC_454*-BNSC_455*-BNSC_456*-BNSC_457*-BNSC_458*+RN_B1_23_1', 'VAR3'),
(24, 'VAR4', 'RN_B1_17_2+RN_B1_18_2+RN_B1_19_2+RN_B1_20_2+RN_B1_21_2+RN_B1_22_2-BNNSCR_452*-BNNSCR_453*-BNNSCR_454*-BNNSCR_455*-BNNSCR_456*-BNNSCR_457*-BNNSCR_458*+RN_B1_23_2', 'VAR4'),
(25, 'Var dettes CT N/(N-1)', 'VAR3-VAR4+BNS_1643*+BNS_1688*-BNNS_1643*-BNNS_1688*', 'TF20'),
(26, 'TF21', '', 'TF21'),
(27, 'Var besoin FR', 'TF18+TF19-TF20', 'TF23'),
(28, 'Var treorerie', 'TF17-TF23', 'TF24');

-- --------------------------------------------------------

-- 
-- Table structure for table `FORMULES_BILANS`
-- 

CREATE TABLE `FORMULES_BILANS` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(100) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- 
-- Dumping data for table `FORMULES_BILANS`
-- 

INSERT INTO `FORMULES_BILANS` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYNBOLE`) VALUES 
(1, 'Source Bilan Actif imprime cerfa', 'RN_ZCL_21', 'BC1'),
(2, 'Source Bilan Actif imprime cerfa', 'RN_ZCL_23+RN_ZCL_24+RN_ZCL_25+RN_ZCL_26+RN_ZCL_27+RN_ZCL_28', 'BC2'),
(3, 'Source Bilan Actif imprime cerfa', 'RN_ZCL_29+RN_ZCL_30+RN_ZCL_31+RN_ZCL_32+RN_ZCL_33+RN_ZCL_34+RN_ZCL_35+RN_ZCL_40+RN_ZCL_41', 'BC3'),
(4, 'Source Bilan Passif imprime cerfa', 'RN_ZCL_46', 'BC4'),
(5, 'Source Bilan Passif imprime cerfa', 'RN_B1_13_1+RN_B1_14_1', 'BC5'),
(6, 'Source Bilan Passif imprime cerfa', 'RN_B1_15_1+RN_B1_16_1+RN_B1_17_1+RN_B1_18_1+RN_B1_19_1+RN_B1_20_1+RN_B1_21_1+RN_B1_22_1RN_B1_23_1', 'BC6'),
(7, 'Source Bilan Actif imprime cerfa', 'RN_ZCL_22', 'BC7'),
(8, 'Source Bilan Actif imprime cerfa', 'RN_A3_1_3+RN_A3_2_3+RN_A3_3_3+RN_A3_4_3+RN_A3_5_3+RN_A3_6_3', 'BC8'),
(9, 'Source Bilan Actif imprime cerfa', 'RN_A3_7_3+RN_A3_8_3+RN_A3_9_3+RN_A3_10_3+RN_A3_11_3+RN_A3_12_3+RN_A3_13_3+RN_A4_1_2+RN_A4_2_2', 'BC9'),
(10, 'Source Bilan Passif imprime cerfa', 'RN_ZCL_47', 'BC10'),
(11, 'Source Bilan Passif imprime cerfa', 'RN_B1_13_2+RN_B1_14_2', 'BC11'),
(12, 'Source Bilan Passif imprime cerfa', 'RN_B1_15_2+RN_B1_16_2+RN_B1_17_2+RN_B1_18_2+RN_B1_19_2+RN_B1_20_2+RN_B1_21_2+RN_B1_22_2+RN_B1_23_2', 'BC12'),
(13, 'Report en annee suivant(N+1) de la case', 'BC7', 'BC13'),
(14, 'Report en annee suivant(N+1) de la case', 'BC8', 'BC14'),
(15, 'Report en annee suivant(N+1) de la case', 'BC9', 'BC15'),
(16, 'Report en annee suivant(N+1) de la case', 'BC10', 'BC16'),
(17, 'Report en annee suivant(N+1) de la case', 'BC11', 'BC17'),
(18, 'Report en annee suivant(N+1) de la case', 'BC12', 'BC18'),
(19, 'BC19', 'BC1+BC2+BC3', 'BC19'),
(20, 'BC20', 'BC7+BC8+BC9', 'BC20'),
(21, 'BC21', 'BC13+BC14+BC15', 'BC21'),
(22, 'BC22', 'BC2+BC3', 'BC22'),
(23, 'BC23', 'BC6', 'BC23'),
(24, 'BC24', 'BC22-BC23', 'BC24'),
(25, 'BC25', 'BC8+BC9', 'BC25'),
(26, 'BC26', 'BC12', 'BC26'),
(27, 'BC27', 'BC25-BC26', 'BC27'),
(28, 'Report en annee suivant(N+1) de la case', 'BC14+BC15', 'BC28'),
(29, 'Report en annee suivant(N+1) de la case', 'BC18+BC19', 'BC29'),
(30, 'Report en annee suivant(N+1) de la case', 'BC28-BC29', 'BC30'),
(31, 'BC31', 'BC24-BC27', 'BC31'),
(32, 'BC32', 'BC27-BC30', 'BC32');

-- --------------------------------------------------------

-- 
-- Table structure for table `FORMULES_FLUX`
-- 

CREATE TABLE `FORMULES_FLUX` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

-- 
-- Dumping data for table `FORMULES_FLUX`
-- 

INSERT INTO `FORMULES_FLUX` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYNBOLE`) VALUES 
(1, 'chiffre d''affaires', 'BNS_70*+BNS_75*', 'FL1'),
(2, 'subventions', 'BNS_74*', 'FL2'),
(3, 'VAR1', 'RN_ZCL_29+RN_ZCL_30+RN_ZCL_31+RN_ZCL_32-BNSD_452*-BNSD_453*-BNSD_454*-BNSD_455*-BNSD_456*-BNSD_457*-BNSD_458*+RN_ZCL_35+BNS_6714*-BNS_7714*', 'VAR1'),
(4, 'VAR2', 'RN_A3_7_3+RN_A3_8_3+RN_A3_9_3+RN_A3_10_3-BNNSDR_452*-BNNSDR_453*-BNNSDR_454*-BNNSDR_455*-BNNSDR_456*-BNNSDR_457*-BNNSDR_458*+RN_A3_13_3+BNNS_6714*-BNNS_7714*', 'VAR2'),
(5, 'INTER_FL3', 'VAR1-VAR2', 'INTER_FL3'),
(6, 'INTER_FL33', 'VAR2-VAR1', 'INTER_FL33'),
(7, 'Variation des creances si negative', 'INTER_FL33>0', 'FL3'),
(8, 'INTER_FL4', 'BNS_1643*+BNS_168*-BNNS_1643*-BNNS_168*', 'INTER_FL4'),
(9, 'INTER_FL44', 'BNNS_1643*+BNNS_168*-BNS_1643*-BNS_168*', 'INTER_FL44'),
(10, 'VAR CT fin si>0', 'INTER_FL4>0', 'FL4'),
(11, 'sous total ressources', 'FL1+FL2+FL3+FL4', 'FL5'),
(12, 'Var creances', 'INTER_FL3>0', 'FL6'),
(13, 'VAR CT fin si<0', 'INTER_FL44>0', 'FL7'),
(14, 'sous total emplois', 'FL6+FL7', 'FL8'),
(15, 'VAR3', 'RN_B1_17_1+RN_B1_18_1+RN_B1_19_1+RN_B1_20_1+RN_B1_21_1+RN_B1_22_1+RN_B1_23_1-BNSC_452*-BNSC_453*-BNSC_454*-BNSC_455*-BNSC_456*-BNSC_457*-BNSC_458*', 'VAR3'),
(16, 'VAR4', 'RN_B1_17_2+RN_B1_18_2+RN_B1_19_2+RN_B1_20_2+RN_B1_21_2+RN_B1_22_2+RN_B1_23_2-BNNSCR_452*-BNNSCR_453*-BNNSCR_454*-BNNSCR_455*-BNNSCR_456*-BNNSCR_457*-BNNSCR_458*', 'VAR4'),
(17, 'INTER_FL10', 'VAR3-VAR4', 'INTER_FL10'),
(18, 'INTER_FL1010', 'VAR4-VAR3', 'INTER_FL1010'),
(19, 'augmentation DCT', 'INTER_FL10>0', 'FL10'),
(20, 'sous total', 'FL10', 'FL11'),
(21, 'charges d''exploitation', 'B16-B11+B18+B21+B23+B24+B29+BNS_66*-BNS_6611*-BNS_6612*', 'FL12'),
(22, 'diminution DCT', 'INTER_FL1010>0', 'FL13'),
(23, 'sous total', 'FL12+FL13', 'FL14'),
(24, 'ETE', 'FL5-FL8+FL11-FL14', 'FL15'),
(25, 'Emprunts nouveaux', 'BNSMC_161*+BNSMC_163*+BNSMC_1641*+BNSMC_1642*+BNSMC_165*+BNSMC_166*+BNSMC_167*+BNSMC_1681*+BNSMC_1687*', 'FL16'),
(26, 'Vente immob', 'BNS_775*', 'FL17'),
(27, 'subvention d''equipement', 'BNSMC_131*+BNSMC_138*', 'FL18'),
(28, 'produits financiers', 'BNS_76*', 'FL19'),
(29, 'sous totale', 'FL16+FL17+FL18+FL19', 'FL20'),
(30, 'invertissments', 'ACQUISITION', 'FL21'),
(31, 'autofinancement', 'FL21-FL20', 'FL24'),
(32, 'annunite LMT', 'BNSMD_161*+BNSMD_163*+BNSMD_1641*+BNSMD_1642*+BNSMD_165*+BNSMD_166*+BNSMD_167*BNSMD_1681*+BNSMD_1687*+BNS_6611*+BNS_6612*-BNS_1688*+BNNS_1688*', 'FL25'),
(33, 'VAR5', '-BNS_455*-BNS_456*+BNNS_455*+BNNS_456*+BNNSCR_120*-BNNSDR_129* +BNS_6413*+BNS_108*-BNSC_726*', 'VAR5'),
(34, 'prelevement', 'VAR5>0', 'FL26'),
(35, 'INTER_FL27', 'VAR5<0', 'INTER_FL27'),
(36, 'apports', '-INTER_FL27', 'FL27'),
(37, 'FL28', 'BNS_695*+BNS_697*', 'FL28'),
(38, 'FL29', 'FL15-FL24-FL25-FL26-FL28+FL27', 'FL29');

-- --------------------------------------------------------

-- 
-- Table structure for table `FORMULES_INTER1`
-- 

CREATE TABLE `FORMULES_INTER1` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) default NULL,
  `ABSOLUE` tinyint(1) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `FORMULES_INTER1`
-- 

INSERT INTO `FORMULES_INTER1` (`ID`, `NOM_FORMULE`, `FORMULE`, `ABSOLUE`, `SYNBOLE`) VALUES 
(1, 'VENTES DE MARCHANDISES', 'BNS_707*', 0, 'B3'),
(2, '-ACHATS DE MARCHANDISES', 'BNS_607*', 1, 'B4'),
(3, 'Variation d''inventaire des MARCHANDISES STOCKEES', 'BNS_6037*', 0, 'B5'),
(4, 'MARGE COMMERCIALE', 'B3-B4-B5', 0, 'B7'),
(5, 'CHIFFRE D''AFFAIRE DE LA PRODUCTION', 'BNS_70*-BNS_707*', 0, 'B9'),
(6, 'Variation d''inventaire DE LA PRODUCTION STOCKEE', 'BNS_71*', 0, 'B10'),
(7, 'PRODUCTION IMMOBILISEE', 'BNS_721*+BNS_722*+BNS_724*', 0, 'B11'),
(8, 'PRODUCTION AUTOCONSOMMEE', 'BNS_726*', 0, 'B12'),
(9, 'INDEMNITES ET SUBVENTIONS D''EXPLOITATION', 'BNS_74*', 0, 'B13'),
(10, 'PRODUCTION DE L''EXERCICE', 'B9+B10+B11+B12+B13', 0, 'B15'),
(11, '-APPROVISIONNEMENTS', 'BNS_601*+BNS_602*+BNS_604*+BNS_609*', 1, 'B16'),
(12, 'Variation inventaire APPROVISIONNEMENTS', 'BNS_603*-BNS_6037*', -1, 'B17'),
(13, '-AUTRES ACHATS ET CHARGES EXTERNES', 'BNS_605*+BNS_606*+BNS_608*+BNS_61*+BNS_62*', 1, 'B18'),
(14, 'VALEUR AJOUTEE PRODUITE', 'B7+B15-B16-B17-B18', 0, 'B20'),
(15, '-IMPOTS ET TAXES', 'BNS_63*', 1, 'B21'),
(16, '-REMUNERATIONS DES ASSOCIES', 'BNS_6413*', 1, 'B22'),
(17, '-MSA EXPLOITANTS', 'BNS_646*', 1, 'B23'),
(18, '-AUTRES CHARGES DE PERSONNEL', 'BNS_64*-BNS_6413*-BNS_646*', 1, 'B24'),
(19, 'EXCEDENT BRUT D''EXPLOITATION', 'B20-B21-B22-B23-B24', 0, 'B26'),
(20, '+Reprise sur provisions et transfert de charges', 'BNS_781*+BNS_791*+BNS_75*', 0, 'B27'),
(21, '-Dotation aux amortissement et aux provisions', 'BNS_68*-BNS_686*-BNS_687*', 1, 'B28'),
(22, '-Autres charges d''exploitation', 'BNS_65*', 1, 'B29'),
(23, 'RESULTAT D''EXPLOITATION', 'B26+B27-B28-B29', 0, 'B31'),
(24, '+Produits financiers', 'BNS_76*+BNS_786*-BNS_796*', 0, 'B32'),
(25, '-Charges financiere', 'BNS_66*+BNS_686*', 1, 'B33'),
(26, 'RESULTAT COURANT AVANT IMPOT', 'B31+B32-B33', 0, 'B35'),
(27, '+Produits exceptionnels divers', 'BNS_771*+BNS_772*+BNS_778*+BNS_787*', 0, 'B36'),
(28, '+Produits des cessions d''element d''actif', 'BNS_775*', 0, 'B37'),
(29, '+Autres produits exceptionnels s/operations en capital', 'BNS_777*', 0, 'B38'),
(30, '-Charges exceptionnelles diverses', 'BNS_67*-BNS_675*+BNS_687*', 1, 'B39'),
(31, '-Valeurs nettes comptables des elements d''actif cedes', 'BNS_675*', 1, 'B40'),
(32, '-Impot sur les societes(I.S)', 'BNS_695*+BNS_697*', 1, 'B42'),
(33, 'RESULTAT DE L''EXERCICE', 'B35+B36+B37+B38-B39-B40-B42', 0, 'B44');

-- --------------------------------------------------------

-- 
-- Table structure for table `FORMULES_INTER2`
-- 

CREATE TABLE `FORMULES_INTER2` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) default NULL,
  `ABSOLUE` tinyint(1) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `FORMULES_INTER2`
-- 

INSERT INTO `FORMULES_INTER2` (`ID`, `NOM_FORMULE`, `FORMULE`, `ABSOLUE`, `SYNBOLE`) VALUES 
(1, 'VENTES DE MARCHANDISES', 'BNNS_707*', 0, 'C3'),
(2, '-ACHATS DE MARCHANDISES', 'BNNS_607*', 1, 'C4'),
(3, 'Variation d''inventaire des MARCHANDISES STOCKEES', 'BNNS_6037*', 0, 'C5'),
(4, 'MARGE COMMERCIALE', 'C3-C4-C5', 0, 'C7'),
(5, 'CHIFFRE D''AFFAIRE DE LA PRODUCTION', 'BNNS_70*-BNNS_707*', 0, 'C9'),
(6, 'Variation d''inventaire DE LA PRODUCTION STOCKEE', 'BNNS_71*', 0, 'C10'),
(7, 'PRODUCTION IMMOBILISEE', 'BNNS_721*+BNNS_722*+BNNS_724*', 0, 'C11'),
(8, 'PRODUCTION AUTOCONSOMMEE', 'BNNS_726*', 0, 'C12'),
(9, 'INDEMNITES ET SUBVENTIONS D''EXPLOITATION', 'BNNS_74*', 0, 'C13'),
(10, 'PRODUCTION DE L''EXERCICE', 'C9+C10+C11+C12+C13', 0, 'C15'),
(11, '-APPROVISIONNEMENTS', 'BNNS_601*+BNNS_602*+BNNS_604*+BNNS_609*', 1, 'C16'),
(12, 'Variation inventaire APPROVISIONNEMENTS', 'BNNS_603*-BNNS_6037*', -1, 'C17'),
(13, '-AUTRES ACHATS ET CHARGES EXTERNES', 'BNNS_605*+BNNS_606*+BNNS_608*+BNNS_61*+BNNS_62*', 1, 'C18'),
(14, 'VALEUR AJOUTEE PRODUITE', 'C7+C15-C16-C17-C18', 0, 'C20'),
(15, '-IMPOTS ET TAXES', 'BNNS_63*', 1, 'C21'),
(16, '-REMUNERATIONS DES ASSOCIES', 'BNNS_6413*', 1, 'C22'),
(17, '-MSA EXPLOITANTS', 'BNNS_646*', 1, 'C23'),
(18, '-AUTRES CHARGES DE PERSONNEL', 'BNNS_64*-BNNS_6413*-BNNS_646*', 1, 'C24'),
(19, 'EXCEDENT BRUT D''EXPLOITATION', 'C20-C21-C22-C23-C24', 0, 'C26'),
(20, '+Reprise sur provisions et transfert de charges', 'BNNS_781*+BNNS_791*+BNNS_75*', 0, 'C27'),
(21, '-Dotation aux amortissement et aux provisions', 'BNNS_68*-BNNS_686*-BNNS_687*', 1, 'C28'),
(22, '-Autres charges d''exploitation', 'BNNS_65*', 1, 'C29'),
(23, 'RESULTAT D''EXPLOITATION', 'C26+C27-C28-C29', 0, 'C31'),
(24, '+Produits financiers', 'BNNS_76*+BNNS_786*-BNNS_796*', 0, 'C32'),
(25, '-Charges financiere', 'BNNS_66*+BNNS_686*', 1, 'C33'),
(26, 'RESULTAT COURANT AVANT IMPOT', 'C31+C32-C33', 0, 'C35'),
(27, '+Produits exceptionnels divers', 'BNNS_771*+BNNS_772*+BNNS_778*+BNNS_787*', 0, 'C36'),
(28, '+Produits des cessions d''element d''actif', 'BNNS_775*', 0, 'C37'),
(29, '+Autres produits exceptionnels s/operations en capital', 'BNNS_777*', 0, 'C38'),
(30, '-Charges exceptionnelles diverses', 'BNNS_67*-BNNS_675*+BNNS_687*', 1, 'C39'),
(31, '-Valeurs nettes comptables des elements d''actif cedes', 'BNNS_675*', 1, 'C40'),
(32, '-Impot sur les societes(I.S)', 'BNNS_695*+BNNS_697*', 1, 'C42'),
(33, 'RESULTAT DE L''EXERCICE', 'C35+C36+C37+C38-C39-C40-C42', 0, 'C44');

-- --------------------------------------------------------

-- 
-- Table structure for table `FORMULES_INTER3`
-- 

CREATE TABLE `FORMULES_INTER3` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(200) NOT NULL,
  `FORMULE` varchar(200) default NULL,
  `ABSOLUE` tinyint(1) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- Dumping data for table `FORMULES_INTER3`
-- 

INSERT INTO `FORMULES_INTER3` (`ID`, `NOM_FORMULE`, `FORMULE`, `ABSOLUE`, `SYNBOLE`) VALUES 
(1, 'VENTES DE MARCHANDISES', '', 0, 'D3'),
(2, '-ACHATS DE MARCHANDISES', '', 1, 'D4'),
(3, 'Variation d''inventaire des MARCHANDISES STOCKEES', '', 0, 'D5'),
(4, 'MARGE COMMERCIALE', '', 0, 'D7'),
(5, 'CHIFFRE D''AFFAIRE DE LA PRODUCTION', '', 0, 'D9'),
(6, 'Variation d''inventaire DE LA PRODUCTION STOCKEE', '', 0, 'D10'),
(7, 'PRODUCTION IMMOBILISEE', '', 0, 'D11'),
(8, 'PRODUCTION AUTOCONSOMMEE', '', 0, 'D12'),
(9, 'INDEMNITES ET SUBVENTIONS D''EXPLOITATION', '', 0, 'D13'),
(10, 'PRODUCTION DE L''EXERCICE', '', 0, 'D15'),
(11, '-APPROVISIONNEMENTS', '', 1, 'D16'),
(12, 'Variation inventaire APPROVISIONNEMENTS', '', -1, 'D17'),
(13, '-AUTRES ACHATS ET CHARGES EXTERNES', '', 1, 'D18'),
(14, 'VALEUR AJOUTEE PRODUITE', '', 0, 'D20'),
(15, '-IMPOTS ET TAXES', '', 1, 'D21'),
(16, '-REMUNERATIONS DES ASSOCIES', '', 1, 'D22'),
(17, '-MSA EXPLOITANTS', '', 1, 'D23'),
(18, '-AUTRES CHARGES DE PERSONNEL', '', 1, 'D24'),
(19, 'EXCEDENT BRUT D''EXPLOITATION', '', 0, 'D26'),
(20, '+Reprise sur provisions et transfert de charges', '', 0, 'D27'),
(21, '-Dotation aux amortissement et aux provisions', '', 1, 'D28'),
(22, '-Autres charges d''exploitation', '', 1, 'D29'),
(23, 'RESULTAT D''EXPLOITATION', '', 0, 'D31'),
(24, '+Produits financiers', '', 0, 'D32'),
(25, '-Charges financiere', '', 1, 'D33'),
(26, 'RESULTAT COURANT AVANT IMPOT', '', 0, 'D35'),
(27, '+Produits exceptionnels divers', '', 0, 'D36'),
(28, '+Produits des cessions d''element d''actif', '', 0, 'D37'),
(29, '+Autres produits exceptionnels s/operations en capital', '', 0, 'D38'),
(30, '-Charges exceptionnelles diverses', '', 1, 'D39'),
(31, '-Valeurs nettes comptables des elements d''actif cedes', '', 1, 'D40'),
(32, '-Impot sur les societes(I.S)', '', 1, 'D42'),
(33, 'RESULTAT DE L''EXERCICE', '', 0, 'D44');

-- --------------------------------------------------------

-- 
-- Table structure for table `RATIOS1`
-- 

CREATE TABLE `RATIOS1` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(100) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- 
-- Dumping data for table `RATIOS1`
-- 

INSERT INTO `RATIOS1` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYNBOLE`) VALUES 
(1, 'INTER11', 'RN_ZCL_46+BNS_455?', 'INTER11'),
(2, 'INTER12', 'RN_ZCL_46+RN_ZCL_48+RN_B1_13_1+RN_B1_14_1', 'INTER12'),
(3, 'Autonomie financière : (Capitaux propres) / (Capitaux permanents)', 'INTER11/INTER12*100', 'RF1'),
(4, 'Liquidité réduite : (Réalisables + disponibles) / (Dettes à court terme)', 'BC3/BC6*100', 'RF2'),
(5, 'Amortissement des immobilisations : (Total des amort.) / (Immob. Brutes amortissables)', 'RN_ZCL_20/RN_ZCL_19*100', 'RF3'),
(6, 'VAR11A', 'RN_A3_8_1*360', 'VAR11A'),
(7, 'VAR11B', 'RN_A3_9_1*360', 'VAR11B'),
(8, 'VAR11', 'VAR11A+VAR11B', 'VAR11'),
(9, 'VAR12', 'RN_ZCL_56+BNSMC_4457?', 'VAR12'),
(10, 'Crédits clients : (Clients + effets à recevoir x 360) / (Chiffre d''affaires TTC)', 'VAR11/VAR12', 'RF4'),
(11, 'VAR13', 'BNS_401?+BNS_402?+BNS_403?+BNS_408?', 'VAR13'),
(12, 'VAR14', 'BNS_60?-BNS_603?+BNS_61?+BNS_62?+BNSMD_44566?', 'VAR14'),
(13, 'Crédits fournisseurs : (Frs hors immob + effets à payer x 360) / (Achats + frais généraux TTC)', 'VAR13/VAR14*360', 'RF5'),
(14, 'Annuités/EBE : (Annuités) / (Excédent Brut d''Exploitation)', 'FL25/FL26', 'RF6'),
(15, 'INTER13', 'RN_B1_8_1+BNS_6413?', 'INTER13'),
(16, 'INTER14', 'RN_ZCL_46+BNS_455?', 'INTER14'),
(17, 'Taux de rentabilité financière : (Bénéfice) / (Capitaux propres)', 'INTER13/INTER14*100', 'RF7'),
(18, 'INTER15', 'RN_ZCL_56+BNSMC_4457?', 'INTER15'),
(19, 'Poids total des frais financiers : (Frais financiers) / (Chiffre d''affaires TTC)', 'RN_C5_2_1/INTER15*100', 'RF8'),
(20, 'INTER16', 'BNS_66?-BNS_6611?-BNS_6612?', 'INTER16'),
(21, 'INTER17', 'RN_ZCL_56+BNSMC_4457?', 'INTER17'),
(22, 'Cout de la trésorerie : (Frais financiers CT et OC) / (Chiffres d''affaires TTC)', 'INTER16/INTER17*100', 'RF9'),
(23, 'VAR15A', 'BNS_3?/2', 'VAR15A'),
(24, 'VAR15B', 'BNNS_3?/2', 'VAR15B'),
(25, 'VAR15', 'VAR15A+VAR15B', 'VAR15'),
(26, 'VAR16', 'BNNS_3?+BNS_60?-BNS_603?-BNS_605?-BNS_606?-BNS_3?', 'VAR16'),
(27, 'Rotation des stocks : (Stock moyen) / (Stock initial + Achats - stock final)', 'VAR15/VAR16*360', 'RF10');

-- --------------------------------------------------------

-- 
-- Table structure for table `RATIOS2`
-- 

CREATE TABLE `RATIOS2` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `NOM_FORMULE` varchar(100) NOT NULL,
  `FORMULE` varchar(200) NOT NULL,
  `SYNBOLE` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- 
-- Dumping data for table `RATIOS2`
-- 

INSERT INTO `RATIOS2` (`ID`, `NOM_FORMULE`, `FORMULE`, `SYNBOLE`) VALUES 
(1, 'INTER21', 'RN_ZCL_47+BNNS_455?', 'INTER21'),
(2, 'INTER22', 'RN_ZCL_47+RN_ZCL_49+RN_B1_13_2+RN_B1_14_2', 'INTER22'),
(3, 'Autonomie financière : (Capitaux propres) / (Capitaux permanents)', 'INTER21/INTER22*100', 'RF11'),
(4, 'Liquidité réduite : (Réalisables + disponibles) / (Dettes à court terme)', 'BC9/BC12*100', 'RF12'),
(5, 'INTER23', 'BNNS_28?', 'INTER23'),
(6, 'INTER24', 'BNNS_2?-BNNS_28?', 'INTER24'),
(7, 'Amortissement des immobilisations : (Total des amort.) / (Immob. Brutes amortissables)', 'INTER23/INTER24*100', 'RF13'),
(8, 'VAR21A', 'RN_A3_8_3*360', 'VAR21A'),
(9, 'VAR21B', 'RN_A3_9_3*360', 'VAR21B'),
(10, 'VAR21', 'VAR21A+VAR21B', 'VAR21'),
(11, 'VAR22', 'RN_ZCL_57+BNSMC_4457?', 'VAR22'),
(12, 'Crédits clients : (Clients + effets à recevoir x 360) / (Chiffre d''affaires TTC)', 'VAR21/VAR22', 'RF14'),
(13, 'VAR23', 'BNNS_401?+BNNS_402?+BNNS_403?+BNNS_408?', 'VAR23'),
(14, 'VAR24', 'BNNS_60?-BNNS_603?+BNNS_61?+BNNS_62?+BNSMD_44566?', 'VAR24'),
(15, 'Crédits fournisseurs : (Frs hors immob + effets à payer x 360) / (Achats + frais généraux TTC)', 'VAR23/VAR24*360', 'RF15'),
(16, 'Annuités/EBE : (Annuités) / (Excédent Brut d''Exploitation)', 'RF6', 'RF16'),
(17, 'INTER25', 'RN_B1_8_2+BNNS_6413?', 'INTER25'),
(18, 'INTER26', 'RN_ZCL_47+BNNS_455?', 'INTER26'),
(19, 'Taux de rentabilité financière : (Bénéfice) / (Capitaux propres)', 'INTER25/INTER26*100', 'RF17'),
(20, 'INTER27', 'RN_ZCL_57+BNSMC_4457?', 'INTER27'),
(21, 'Poids total des frais financiers : (Frais financiers) / (Chiffre d''affaires TTC)', 'RN_C5_2_1/INTER5*100', 'RF18'),
(22, 'INTER28', 'BNNS_66?-BNNS_6611?-BNNS_6612?', 'INTER28'),
(23, 'INTER29', 'RN_ZCL_57+BNSMC_4457?', 'INTER29'),
(24, 'Cout de la trésorerie : (Frais financiers CT et OC) / (Chiffres d''affaires TTC)', 'INTER28/INTER29*100', 'RF19'),
(25, 'Rotation des stocks : (Stock moyen) / (Stock initial + Achats - stock final)', 'RF10', 'RF20');

-- --------------------------------------------------------

-- 
-- Table structure for table `contenu_dossier`
-- 

CREATE TABLE `contenu_dossier` (
  `ID_CD` int(10) unsigned NOT NULL auto_increment,
  `ANNEE` year(4) NOT NULL,
  `ID_DOSSIER` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ID_CD`),
  KEY `fk2` (`ID_DOSSIER`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `contenu_dossier`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `description_tableau`
-- 

CREATE TABLE `description_tableau` (
  `id` int(11) NOT NULL auto_increment,
  `page` varchar(30) NOT NULL,
  `tableau` varchar(30) NOT NULL,
  `libelle` tinyint(1) NOT NULL,
  `nb_col_val` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `description_tableau`
-- 

INSERT INTO `description_tableau` (`id`, `page`, `tableau`, `libelle`, `nb_col_val`) VALUES 
(1, 'tableau_flux', 'exercice', 1, 2),
(2, 'tableau_flux', 'ressources', 0, 0),
(3, 'tableau_flux', 'emplois', 0, 0),
(9, 'bilans_comparatifs', 'passif', 0, 3),
(8, 'bilans_comparatifs', 'actif', 0, 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `dossiers`
-- 

CREATE TABLE `dossiers` (
  `ID_DOSSIER` int(10) unsigned NOT NULL auto_increment,
  `NUM_DOSSIER` varchar(20) NOT NULL,
  `CHEMIN_DOSSIER` varchar(60) default NULL,
  `NOM_ENTREPRISE` varchar(50) default NULL,
  `CONSULTATION` tinyint(4) default NULL,
  `ID_USER` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`ID_DOSSIER`),
  KEY `fk1` (`ID_USER`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `dossiers`
-- 

INSERT INTO `dossiers` (`ID_DOSSIER`, `NUM_DOSSIER`, `CHEMIN_DOSSIER`, `NOM_ENTREPRISE`, `CONSULTATION`, `ID_USER`) VALUES 
(1, '44', NULL, 'ma', NULL, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `logins`
-- 

CREATE TABLE `logins` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `USER` varchar(45) NOT NULL,
  `PASSWORD` varchar(45) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `logins`
-- 

INSERT INTO `logins` (`ID`, `USER`, `PASSWORD`) VALUES 
(1, 'admin', '123'),
(2, 'user1', '1234'),
(3, 'user2', '123');

-- --------------------------------------------------------

-- 
-- Table structure for table `tableaux`
-- 

CREATE TABLE `tableaux` (
  `id` bigint(20) NOT NULL auto_increment,
  `page` varchar(30) NOT NULL,
  `tableau` varchar(30) NOT NULL,
  `libelle` varchar(30) NOT NULL,
  `valeur_1` varchar(15) NOT NULL,
  `valeur_2` varchar(15) NOT NULL,
  `valeur_3` varchar(15) NOT NULL,
  `valeur_4` varchar(15) NOT NULL,
  `valeur_5` varchar(15) NOT NULL,
  `valeur_6` varchar(15) NOT NULL,
  `valeur_7` varchar(15) NOT NULL,
  `valeur_8` varchar(15) NOT NULL,
  `valeur_9` varchar(15) NOT NULL,
  `valeur_10` varchar(15) NOT NULL,
  `affichage` varchar(15) NOT NULL,
  `ordre` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- 
-- Dumping data for table `tableaux`
-- 

INSERT INTO `tableaux` (`id`, `page`, `tableau`, `libelle`, `valeur_1`, `valeur_2`, `valeur_3`, `valeur_4`, `valeur_5`, `valeur_6`, `valeur_7`, `valeur_8`, `valeur_9`, `valeur_10`, `affichage`, `ordre`) VALUES 
(1, 'tableau_flux', 'exercice', 'chiffre d''affaires', '', 'FL1', '', '', '', '', '', '', '', '', '', 0),
(2, 'tableau_flux', 'exercice', 'subvention', '', 'FL2', '', '', '', '', '', '', '', '', '', 0),
(3, 'tableau_flux', 'exercice', 'var creances', 'FL6', 'FL3', '', '', '', '', '', '', '', '', '', 0),
(4, 'tableau_flux', 'exercice', 'var CT finance', 'FL7', 'FL4', '', '', '', '', '', '', '', '', '', 0),
(5, 'tableau_flux', 'exercice', 'sous total', 'FL8', 'FL5', '', '', '', '', '', '', '', '', '', 0),
(6, 'tableau_flux', 'exercice', 'Charges d''ex', 'FL12', '', '', '', '', '', '', '', '', '', '', 0),
(7, 'tableau_flux', 'exercice', 'var fournisseur', 'FL13', 'FL10', '', '', '', '', '', '', '', '', '', 0),
(8, 'tableau_flux', 'exercice', 'sous total', 'FL14', 'FL11', '', '', '', '', '', '', '', '', '', 0),
(9, 'bilans_comparatifs', 'actif', 'N', 'BC1', 'BC2', 'BC3', '', '', '', '', '', '', '', '', 0),
(10, 'bilans_comparatifs', 'actif', 'N-1', 'BC7', 'BC8', 'BC9', '', '', '', '', '', '', '', '', 0),
(11, 'bilans_comparatifs', 'actif', 'N-2', 'BC13', 'BC14', 'BC15', '', '', '', '', '', '', '', '', 0),
(12, 'bilans_comparatifs', 'passif', 'N', 'BC4', 'BC5', 'BC6', '', '', '', '', '', '', '', '', 0),
(13, 'bilans_comparatifs', 'passif', 'N-1', 'BC10', 'BC11', 'BC12', '', '', '', '', '', '', '', '', 0),
(14, 'bilans_comparatifs', 'passif', 'N-2', 'BC16', 'BC17', 'BC18', '', '', '', '', '', '', '', '', 0),
(15, 'bilans_comparatifs', 'totaux', '', 'BC19', 'BC20', 'BC21', '', '', '', '', '', '', '', '', 0),
(16, 'bilans_comparatifs', 'fonds_roulement', '+ Actif circulant', 'BC22', 'BC25', 'BC28', '', '', '', '', '', '', '', '', 0),
(17, 'bilans_comparatifs', 'fonds_roulement', '- Dettes à court terme', 'BC23', 'BC26', 'BC29', '', '', '', '', '', '', '', '', 0),
(18, 'bilans_comparatifs', 'fonds_roulement', '= Fonds de roulement (FR)', 'BC24', 'BC27', 'BC30', '', '', '', '', '', '', '', '', 0),
(19, 'bilans_comparatifs', 'variation_fr', 'Variation du FR', 'BC31', 'BC32', '', '', '', '', '', '', '', '', '', 0),
(20, 'tableau_flux', 'ressources', 'Emprunts', 'FL16', '', '', '', '', '', '', '', '', '', '', 0),
(21, 'tableau_flux', 'ressources', 'Vente immobilisation', 'FL17', '', '', '', '', '', '', '', '', '', '', 0),
(22, 'tableau_flux', 'ressources', 'Subvention d''équipement', 'FL18', '', '', '', '', '', '', '', '', '', '', 0),
(23, 'tableau_flux', 'ressources', 'Produits financiers', 'FL19', '', '', '', '', '', '', '', '', '', '', 0),
(24, 'tableau_flux', 'ressources', 'Sous total', 'FL20', '', '', '', '', '', '', '', '', '', '', 0),
(25, 'tableau_flux', 'emplois', 'Investissements', 'FL21', '', '', '', '', '', '', '', '', '', '', 0),
(26, 'tableau_flux', 'emplois_ressources', 'Prélèvements', 'FL26', '', '', '', '', '', '', '', '', '', '', 0),
(27, 'tableau_flux', 'emplois_ressources', 'Apports privés', '', 'FL27', '', '', '', '', '', '', '', '', '', 0),
(28, 'tableau_flux', 'emplois_ressources', 'Impots/ste', 'FL28', '', '', '', '', '', '', '', '', '', '', 0),
(29, 'ATE', 'activite_globale', 'N-2', 'ATE1', 'ATE4', 'ATE7', '', '', '', '', '', '', '', '', 0),
(30, 'ATE', 'activite_globale', 'N-1', 'ATE2', 'ATE5', 'ATE8', '', '', '', '', '', '', '', '', 0),
(31, 'ATE', 'activite_globale', 'N', 'ATE3', 'ATE6', 'ATE9', '', '', '', '', '', '', '', '', 0),
(32, 'ATE', 'charges_globales', 'Ch. Opérationnelles', 'C55', 'D55', 'E55', 'F55', 'G55', 'H55', '', '', '', '', '', 0),
(33, 'ATE', 'charges_globales', 'Mécanisation', 'C56', 'D56', 'E56', 'F56', 'G56', 'H56', '', '', '', '', '', 0),
(34, 'ATE', 'charges_globales', 'Main d''oeuvre', 'C57', 'D57', 'E57', 'F57', 'G57', 'H57', '', '', '', '', '', 0),
(35, 'ATE', 'charges_globales', 'Foncier', 'C58', 'D58', 'E58', 'F58', 'G58', 'H58', '', '', '', '', '', 0),
(36, 'ATE', 'charges_globales', 'Diverses', 'C59', 'D59', 'E59', 'F59', 'G59', 'H59', '', '', '', '', '', 0),
(37, 'ATE', 'charges_globales', 'Total', 'C60', 'D60', 'E60', 'F60', 'G60', 'H60', '', '', '', '', '', 0),
(38, 'ATE', 'charge_globale_graph', 'N-2', 'G60', '', '', '', '', '', '', '', '', '', '', 0),
(39, 'ATE', 'charge_globale_graph', 'N-1', 'E60', '', '', '', '', '', '', '', '', '', '', 0),
(40, 'ATE', 'charge_globale_graph', 'N', 'C60', '', '', '', '', '', '', '', '', '', '', 0);
