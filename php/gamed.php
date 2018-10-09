<?php

/*Traitement d'une proposition, un premier traitement javascript que l'on a bien 5 lettres(fonction onClickExecute*/

session_start();

/*include bdd connection file*/
include 'utilities.php';

$try=$_POST['try'];
$saisie=normalize($_POST['saisie']);

$saisie=sanitize($saisie);
$saisie=strtoupper($saisie);

$query = $pdo->prepare (
		"SELECT Word FROM hard WHERE Word LIKE (?)"
	);

	$query->execute([$saisie]);

	$result = $query->fetch(PDO::FETCH_ASSOC);

if($result != false){
	$right = 0;
	$wrong = 0;
		if ($saisie == $_SESSION['word']){
			echo '<div id="wellmessage" class="bg-white"><p class="bg-white">Bravo ! En '.$_SESSION['essai'];
			if ($_SESSION['essai'] == 1){
				echo ' essai';
			} else {
				echo ' essais';
			};

			echo'!</p><p id="success"><input id="playername" type="text" placeholder="Votre nom"><button id="addname" >Ajouter mon nom</button><span>Sinon le score sera enregistré en anonyme.</span></p></div>';

			updateData('success');
			
		} 	else{if($_SESSION['essai'] == 12){
				echo '<pre><div>La solution était : <span>'.$_SESSION['word'].'</span>.<div>';
			}
			else {
			$sa = str_split($saisie);
			foreach ($sa as $key=>$g){
				if ($_SESSION['letters'][$key] == $g){
					$right++;
				} elseif (in_array($g, $_SESSION['letters'])){
					$wrong++;
				}
			}

			echo '<span class="summary">';

			if ($right==0 && $wrong==0){
				echo '<img src="img/pinzero.png" alt="Icone aucune de ces lettres" />';
			} else {
				for ($i=0; $i<$right;$i++){
					echo '<img src="img/pinblack.png" alt="Icone lettre bien placée" />';
				}
				for ($i=0; $i<$wrong;$i++){
					echo '<img src="img/pinwhite.png" alt="Icone lettre mal placée" />';
				}
			}
			echo '</span>';

			$_SESSION['essai']++;
			}
		}

	}
	else {
		/*ajout dans une base de données des mots de 5 lettres introuvables pour traitement ultérieur*/
		$query = $pdo->prepare (
		"INSERT INTO unknownwords (Word) VALUES (?)"
		);

		$query->execute([$saisie]);

		echo'&nbsp;Je ne connais pas votre mot. Retentez !';
	}

