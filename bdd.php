<?php

$servername = 'localhost';     
$dbname = 'magazines';
$username = 'root';
$password = '';

// Connexion à la base de données
try { 
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    //On définit le mode d'erreur de PDO sur Exception
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Retour d'erreur à enlever en prod !!
	//$bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);   // Evite de ne renvoyer que des Strings en tableau associatif   
    //echo 'Connexion réussie';
}
catch (Exception $e) { 
    echo $e->getMessage(); 
    die();
}
// Si le try échoue, on capture l'erreur et on l'affiche et on quiutte le programme
?>