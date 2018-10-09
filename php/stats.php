<?php

/*Récupération des statistiques du jeu, le pourcentage des parties gagnées est exact lorsque la dernière partie a été remportée, sinon approximatif*/

/*include bdd connection file*/

$data = [];

for ($i=1; $i<4;$i++){

$query = $pdo->prepare (
		"SELECT AVG(tries) AS averagetries FROM `highscores` WHERE difficulty = ?  "
	);

	$query->execute([$i]);

	array_push($data,$query->fetch(PDO::FETCH_ASSOC));
}

$query = $pdo->prepare (
		"SELECT * FROM `highscores` ORDER BY id DESC LIMIT 1 "
	);

	$query->execute();

	array_push($data,$query->fetch(PDO::FETCH_ASSOC));

$games = $data[3]['nthgame'];
$success= $data[3]['id'];

$percent = $success/$games;

echo '<p>'.round($percent*100,2). ' % des jeux lancés ont été réussis.</p>';
echo '<p>Le nombre moyen d\'essais des parties réussies est de :</p><ul><li>'. round($data[0]['averagetries'],2).' en niveau <span class="green">facile</span>.</li><li>'. round($data[1]['averagetries'],2).' en niveau <span class="yellow">intermédiaire</span>.</li><li>'. round($data[2]['averagetries'],2).' en niveau <span class="red">difficile</span>.</li></p>'; 



