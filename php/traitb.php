<?php

/*Insertion dans la base de données d'un message du formulaire de contact*/

/*include bdd connection file*/
include 'utilities.php';

if (!isset($_POST['envoi'])){
	echo '<p>Une erreur s\'est produite</p>';
}	else{

	$nom     = (isset($_POST['nom']))     ? sanitize($_POST['nom'])     : '';
	$email   = (isset($_POST['email']))   ? sanitize($_POST['email'])   : '';
	$message = (isset($_POST['message'])) ? sanitize($_POST['message']) : '';

	$email = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? $email : ''; 

	if (($nom != '') && ($email != '') && ($message != '')){
		
		$query = $pdo->prepare (
		"INSERT INTO messages(`name`, `email`, `message`,`day`) VALUES (?,?,?, NOW())"
		);

		$query->execute(array($nom,$email,$message));

		if ($query==false){
			echo '<p>Une erreur s\'est produite</p>';
		} else {
			echo "<link rel='stylesheet'href='../csstyle/mailstyle.css'><p class='answer'>Votre message a bien été envoyé.</p><button class='back'><a href=\"../index.php\">Retour au site</a></button><img class='imageset' src='../img/postbox.png' alt='Message reçu'/>"."\n";
		}
		
	} else{ 
		echo "<link rel='stylesheet'href='../csstyle/mailstyle.css'><p class='answer'>Vérifiez que tous les champs soient bien remplis et que l'e-mail soit sans erreur.</p><button class='back'><a href=\"../index.php#contact\">Retour au formulaire</a></button><img class='imageset' src='../img/epic.jpg' alt='Message reçu'/>"."\n";
	};

}
