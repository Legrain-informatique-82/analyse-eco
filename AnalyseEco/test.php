<?php


$s = "BAN_6*+BAN_7132*+BAN_7134*-ATELIER_N[MECA,M--O,BAFO,DIVE,ELEM]";

$resultat = preg_split("/[+-]ATELIER_N\[[A-Z,-]*\]/",$s);

print_r($resultat);


$pattern="/[+-]ATELIER_N\[[A-Z,-]*\]/";
if(preg_match($pattern,$s)) {
	echo "ok";
} else {
	echo "pas ok";
}

//$flux_exercice = array ( "libelle"  => array ( "Chiffre d'affaire",
//                                       "subvention",
//                                       "var créances",
//                                       "var créances",
//                                       "var CT finance",
//                                       "Sous total",
//                                       "",
//                                       "charges d'expliotation",
//                                       "var fournisseur",
//                                       "sous total"
//                                     ),
//                  "emplois" => array ( "",
//                                       "",
//                                       "FL6",
//                                       "FL7",
//                                       "FL8",
//                                       "",
//                                       "FL12",
//                                       "FL13",
//                                       "FL14"
//                                     ),
//                  "ressources"   => array ( "FL1",
//                                       "FL2",
//                                       "FL3",
//                                       "FL4",
//                                       "FL5",
//                                       "",
//                                       "",
//                                       "FL10",
//                                       "FL11"
//                                     )
//                );
?>