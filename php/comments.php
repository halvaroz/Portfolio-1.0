<?php

/*Chargement et préparation à la pagination des commentaires*/

/*include bdd connection file*/
include 'utilities.php';

echo '<div class="bg-white"><p class="bg-white">Il faut gagner une partie pour pouvoir laisser un commentaire ici.</p>';

$data=[];

$query = $pdo->prepare (
		'SELECT name, day, message FROM `highscores` WHERE message IS NOT NULL AND message <> "" ORDER BY id DESC'
	);

	$query->execute();

	$data = $query->fetchAll(PDO::FETCH_ASSOC);
	

	for ($j=0;$j<count($data);$j++){
			$prov = explode('-',$data[$j]['day']);
			$data[$j]['day']= $prov[2].' '.$months[$prov[1]].' '.$prov[0];
		};

	

	$pages = ceil(count($data)/3);

	echo '<p>Il y a '.$pages.' page';

	if ($pages>1){
		echo 's';
	}
	echo ' de messages</p><input type="text" id="nthpage" placeholder="N° de page souhaitée"></input>
					<button id="pageSelect">Aller à la page</button>';
	
	$comments = count($data);
	

	if ($comments===0){
		return;
	}

	$reste = (count($data)%3);
	$lastpage = $reste;

	$starting=$comments-$lastpage;



	if ($lastpage == 0){
		$starting = $starting-3;
	}


if ($pages>1){

	for ($i=0;$i<($pages-1);$i++){

		echo '<div class="page'.($i+1).' hidden"><button class="arrows prevPage" ><img src="img/back.png"></button> Page '.($i+1) .'<button class="arrows nextPage"><img src="img/next.png"></button>';

		for ($j=0; $j<3;$j++){
			echo '<div class="';

			if ($j%2==0){
			echo 'firsts';
		} else {
			echo 'seconds';
		}

			echo'"><ul><li>'.$data[(($i*3)+$j)]['name'].'</li><li>'.$data[(($i*3)+$j)]['day'].'</li></ul><p>'.$data[(($i*3)+$j)]['message'].'</p></div>';
		}
		echo '</div>';
	}
}

echo '<div class="page'. $pages.' hidden"><button class="arrows prevPage" ><img src="img/back.png"></button> Page '. $pages.'<button class="arrows nextPage" ><img src="img/next.png"></button>';

for ($i=$starting; $i<$comments; $i++){
	echo '<div class="';
	if ($i%2==0){
	echo 'firsts';
} else {
	echo 'seconds';
}
	echo'"><ul><li>'.$data[($i)]['name'].'</li><li>'.$data[($i)]['day'].'</li></ul><p>'.$data[($i)]['message'].'</p></div>';
}
echo '</div></div>';
