<?php

/*Insertion dans la base de données d'une partie remportée*/

session_start();

/*include bdd connection file*/


$data = [$_SESSION['uniqueid'],$_SESSION['essai'],$_SESSION['word'],$_SESSION['difficulty']];

$query = $pdo->prepare (
		'INSERT INTO `highscores`(`nthgame`, `tries`, `word`,`difficulty`,`day`) VALUES (?,?,?,?, NOW())'
		);

		$query->execute($data);

		$result = $query->rowCount();

if ($result ==1){
	echo '<p class="bg-white">Score ajouté au classement</p>';
}
