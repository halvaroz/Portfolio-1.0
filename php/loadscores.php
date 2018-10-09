<?php

/*Création des trois tableaux de scores*/

/*include bdd connection file*/
include 'utilities.php';

$tables = ['easy','medium','hard'];

$datas =[];

for ($i=1; $i<=count($tables); $i++){

$query = $pdo->prepare (
		'SELECT * FROM `highscores` WHERE `difficulty`='.$i.' ORDER BY tries, day, name'
		);

		$query->execute();

		$datas[$i] = $query->fetchAll();

		for ($j=0;$j<count($datas[$i]);$j++){
			$prov = explode('-',$datas[$i][$j]['day']);
			$datas[$i][$j]['day']= $prov[2].' '.$months[$prov[1]].' '.$prov[0];
		};
	};

for ($i=1; $i<=count($tables); $i++){

		$previous=0;

		echo '<table id="'.$tables[$i-1].'" class="container';
			if ($i>1){
				echo' ghost';
			} else {
				echo' buster';
			}
		echo '"><th class="cool">Rang</th><th class="cool">Nom</th><th class="cool">Essais</th><th class="cool">Mot</th><th class="cool">Date</th>';

		for ($j=0; $j<count($datas[$i]); $j++){

			echo'<tr class="cool"><td class="cool">';

			if ($datas[$i][$j]['tries'] != $previous) {
				echo($j+1);
			} else {
				echo '-';
			}

			echo '</td><td class="cool naming">'.$datas[$i][$j]['name'].'</td><td class="cool">'.$datas[$i][$j]['tries'].'</td><td class="cool">'.$datas[$i][$j]['word'].'</td><td class="cool">'.$datas[$i][$j]['day'].'</td></tr>';
			
			$previous=$datas[$i][$j]['tries'];
		};

		echo '</table>';
}