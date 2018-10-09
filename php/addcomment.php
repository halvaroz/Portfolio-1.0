<?php 

/*Ajout d'un commentaire à la fin d'une partie gagnée*/


/*include bdd connection file*/
include 'utilities.php';

session_start();

$comment=sanitize($_POST['comment']);

if (strlen($comment)>400){
	echo '<p class="bg-white">Les commentaires sont limités à 400 caractères</p>';
	echo'<p class="bg-white"><textarea id="commentaire" placeholder="Votre commentaire"></textarea>
					<button id="write">Ajouter mon commentaire</button><span></p>';
	return;
}

$data = [$comment,$_SESSION['uniqueid']];

$query = $pdo->prepare (
		'UPDATE `highscores` SET `message`=? WHERE nthgame=?'
		);

		$query->execute($data);


 	if ($query->rowCount() == 1){
 	echo '<p class="bg-white">Votre commentaire a bien été enregistré.</p>';
 } else {
 	echo '<p class="bg-white">Votre commentaire n\'a pas pu être enregistré.</p>';
 	echo'<p class="bg-white"><textarea id="commentaire" placeholder="Votre commentaire"></textarea>\
					<button id="write">Ajouter mon commentaire</button><span></p>';
 }
