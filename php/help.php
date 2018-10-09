<?php

/*Création de l'indice*/

session_start();

$pieces = str_split($_SESSION['word']);

$sequence = '';

for ($i=0;$i<5;$i++){
	if (preg_match_all('/[AEIOUY]/i',$pieces[$i]) == 0) {
		$sequence .= 'Consonne ';
	} else {
		$sequence .= 'Voyelle ';
	}
}

echo '<span class="bg-white">'.$sequence.'</span>';

