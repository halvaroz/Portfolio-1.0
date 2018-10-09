<?php

/*Initialisation d'une partie*/

/*include bdd connection file*/
include 'utilities.php';

session_start();
session_destroy();
session_start();

$lvl=$_POST['difficulty'];

	switch($lvl){
		case 1:
			$query = $pdo->prepare (
				"SELECT * FROM easy ORDER BY RAND() LIMIT 1");
			break;
		case 2:
			$query = $pdo->prepare (
			"SELECT * FROM medium ORDER BY RAND() LIMIT 1");
			break;

		case 3:
			$query = $pdo->prepare (
			"SELECT * FROM hard ORDER BY RAND() LIMIT 1");
			break;
	}

	$query->execute();

	$random = $query->fetch(PDO::FETCH_ASSOC);

	$basicWord=$random['Word'];

	$_SESSION['basicWord']= $basicWord;


	$_SESSION['word']=strtoupper(normalize($basicWord));

	$_SESSION['letters']=str_split($_SESSION['word']);

	$_SESSION['difficulty']=$lvl;

	$_SESSION['essai']=1;

	$uniqueid = readData();
	$uniqueid = $uniqueid[0];

	$_SESSION['uniqueid'] = $uniqueid+1;

	updateData('play');


