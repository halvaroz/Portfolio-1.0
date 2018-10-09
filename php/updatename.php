<?php

/*Mise à jour du nom associé à la partie qui vient d'être remportée*/


/*include bdd connection file*/
include 'utilities.php';

session_start();




$name=sanitize($_POST['name']);

if (strlen($name)>30){
	echo '<p class="bg-white">Les noms sont limités à 40 caractères</p>';
	echo '</p><p id="success"><input id="playername" type="text" placeholder="Votre nom"><button id="addname" >Ajouter mon nom</button><span>Sinon le score sera enregistré en anonyme.</span></p>';
	return;
}


$data = [$name,$_SESSION['uniqueid']];

$query = $pdo->prepare (
		'UPDATE `highscores` SET `name`=? WHERE nthgame=?'
		);

		$query->execute($data);


 	if ($query->rowCount() == 1){
 	echo '<p>Votre nom a bien été pris en compte.</p>';
 } else {
 	echo '<p>Votre nom n\'a pas pu être spécifié.</p>';
 	echo '</p><p id="success"><input id="playername" type="text" placeholder="Votre nom"><button id="addname" >Ajouter mon nom</button><span>Sinon le score sera enregistré en anonyme.</span></p>';
 }
